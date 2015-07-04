<?php

namespace App\Resources;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class Homestead
{

    /* @var Filesystem */
    protected $filesystem;

    /* @var Yaml */
    private $yaml;

    public function __construct(Filesystem $filesystem, Yaml $yaml)
    {
        $this->filesystem = $filesystem;
        $this->yaml       = $yaml;
    }

    public function getIp()
    {
        return $this->yaml->parse($this->filesystem->get(setting('userDir') . '/.homestead/Homestead.yaml'))['ip'];
    }

    /**
     * Add a site to the config.
     *
     * @param $site
     * @param $name
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function createConfig($site, $name)
    {
        $config = $this->getConfig();

        // Add the site to the config
        $config['sites'][] = [
            'map' => $site->name,
            'to'  => vagrantDirectory($site->path),
        ];

        // Add the database to the config
        $config['databases'][] = Str::snake($name);

        $this->saveConfig($config);
    }

    /**
     * Update a site in the config.
     *
     * @param $originalSite
     * @param $newSite
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function updateConfig($originalSite, $newSite)
    {
        $config = $this->getConfig();

        // Check the sites and databases to see if we need to change anything.
        foreach ($config['sites'] as $key => $homesteadSite) {
            if ($homesteadSite['map'] == $originalSite->name) {
                $config['sites'][$key] = [
                    'map' => $newSite->name,
                    'to'  => vagrantDirectory($newSite->path)
                ];
            }
        }

        $this->saveConfig($config);
    }

    /**
     * Remove a site from the config.
     *
     * @param $site
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function deleteConfig($site)
    {
        // Convert yaml to array
        $config = $this->getConfig();

        // Look for the site in sites and in databases
        foreach ($config['sites'] as $key => $homesteadSite) {
            if ($homesteadSite['map'] == $site->name) {
                unset($config['sites'][$key]);
            }
        }

        foreach ($config['databases'] as $key => $homesteadDatabase) {
            if ($homesteadDatabase == Str::snake(str_replace('.app', '', $site->name))) {
                unset($config['databases'][$key]);
            }
        }

        // Rebuild the yaml
        $this->saveConfig($config);
    }

    /**
     * Get and parse the main yaml config.
     *
     * @return array
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function getConfig()
    {
        return $this->yaml->parse($this->filesystem->get(setting('userDir') . '/.homestead/Homestead.yaml'));
    }

    /**
     * Converts the array to yaml and saves the homestead config.
     *
     * @param $config
     */
    private function saveConfig($config)
    {
        $finalConfig = '';

        foreach ($config as $key => $value) {
            if (is_array($value)) {
                $finalConfig .= "$key:\r";

                foreach ($value as $subValue) {
                    if (is_string($subValue)) {
                        $finalConfig = $this->addHomesteadConfigArrayString($finalConfig, $subValue);
                    } else {
                        $finalConfig = $this->addHomesteadConfigArray($finalConfig, $key, $subValue);
                    }
                }
            } else {
                $finalConfig = $this->addHomesteadConfigKeyValue($finalConfig, $key, $value);
            }

            $finalConfig .= "\r";
        }

        $this->filesystem->put(setting('userDir') . '/.homestead/Homestead.yaml', $finalConfig);
    }

    /**
     * Add a value only array line to the yaml.
     *
     * @param $config
     * @param $value
     *
     * @return string
     */
    private function addHomesteadConfigArrayString($config, $value)
    {
        return $config .= "    - $value\r";
    }

    /**
     * Add a key value single line to the yaml.
     *
     * @param $config
     * @param $key
     * @param $value
     *
     * @return string
     */
    private function addHomesteadConfigKeyValue($config, $key, $value)
    {
        $value = $key == 'ip' ? '"' . $value . '"' : $value;

        return $config .= "$key: $value\r";
    }

    /**
     * Add an array line to the yaml.
     *
     * @param $config
     * @param $key
     * @param $array
     *
     * @return string
     */
    private function addHomesteadConfigArray($config, $key, $array)
    {
        $map     = reset($array);
        $mapText = $key == 'variables' ? 'key' : 'map';

        $to     = end($array);
        $toText = $key == 'variables' ? 'value' : 'to';

        $config .= "    - $mapText: $map\r";

        if ($map != $to) {
            $config .= "      $toText: $to\r";
        }

        return $config;
    }
}