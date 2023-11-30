const gulp = require('gulp');
const path = require('path');
const sass = require('gulp-sass')(require('sass'));
const autoprefixer = require('gulp-autoprefixer');
const sourcemaps = require('gulp-sourcemaps');
const open = require('gulp-open');

const browserSync = require('browser-sync').create();

const babel = require('gulp-babel');
const uglify = require('gulp-uglify');
// const pipeline = require('readable-stream').pipeline;
const uglifycss = require('gulp-uglifycss');
const rename = require("gulp-rename");
const { on } = require('events');

const Paths = {
  HERE: './',
  DIST: 'web/',
  DIST_CSS: 'web/css/',
  CSS: './src/assets/css/',
  JS: './src/assets/js/',
  DIST_JS: 'web/js/',
  HTML: './src/',
  SCSS_TOOLKIT_SOURCES: './src/assets/scss/dashboard.scss',
  SCSS: './src/assets/scss/**/**',
  SRC_JS: './src/assets/js/**/**'
};

gulp.task('compile-scss', function() {
  return gulp.src(Paths.SCSS_TOOLKIT_SOURCES)
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(sourcemaps.write(Paths.HERE))
    .pipe(gulp.dest(Paths.DIST_CSS));
});

gulp.task('minify-css', function () {
  return gulp.src(Paths.CSS+'**/*.css')
    .pipe(uglifycss({
      "uglyComments": true
    }))
    .pipe(rename({ extname: '.min.css' }))
    .pipe(gulp.dest(Paths.DIST_CSS));
});

gulp.task('copy-css', function() {
  return gulp.src(Paths.CSS+'**/*.css')
    .pipe(gulp.dest(Paths.DIST_CSS));
});

gulp.task('css', gulp.parallel('compile-scss', 'minify-css', 'copy-css'));

gulp.task('minify-js', function() {
  return gulp.src(Paths.JS+'**/*.js')
    .pipe(babel({
        presets: ['@babel/preset-env']
	}))
    .pipe(gulp.src(Paths.JS+'**/*.js'))
    .pipe(gulp.dest(Paths.JS))
    .pipe(uglify())
    .pipe(rename({ extname: '.min.js' }))
    .pipe(gulp.dest(Paths.DIST_JS));
});

gulp.task('copy-js', function() {
  return gulp.src(Paths.JS+'**/*.js')
    .pipe(gulp.dest(Paths.DIST_JS));
});

gulp.task('js', gulp.parallel('minify-js', 'copy-js'));

// browsersync tasks
function browserSyncServe (cb) {
  browserSync.init({
    server: {
      baseDir:'./web/'
    }
  });
  cb();
}

function Reload(cb) {
  browserSync.reload();
  cb();
}

gulp.task('watch', function() {
  gulp.watch(Paths.SCSS, gulp.series('compile-scss'));
  gulp.watch(Paths.CSS, gulp.series('minify-css'));
  gulp.watch(Paths.CSS, gulp.series('copy-css'));
  gulp.watch(Paths.JS, gulp.series('minify-js'));
  gulp.watch(Paths.JS, gulp.series('copy-js'));

});

gulp.task('open', function() {
  gulp.src('web/index.php')
    .pipe(open());
});

gulp.task('open-app', gulp.parallel('open', 'watch'));