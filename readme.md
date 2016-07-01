# Install

    cp .env.example .env
    # fix .env as necessary for environment
    composer install
    php artisan key:generate
    composer install
    php artisan migrate
    # run seeders
    php artisan db:seed

# Develop

Edit from resources/assets not public/js or public/css

    npm install
    gulp watch

# Seeders

    php artisan db:seed --class=FinancialGoalTypesSeeder
    php artisan db:seed --class=FinancialRatioTypesSeeder
    php artisan db:seed --class=RolesTableSeeder

# Deploying changes

Specify the `--env=production` commandline option to do a production deployment

Standard deployment only does a `git pull` and resolves common permission issues. A full deploy will take the site down, do a composer install, force run all pending migrations, do an `artisan optimize`, fix common permission issues then bring the site back up.

Below are notes for ssh configs and deployments for stage and production environments.

## Stage Server

Setup `~/.ssh/config` for server with

    Host ficheck-stage
      HostName ####ficheck stage hostname or IP####
      User someuser
      IdentityFile ~/.ssh/ficheck-stage_id_rsa

For a git pull only deployment:

    envoy run deploy

For a full deployment:

    envoy run full-deploy

## Production Server

Setup `~/.ssh/config` for server with

    Host ficheck
      HostName ####ficheck production hostname or IP####
      User someuser
      IdentityFile ~/.ssh/ficheck_id_rsa

For a git pull only deployment:

    envoy run deploy --env=production

For a full deployment:

    envoy run full-deploy --env=production
