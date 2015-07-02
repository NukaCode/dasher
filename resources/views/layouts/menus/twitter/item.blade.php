@if ($item->isDropDown() && $item->hasLinks())
    <li class="dropdown {{ $item->active ? 'active' : '' }}">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $item->name }}<b class="caret"></b></a>
        <ul class="dropdown-menu">
            @each('layouts.menus.twitter.item', $item->links, 'item')
        </ul>
    </li>
@else
    <li class="{{ $item->active ? 'active' : '' }}">
        {!! HTML::link($item->url, $item->name, $item->options) !!}
    </li>
@endif