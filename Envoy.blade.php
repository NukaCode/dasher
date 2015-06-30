@servers(['local' => '127.0.0.1'])

@task('make-site')
    cd {{ $path }}
    pwd
    ~/.composer/vendor/bin/laravel new {{ $name }} {{ $type }}
@endtask

@task('nginx')
    nginx -s {{ $cmd }}
@endtask

@task('vagrant')
    cd {{ $dir }}
    pwd
    vagrant {{ $cmd }}
@endtask