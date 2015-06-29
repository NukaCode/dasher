<?php

namespace App\Services\Group;

use App\Models\Group;

class Create
{

    /* @var Group */
    private $group;

    public function __construct(Group $group)
    {
        $this->group = $group;
    }

    public function handle($request)
    {
        // Make sure ports don't overlap.
        if (! $this->verifyPorts($request)) {
            return [false, 'Starting port is used by another group!'];
        }

        // Create the group.
        $this->group->create($request);

        return [true, null];
    }

    private function verifyPorts($request)
    {
        return $this->group->where('starting_port', $request['starting_port'])->count() == 0;
    }
}