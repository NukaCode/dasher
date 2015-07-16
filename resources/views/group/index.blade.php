<div class="ui grid">
    <div class="eight wide centered column">
        <div class="ui right floated">
            {!! HTML::linkRoute('group.create', 'Create New Group', [], ['class' => 'ui primary button']) !!}
        </div>
        <div class="clearfix"></div>
        <div class="ui segments dark">
            @foreach($groups as $group)
                <div class="ui horizontal segments primary text">
                    <div class="ui segment" style="width: 40%;">
                        {{ $group->name }}
                    </div>
                    <div class="ui segment" style="width: 15%;">
                        {{ $group->starting_port }}
                    </div>
                    <div class="ui segment" style="width: 15%;">
                        {{ $group->sites()->count() }} {{ Str::plural('site', $group->sites()->count()) }}
                    </div>
                    <div class="ui segment noHover">
                        <div class="mini ui buttons right floated">
                            {!! HTML::linkRoute('group.show', 'View', [$group->id], ['class' => 'ui primary button']) !!}
                            {!! HTML::linkRoute('group.edit', 'Edit', [$group->id], ['class' => 'ui primary button']) !!}
                            {!! HTML::linkRoute('group.delete', 'Delete', [$group->id], ['class' => 'confirm-remove ui red button']) !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>