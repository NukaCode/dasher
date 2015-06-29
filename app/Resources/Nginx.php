<?php

namespace App\Resources;

use App\Services\Status;
use App\Services\Verify;

class Nginx
{

    public $version;

    public $status;

    public function __construct(Status $status, Verify $verify)
    {
        $this->version = cache()->remember('nginx.version', 120, function () use ($verify) {
            return $verify->nginx();
        });
        $this->status = cache()->remember('nginx.status', 5, function () use ($status) {
            return $status->nginx();
        });
    }

}