<?php

namespace App\Services\Group;

use App\Models\Group;
use App\Resources\Homestead;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class Delete
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

    public function handle($id)
    {
        $group = $this->group->find($id);

        if (settings('homesteadFlag') == 1) {
            $this->updateHomesteadConfig($group);

            $this->envoy->run('vagrant --cmd="provision" --dir="' . setting('homestead') . '"');
        }

        $group->delete();

        return [true, null];
    }

    /**
     * Updates the homestead.yaml file to include the new folder.
     *
     * @param $group
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function updateHomesteadConfig($group)
    {
        $config = $this->yaml->parse($this->filesystem->get(setting('userDir') . '/.homestead/Homestead.yaml'));

        // Check the folders to see if we need to change anything.
        foreach ($config['folders'] as $key => $homesteadGroup) {
            if ($homesteadGroup['map'] == $group->starting_path) {
                unset($config['folders'][$key]);
            }
        }
        foreach ($config['sites'] as $key => $homesteadSite) {
            $originalPath = vagrantDirectory($group->starting_path);

            if (strpos($homesteadSite['to'], $originalPath) !== false) {
                unset($config['sites'][$key]);
            }
        }

        app(Homestead::class)->saveHomesteadConfig($config);
    }
}