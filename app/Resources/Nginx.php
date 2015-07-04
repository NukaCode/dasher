<?php

namespace App\Resources;

use App\Models\Site;

class Nginx
{

    public static function createConfig(Site $site)
    {
        // Get the config template
        $template = app('files')->get(base_path('resources/templates/site.template'));

        // Replace the needed data
        $config = str_replace(
            ['{{NAME}}', '{{LOGS}}', '{{PORT}}', '{{PATH}}'],
            [$site->name, setting('nginx') .'/logs', $site->port, $site->path],
            $template);

        // Save the config to the filesystem.
        $filename = setting('nginx') . '/sites-enabled/' . $site->uuid;

        app('files')->put($filename, $config);
    }

}