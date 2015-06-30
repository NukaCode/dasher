<?php

namespace App\Models;

class Group extends BaseModel
{

    public $table = 'groups';

    public $timestamps = false;

    protected $fillable = ['name', 'starting_path', 'starting_port'];

    public function getMaxPortAttribute()
    {
        $maxPort = $this->sites->max('port');

        return $maxPort == 0 ? $this->starting_port : $maxPort + 1;
    }

    public function sites()
    {
        return $this->hasMany(Site::class, 'group_id');
    }
}