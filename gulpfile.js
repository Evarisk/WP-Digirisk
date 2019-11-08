/**
 * Concaténation automatique des fichiers .backend.js en backend.min.js
 * dans le dossier core/assets/js/.
 *
 * Concaténation automatique des fichiers .frontend.js en frontend.min.js
 * dans le dossier core/assets/js/.
 *
 * SCSS to CSS, Concaténation, minification, autoprefixer des scss se trouvant
 * dans le dossier path.scss_backend en backend.min.css dans le dossier
 * core/assets/css/.
 *
 * SCSS to CSS, Concaténation, minification, autoprefixer des scss se trouvant
 * dans le dossier path.scss_frontend en frontend.min.css dans le dossier
 * core/assets/css/.
 *
 * @since 0.1.0
 * @version 1.0.0
 */

var gulp         = require('gulp');
var watch        = require('gulp-watch');
var rename       = require("gulp-rename");
var concat       = require('gulp-concat');
var uglify       = require('gulp-uglify');
var sass         = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');

var paths = {
  js_backend: ['core/assets/js/init.js', '**/*.backend.js'],
  js_frontend: ['core/assets/js/init.js', '**/*.frontend.js'],
  scss_backend:[ 'core/assets/css/scss/**/*.scss', 'core/assets/css/' ],
  scss_frontend:[ 'core/assets/css/scss-frontend/**/*.scss', 'core/assets/css/' ]
};

gulp.task('build_js_backend', function() {
	return gulp.src( paths.js_backend)
		.pipe(concat('backend.min.js'))
		// .pipe( uglify() )
		.pipe(gulp.dest('core/assets/js/'))
});

gulp.task('build_js_frontend', function() {
	return gulp.src( paths.js_frontend)
		.pipe(concat('frontend.min.js'))
		.pipe(gulp.dest('core/assets/js/'))
});


gulp.task('build_scss_backend', function() {
	return gulp.src( paths.scss_backend[0] )
		.pipe( sass( { 'outputStyle': 'expanded' } ).on( 'error', sass.logError ) )
		.pipe( autoprefixer() )
		.pipe( gulp.dest( paths.scss_backend[1] ) )
		.pipe( sass({outputStyle: 'compressed'}).on( 'error', sass.logError ) )
		.pipe( rename( './style.min.css' ) )
		.pipe( gulp.dest( paths.scss_backend[1] ) );
});


gulp.task('build_scss_frontend', function() {
	return gulp.src( paths.scss_frontend[0] )
		.pipe( sass( { 'outputStyle': 'expanded' } ).on( 'error', sass.logError ) )
		.pipe( autoprefixer() )
		.pipe( gulp.dest( paths.scss_frontend[1] ) )
		.pipe( sass({outputStyle: 'compressed'}).on( 'error', sass.logError ) )
		.pipe( rename( './style.frontend.min.css' ) )
		.pipe( gulp.dest( paths.scss_backend[1] ) );
});


gulp.task('default', function() {
	gulp.watch( paths.js_backend, gulp.series("build_js_backend") );
	gulp.watch( paths.js_frontend, gulp.series("build_js_frontend") );
	gulp.watch( paths.scss_backend[0], gulp.series("build_scss_backend") );
	gulp.watch( paths.scss_frontend[0], gulp.series("build_scss_frontend") );
});
