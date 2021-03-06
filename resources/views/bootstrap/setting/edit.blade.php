<div class="row">
    <div class="col-md-offset-3 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">Edit {{ $setting->name }} Setting</div>
            </div>
            <div class="panel-body">
                {!! Form::open() !!}
                    {!! Form::setSizes(2, 8, 2)->groupOpen() !!}
                        {!! Form::text('estimate', $setting->present()->estimatedValue, ['readonly', 'id' => 'estimate'], 'Estimated Value') !!}
                        {!! Form::help('This value is a best guess generated by the system.  It should be pretty accurate, but always double check.') !!}
                        </div>
                        <div class="col-md-2">
                            <a href="javascript:void(0);" onclick="useEstimate()" class="btn btn-primary btn-block">Use This Value</a>
                    {!! Form::groupClose() !!}
                    @if ($setting->enabled !== null)
                        {!! Form::groupOpen() !!}
                            {!! Form::select('enabled', ['No', 'Yes'], $setting->enabled, ['id' => 'enabled'], 'Enabled?') !!}
                        {!! Form::groupClose() !!}
                    @endif
                    {!! Form::groupOpen() !!}
                        {!! Form::text('value', $setting->value, ['id' => 'value'], 'Current Value') !!}
                    {!! Form::groupClose() !!}
                    {!! Form::offsetGroupOpen() !!}
                        {!! Form::submit('Update setting', ['class' => 'btn btn-primary']) !!}
                    {!! Form::groupClose() !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@section('js')
    <script>
        function useEstimate() {
            var estimate = $('#estimate').val();

            $('#value').val(estimate);
        }
    </script>
@endsection