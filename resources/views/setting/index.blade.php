<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">Settings</div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Setting</th>
                        <th style="width: 5%;" class="text-center">Enabled</th>
                        <th>Value</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($settings as $setting)
                        <tr>
                            <td>{{ $setting->name }}</td>
                            <td class="text-center">{{ $setting->present()->enabled }}</td>
                            <td title="{{ $setting->value }}">{{ $setting->present()->value }}</td>
                            <td class="text-right">
                                <div class="btn-group">
                                    {!! HTML::linkRouteIcon('setting.edit', [$setting->id], 'fa fa-edit', null, ['class' => 'btn btn-xs btn-primary']) !!}
                                    {!! HTML::linkRouteIcon('setting.delete', [$setting->id], 'fa fa-trash', null, ['class' => 'confirm-remove btn btn-xs btn-danger']) !!}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">Stats</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">Helpers</div>
        </div>
    </div>
</div>