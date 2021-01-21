const gulp = require("gulp");
const jsmin = require("gulp-jsmin");
const rename = require("gulp-rename");
// エラーでも監視を続行させる
var plumber = require("gulp-plumber");
var sass = require("gulp-sass");
// add vender prifix
var autoprefixer = require("gulp-autoprefixer");
var cleanCss = require("gulp-clean-css");

gulp.task("build_free_css", function(done) {
	// design skin の方は親テーマの方でコンパイルするのでこちらではしない
	gulp.src(["./inc/filter-search/package/src/style.scss"])
		.pipe(
			plumber({
				handleError: function(err) {
					console.log(err);
					this.emit("end");
				}
			})
		)
		.pipe(plumber())
		.pipe(sass(
			{
				includePaths: [
					'./inc/filter-search/package/src/style.scss'
				]
			}
		))
		.pipe(autoprefixer())
		.pipe(cleanCss())
		.pipe(gulp.dest("./inc/filter-search/package/build/"));
	gulp.src(["./inc/filter-search/package/src/editor.scss"])
		.pipe(
			plumber({
				handleError: function(err) {
					console.log(err);
					this.emit("end");
				}
			})
		)
		.pipe(plumber())
		.pipe(sass(
			{
				includePaths: [
					'./inc/filter-search/package/src/editor.scss'
				]
			}
		))
		.pipe(autoprefixer())
		.pipe(cleanCss())
		.pipe(gulp.dest("./inc/filter-search/package/build/"));
	done();
});

gulp.task( 'build_free_js', function (done)  {
	gulp.src('inc/filter-search/package/src/filter-search/enque-front.js')
	.pipe(jsmin())
	.pipe(rename('vk-filter-search.min.js'))
	.pipe(gulp.dest('inc/filter-search/package/build/'));
	done();
});