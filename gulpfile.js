var gulp = require("gulp");
var sass = require("gulp-sass");
var ugly = require("gulp-uglify");
var minicss = require("gulp-minify-css");
var sourcemaps = require("gulp-sourcemaps");
var imagemin = require('gulp-imagemin');
var pngquant = require('imagemin-pngquant');
var rimraf = require('rimraf');
var cache = require("gulp-cache");
var concat = require('gulp-concat');
var bfy = require('gulp-browserify');
var babel = require('gulp-babel');

gulp.task("sass",function(){
	return gulp.src("build/scss/*.scss")
		.pipe(sourcemaps.init())
		.pipe(sass())
		.pipe(cache(minicss()))
		.pipe(sourcemaps.write())
		.pipe(gulp.dest("css"))
});

gulp.task("ugly",function(){
	return gulp.src("build/js/**/*.js")
        .pipe(bfy())
        .pipe(babel())
		.pipe(sourcemaps.init())
		.pipe(cache(ugly()))
		.pipe(sourcemaps.write())
		.pipe(gulp.dest("js"))
});

gulp.task('img', function () {
    gulp.src("build/images/**/*.*")
        .pipe(cache(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant()],
            interlaced: true
        })))
        .pipe(gulp.dest("images"))
});