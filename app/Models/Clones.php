<?php

namespace App\Models;

class Clones extends BaseModel
{

    public $table = 'clones';

    public $timestamps = false;

    protected $fillable = ['name', 'url'];
}