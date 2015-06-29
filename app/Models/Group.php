<?php

namespace App\Models;

class Group extends BaseModel
{

    public $table = 'groups';

    public $timestamps = false;

    protected $fillable = ['name', 'starting_path', 'starting_port'];

    public function sites()
    {
        return $this->hasMany(Site::class, 'group_id');
    }
}