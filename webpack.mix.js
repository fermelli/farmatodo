const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
])
    .js('resources/js/app.js', 'public/js')
    .js('resources/js/vue/roles/main.js', 'public/js/vue/roles/')
    .js(
        'resources/js/vue/shopping-cart/main.js',
        'public/js/vue/shopping-cart/'
    )
    .js('resources/js/vue/purchases/main.js', 'public/js/vue/purchases/')
    .js('resources/js/vue/discounts/main.js', 'public/js/vue/discounts/')
    .vue();
