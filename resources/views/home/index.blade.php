<div class="row" id="vue">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <input type="text" id="search" class="form-control" placeholder="Search..." v-model="search" />
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-4" v-repeat="group: groups">
                <h6>
                    @{{ group.name }}
                    <ul class="list-inline pull-right">
                        @if (setting('nginxFlag'))
                            <li>
                                <small class="pull-right">
                                    <a href="/nginx/create/@{{ group.id }}">Create New <span class="text-success">Nginx</span> Site</a>
                                </small>
                            </li>
                        @endif
                        @if (setting('homesteadFlag'))
                            <li>
                                <small class="pull-right">
                                    <a href="/homestead/create/@{{ group.id }}">Create New <span class="text-success">Homestead</span> Site</a>
                                </small>
                            </li>
                        @endif
                    </ul>
                </h6>
                <div v-if="group.sites.length > 0">
                    <div class="list-group">
                        <div class="list-group-item clearfix site" v-repeat="site: group.sites | filterBy search | orderBy 'name'">
                            <div v-if="site.homesteadFlag == 0">
                                <a href="http://localhost:@{{ site.port }}/" target="_blank">
                                    <ul class="list-inline">
                                        <li>@{{ site.port }}</li>
                                        <li>@{{ site.name }}</li>
                                    </ul>
                                </a>
                                <span class="btn-group pull-right" style="margin-top: -23px;">
                                    <a href="/nginx/edit/@{{ site.id }}" class="btn btn-xs btn-primary">Edit</a>
                                    <a href="/nginx/delete/@{{ site.id }}" class="confirm-remove btn btn-xs btn-danger">Delete</a>
                                </span>
                            </div>
                            <div v-if="site.homesteadFlag == 1">
                                <a href="http://@{{ site.name }}/" target="_blank">
                                    <ul class="list-inline">
                                        <li>@{{ site.port }}</li>
                                        <li>@{{ site.name }}</li>
                                    </ul>
                                </a>
                                <span class="btn-group pull-right" style="margin-top: -23px;">
                                    <a href="/homestead/edit/@{{ site.id }}" class="btn btn-xs btn-primary">Edit</a>
                                    <a href="/homestead/delete/@{{ site.id }}" class="confirm-remove btn btn-xs btn-danger">Delete</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="group.sites.length == 0">
                    <div class="list-group">
                        <div class="list-group-item text-primary">No sites added to the @{{ group.name }} group yet.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--<div class="col-md-4">--}}
        {{--@include('home.partials.services')--}}
    {{--</div>--}}
</div>

@section('js')
    <script>
        new Vue({
            el: '#vue',

            data: {
                search: '',
                groups: window.groups
            }
        });
    </script>
@endsection