<?php

namespace App\Models;

use App\Http\Presenters\SettingPresenter;

class Setting extends BaseModel
{

    public $table = 'settings';

    public $timestamps = false;

    protected $fillable = ['name', 'enabled', 'value'];

    protected $presenter = SettingPresenter::class;

    public static function getValue($name)
    {
        try {
            return static::where('name', $name)->first()->value;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function getEnabled($name)
    {
        try {
            return static::where('name', $name)->first()->enabled;
        } catch (\Exception $e) {
            return null;
        }
    }
}