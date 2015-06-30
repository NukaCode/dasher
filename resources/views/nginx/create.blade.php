<div class="row" id="vue">
    <div class="col-md-offset-2 col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">Create a New Nginx Site</div>
            <div class="panel-body">
                {!! Form::open() !!}
                    {!! Form::setSizes(2, 8, 2)->groupOpen() !!}
                        {!! Form::text('path', $group->starting_path, [
                            'placeholder' => 'Directory',
                            'v-on'        => 'keyup: getDirectory',
                            'v-model'     => 'query',
                            'id'          => 'query',
                        ], 'Directory') !!}
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-block btn-primary" id="toggle" v-on="click: toggleDirs">Hide Dirs</button>
                        </div>
                    </div>
                    <div class="col-md-offset-2 panel-footer" id="dirs">
                        <div v-on="click: upDirectory()">../</div>
                        <div v-repeat="directory: directories">
                            <div v-on="click: setQuery(directory)">@{{ directory | relativePath }}</div>
                        </div>
                    </div>
                    <br />
                    {!! Form::setSizes(2, 10)->groupOpen() !!}
                        {!! Form::text('name', null, [], 'Name') !!}
                    {!! Form::groupClose() !!}
                    {!! Form::groupOpen() !!}
                        {!! Form::text('port', $port, [], 'Port') !!}
                    {!! Form::groupClose() !!}
                    {!! Form::offsetGroupOpen() !!}
                        {!! Form::submit('Add Site', ['class' => 'btn btn-primary']) !!}
                    {!! Form::groupClose() !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@section('jsInclude')
    {!! HTML::script('//cdn.jsdelivr.net/typeahead.js/0.11.1/typeahead.jquery.min.js') !!}
@endsection

@section('js')
    <script>
        new Vue({
            el: '#vue',

            data: {
                query: '',
                showDirs: true,
                directories: window.directories
            },

            ready: function () {
                this.getDirectory()
            },

            methods: {
                getDirectory: function () {
                    this.$http.get(window.url + '?query=' + encodeURIComponent(this.query), function (data, status, request) {
                        this.$set('directories', data.directories);
                    })
                },
                upDirectory: function () {
                    this.$http.get(window.url + '?up=true&query=' + encodeURIComponent(this.query), function (data, status, request) {
                        this.$set('directories', data.directories);

                        if (data.query) {
                            this.$set('query', data.query);
                        }
                    })
                },
                setQuery: function (directory) {
                    this.$set('query', directory);
                    this.getDirectory();
                },
                toggleDirs: function () {
                    if (this.showDirs == true) {
                        $('#toggle').text('Show Dirs');
                        $('#dirs').hide();
                        this.$set('showDirs', false);
                    } else {
                        $('#toggle').text('Hide Dirs');
                        $('#dirs').show();
                        this.$set('showDirs', true);
                    }
                }
            },

            filters: {
                relativePath: function (dir) {
                    if (dir != this.query) {
                        return String(dir).replace(this.query, '');
                    }
                    return dir;
                }
            }
        });
    </script>
@endsection