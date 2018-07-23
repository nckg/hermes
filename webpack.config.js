/* eslint-disable no-unused-vars,prefer-const,import/no-dynamic-require,no-undef */
/**
 * As our first step, we'll pull in the user's webpack.mix.js
 * file. Based on what the user requests in that file,
 * a generic config object will be constructed for us.
 */
let mix = require('laravel-mix/src/index');

let ComponentFactory = require('laravel-mix/src/components/ComponentFactory');

new ComponentFactory().installAll();

if (process.env.NODE_ENV === 'testing') {
    Mix.manifest.refresh = () => {};
}

require(Mix.paths.mix());

/**
 * Just in case the user needs to hook into this point
 * in the build process, we'll make an announcement.
 */

Mix.dispatch('init', Mix);

/**
 * Now that we know which build tasks are required by the
 * user, we can dynamically create a configuration object
 * for Webpack. And that's all there is to it. Simple!
 */

let WebpackConfig = require('laravel-mix/src/builder/WebpackConfig');

const config = new WebpackConfig().build();
const defaultRulesToRemove = [
    /(\.(png|jpe?g|gif)$|^((?!font).)*\.svg$)/,
];

defaultRulesToRemove.forEach((ruleToDelete) => {
    config.module.rules.forEach((rule, index) => {
        if (String(rule.test) === String(ruleToDelete)) {
            config.module.rules.splice(index, 1);
        }
    });
});

module.exports = config;
