<?php

namespace App\Services\Site;

use App\Models\Group;
use App\Models\Site;
use App\Services\Envoy;
use App\Services\Site\Homestead\Create as CreateHomestead;
use App\Services\Site\Nginx\Create as CreateNginx;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Generate
{

    /* @var Site */
    private $site;

    /* @var Group */
    private $group;

    /* @var Envoy */
    private $envoy;

    /* @var CreateNginx */
    private $createNginxSiteService;

    /* @var CreateHomestead */
    private $createHomesteadSiteService;

    public function __construct(Site $site, Group $group, Envoy $envoy, CreateNginx $createNginxSiteService, CreateHomestead $createHomesteadSiteService)
    {
        $this->site                       = $site;
        $this->group                      = $group;
        $this->envoy                      = $envoy;
        $this->createNginxSiteService     = $createNginxSiteService;
        $this->createHomesteadSiteService = $createHomesteadSiteService;
    }

    public function handle(Request $request)
    {
        $installerType = $request->get('installType') == 'base' ? null : '"--' . $request->get('installType') . '"';
        $group         = $this->group->find($request->get('group_id'));
        $sitePath      = Str::camel($request->get('name'));

        $this->envoy->run('make-site --path="' . $group->starting_path . '" --name="' . $sitePath . '" --type=' . $installerType, true);

        // Add the new site based on what site types are enabled.
        if (setting('nginxFlag') == 1) {
            list($success, $messages) = $this->createNginxSite($request, $group, $sitePath);

            if (! $success) {
                return [$success, $messages];
            }
        }

        if (setting('homesteadFlag') == 1) {
            list($success, $messages) = $this->createHomesteadSite($request, $group, $sitePath);

            if (! $success) {
                return [$success, $messages];
            }
        }

        return [true, null];
    }

    /**
     * Add an nginx site to the database and filesystem.
     *
     * @param Request $request
     * @param         $group
     * @param         $sitePath
     *
     * @return mixed
     */
    private function createNginxSite(Request $request, $group, $sitePath)
    {
        $site = [
            'name' => $request->get('name'),
            'path' => $group->starting_path . '/' . $sitePath . '/public',
            'port' => $group->maxPort
        ];

        return $this->createNginxSiteService->handle($site, $request->get('group_id'));
    }

    /**
     * Add a homestead site to the database and filesystem.
     *
     * @param $request
     * @param $group
     * @param $sitePath
     *
     * @return mixed
     */
    private function createHomesteadSite($request, $group, $sitePath)
    {
        $site = [
            'name' => $request->get('name'),
            'path' => $group->starting_path . '/' . $sitePath . '/public',
        ];

        return $this->createHomesteadSiteService->handle($site, $request->get('group_id'));
    }
}