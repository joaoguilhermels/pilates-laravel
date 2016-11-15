const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

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

elixir(mix => {
	mix.styles([
			'./node_modules/jquery-datetimepicker/jquery.datetimepicker.css',
			'./node_modules/sweetalert2/dist/sweetalert2.css',
			'./node_modules/multiselect/css/multi-select.css'
		])
		.copy('./node_modules/multiselect/img/switch.png', 'public/img/switch.png')
		.copy('./node_modules/bootswatch', 'resources/assets/sass/bootswatch')
		.webpack('app.js')
		.sass('app.scss');
});
