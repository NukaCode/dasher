<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">Generate a new site</div>
            <div class="panel-body">
                {!! Form::open() !!}
                    {!! Form::offsetGroupOpen() !!}
                        @foreach ($installerOptions as $option => $readable)
                            {!! Form::radio('installType', $option, false, [], $readable, true) !!}
                        @endforeach
                    {!! Form::groupClose() !!}
                    {!! Form::groupOpen() !!}
                        {!! Form::select2('group_id', $groups, null, [], 'Group') !!}
                    {!! Form::groupClose() !!}
                    {!! Form::groupOpen() !!}
                        {!! Form::text('name', null, [], 'Site Name') !!}
                    {!! Form::groupClose() !!}
                    {!! Form::offsetGroupOpen() !!}
                        {!! Form::submit('Generate Site', ['class' => 'btn btn-primary']) !!}
                    {!! Form::groupClose() !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>