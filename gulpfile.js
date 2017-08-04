var gulp = require('gulp');
var sass = require('gulp-sass');
var clean = require('gulp-clean');
var cssmin = require('gulp-cssmin');
var rename = require('gulp-rename');
//var cleanCSS = require('gulp-clean-css');

var concat = require('gulp-concat');
var minify = require('gulp-minify');

//var rm = require( 'gulp-rm' );

// var mkdirp = require('mkdirp');

// gulp.task('init-project-structure', function() {
//     mkdirp('./app/templates_c/default', function (err) {
//         if (err) console.error(err)
//         else console.log('pow!')
//     });
// });    

/*gulp.task('clean-css', function() {
    return gulp.src('./web/css', { read: false })
        .pipe(rm())
});*/
// var gulp = require('gulp');
var cleanCSS = require('gulp-clean-css');



gulp.task('clean-css', function () {
    return gulp.src('web/css', {read: false})
        .pipe(clean());
});

gulp.task('compile-scss', function() {
    // gulp.src('web/scss/**/*.scss')
    gulp.src('web/scss/main.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./web/css/'));
});

/*gulp.task('minify-css', function() {
  return gulp.src('web/css/*.css')
    .pipe(cleanCSS({compatibility: 'ie8'}))
    .pipe(gulp.dest('web/css'));
});*/

// gulp.task('minify-css', function () {
//     gulp.src('web/css/*.css')
//         .pipe(cssmin())
//         .pipe(rename({suffix: '.min'}))
//         .pipe(gulp.dest('web/css'));
// });

gulp.task('new-minify-css', function() {
    return gulp.src('web/css/main.css')
        .pipe(cleanCSS({debug: true}, function(details) {
            console.log(details.name + ': ' + details.stats.originalSize);
            console.log(details.name + ': ' + details.stats.minifiedSize);
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('web/css', {overwrite: true}));
});

gulp.task('concat-js', function() {
    return gulp.src(['./web/js/jquery-2.1.0.min.js', './web/js/imagelightbox/imagelightbox.js', './web/js/magic.jquery.js'])
        .pipe(concat('all.js'))
        .pipe(gulp.dest('./web/js'));
});
 
gulp.task('minify-js', function() {
    gulp.src('web/js/all.js')
        .pipe(minify({
            ext:{
                src:'-debug.js',
                min:'.min.js'
            },
            exclude: ['tasks'],
            ignoreFiles: ['.combo.js', '-min.js']
        }))
        .pipe(gulp.dest('./web/js/'));
});


//Watch task
gulp.task('prepare-production', ['clean-css', 'compile-scss', 'minify-css', 'concat-js', 'minify-js']);
gulp.task('prepare-css', ['compile-scss', 'new-minify-css']);
gulp.task('prepare-js', ['concat-js', 'minify-js']);
gulp.task('default',function() {
    gulp.watch('web/scss/**/*.scss', ['compile-scss']);
});

