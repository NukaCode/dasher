<?php

namespace App\Resources;

use App\Services\Status;
use App\Services\Verify;

class Mysql
{

    public $version;

    public $status;

    public function __construct(Status $status, Verify $verify)
    {
        $this->version = cache()->remember('mysql.version', 120, function () use ($verify) {
            return $verify->mysql();
        });
        $this->status = cache()->remember('mysql.status', 5, function () use ($status) {
            return $status->mysql();
        });
    }

}