var gulp = require('gulp');   //Modul Gulp wird angefordert.
var sass = require('gulp-sass');  // Modul Gulp-sass wird angefordert, dieses wird benötigt um SCSS dateien in CSS dateien zu kompilieren.


gulp.task('default', function() { //erster Task wird definiert
    gulp.src('./assets/scss/main.scss') //als quelle des SCSS gilt die main.scss
        .pipe(sass({outputStyle: 'expanded'}).on('error', sass.logError)) //Kompilieren des SCSS in CSS
        .pipe(gulp.dest('./dist/css'));//Ziel des Kompilierten Codes
});


gulp.task('watch', function () { //zweiter Tast wird definiert, dieser führt mittels des Scriptes watch (siehe package.json) den ersten Task aus, sobald die main.scss gespeichert wird.
    gulp.watch('./assets/scss/main.scss', ['default']);//default Task wird in Watch übernommen.
});
