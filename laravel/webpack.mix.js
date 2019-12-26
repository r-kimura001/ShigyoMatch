const mix = require('laravel-mix')

mix
  .browserSync('shigyo-match.site:10080')
  .js(
    'resources/js/app.js',
    'public/js',
    'node_modules/swiper/js/swiper.min.js'
  )
  .sass(
    'resources/sass/app.scss',
    'public/css',
    'node_modules/swiper/css/swiper.min.css'
  )
  .version()

mix.webpackConfig({
  resolve: {
    extensions: ['.js', '.vue', '.json'],
    alias: {
      vue$: 'vue/dist/vue.esm.js',
      '@': __dirname + '/resources/js',
    },
  },
})
