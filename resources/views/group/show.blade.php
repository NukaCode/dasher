<div class="ui grid" id="vue">
    <div class="fourteen wide column">
        <div class="ui fluid icon input">
            <input type="text" id="search" class="prompt primary" placeholder="Search..." v-model="search" />
            <i class="search icon"></i>
        </div>
    </div>
    <div class="two wide column">
        {!! HTML::linkRoute('nginx.create', 'Add New Site', [$group->id], ['class' => 'ui primary fluid button']) !!}
    </div>
    <div class="eight wide centered column">
        <div class="ui segments dark">
            <div class="ui horizontal segments">
                <div class="ui segment">
                    <h4 class="ui header primary text">{{ $group->name }}</h4>
                </div>
                {!! HTML::linkRouteIcon('group.edit', [$group->id], 'edit icon', null, ['class' => 'mini ui right attached primary compact icon button']) !!}
            </div>
            <div class="ui horizontal segments">
                <div class="ui segment">
                    <span class="ui grey text">Starting Port</span>
                    <span class="ui primary text">{{ $group->starting_port }}</span>
                </div>
                <div class="ui segment">
                    <span class="ui grey text">Sites</span>
                    <span class="ui primary text">{{ $group->sites()->count() }}</span>
                </div>
                <div class="ui segment">
                    <span class="ui grey text">Directory</span>
                    <span class="ui primary text">{{ $group->starting_path }}</span>
                </div>
            </div>
        </div>
        <div class="ui segments dark">
            <div class="ui horizontal segments" v-repeat="site: group.sites | filterBy search | orderBy 'name'"  v-if="group.sites.length > 0">
                <div class="ui segment" v-if="site.homesteadFlag == 0">
                    <a href="http://localhost:@{{ site.port }}/" target="_blank" class="ui left floated">
                        <span class="ui grey text">@{{ site.port }}</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="ui primary text">@{{ site.name }}</span>
                    </a>
                    <site-links site="@{{ site }}"></site-links>
                        <span class="ui grey text right floated" v-if="site.readyFlag == 0">
                            @{{ site.status }}...&nbsp;&nbsp;
                        </span>
                    <div class="ui bottom attached blue progress active" data-percent="100" v-if="site.readyFlag == 0">
                        <div class="bar" style="transition-duration: 100ms; -webkit-transition-duration: 100ms; width: 100%;"></div>
                    </div>
                </div>
                <div class="ui segment" v-if="site.homesteadFlag == 1">
                    <a href="http://@{{ site.name }}/" target="_blank" class="ui left floated">
                        <span class="ui grey text">@{{ site.port }}</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="ui primary text">@{{ site.name }}</span>
                    </a>
                    <site-links site="@{{ site }}"></site-links>
                        <span class="ui grey text right floated" v-if="site.readyFlag == 0">
                            @{{ site.status }}...&nbsp;&nbsp;
                        </span>
                    <div class="ui bottom attached blue progress active" data-percent="100" v-if="site.readyFlag == 0">
                        <div class="bar" style="transition-duration: 100ms; -webkit-transition-duration: 100ms; width: 100%;"></div>
                    </div>
                </div>
            </div>
            <div class="ui horizontal bottom attached segments" v-if="group.sites.length == 0">
                <div class="ui segment grey text">No sites added to the @{{ group.name }} group yet.</div>
            </div>
        </div>
    </div>
</div>

@section('js')
    <script id="site-links-template" type="x-template">
        <div class="mini ui right floated buttons">
            @if (settingEnabled('phpstorm') == 1)
                <a href="/site/editor/phpstorm/@{{ site.id }}" class="ui teal compact icon button">
                    <small>PS</small>
                </a>
            @endif
            @if (settingEnabled('sublime') == 1)
                <a href="/site/editor/sublime/@{{ site.id }}" class="ui teal compact button">
                    <small>Sub</small>
                </a>
            @endif
            @if (settingEnabled('atom') == 1)
                <a href="/site/editor/atom/@{{ site.id }}" class="ui teal compact button">
                    <small>Atom</small>
                </a>
            @endif
            <a v-show="site.homesteadFlag == 1" href="/homestead/edit/@{{ site.id }}" class="ui blue compact icon button">
                <i class="edit icon"></i>
            </a>
            <a v-show="site.homesteadFlag == 1" href="/homestead/delete/@{{ site.id }}" class="confirm-remove ui red compact icon button">
                <i class="trash icon"></i>
            </a>
            <a v-show="site.homesteadFlag == 0" href="/nginx/edit/@{{ site.id }}" class="ui blue compact icon button">
                <i class="edit icon"></i>
            </a>
            <a v-show="site.homesteadFlag == 0" href="/nginx/delete/@{{ site.id }}" class="confirm-remove ui red compact icon button">
                <i class="trash icon"></i>
            </a>
        </div>
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
                group: window.group
            },

            ready: function () {
                var self = this;
                var setInts = new Array;

                $.each(this.group.sites, function (sIndex, site) {
                    if (site.readyFlag == 0) {
                        setInts[site.id] = setInterval(function () {
                            if (self.group.sites[sIndex].readyFlag == 1) {
                                clearInterval(setInts[site.id]);
                            }
                            self.$http.get(window.siteJsonLink + '/' + site.id, function (newSite) {
                                self.group.sites.$set(sIndex, newSite);
                            });
                        }, 1500);
                    }
                });
            }
        });
    </script>
@endsection