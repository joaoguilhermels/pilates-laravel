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
    mix.sass('app.scss')
       .copy('node_modules/multiselect', 'public/vendor/multiselect');	

    //mix.copy('node_modules/multiselect/css/multi-select.css', 'public/vendor/multiselect/css/multi-select.css');

    /*mix.scripts([
        'resources/assets/js/vendor/multiselect/jquery.multi-select.js'
    ], 'public/js/vendor/vendor.js');*/

});
