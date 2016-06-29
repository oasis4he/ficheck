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