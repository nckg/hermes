let mix = require("laravel-mix");
let tailwindcss = require("tailwindcss");
require("laravel-mix-purgecss");

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

mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.svg$/,
                loader: 'vue-svg-loader', // `vue-svg` for webpack 1.x
                options: {
                    // optional [svgo](https://github.com/svg/svgo) options
                    svgo: {
                        plugins: [
                            { removeViewBox: false },
                            { removeComments: true },
                        ],
                    },
                },
            },
        ],
    },
})
  .js("resources/assets/js/app.js", "public/js")
    .less('resources/assets/less/app.less', 'public/css')
    .options({
        postCss: [
            tailwindcss('./tailwind.js'),
        ]
    });

if (mix.inProduction()) {
  mix.version();
}

// If you want to use LESS for your preprocessing
// mix.less('resources/assets/less/main.less', 'public/css')
//   .options({
//     postCss: [
//       tailwindcss('./tailwind.js'),
//     ]
//   })

// If you want to use SASS for preprocessing
// mix.sass('resources/assets/sass/app.scss', 'public/css')
//    .options({
//       processCssUrls: false,
//       postCss: [ tailwindcss('tailwind.js') ],
//    });
