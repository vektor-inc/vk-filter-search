const gulp = require("gulp");
const jsmin = require("gulp-jsmin");
const rename = require("gulp-rename");

gulp.task( 'query-js', function (done)  {
	gulp.src('inc/filter-search/package/src/common/enque-front.js')
	.pipe(jsmin())
	.pipe(rename('vk-filter-search.min.js'))
	.pipe(gulp.dest('inc/filter-search/package/build/'));
	done();
});