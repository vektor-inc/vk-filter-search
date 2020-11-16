const gulp = require("gulp");
const jsmin = require("gulp-jsmin");
const rename = require("gulp-rename");

gulp.task( 'query-js', function (done)  {
	gulp.src('inc/filter-search/package/src/query.js')
	.pipe(jsmin())
	.pipe(gulp.dest('inc/filter-search/package/build/'));
	done();
});