         // Includes (run: 'npm install' to install these before running 'gulp')
var gulp = require('gulp')
  , prompt = require('gulp-prompt')
  , sass = require('gulp-sass')
  , sourcemaps = require('gulp-sourcemaps')
  , autoprefixer = require('gulp-autoprefixer')
  , imagemin = require('gulp-imagemin')
  //, pngquant = require('imagemin-pngquant') // $ npm i -D imagemin-pngquant
  , source = require('vinyl-source-stream')
  , concat = require('gulp-concat')
  , minify = require('gulp-minify')
  , scsslint = require('gulp-scss-lint')
  , del = require('del')
  , runSequence = require('run-sequence')
  , jshint = require('gulp-jshint')
  , bower = require('gulp-bower');;

// Source / compilation directories
var sassDir = './sass/**/*.scss'
  , bowerDir = './vendor/bower_components'
  , jsDir = './webroot/assets/scripts/*'
  , bootstrapFontsDir = './vendor/bower_components/bootstrap-sass/assets/fonts/bootstrap/**/*'
  , bootstrapFontsDistDir = './webroot/dist/bootstrap'
  , fontsDir = './webroot/assets/fonts/**/*'
  , imgDir = './webroot/assets/img/*'
  , fontsDistDir = './webroot/dist/fonts'
  , imgDistDir = './webroot/dist/img'
  , cssDir = './webroot/dist/css';

// These files get concatenated in this order, into /dist/scripts/build.js
var jsPaths = [
  './vendor/bower_components/jquery-1.11.1/dist/jquery.min.js',
  './vendor/bower_components/bootstrap/js/collapse.js',
  './vendor/bower_components/bootstrap/js/modal.js',
  //'./vendor/bower_components/jPushMenu/js/jPushMenu.js',
  //'./vendor/bower_components/bootstrap-validator/dist/validator.min.js',
  './vendor/bower_components/jquery-selectboxit/libs/jqueryUI/jquery-ui.js',
  './vendor/bower_components/jquery-selectboxit/src/javascripts/jquery.selectBoxIt.js',
  './vendor/bower_components/moment/moment.js',
  './vendor/bower_components/bootstrap-daterangepicker/daterangepicker.js',
  './vendor/bower_components/chosen/chosen.jquery.js',
  './vendor/bower_components/blockUI/jquery.blockUI.js',
  './webroot/assets/scripts/*',
];

// Options
var sassOptions = {
  errLogToConsole: true,
  outputStyle: 'expanded'
};

var autoprefixerOptions = {
  browsers: ['last 2 versions', '> 5%', 'Firefox ESR']
};

var sasslintOptions = {
  'config': 'sass-lint.yml',
}

// TASK: watch
// watch task – watches sass, js and img directories for changes, and rebuilds
// assets if there is a change
gulp.task('watch', function() {
  gulp
    // Watch the input folder for change,
    // and run `sass` task when something happens
    .watch(sassDir, ['sass:dev'])
    // When there is a change,
    // log a message in the console
    .on('change', function(event) {
      console.log('File ' + event.path + ' was ' + event.type + ', running...');
    });
  gulp
    .watch(jsDir, ['scripts:dev'])
    // When there is a change,
    // log a message in the console
    .on('change', function(event) {
      console.log('File ' + event.path + ' was ' + event.type + ', running...');
    });
});

// TASK: sass
// sass task, compiles sass
gulp.task('sass:dev', function () {
  return gulp
    .src(sassDir)
    .pipe(sourcemaps.init())
    .pipe(sass(sassOptions).on('error', sass.logError))
    .pipe(autoprefixer(autoprefixerOptions))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(cssDir));
});

// TASK: prod:sass
// The prod:sass task, useful for building production ready sass
gulp.task('sass:prod', [], function () {
  gulp
    .src(sassDir)
    .pipe(sass({ outputStyle: 'compressed' }))
    .pipe(autoprefixer(autoprefixerOptions))
    .pipe(gulp.dest(cssDir));
});

// TASK: scripts
// Concats all js files in the order shown – outputs to dist/scripts/build.js
gulp.task('scripts:dev', function() {
  return gulp.src(jsPaths)
    .pipe(concat('build.js'))
    .pipe(gulp.dest('./webroot/dist/scripts'));
});

// TASK: prod:js
// The prod:js task, useful for building production ready js
gulp.task('scripts:prod', function() {
  gulp.src('./webroot/dist/scripts/build.js')
    .pipe(minify({
        exclude: ['tasks'],
        ignoreFiles: ['.combo.js', '-min.js']
    }))
    .pipe(gulp.dest('./webroot/dist'))
});

// The img task - copy from assets to dist and minify
gulp.task('img', function() {
  return gulp.src(imgDir)
  .pipe(imagemin())
    .pipe(gulp.dest(imgDistDir));
});

// TASK: build
// Force a clean and then compile into /dist
gulp.task('build', function(callback) {
  runSequence(
    'clean:dist',
    ['sass:prod', 'scripts:prod'],
    callback
  )
})

// TASK: clean:dist
// Clean dist directory
gulp.task('clean:dist', function() {
  // return del.sync(['dist/**/*', '!dist/images', '!dist/images/**/*']);
  return del.sync(['./webroot/dist/**/*']);
});

//install the bower components to the vendor directory
gulp.task('install-bower', function() {
  return bower({ directory: './vendor/bower_components'});
});

gulp.task('icons', function() { 
    return gulp.src(bowerDir + '/font-awesome/fonts/**.*') 
        .pipe(gulp.dest(fontsDistDir)); 
});

// TASK: default
// The default task, ie. 'gulp' – runs sass, img, fonts, scripts and watch tasks
gulp.task('default', ['sass:dev', 'scripts:dev', 'img', 'icons', 'watch']);

