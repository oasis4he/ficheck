@servers(['local' => 'localhost', 'stage' => 'ficheck-stage', 'production' => 'ficheck', 'vagrant' => 'vagrant'])

@setup
    $env = (isset($env)) ? $env : 'stage';

    $processUser = posix_getpwuid(posix_geteuid());
    $user = $processUser['name'];

@endsetup

@task('deploy', ['on' => $env])
    cd /var/www/ficheck-laravel/
    sudo chown -R ubuntu:ubuntu ./
    git pull

    sudo chown -R www-data:www-data public/ storage/ bootstrap/
@endtask

@task('full-deploy', ['on' => $env])
    cd /var/www/ficheck-laravel/
    sudo chown -R ubuntu:ubuntu ./
    php artisan down
    git pull
    composer install
    php artisan migrate --force
    php artisan optimize
    php artisan up
    sudo chown -R www-data:www-data public/ storage/ bootstrap/
@endtask

@task('nginx', ['on' => $env])
    sudo nginx -t
@endtask

@task('nginx-restart', ['on' => $env])
    sudo service nginx restart
@endtask

