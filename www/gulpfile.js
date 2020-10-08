const { src, dest, parallel, watch } = require('gulp');
const gulp = require('gulp'),
    sourcemaps = require('gulp-sourcemaps');
    sass = require('gulp-sass'),
    browserSync = require('browser-sync'),
    imagemin = require('gulp-imagemin'),
    clone = require('gulp-clone'),
    clonesink = clone.sink(),
    plumber = require('gulp-plumber'),
    webp = require('gulp-webp'),
    cacheFiles = require('gulp-cache-files'),
    babel = require('gulp-babel'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify');

function imagesPng () {
    return src('img-full/**/*.png', {read: false})
        .pipe(cacheFiles.filter('manifest-png.json'))
        .pipe(plumber())
        .pipe(imagemin())
        .pipe(cacheFiles.manifest())
        .pipe(clonesink) // start stream
        .pipe(webp({quality: '75', lossless: true, method: 6})) // convert images to webp and save a copy of the original format
        .pipe(clonesink.tap()) // close stream and send both formats to dist
        .pipe(gulp.dest('img'));
}

function imagesJpg() {
    return src('img-full/**/*.jpg', {read: false})
        .pipe(cacheFiles.filter('manifest-jpg.json'))
        .pipe(plumber())
        .pipe(imagemin())
        .pipe(cacheFiles.manifest())
        .pipe(clonesink) // start stream
        .pipe(webp({quality: '85', method: 6})) // convert images to webp and save a copy of the original format
        .pipe(clonesink.tap()) // close stream and send both formats to dist
        .pipe(gulp.dest('img'));
}

function imagesSvg() {
    return src('img-full/**/*.svg', {read: false})
        .pipe(cacheFiles.filter('manifest-svg.json'))
        .pipe(plumber())
        .pipe(imagemin())
        .pipe(cacheFiles.manifest())
        .pipe(gulp.dest('img'));
}

function uploadsPng () {
    return src('uploads/*.png')
        .pipe(plumber())
        .pipe(imagemin())
        .pipe(clonesink) // start stream
        .pipe(webp({quality: '75', lossless: true, method: 6})) // convert images to webp and save a copy of the original format
        .pipe(clonesink.tap()) // close stream and send both formats to dist
        .pipe(gulp.dest('uploads'));
}

function uploadsJpg () {
    return src('uploads/*.jpg')
        .pipe(plumber())
        .pipe(imagemin())
        .pipe(clonesink) // start stream
        .pipe(webp({quality: '85', method: 6})) // convert images to webp and save a copy of the original format
        .pipe(clonesink.tap()) // close stream and send both formats to dist
        .pipe(gulp.dest('uploads'));
}

function thumbsPng () {
    return src('images/thumbs/*.png')
        .pipe(plumber())
        .pipe(imagemin())
        .pipe(clonesink) // start stream
        .pipe(webp({quality: '75', lossless: true, method: 6})) // convert images to webp and save a copy of the original format
        .pipe(clonesink.tap()) // close stream and send both formats to dist
        .pipe(gulp.dest('images/thumbs'));
}

function thumbsJpg() {
    return src('images/thumbs/*.jpg')
        .pipe(plumber())
        .pipe(imagemin())
        .pipe(clonesink) // start stream
        .pipe(webp({quality: '85', method: 6})) // convert images to webp and save a copy of the original format
        .pipe(clonesink.tap()) // close stream and send both formats to dist
        .pipe(gulp.dest('images/thumbs'));
}

function scripts() {
    return src('js/script.es6')
        .pipe(babel({
            presets: ['@babel/env']
        }))
        .pipe(plumber())
        .pipe(concat('script.js'))
        .pipe(uglify())
        .pipe(gulp.dest('js'))
        .pipe(browserSync.reload({stream: true}));
}

function scriptsVendor () {
    return src(['js/vendor/jquery-ui/jquery-ui.min.js',
        'js/vendor/fancybox/dist/jquery.fancybox.js',
        'js/vendor/owl.carousel/dist/owl.carousel.min.js'])
        .pipe(concat('vendor.js'))
        .pipe(plumber())
        .pipe(uglify())
        .pipe(gulp.dest('js'));
}

function styles() {
    return src('css/styles.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('css'))
        .pipe(browserSync.reload({stream: true}));
}

exports.default = function() {
    browserSync.init({
        proxy: "ksg.local"
    });
    scripts();
    styles();
    watch('js/script.es6', scripts);
    watch('css/**/*.scss', styles);
};

exports.styles = styles;
exports.imagesPng = imagesPng;
exports.imagesJpg = imagesJpg;
exports.uploadsPng = uploadsPng;
exports.uploadsJpg = uploadsJpg;
exports.thumbsPng = thumbsPng;
exports.thumbsJpg = thumbsJpg;
exports.imagesSvg = imagesSvg;
exports.scripts = scripts;
exports.scriptsVendor = scriptsVendor;