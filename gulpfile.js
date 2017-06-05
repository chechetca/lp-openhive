var gulp = require('gulp');
var browserSync = require('browser-sync').create();
var reload = browserSync.reload;
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var imagemin = require('gulp-imagemin');


gulp.task('sass', function () {
    return gulp.src('./fullpage-js/css/src/style.scss')
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./fullpage-js/css/'))
        .pipe(browserSync.stream());
});

gulp.task('img-min', function () {
    return gulp.src('./fullpage-js/img/**/*')
        .pipe(imagemin())
        .pipe(gulp.dest('./fullpage-js/img/'))
});

gulp.task('watch', function () {
    browserSync.init({
        open: false,
        notify: false,
        ghostMode: false,
        server: {
            baseDir: "./fullpage-js/"

        }
    });
    gulp.watch('./fullpage-js/**/*.html').on('change', reload);
    gulp.watch('./fullpage-js/css/src/**/*.scss', gulp.parallel(['sass']));
});