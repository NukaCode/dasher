<?php

namespace App\Models;

class PortForward extends BaseModel
{

    public $table = 'port_forwards';

    public $timestamps = false;

    protected $fillable = ['starting_port', 'destination_port'];
}