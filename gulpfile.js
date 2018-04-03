var gulp    = require( 'gulp' );
var please  = require( 'gulp-pleeease' ) ;
var watch   = require( 'gulp-watch' ) ;
var concat  = require( 'gulp-concat' ) ;
var sass    = require( 'gulp-sass' ) ;

var frameworkPath = 'core/external/eo-framework/';

var paths = {
	scss_framework: [frameworkPath + 'core/assets/css/scss/**/*.scss', frameworkPath + 'core/assets/css/'],
	js_framework: [frameworkPath + 'core/assets/js/init.js', frameworkPath + 'core/assets/js/*.lib.js'],

	scss_wpeo_upload: [frameworkPath + 'modules/wpeo-upload/assets/css/scss/**/*.scss', frameworkPath + 'modules/wpeo-upload/assets/css/'],
	scss_wpeo_update_manager: [frameworkPath + 'modules/wpeo-update-manager/assets/css/scss/**/*.scss', frameworkPath + 'modules/wpeo-update-manager/assets/css/'],

	scss_plugin: ['core/assets/css/scss/**/*.scss', 'core/assets/css/'],
	js_frontend_plugin: ['core/assets/js/init.js', '**/*.frontend.js'],
	js_backend_plugin: ['core/assets/js/init.js', '**/*.backend.js']
};

// EO Framework 1.0.0
gulp.task( 'build_scss_framework', function() {
	gulp.src( paths.scss_plugin[0] )
		.pipe( sass().on( 'error', sass.logError ) )
		.pipe( please({
			minifier: false,
			autoprefixer: { 'browsers': ['last 40 versions', 'ios 6', 'ie 9'] },
			pseudoElements: true,
			sass: true
		} ) )
		.pipe( gulp.dest( paths.scss_plugin[1] ) )
		.pipe( please({
			minifier: true,
			out: 'style.min.css'
		} ) )
		.pipe( gulp.dest( paths.scss_plugin[1] ) );
});

gulp.task( 'build_lib_js_framework', function() {
	return gulp.src( paths.js_framework )
		.pipe( concat( 'wpeo-assets.js' ) )
		.pipe( gulp.dest( frameworkPath + 'core/assets/js/dest/' ) );
});

// SCSS EO Upload
gulp.task( 'build_scss_module_upload', function() {
	gulp.src( paths.scss_wpeo_upload[0] )
		.pipe( sass().on( 'error', sass.logError ) )
		.pipe( please({
			minifier: false,
			autoprefixer: { 'browsers': ['last 40 versions', 'ios 6', 'ie 9'] },
			pseudoElements: true,
			sass: true
		} ) )
		.pipe( gulp.dest( paths.scss_wpeo_upload[1] ) )
		.pipe( please({
			minifier: true,
			out: 'style.min.css'
		} ) )
		.pipe( gulp.dest( paths.scss_wpeo_upload[1] ) );
});

// SCSS EO Update Manager
gulp.task( 'build_scss_module_update_manager', function() {
	gulp.src( paths.scss_wpeo_update_manager[0] )
		.pipe( sass().on( 'error', sass.logError ) )
		.pipe( please({
			minifier: false,
			autoprefixer: { 'browsers': ['last 40 versions', 'ios 6', 'ie 9'] },
			pseudoElements: true,
			sass: true
		} ) )
		.pipe( gulp.dest( paths.scss_wpeo_update_manager[1] ) )
		.pipe( please({
			minifier: true,
			out: 'style.min.css'
		} ) )
		.pipe( gulp.dest( paths.scss_wpeo_update_manager[1] ) );
});

// SCSS Plugin
gulp.task( 'build_scss_plugin', function() {
	gulp.src( paths.scss_plugin[0] )
		.pipe( sass().on( 'error', sass.logError ) )
		.pipe( please({
			minifier: false,
			autoprefixer: { 'browsers': ['last 40 versions', 'ios 6', 'ie 9'] },
			pseudoElements: true,
			sass: true
		} ) )
		.pipe( gulp.dest( paths.scss_plugin[1] ) )
		.pipe( sass().on( 'error', sass.logError ) )
		.pipe( please({
			minifier: true,
			out: 'style.min.css'
		} ) )
		.pipe( gulp.dest( paths.scss_plugin[1] ) );
});

// JS Plugin
gulp.task( 'build_js_backend', function() {
	return gulp.src( paths.js_backend_plugin )
		.pipe( concat( 'backend.min.js' ) )
		.pipe( gulp.dest( 'core/assets/js/' ) );
});

gulp.task( 'build_js_frontend', function() {
	return gulp.src( paths.js_frontend_plugin )
		.pipe( concat( 'frontend.min.js' ) )
		.pipe( gulp.dest( 'core/assets/js/' ) );
});

gulp.task( 'default', function() {
	gulp.watch( paths.scss_framework[0], ['build_scss_framework'] );
	gulp.watch( paths.js_framework, ['build_lib_js_framework'] );
	gulp.watch( paths.scss_wpeo_upload[0], ['build_scss_module_upload'] );
	gulp.watch( paths.scss_wpeo_update_manager[0], ['build_scss_module_update_manager'] );

	gulp.watch( paths.scss_plugin[0], ['build_scss_plugin'] );
	gulp.watch( paths.js_backend_plugin, ['build_js_backend'] );
	gulp.watch( paths.js_frontend_plugin, ['build_js_frontend'] );
});
