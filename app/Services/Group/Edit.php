<?php

namespace App\Services\Group;

use App\Models\Group;
use App\Resources\Homestead;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class Edit
{

    /* @var Group */
    private $group;

    /* @var Yaml */
    private $yaml;

    /* @var Filesystem */
    private $filesystem;

    public function __construct(Group $group, Yaml $yaml, Filesystem $filesystem)
    {
        $this->group      = $group;
        $this->yaml       = $yaml;
        $this->filesystem = $filesystem;
    }

    public function handle($id, $request)
    {
        // Make sure ports don't overlap.
        if (! $this->verifyPorts($id, $request)) {
            return [false, 'Starting port is used by another group!'];
        }

        $originalGroup = $this->group->find($id);
        $newGroup = $this->updateGroup($id, $request);


        if (settingEnabled('homestead') == 1) {
            $this->updateHomesteadConfig($originalGroup, $newGroup);

            $this->envoy->run('vagrant --cmd="provision" --dir="' . setting('homestead') . '"');
        }

        return [true, null];
    }

    private function verifyPorts($id, $request)
    {
        return $this->group->where('id', '!=', $id)->where('starting_port', $request['starting_port'])->count() == 0;
    }

    /**
     * Updates the stored group.
     *
     * @param $id
     * @param $request
     *
     * @return Group
     */
    protected function updateGroup($id, $request)
    {
        $group = $this->group->find($id);
        $group->fill($request);
        $group->save();

        return $group;
    }

    /**
     * Updates the homestead.yaml file to include the new folder.
     *
     * @param $originalGroup
     * @param $newGroup
     */
    protected function updateHomesteadConfig($originalGroup, $newGroup)
    {
        $config = $this->yaml->parse($this->filesystem->get(setting('userDir') . '/.homestead/Homestead.yaml'));

        // Check the folders to see if we need to change anything.
        foreach ($config['folders'] as $key => $homesteadGroup) {
            if ($homesteadGroup['map'] == $originalGroup->starting_path) {
                $config['folders'][$key] = [
                    'map' => $newGroup->starting_path,
                    'to'  => vagrantDirectory($newGroup->starting_path)
                ];
            }
        }
        foreach ($config['sites'] as $key => $homesteadSite) {
            $originalPath = vagrantDirectory($originalGroup->starting_path);

            if (strpos($homesteadSite['to'], $originalPath) !== false) {
                $newPath = vagrantDirectory($newGroup->starting_path);

                $config['sites'][$key]['to'] = str_replace($originalPath, $newPath, $config['sites'][$key]['to']);
            }
        }

        app(Homestead::class)->saveHomesteadConfig($config);
    }
}