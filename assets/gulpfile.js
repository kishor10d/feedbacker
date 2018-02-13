var gulp = require('gulp'),
	gp_clean_css = require('gulp-clean-css'),
	gp_concat_css = require('gulp-concat-css')
    gp_concat_js = require('gulp-concat'),
    gp_rename_js = require('gulp-rename'),
    gp_uglify_js = require('gulp-uglify'),
    gp_insert = require('gulp-insert');

gulp.task('pluginjs', function(){
	return gulp.src(['bootstrap/js/bootstrap.min.js',
	                 'dist/js/app.min.js',
	                 'js/jquery.validate.min.js',
	                 'js/additional-methods.min.js',
	                 'js/validation.js',
	                 'plugins/datepicker/bootstrap-datepicker.js',
	                 'plugins/timepicker/bootstrap-timepicker.min.js',
	                 'plugins/bootstrap-editable/js/bootstrap-editable.min.js',
	                 'plugins/coolclock/coolclock.js',
	                 'plugins/coolclock/moreskins.js'])
	                 .pipe(gp_uglify_js())
	                 .pipe(gp_concat_js('plugins.min.js'))
	                 .pipe(gulp.dest('./js/'));            
	                 
});

gulp.task('plugincss', function(){
	/*return gulp.src(['bootstrap/css/bootstrap.min.css',
	                 'dist/css/AdminLTE.min.css',
	                 'dist/css/skins/_all-skins.min.css',
	                 'plugins/datepicker/datepicker3.css',
	                 'plugins/datepicker/datepicker3.css',
	                 'plugins/timepicker/bootstrap-timepicker.min.css',
	                 'plugins/bootstrap-editable/css/bootstrap-editable.css'])
  	.pipe(gp_clean_css({compatibility: 'ie8'}))  	
    .pipe(gp_concat_css('plugins.min.css'))
    .pipe(gulp.dest('./css/'));*/
});

gulp.task('jsminification', ['pluginjs'], function() {
  return gulp.src('appjs/*.js')
  	.pipe(gp_uglify_js())
    .pipe(gp_concat_js('custom.min.js'))
    .pipe(gulp.dest('./js/'));
});

gulp.task('cssminification',['plugincss'], function() {
  return gulp.src('appcss/*.css')
  	.pipe(gp_clean_css({compatibility: 'ie8'}))  	
    .pipe(gp_concat_css('custom.min.css'))
    .pipe(gulp.dest('./css/'));
});



gulp.task('default', ['jsminification','cssminification'], function(){
  return true;
});