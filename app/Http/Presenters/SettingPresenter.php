<?php

namespace App\Http\Presenters;

use App\Resources\Homestead;
use Illuminate\Support\Str;
use NukaCode\Core\Presenters\BasePresenter;

class SettingPresenter extends BasePresenter {

    public function enabled()
    {
        if ($this->entity->enabled === null) {
            return null;
        }

        return $this->entity->enabled == 1 ? 'Yes' : 'No';
    }

    public function value()
    {
        if ($this->entity->value === '0' || $this->entity->value === '1') {
            return $this->entity->value === '0' ? 'false' : 'true';
        }

        return Str::limit($this->entity->value, 20);
    }

    public function estimatedValue()
    {
        $method = $this->entity->name .'Estimate';

        if (method_exists($this, $method)) {
            return $this->$method();
        }

        return null;
    }

    public function homesteadIpEstimate()
    {
        return app(Homestead::class)->getIp();
    }

    public function userDirEstimate()
    {
        return shell_exec('cd ~; pwd');
    }

    public function nginxEstimate()
    {
        return str_replace('/sites-enabled', '', shell_exec('locate "sites-enabled"'));
    }

    public function homesteadEstimate()
    {
        return str_replace('/Vagrantfile', '', shell_exec('locate "Homestead/Vagrantfile";'));
    }

    public function phpstormEstimate()
    {
        return shell_exec('locate "PhpStorm.app/Contents/MacOS/phpstorm"');
    }

    public function sublimeEstimate()
    {
        return shell_exec('locate "Sublime Text.app/Contents/SharedSupport/bin/subl"');
    }

    public function atomEstimate()
    {
        return shell_exec('locate "Atom.app/Contents/Resources/app/atom.sh"');
    }
}