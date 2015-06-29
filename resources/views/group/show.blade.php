<div class="row" id="vue">
    <div class="col-md-offset-2 col-md-8">
        <div class="row">
            <div class="col-md-10">
                <input type="text" id="search" class="form-control" placeholder="Search..." v-model="search" />
            </div>
            <div class="col-md-2">
                {!! HTML::linkRoute('site.create', 'Add New Site', [$group->id], ['class' => 'btn btn-primary btn-block']) !!}
            </div>
        </div>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <div class="panel-title pull-left">{{ $group->name }}</div>
                <div class="pull-right">
                    {!! HTML::linkRoute('group.edit', 'Edit', [$group->id], ['class' => 'btn btn-xs btn-primary']) !!}
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    {!! HTML::description(['Starting Port' => $group->starting_port, 'Sites' => $group->sites()->count()], ['class' => 'dl-horizontal']) !!}
                </div>
            </div>
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
    </div>
</div>

@section('js')
    <script>
        new Vue({
            el: '#vue',

            data: {
                search: '',
                group: window.group
            }
        });
    </script>
@endsection