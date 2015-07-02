<?php

namespace App\Models;

class Site extends BaseModel
{

    public $table = 'sites';

    public $timestamps = false;

    protected $fillable = ['group_id', 'name', 'path', 'port', 'uuid', 'homesteadFlag'];

    public function getRootPathAttribute()
    {
        return str_replace('/public', '', $this->path);
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

}