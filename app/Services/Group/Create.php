<?php

namespace App\Services\Group;

use App\Models\Group;
use App\Resources\Homestead;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class Create
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

    public function handle($request)
    {
        // Make sure ports don't overlap.
        if (! $this->verifyPorts($request)) {
            return [false, 'Starting port is used by another group!'];
        }

        // Create the group.
        $group = $this->group->create($request);

        if (settingEnabled('homestead') == 1) {
            // Add the folder to the homestead dir
            $this->updateHomesteadConfig($group);

            $this->envoy->run('vagrant --cmd="provision" --dir="' . setting('homestead') . '"');
        }

        return [true, null];
    }

    private function verifyPorts($request)
    {
        return $this->group->where('starting_port', $request['starting_port'])->count() == 0;
    }

    /**
     * Updates the homestead.yaml file to include the new folder.
     *
     * @param $group
     */
    protected function updateHomesteadConfig($group)
    {
        $config = $this->yaml->parse($this->filesystem->get(setting('userDir') . '/.homestead/Homestead.yaml'));

        // Add the group to the folder config
        $config['folders'][] = [
            'map' => $group->starting_path,
            'to'  => vagrantDirectory($group->starting_path),
        ];

        app(Homestead::class)->saveHomesteadConfig($config);
    }
}