const gulp = require('gulp');
const sass = require('gulp-sass');
const minifyCSS = require('gulp-clean-css');
const autoprefixer = require('gulp-autoprefixer');
const browserSync = require('browser-sync').create();

// compile scss into css
function style() {
    return gulp.src('./scss/**/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({
        browsers: ['last 2 versions'],
        cascade: false
    }))
    .pipe(gulp.dest('./css'));
}

function minify() {
    return gulp.src('./css/main.css')
    .pipe(minifyCSS({level: {1: {specialComments: false}}}))
    .pipe(gulp.dest('css/dist'))
}

function watch() {
   gulp.watch('./scss/**/*.scss', style);
   gulp.watch('./css/main.css', minify);
}

exports.style = style;
exports.watch = watch;