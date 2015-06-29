<?php

namespace App\Services\Group;

use App\Models\Group;

class Edit
{

    /* @var Group */
    private $group;

    public function __construct(Group $group)
    {
        $this->group = $group;
    }

    public function handle($id, $request)
    {
        // Make sure ports don't overlap.
        if (! $this->verifyPorts($id, $request)) {
            return [false, 'Starting port is used by another group!'];
        }

        $this->updateGroup($id, $request);

        return [true, null];
    }

    private function verifyPorts($id, $request)
    {
        return $this->group->where('id', '!=', $id)->where('starting_port', $request['starting_port'])->count() == 0;
    }

    /**
     * Updates the stored group.
     *
     * @param $id
     * @param $request
     */
    protected function updateGroup($id, $request)
    {
        $group = $this->group->find($id);
        $group->fill($request);
        $group->save();
    }
}