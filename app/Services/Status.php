<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class Status
{

    private $envoy;

    public function __construct(Envoy $envoy)
    {
        $this->envoy = $envoy;
    }

    public function nukaInstaller()
    {
        $this->envoy('nuka-installer-version');
    }

    public function nginx()
    {
        $client = new Client;

        $response = $client->get('http://localhost:8000');

        return (bool) ($response->getStatusCode() === 200);
    }

    public function mysql()
    {
        try {
            return (bool)(! is_null(DB::connection()->getDatabaseName()));
        } catch (\Exception $e) {
            return false;
        }
    }

}