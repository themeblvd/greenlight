var gulp = require('gulp'),
	rename = require('gulp-rename'),
	uglify = require('gulp-uglify'),
	sass = require('gulp-sass'),
	compass = require('gulp-compass'),
	maps = require('gulp-sourcemaps'),
	sync = require('browser-sync').create();

gulp.task('minify', function(foo) {
	console.log(foo);
	return gulp.src([
			'assets/js/customize-controls.js',
			'assets/js/greenlight.js',
			'assets/js/meta-box.js'
		])
		.pipe(uglify())
		.pipe(rename({ suffix: '.min' }))
		.pipe(gulp.dest('assets/js/'))
		.pipe(sync.stream());
});

gulp.task('compass', function() {
	return gulp.src('assets/scss/style.scss')
		.pipe(compass({
			config_file: 'assets/scss/config.rb',
			css: '.',
			sass: 'assets/scss'
		}))
		.pipe(gulp.dest('./'))
		.pipe(sync.stream());
});

gulp.task('serve', function() {

	sync.init({
		proxy: "greenlight.dev"
	});

	gulp.watch([
		'assets/scss/**/*.scss',
		'assets/scss/style.scss'
	], ['compass']);

	gulp.watch([
		'assets/js/customize-controls.js',
		'assets/js/greenlight.js',
		'assets/js/meta-box.js'
	], ['minify']);

});
