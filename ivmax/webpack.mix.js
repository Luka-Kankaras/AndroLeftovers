const mix = require("laravel-mix");
const path = require("path");

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

mix.disableNotifications();

mix.js("resources/js/app.js", "public/js")
    .vue({ version: 2 })
    .js("resources/js/admin.js", "public/js")
    .vue({ version: 2 })
    .js("resources/js/scripts.js", "public/js")
    .sass("resources/sass/app.scss", "public/css")
    .sass("resources/sass/admin.scss", "public/css")
    .extract(["vue", "vue-router", "sweetalert2"])
    .sourceMaps();

mix.webpackConfig({
    output: {
        filename: "[name].js",
        chunkFilename: "js/[name].js?id=[chunkhash]"
    },
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "resources/js"),
            "@admin": path.resolve(__dirname, "resources/js/components/admin")
        }
    },
    optimization: {
        providedExports: false,
        sideEffects: false,
        usedExports: false
    }
});

mix.babelConfig({
    plugins: ["@babel/plugin-syntax-dynamic-import"]
});

if (mix.inProduction()) {
    mix.options({
        postCss: [
            require("@fullhuman/postcss-purgecss")({
                content: [
                    "app/**/*.php",
                    "resources/**/*.js",
                    "resources/**/*.php",
                    "resources/**/*.vue"
                ],
                defaultExtractor: content =>
                    content.match(/[\w-/.:]+(?<!:)/g) || [],
                safelist: [
                    /^router-link/,
                    /^pagination/,
                    /^page-/,
                    /-active$/,
                    /-enter$/,
                    /-leave-to$/,
                    /^modal/,
                    /^multiselect/,
                    /fade/,
                    /show/,
                    /sr-only/,
                    /sidebar-collapse/,
                    /justify-content-end/
                ]
            })
        ]
    }).version();
}
