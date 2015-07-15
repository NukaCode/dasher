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
                        @if (settingEnabled('nginx'))
                            <li>
                                <small class="pull-right">
                                    <a href="/nginx/create/@{{ group.id }}">Create New <span class="text-success">Nginx</span> Site</a>
                                </small>
                            </li>
                        @endif
                        @if (settingEnabled('homestead'))
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
                                <div style="width: 100%;" class="clearfix">
                                    <div style="width: 50%;" class="pull-left">
                                        <a href="http://localhost:@{{ site.port }}/" target="_blank">
                                            <ul class="list-inline">
                                                <li>@{{ site.port }}</li>
                                                <li>@{{ site.name }}</li>
                                            </ul>
                                        </a>
                                    </div>
                                    <div style="width: 35%;" class="pull-left" v-if="site.readyFlag == 0">
                                        <span class="text-muted"><i class="fa fa-spinner fa-spin"></i>&nbsp;@{{ site.status }}...</span>
                                    </div>
                                    <div style="width: 15%;" class="pull-right">
                                        <site-links site="@{{ site }}"></site-links>
                                    </div>
                                </div>
                            </div>
                            <div v-if="site.homesteadFlag == 1">
                                <div style="width: 100%;" class="clearfix">
                                    <div style="width: 50%;" class="pull-left">
                                        <a href="http://@{{ site.name }}/" target="_blank">
                                            <ul class="list-inline" style="width: 60%;">
                                                <li>@{{ site.port }}</li>
                                                <li>@{{ site.name }}</li>
                                            </ul>
                                        </a>
                                    </div>
                                    <div style="width: 35%;" class="pull-left" v-if="site.readyFlag == 0">
                                        <span class="text-primary"><i class="fa fa-spinner fa-spin"></i>&nbsp;@{{ site.status }}...</span>
                                    </div>
                                    <div style="width: 15%;" class="pull-right">
                                        <site-links site="@{{ site }}"></site-links>
                                    </div>
                                </div>
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
</div>

@section('js')
    <script id="site-links-template" type="x-template">
        <span class="btn-group pull-right">
            @if (settingEnabled('phpstorm') == 1)
                <a href="/site/editor/phpstorm/@{{ site.id }}" class="btn btn-xs btn-info"><small>PS</small></a>
            @endif
            @if (settingEnabled('sublime') == 1)
                <a href="/site/editor/sublime/@{{ site.id }}" class="btn btn-xs btn-info"><small>Sub</small></a>
            @endif
            @if (settingEnabled('atom') == 1)
                <a href="/site/editor/atom/@{{ site.id }}" class="btn btn-xs btn-info"><small>Atom</small></a>
            @endif
            <a v-show="site.homesteadFlag == 1" href="/homestead/edit/@{{ site.id }}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
            <a v-show="site.homesteadFlag == 1" href="/homestead/delete/@{{ site.id }}" class="confirm-remove btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
            <a v-show="site.homesteadFlag == 0" href="/nginx/edit/@{{ site.id }}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
            <a v-show="site.homesteadFlag == 0" href="/nginx/delete/@{{ site.id }}" class="confirm-remove btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
        </span>
    </script>
    <script>
        Vue.component('site-links', {
            props: ['site'],
            data: function () {
                return {
                    site: null
                }
            },
            template: document.querySelector('#site-links-template')
        });

        new Vue({
            el: '#vue',

            data: {
                search: '',
                groups: window.groups
            },

            ready: function () {
                var self = this;
                var setInts = new Array;

                $.each(this.groups, function (gIndex, group) {
                    $.each(group.sites, function (sIndex, site) {
                        if (site.readyFlag == 0) {
                            setInts[site.id] = setInterval(function () {
                                if (self.groups[gIndex].sites[sIndex].readyFlag == 1) {
                                    clearInterval(setInts[site.id]);
                                }
                                self.$http.get(window.siteJsonLink + '/' + site.id, function (newSite) {
                                    self.groups[gIndex].sites.$set(sIndex, newSite);
                                });
                            }, 1500);
                        }
                    });
                });
            }
        });
    </script>
@endsection