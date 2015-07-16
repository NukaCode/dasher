<div class="ui twelve column grid">
    <div class="four wide column">
        <h4 class="ui dividing header primary text">Settings</h4>
        <table class="ui table hover dark">
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
                        <td class="center aligned">{{ $setting->present()->enabled }}</td>
                        <td title="{{ $setting->value }}">{{ $setting->present()->value }}</td>
                        <td class="right aligned">
                            <div class="mini ui buttons">
                                {!! HTML::linkRouteIcon('setting.edit', [$setting->id], 'edit icon', null, ['class' => 'ui compact primary icon button']) !!}
                                {!! HTML::linkRouteIcon('setting.delete', [$setting->id], 'trash icon', null, ['class' => 'confirm-remove ui compact red icon button']) !!}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="four wide column">
        <h4 class="ui dividing header primary text">Forwarded Ports</h4>
        <table class="ui fluid table hover dark">
            <thead>
                <tr>
                    <th>Starting Port</th>
                    <th>Destination Port</th>
                    <th class="right aligned">{!! HTML::linkRouteIcon('port.create', [], 'plus icon', null, ['class' => 'mini ui primary compact icon button']) !!}</th>
                </tr>
            </thead>
            <tbody>
                @if ($forwards->count() > 0)
                    @foreach ($forwards as $forward)
                        <tr>
                            <td>{{ $forward->starting_port }}</td>
                            <td>{{ $forward->destination_port }}</td>
                            <td class="right aligned">
                                <div class="mini ui buttons">
                                    {!! HTML::linkRouteIcon('port.edit', [$forward->id], 'edit icon', null, ['class' => 'ui compact primary icon button']) !!}
                                    {!! HTML::linkRouteIcon('port.delete', [$forward->id], 'trash icon', null, ['class' => 'confirm-remove ui compact red icon button']) !!}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3">No ports have been forwarded.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>