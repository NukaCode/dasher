<div class="row">
    <div class="col-md-offset-3 col-md-6">
        <div class="pull-right">
            {!! HTML::linkRoute('group.create', 'Create New Group', [], ['class' => 'btn btn-primary']) !!}
        </div>
        <div class="clearfix"></div>
        <br />
        <div class="panel panel-default">
            <div class="list-group">
                @foreach($groups as $group)
                    <div class="list-group-item">
                        <table class="table table-inner">
                            <tbody>
                                <tr>
                                    <td style="width: 40%;">{{ $group->name }}</td>
                                    <td style="width: 15%;">{{ $group->starting_port }}</td>
                                    <td style="width: 15%;">{{ $group->sites()->count() }} {{ Str::plural('site', $group->sites()->count()) }}</td>
                                    <td class="text-right">
                                        <div class="btn-group">
                                            {!! HTML::linkRoute('group.show', 'View', [$group->id], ['class' => 'btn btn-xs btn-primary']) !!}
                                            {!! HTML::linkRoute('group.edit', 'Edit', [$group->id], ['class' => 'btn btn-xs btn-primary']) !!}
                                            {!! HTML::linkRoute('group.delete', 'Delete', [$group->id], ['class' => 'confirm-remove btn btn-xs btn-danger']) !!}
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>