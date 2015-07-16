<div class="ui grid" id="vue">
    <div class="sixteen wide column">
        <div class="ui fluid icon input">
            <input type="text" id="search" class="prompt primary" placeholder="Search..." v-model="search" />
            <i class="search icon"></i>
        </div>
    </div>
    <div class="four wide column" v-repeat="group: groups">
        <div class="ui left floated primary text">
            <a href="/group/@{{ group.id }}">@{{ group.name }}</a>
        </div>
        <div class="ui horizontal link list right floated">
            @if (settingEnabled('nginx'))
                <a href="/nginx/create/@{{ group.id }}" class="item">
                    <small>
                        Create New <span class="ui green text">Nginx</span> Site
                    </small>
                </a>
            @endif
            @if (settingEnabled('homestead'))
                <li>
                    <small class="pull-right">
                        <a href="/homestead/create/@{{ group.id }}">Create New <span class="text-success">Homestead</span> Site</a>
                    </small>
                </li>
            @endif
        </div>
        <div class="clearfix"></div>
        <div v-if="group.sites.length > 0">
            <div class="ui segments dark">
                <div class="ui horizontal segments" v-repeat="site: group.sites | filterBy search | orderBy 'name'">
                    <div class="ui segment" v-if="site.homesteadFlag == 0">
                        <a href="http://localhost:@{{ site.displayPort }}/" target="_blank" class="ui left floated">
                            <span class="ui grey text">@{{ site.displayPort }}</span>
                            {{--<span>@{{ site.displayPort | portSpaces }}</span>--}}
                            <span v-if="site.displayPort < 100">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <span v-if="site.displayPort < 1000 && site.displayPort >= 100">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <span v-if="site.displayPort < 10000 && site.displayPort >= 1000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <span v-if="site.displayPort < 100000 && site.displayPort >= 10000">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <span v-if="site.displayPort < 1000000 && site.displayPort >= 100000">&nbsp;&nbsp;&nbsp;</span>
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
            </div>
        </div>
        <div class="ui segment dark" v-if="group.sites.length == 0">
            <div class="ui grey text">No sites added to the @{{ group.name }} group yet.</div>
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

//        Vue.filter('portSpaces', function (value) {
//            var portLength = value.toString().length;
//
//            var entityMap = {
//                "&": "&amp;",
//                "<": "&lt;",
//                ">": "&gt;",
//                '"': '&quot;',
//                "'": '&#39;',
//                "/": '&#x2F;'
//            };
//
//            if (portLength == 2) {
//                return "\s\s\s\s\s\s\s\s\s\s";
//            } else if (portLength == 3) {
//                var result = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
//            } else if (portLength == 4) {
//                var result = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
//            } else if (portLength == 5) {
//                var result = '&nbsp;&nbsp;&nbsp;&nbsp;';
//            } else if (portLength == 6) {
//                var result = '&nbsp;&nbsp;&nbsp;';
//            }
//
//            return String(result).replace(/[&<>"'\/]/g, function (s) {
//                return entityMap[s];
//            });
//        });

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
            },

            methods: {
                portSpace: function () {

                }
            }
        });
    </script>
@endsection