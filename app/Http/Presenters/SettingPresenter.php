<?php

namespace App\Http\Presenters;

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
}