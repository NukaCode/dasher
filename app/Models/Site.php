<?php

namespace App\Models;

class Site extends BaseModel
{

    public $table = 'sites';

    public $timestamps = false;

    protected $fillable = ['group_id', 'name', 'path', 'port', 'uuid'];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

}