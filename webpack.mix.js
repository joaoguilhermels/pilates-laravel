const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
	.sass('resources/assets/sass/app.scss', 'public/css');
	/*.styles([
			'node_modules/jquery-datetimepicker/jquery.datetimepicker.css',
			'node_modules/sweetalert2/dist/sweetalert2.css',
			'node_modules/multiselect/css/multi-select.css'
		]);
	.copy('./node_modules/multiselect/img/switch.png', 'public/img/switch.png')
	.copy('./node_modules/bootswatch', 'resources/assets/sass/bootswatch');*/
/*		.webpack('app.js')
		.sass('app.scss');*/