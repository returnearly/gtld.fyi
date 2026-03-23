const mix = require('laravel-mix');
require('laravel-mix-jigsaw');

mix.disableSuccessNotifications();
mix.setPublicPath('source/assets/build');

mix.js('source/_assets/js/main.js', 'js')
    .postCss('source/_assets/css/main.css', 'css/main.css')
    .jigsaw({
        watch: ['config.php', 'source/**/*.md', 'source/**/*.php', 'source/**/*.css'],
    })
    .options({
        processCssUrls: false,
        postCss: [
            require('postcss-import'),
            require('tailwindcss'),
            require('autoprefixer'),
        ],
    })
    .sourceMaps()
    .version();
