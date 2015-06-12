@servers(['local' => '127.0.0.1'])

@task('get-nuka-installer')
    composer global require "nukacode/installer=~2.1"
@endtask

@task('nuka-installer-version')
    ~/.composer/vendor/bin/laravel --version
@endtask