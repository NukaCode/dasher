@servers(['local' => '127.0.0.1'])

@task('get-nuka-installer')
    composer global require "nukacode/installer=~2.1"
@endtask

@task('nginx')
    nginx -s {{ $cmd }}
@endtask

@task('nginx-restart')
    nginx -s stop
    nginx -c  ~/Library/Application\ Support/com.webcontrol.WebControl/nginx/nginx.conf
@endtask

@task('make-site')
    cd {{ $path }}
    laravel new {{ $name }}
@endtask

@task('nuka-installer-version')
    ~/.composer/vendor/bin/laravel --version
@endtask

@task('nginx-version')
    nginx -v
@endtask

@task('mysql-version')
    mysql --version
@endtask