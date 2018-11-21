let mix = require("laravel-mix");

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

mix
    .webpackConfig({
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

    .postCss('resources/css/app.css', 'public/css')
    .options({
        postCss: [
            require('postcss-easy-import')(),
            require('tailwindcss')('./tailwind.js'),
            require('postcss-preset-env')({
                // The stage option determines which CSS features to polyfill,
                // based upon their stability in the process of becoming
                // implemented web standards.
                // The stage can be 0 (experimental) through 4 (stable), or false.
                // Setting stage to false will disable every polyfill. Doing
                // this would only be useful if you intended to exclusively
                // use the features option
                stage: 0,
            }),
            require('postcss-nested')(),
        ],

        // CSSNext already processes our css with Autoprefixer, so we don't
        // need mix to do it twice.
        autoprefixer: false,

        // Since we don't do any image preprocessing and write url's that are
        // relative to the site root, we don't want the css loader to try to
        // follow paths in `url()` functions.
        processCssUrls: false,
});