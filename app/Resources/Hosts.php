<?php

namespace App\Resources;

use Illuminate\Filesystem\Filesystem;

class Hosts
{

    public $ip;

    public $hosts;

    /* @var Filesystem */
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->ip         = setting('homesteadIp');
        $this->hosts      = $filesystem->get('/etc/hosts');
        $this->filesystem = $filesystem;
    }

    public function addHost($host)
    {
        $ip = setting('homesteadIp');

        $this->hosts .= "$ip $host\n";

        $this->filesystem->put('/etc/hosts', $this->hosts);
    }

    public function removeHost($host)
    {
        $ip = setting('homesteadIp');

        $this->hosts = str_replace("$ip $host", '', $this->hosts);

        $this->filesystem->put('/etc/hosts', $this->hosts);
    }

    public function updateHost($originalHost, $newHost)
    {
        $ip = setting('homesteadIp');

        if ($originalHost != $newHost) {
            $this->hosts = str_replace("$ip $originalHost", "$ip $newHost", $this->hosts);

            $this->filesystem->put('/etc/hosts', $this->hosts);
        }
    }
}