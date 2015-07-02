<?php

use NukaCode\Menu\Link;

$leftMenu = \Menu::getMenu('leftMenu');

$leftMenu->link('home', function (Link $link) {
    $link->name = 'Home';
    $link->url  = route('home');
});

$leftMenu->link('groups', function (Link $link) {
    $link->name = 'Groups';
    $link->url  = route('group.index');
});

$leftMenu->link('generate', function (Link $link) {
    $link->name = 'Generate Site';
    $link->url  = route('site.generate');
});

$rightMenu = \Menu::getMenu('rightMenu');

$rightMenu->link('settings', function (Link $link) {
    $link->name = 'Settings';
    $link->url  = route('setting.index');
});