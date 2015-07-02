<div id="mainMenu">
    <nav class="navbar navbar-default navbar-static-top" role="navigation">
        @if (Menu::exists('leftMenu') && Menu::hasLinks('leftMenu'))
            <ul class="nav navbar-nav">
                @each('layouts.menus.twitter.item', Menu::render('leftMenu')->links, 'item')
            </ul>
        @endif
        @if (Menu::exists('rightMenu') && Menu::hasLinks('rightMenu'))
            <ul class="nav navbar-nav navbar-right">
                @each('layouts.menus.twitter.item', Menu::render('rightMenu')->links, 'item')
            </ul>
        @endif
    </nav>
</div>
<br style="clear: both;" />