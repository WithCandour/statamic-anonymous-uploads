const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'resources/public/js/statamic-anonymous-uploads.js').vue({ version: 2 });
