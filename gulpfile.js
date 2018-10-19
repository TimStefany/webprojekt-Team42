var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var plumber = require('gulp-plumber');



gulp.task('default', function() {
    gulp.src('./assets/scss/main.scss')
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(concat('main.css'))
        .pipe(gulp.dest('./dist/css'));
});


gulp.task('watch', function () {
    gulp.watch('./assets/scss/main.scss', ['default']);
});
