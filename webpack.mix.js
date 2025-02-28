// const mix = require('laravel-mix');

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

// mix.js('resources/js/app.js', 'public/js')
//     .vue()
//     .sass('resources/sass/app.scss', 'public/css');

// mix.js("resources/js/app.js", "public/js")
//   .postCss("resources/css/app.css", "public/css", [
//     require("tailwindcss"),
  
//   ]);

// 

const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix.js('resources/js/app.js', 'public/js')
// .sass('resources/sass/app.scss', 'public/css')
.postCss("resources/css/app.css", "public/css", [
     require("tailwindcss"),
    
   ])
   .copy('node_modules/select2/dist/css/select2.min.css', 'public/css')
   .copy('node_modules/select2/dist/js/select2.min.js', 'public/js');
  
    // .vue(); // Enable Vue.js support

// Add additional rules for Vue SFC files
mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            }
        ]
    },
    resolve: {
        alias: {
            vue$: 'vue/dist/vue.runtime.esm.js' // Resolve Vue runtime version for templates
        }
    }
});

