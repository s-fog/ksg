var gulp = require('gulp');
var babel = require('gulp-babel');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var watch = require('gulp-watch');
var browserSync = require('browser-sync');
var autoprefixer = require('gulp-autoprefixer');
const imagemin = require('gulp-imagemin');
var plumber = require('gulp-plumber');
var imageminJpegRecompress = require('imagemin-jpeg-recompress');
var imageminPngquant = require('imagemin-pngquant');
var cacheFiles = require('gulp-cache-files');
const webp = require('gulp-webp');
const clone = require('gulp-clone');
const clonesink = clone.sink();
var autoprefixerOptions = {
    browsers: ['> 1%'],
    cascade: false
};

gulp.task('browser-sync', function () {
    browserSync({
        server: {
            baseDir: '.'
        }
    });
});

gulp.task('images', function () {
    return gulp.src('img-full/**/*.{jpg,png}', {read: false})
        .pipe(cacheFiles.filter('manifest.json'))
        .pipe(plumber())
        .pipe(imagemin([
            imagemin.gifsicle({interlaced: true}),
            imagemin.jpegtran({progressive: true}),
            imageminJpegRecompress({
                progressive: true,
                max: 80,
                min: 70
            }),
            imageminPngquant({quality: '80'}),
            imagemin.optipng({optimizationLevel: 4}),
            imagemin.svgo()
        ]))
        .pipe(cacheFiles.manifest())
        .pipe(clonesink) // start stream
        .pipe(webp({quality: '80'})) // convert images to webp and save a copy of the original format
        .pipe(clonesink.tap()) // close stream and send both formats to dist
        .pipe(gulp.dest('img'));
});

gulp.task('images-uploads', function () {
    return gulp.src('uploads/*')
        .pipe(plumber())
        .pipe(imagemin([
            imagemin.gifsicle({interlaced: true}),
            imagemin.jpegtran({progressive: true}),
            imageminJpegRecompress({
                progressive: true,
                max: 80,
                min: 70
            }),
            imageminPngquant({quality: '80'}),
            imagemin.optipng({optimizationLevel: 4}),
            imagemin.svgo()
        ]))
        .pipe(clonesink) // start stream
        .pipe(webp({quality: '80'})) // convert images to webp and save a copy of the original format
        .pipe(clonesink.tap()) // close stream and send both formats to dist
        .pipe(gulp.dest('uploads'));
});

gulp.task('images-thumbs', function () {
    return gulp.src('images/thumbs/*')
        .pipe(plumber())
        .pipe(imagemin([
            imagemin.gifsicle({interlaced: true}),
            imagemin.jpegtran({progressive: true}),
            imageminJpegRecompress({
                progressive: true,
                max: 80,
                min: 70
            }),
            imageminPngquant({quality: '80'}),
            imagemin.optipng({optimizationLevel: 4}),
            imagemin.svgo()
        ]))
        .pipe(clonesink) // start stream
        .pipe(webp({quality: '80'})) // convert images to webp and save a copy of the original format
        .pipe(clonesink.tap()) // close stream and send both formats to dist
        .pipe(gulp.dest('images/thumbs'));
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
        'js/vendor/owl.carousel/dist/owl.carousel.min.js'
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

gulp.task('watch', ['browser-sync', 'scripts', 'styles', 'images'], function () {
    gulp.watch('img-full/**/*.{jpg,png}', ['images']);
    gulp.watch('js/script.es6', ['scripts']);
    gulp.watch('css/**/*.scss', ['styles']);
    gulp.watch('*.php', browserSync.reload);
    gulp.watch('*.html', browserSync.reload);
});
