<div class="ui secondary pointing primary menu">
    @if (Menu::exists('leftMenu') && Menu::hasLinks('leftMenu'))
        @each('layouts.menus.semantic.item', Menu::render('leftMenu')->links, 'item')
    @endif
    @if (Menu::exists('rightMenu') && Menu::hasLinks('rightMenu'))
        <div class="right menu">
            @each('layouts.menus.semantic.item', Menu::render('rightMenu')->links, 'item')
        </div>
    @endif
</div>