@servers(['local' => '127.0.0.1'])

<?php

    if (! isset($path)) {
        $path = null;
    }
    if (! isset($name)) {
        $name = null;
    }
    if (! isset($type)) {
        $type = null;
    }
    if (! isset($url)) {
        $url = null;
    }
    if (! isset($cmd)) {
        $cmd = null;
    }
    if (! isset($sql)) {
        $sql = null;
    }
?>

@task('make-site')
    cd {{ $path }}; pwd
    ~/.composer/vendor/bin/laravel new {{ $name }} {{ $type }}
@endtask

@task('clone')
    cd {{ $path }}; pwd
    git clone {{ $url }} ./{{ $name }}
@endtask

@task('composer')
    cd {{ $path }}; pwd
    composer {{ $cmd }}
@endtask

@task('copy-env')
    cd {{ $path }}; pwd
    cp .env.example .env
@endtask

@task('artisan')
    cd {{ $path }}; pwd
    php artisan {{ $cmd }}
@endtask

@task('nginx')
    nginx -s {{ $cmd }}
@endtask

@task('mysql')
    mysql -uroot -e "{{ $sql }}"
@endtask

@task('vagrant')
    cd {{ $path }}; pwd
    vagrant {{ $cmd }}
@endtask