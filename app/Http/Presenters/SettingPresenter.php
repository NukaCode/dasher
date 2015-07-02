<?php

namespace App\Http\Presenters;

use App\Resources\Homestead;
use Illuminate\Support\Str;
use NukaCode\Core\Presenters\BasePresenter;

class SettingPresenter extends BasePresenter {

    public function value()
    {
        if ($this->entity->value === '0' || $this->entity->value === '1') {
            return $this->entity->value === '0' ? 'false' : 'true';
        }

        return Str::limit($this->entity->value, 50);
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

    public function homesteadLocationEstimate()
    {
        return str_replace('/Vagrantfile', '', shell_exec('locate "Homestead/Vagrantfile";'));
    }
}