var gulp = require('gulp');
var sass = require('gulp-sass');
var webpack = require('webpack-stream');
 
sass.compiler = require('node-sass');
 
gulp.task('sass', function () {
    return gulp.src('./public/themes/gablab/sass/app.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./public/themes/gablab/css'));
});

gulp.task('sass.deploy', function () {
    return gulp.src('./public/themes/gablab/sass/deploy.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./public/themes/gablab/css'));
});
 
gulp.task('watch', function () {
    gulp.watch('./public/themes/gablab/sass/**/*.scss', gulp.series('sass', 'sass.deploy'));
});

gulp.task('default', gulp.series('sass', 'sass.deploy'));