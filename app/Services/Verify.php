<?php

namespace App\Services;

class Verify
{

    private $envoy;

    public function __construct(Envoy $envoy)
    {
        $this->envoy = $envoy;
    }

    public function nukaInstaller()
    {
        $versionParts = explode(' ', trim($this->envoy->run('nuka-installer-version')[0]));

        return end($versionParts);
    }

    public function nginx()
    {
        $versionParts = explode('/', trim($this->envoy->run('nginx-version')[0]));

        return $versionParts[1];
    }

    public function mysql()
    {
        $versionParts = explode(' ', trim($this->envoy->run('mysql-version')[0]));

        return $versionParts[2];
    }
}