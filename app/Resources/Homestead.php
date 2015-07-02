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
        return $this->yaml->parse($this->filesystem->get(setting('userDir') .'/.homestead/Homestead.yaml'))['ip'];
    }

    /**
     * Converts the array to yaml and saves the homestead config.
     *
     * @param $config
     */
    public function saveHomesteadConfig($config)
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