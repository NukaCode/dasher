<?php

namespace App\Services\Site;

use App\Events\SiteWasGenerated;
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

    public function handle(array $request)
    {
        $group    = $this->group->find($request['group_id']);
        $sitePath = Str::camel($request['name']);

        // Add the new site based on what site types are enabled.
        $site = [
            'name'     => $request['name'],
            'path'     => $group->starting_path . '/' . $sitePath . '/public',
            'group_id' => $group->id
        ];

        if (settingEnabled('nginx') == 1) {
            $site['port'] = $group->maxPort;
        } elseif (settingEnabled('homestead') == 1) {
            $site['port'] = 8000;
        }

        $site['uuid'] = $this->site->generateUuid($site['port'] . $site['name']);

        $site = $this->site->create($site);

        event(new SiteWasGenerated($site, $request));
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