<?php

namespace App\Services\Site\Nginx;

use App\Services\Site\BaseDelete;

class Delete extends BaseDelete
{

    public function handle($id)
    {
        $site = $this->site->find($id);

        $this->filesystem->delete(setting('nginx') . '/sites-enabled/' . $site->uuid);

        $site->delete();

        $this->envoy->run('nginx --cmd="reload"');

        return true;
    }
}