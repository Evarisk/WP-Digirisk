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

var paths = {
	scss_backend: [ 'core/assets/css/scss/**/*.scss', 'core/assets/css/' ],
	frontend_js: ['core/assets/js/lib/init.js', 'core/assets/js/lib/*.js', '**/*.frontend.js'],
  all_js: ['core/assets/js/lib/init.js', '**/*.backend.js'],
};

gulp.task('build_scss_backend', function() {
	gulp.src(paths.scss_backend[0])
		.pipe( sass().on( 'error', sass.logError ) )
		.pipe(please({
			minifier: false,
			autoprefixer: {"browsers": ["last 40 versions", "ios 6", "ie 9"]},
			pseudoElements: true,
			sass: true
		}))
		.pipe( gulp.dest( paths.scss_backend[1] ) );
});

gulp.task('build_scss_backend_min', function() {
	gulp.src(paths.scss_backend[0])
		.pipe( sass().on( 'error', sass.logError ) )
		.pipe(please({
			minifier: true,
			autoprefixer: {"browsers": ["last 40 versions", "ios 6", "ie 9"]},
			pseudoElements: true,
			sass: true,
			out: 'style.min.css'
		}))
		.pipe( gulp.dest( paths.scss_backend[1] ) );
});


gulp.task('js', function() {
	return gulp.src(paths.all_js)
		.pipe(concat('backend.min.js'))
		.pipe(gulp.dest('core/assets/js/'))
})

gulp.task('js_frontend', function() {
	return gulp.src(paths.frontend_js)
		.pipe(concat('frontend.min.js'))
		.pipe(gulp.dest('core/assets/js/'))
})

gulp.task('default', function() {
	gulp.watch(paths.scss_backend[0], ["build_scss_backend"]);
	gulp.watch(paths.scss_backend[0], ["build_scss_backend_min"]);
	gulp.watch(paths.all_js, ["js"]);
	gulp.watch(paths.frontend_js, ["js_frontend"]);
});
