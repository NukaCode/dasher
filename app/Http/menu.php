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

$leftMenu->link('install', function (Link $link) {
    $link->name = 'Install Site';
    $link->url  = route('site.install');
});

$leftMenu->link('clone', function (Link $link) {
    $link->name = 'Clone Site';
    $link->url  = route('site.clone');
});

$rightMenu = \Menu::getMenu('rightMenu');

$rightMenu->link('settings', function (Link $link) {
    $link->name = 'Settings';
    $link->url  = route('setting.index');
});