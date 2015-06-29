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
                <h6>@{{ group.name }} <small class="pull-right"><a href="/site/create/@{{ group.id }}">Create New @{{ group.name }} Site</a></small></h6>
                <div v-if="group.sites.length > 0">
                    <div class="list-group">
                        <div class="list-group-item clearfix site" v-repeat="site: group.sites | filterBy search | orderBy 'port'">
                            <a href="http://localhost:@{{ site.port }}/" target="_blank">
                                <ul class="list-inline">
                                    <li>@{{ site.port }}</li>
                                    <li>@{{ site.name }}</li>
                                </ul>
                            </a>
                            <span class="btn-group pull-right" style="margin-top: -23px;">
                                <a href="/site/edit/@{{ site.id }}" class="btn btn-xs btn-primary">Edit</a>
                                <a href="/site/delete/@{{ site.id }}" class="confirm-remove btn btn-xs btn-danger">Delete</a>
                            </span>
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