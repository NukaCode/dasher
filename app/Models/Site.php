<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;

class Site extends BaseModel
{

    public $table = 'sites';

    public $timestamps = false;

    protected $fillable = ['group_id', 'name', 'path', 'port', 'uuid', 'homesteadFlag'];

    public function getRootPathAttribute()
    {
        return str_replace('/public', '', $this->path);
    }

    public function updateStatus($status, $ready = false)
    {
        $this->status = $status;

        if ($ready === true) {
            $this->readyFlag = 1;
        }

        $this->save();
    }

    /**
     * Generate a uuid for the site based on it's port.
     *
     * @param $unique
     *
     * @return string
     */
    public function generateUuid($unique)
    {
        $uuid3 = Uuid::uuid3(Uuid::NAMESPACE_DNS, $unique);
        $uuid  = $uuid3->toString();

        return $uuid;
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

}