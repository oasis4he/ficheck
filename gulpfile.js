var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss');

    elixir(function(mix) {
      mix.scripts(['app.js', '**.js', '**/*.js'], 'public/js/app.js');
    });
    elixir(function(mix){
      mix.version(['js/app.js', 'css/app.css', 'js/jquery-ui.min.js', 'css/jquery-ui.min.css', 'css/jquery-ui.structure.min.css', 'css/jquery-ui.theme.min.css'])
    });
});
