<div class="ui grid" id="vue">
    <div class="ten wide centered column dark">
        <form class="ui form primary" method="POST">
            {{ csrf_field() }}
            <h4 class="ui dividing header primary text">Create a New Nginx Site</h4>
            <div class="field">
                <label for="starting_path">Directory</label>
                <div class="ui action input">
                    <input type="text" name="path" placeholder="Directory" v-on="keyup: getDirectory"
                           v-model="query" id="query" value="{{ $group->starting_path }}" />
                    <button class="ui primary right labeled icon button" type="button" id="toggle" v-on="click:
                    toggleDirs">
                        <i class="folder icon"></i>
                        <span>Hide Dirs</span>
                    </button>
                </div>
            </div>
            <div class="ui black inverted segment" id="dirs">
                <div class="ui primary text" v-on="click: upDirectory()">../</div>
                <div v-repeat="directory: directories">
                    <div class="ui primary text" v-on="click: setQuery(directory)">@{{ directory | relativePath }}</div>
                </div>
            </div>
            <div class="field">
                <label for="name">Name</label>
                <input type="text" name="name">
            </div>
            <div class="field">
                <label for="port">Port</label>
                <input type="text" name="port" value="{{ $port }}">
            </div>
            <input type="submit" class="ui primary button" value="Add Site" />
        </form>
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
                        $('#toggle span').text('Show Dirs');
                        $('#dirs').hide();
                        this.$set('showDirs', false);
                    } else {
                        $('#toggle span').text('Hide Dirs');
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