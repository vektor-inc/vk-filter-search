const gulp = require("gulp");
const jsmin = require("gulp-jsmin");
const rename = require("gulp-rename");
// エラーでも監視を続行させる
var plumber = require("gulp-plumber");
var sass = require("gulp-sass");
// add vender prifix
var autoprefixer = require("gulp-autoprefixer");
var cleanCss = require("gulp-clean-css");
var replace = require("gulp-replace");

gulp.task("build_css", function(done) {
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

gulp.task( 'build_js', function (done)  {
	gulp.src('inc/filter-search/package/src/filter-search/enque-front.js')
	.pipe(jsmin())
	.pipe(rename('vk-filter-search.min.js'))
	.pipe(gulp.dest('inc/filter-search/package/build/'));
	done();
});

gulp.task("replace_text_domain", function(done) {
	gulp.src(["./inc/filter-search/package/**"])
		.pipe(replace("'filter-search-textdomain'","'vk-filter-search'"))
		.pipe(gulp.dest("./inc/filter-search/package/"))
	done();
});

gulp.task("copy_filter_search", function(done) {
	gulp.src(["./inc/filter-search/package/**"])
		.pipe(replace("'vk-filter-search'","'filter-search-textdomain'"))
		.pipe(gulp.dest("../../vektor-wp-libraries/filter-search/package/"))
	gulp.src(["./inc/filter-search/package/**"])
		.pipe(replace("'vk-filter-search'","'vk-filter-search-pro'"))
		.pipe(replace("wp_set_script_translations( 'vk-filter-search-js', 'vk-filter-search' );","wp_set_script_translations( 'vk-filter-search-js', 'vk-filter-search-pro', VKFS_PRO_PATH . '/languages/');"))
		.pipe(gulp.dest("../vk-filter-search-pro/inc/filter-search/package/"))
	done();
});