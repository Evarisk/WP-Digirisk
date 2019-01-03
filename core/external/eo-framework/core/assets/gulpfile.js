'use strict';

var gulp   = require('gulp');
var watch  = require('gulp-watch');
var concat = require('gulp-concat');
var sass   = require('gulp-sass');
var rename = require('gulp-rename');
var autoprefixer = require('gulp-autoprefixer');

var paths = {
	scss: ['css/scss/**/*.scss', 'css/'],
	js: ['js/init.js', 'js/*.lib.js'],
};

// SCSS Plugin
gulp.task( 'build_scss', function() {
	return gulp.src( paths.scss[0] )
		.pipe( sass().on( 'error', sass.logError ) )
		.pipe( autoprefixer({
			browsers: ['last 2 versions'],
			cascade: false
		}) )
		.pipe( gulp.dest( paths.scss[1] ) )
		.pipe( sass({outputStyle: 'compressed'}).on( 'error', sass.logError ) )
		.pipe( rename( './style.min.css' ) )
		.pipe( gulp.dest( paths.scss[1] ) );
});

gulp.task('build_js', function() {
    return gulp.src(paths.js)
        .pipe(concat('wpeo-assets.js'))
        .pipe(gulp.dest('js/dest/'))
})

gulp.task( 'default', function() {
	gulp.watch( paths.scss[0], gulp.series('build_scss') );
	gulp.watch( paths.js, gulp.series('build_js') );
});
