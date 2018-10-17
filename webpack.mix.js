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
  .js("resources/js/app.js", "public/js")
    .less('resources/less/app.less', 'public/css')
    .options({
        postCss: [
            tailwindcss('./tailwind.js'),
        ]
    });

if (mix.inProduction()) {
  mix.version();
}
