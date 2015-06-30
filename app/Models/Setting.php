<?php

namespace App\Models;

use App\Http\Presenters\SettingPresenter;

class Setting extends BaseModel
{

    public $table = 'settings';

    public $timestamps = false;

    protected $fillable = ['name', 'value'];

    protected $presenter = SettingPresenter::class;

    public static function getValue($name)
    {
        try {
            return static::where('name', $name)->first()->value;
        } catch (\Exception $e) {
            return null;
        }
    }
}