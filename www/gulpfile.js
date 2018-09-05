var gulp = require('gulp');
var babel = require('gulp-babel');
var concat = require('gulp-concat');
var less = require('gulp-less');
var minifyCSS = require('gulp-minify-css');
var uglify = require('gulp-uglify');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var watch = require('gulp-watch');
var browserSync = require('browser-sync');
var autoprefixer = require('gulp-autoprefixer');
const imagemin = require('gulp-imagemin');
const pngquant = require('imagemin-pngquant');
var plumber = require('gulp-plumber');
var autoprefixerOptions = {
    browsers: ['> 1%'],
    cascade: false
};
var cssDest = 'assets/css';

gulp.task('browser-sync', function () {
    browserSync({
        server: {
            baseDir: '.'
        }
    });
});

gulp.task('scripts', function () {
    return gulp.src('js/script.es6')
        .pipe(babel({
            presets: ['es2015']
        }))
        .pipe(plumber())
        .pipe(concat('script.js'))
        .pipe(uglify())
        .pipe(gulp.dest('js'))
        .pipe(browserSync.reload({stream: true}));
});

gulp.task('scripts.vendor', function () {
    return gulp.src([
        'js/vendor/jquery-ui/jquery-ui.min.js',
        'js/vendor/fancybox/dist/jquery.fancybox.js',
        'js/vendor/owl.carousel/dist/owl.carousel.js'
        ])
        .pipe(concat('vendor.js'))
        .pipe(plumber())
        .pipe(uglify())
        .pipe(gulp.dest('js'));
});

gulp.task('styles', function () {
    return gulp.src('css/styles.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(sourcemaps.write())
        .pipe(autoprefixer(autoprefixerOptions))
        .pipe(gulp.dest('css'))
        .pipe(browserSync.reload({stream: true}));
});

gulp.task('build', ['scripts', 'scripts.vendor', 'styles', 'images']);

gulp.task('watch', ['scripts', 'styles'], function () {
    gulp.watch('js/script.es6', ['scripts']);
    gulp.watch('css/**/*.scss', ['styles']);
    gulp.watch('*.php', browserSync.reload);
    gulp.watch('*.html', browserSync.reload);
});
