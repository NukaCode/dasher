<div class="row">
    <div class="col-md-offset-3 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">Edit {{ $setting->name }} Setting</div>
            </div>
            <div class="panel-body">
                {!! Form::open() !!}
                    {!! Form::groupOpen() !!}
                        {!! Form::text('estimate', $setting->present()->estimatedValue, ['readonly'], 'Estimated Value') !!}
                        {!! Form::help('This value is a best guess generated by the system.  It should be pretty accurate.') !!}
                    {!! Form::groupClose() !!}
                    {!! Form::groupOpen() !!}
                        {!! Form::text('value', $setting->value, [], 'Current Value') !!}
                    {!! Form::groupClose() !!}
                    {!! Form::offsetGroupOpen() !!}
                        {!! Form::submit('Update setting', ['class' => 'btn btn-primary']) !!}
                    {!! Form::groupClose() !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>