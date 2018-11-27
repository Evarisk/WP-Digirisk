var gulp = require('gulp');
var please = require('gulp-pleeease');
var watch = require('gulp-watch');
var plumber = require('gulp-plumber');
var rename = require("gulp-rename");
var cssnano = require('gulp-cssnano');
var concat = require('gulp-concat');
var glob = require("glob");
var uglify = require('gulp-uglify');
var sass = require('gulp-sass');
var stripCssComments = require('gulp-strip-css-comments');

var paths = {
    scss: [ 'css/scss/**/*.scss', 'css/' ],
    css: [ 'css/style.css' ],
 js: ['js/init.js', 'js/*.lib.js'],
};

gulp.task('build_scss', function() {
    gulp.src(paths.scss[0])
        .pipe( sass().on( 'error', sass.logError ) )
        .pipe(stripCssComments())
        .pipe(please({
            minifier: false,
            autoprefixer: {"browsers": ["last 40 versions", "ios 6", "ie 9"]},
            pseudoElements: true,
            sass: true
        }))
        .pipe( gulp.dest( paths.scss[1] ) );
});

gulp.task('build_scss_min', function() {
    gulp.src(paths.css[0])
        .pipe(stripCssComments())
        .pipe(please({
            minifier: true,
            autoprefixer: {"browsers": ["last 40 versions", "ios 6", "ie 9"]},
            pseudoElements: true,
            sass: true,
            out: 'style.min.css'
        }))
        .pipe( gulp.dest( paths.scss[1] ) );
});


gulp.task('build_js_min', function() {
    return gulp.src(paths.js)
        .pipe(concat('wpeo-assets.js'))
        .pipe(gulp.dest('js/dest/'))
})

gulp.task('default', function() {
    gulp.watch(paths.scss[0], ["build_scss"]);
    gulp.watch(paths.scss[0], ["build_scss_min"]);
    gulp.watch(paths.js, ["build_js_min"]);
});
