var gulp = require('gulp');
var sass = require('gulp-sass');
var plumber = require('gulp-plumber');



gulp.task('default', function() {
    gulp.src('./assets/scss/main.scss')
        .pipe(sass({outputStyle: 'expanded'}).on('error', sass.logError))
        .pipe(gulp.dest('./dist/css'));
});


gulp.task('watch', function () {
    gulp.watch('./assets/scss/main.scss', ['default']);
});
