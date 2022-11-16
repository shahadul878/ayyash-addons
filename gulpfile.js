/**
 * Gulp Config.
 * @version 1.0.0
 */

//const app = require( './package.json' );
const gulp = require('gulp');
const babel = require('gulp-babel');
const eslint = require('gulp-eslint');
const prettify = require('gulp-js-prettify');
const terser = require('gulp-terser');
const rename = require('gulp-rename');
const {sass} = require("@mr-hope/gulp-sass");
const rtlcss = require('gulp-rtlcss');
const minifyCSS = require('gulp-clean-css');
const autoprefixer = require('gulp-autoprefixer');
const sourcemaps = require('gulp-sourcemaps');
const mode = require('gulp-mode')();


// Tasks
gulp.task('compile:js', () => {
    return gulp.src([
        'assets/src/js/**/*.js',
        '!assets/src/js/**/*.min.js',
        '!assets/src/js/utils/*.min.js',
        '!assets/src/js/libraries/sweetalert2.all.js',
    ])
        .pipe(mode.development(sourcemaps.init({largeFile: true})))
        .pipe(eslint())
        .pipe(mode.development(eslint.format()))
        .pipe(babel({presets: ['@babel/env']}))
        .pipe(mode.production(terser()))
        .pipe(mode.development(prettify({"indent_with_tabs": true,})))
        .pipe(mode.development(sourcemaps.write('/.')))
        .pipe(gulp.dest('assets/dist/js'));
});

// Tasks
// gulp.task('copy:js', () => {
//     return gulp.src( [
//         'assets/src/js/libraries/sweetalert2.all.js'
//     ] )
//         .pipe(gulp.dest('assets/dist/js/libraries'));
// } );

gulp.task('minify:js', () => {
    return gulp.src([
        'assets/dist/js/**/*.js',
        '!assets/dist/js/**/*.min.js',
    ])
        .pipe(mode.development(sourcemaps.init({largeFile: true})))
        .pipe(terser())
        .pipe(rename({suffix: '.min'}))
        .pipe(mode.development(sourcemaps.write('/.')))
        .pipe(gulp.dest('assets/dist/js'));
});

gulp.task('compile:scss', () => {
    return gulp.src([
        'assets/src/scss/**/*.scss',
    ])
        .pipe(mode.development(sourcemaps.init({largeFile: true})))
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(mode.production(minifyCSS()))
        .pipe(mode.development(sourcemaps.write('/.')))
        .pipe(gulp.dest('assets/dist/css'));
});

gulp.task('rtl:css', function () {
    return gulp.src([
        'assets/dist/css/**/*.css',
        '!assets/dist/css/**/*-rtl.css',
    ])
        .pipe(mode.development(sourcemaps.init({largeFile: true})))
        .pipe(gulp.dest('assets/dist/css'))
        .pipe(rtlcss())
        .pipe(rename({suffix: '-rtl'}))
        .pipe(mode.development(sourcemaps.write('/.')))
        .pipe(gulp.dest('assets/dist/css'));
});

gulp.task('minify:css', function () {
    return gulp.src([
        'assets/dist/css/**/*.css',
        '!assets/dist/css/**/*.min.css'
    ])
        .pipe(mode.development(sourcemaps.init({largeFile: true})))
        .pipe(minifyCSS())
        .pipe(rename({suffix: '.min'}))
        .pipe(mode.development(sourcemaps.write('/.')))
        .pipe(gulp.dest('assets/dist/css'));
});

// Combined tasks.
// gulp.task('buildJs', gulp.series('compile:js', 'copy:js'));
gulp.task('buildJs', gulp.series('compile:js'));
gulp.task('buildCss', gulp.series('compile:scss', 'rtl:css'));

gulp.task('build', gulp.series('buildCss', 'buildJs'));

gulp.task('watch', () => new Promise((resolve, reject) => {
    try {
        gulp.watch('assets/src/js/**/*.js', {ignoreInitial: true}, gulp.series('buildJs'));
        gulp.watch('assets/src/scss/**/*.scss', {ignoreInitial: true}, gulp.series('buildCss'));
        resolve();
    } catch (e) {
        reject(e);
    }
}));
