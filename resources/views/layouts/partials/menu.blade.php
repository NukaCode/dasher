@if (Menu::count() > 0)
    @include('layouts.menus.'. Config::get('nukacode-frontend.menu'))
@endif
