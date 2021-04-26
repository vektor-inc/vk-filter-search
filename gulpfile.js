const gulp = require( 'gulp' );

// エラーでも監視を続行させる
const plumber = require( 'gulp-plumber' );
const sass = require( 'gulp-sass' );
// add vender prifix
const autoprefixer = require( 'gulp-autoprefixer' );
const cleanCss = require( 'gulp-clean-css' );
const replace = require( 'gulp-replace' );

gulp.task( 'build_css', function ( done ) {
	gulp.src( [ './inc/filter-search/package/src/style.scss' ] )
		.pipe(
			plumber( {
				handleError: ( err ) => {
					console.log( err ); //eslint-disable-line no-console
					this.emit( 'end' );
				},
			} )
		)
		.pipe( plumber() )
		.pipe(
			sass( {
				includePaths: [ './inc/filter-search/package/src/style.scss' ],
			} )
		)
		.pipe( autoprefixer() )
		.pipe( cleanCss() )
		.pipe( gulp.dest( './inc/filter-search/package/build/' ) );
	gulp.src( [ './inc/filter-search/package/src/editor.scss' ] )
		.pipe(
			plumber( {
				handleError: ( err ) => {
					console.log( err ); //eslint-disable-line no-console
					this.emit( 'end' );
				},
			} )
		)
		.pipe( plumber() )
		.pipe(
			sass( {
				includePaths: [ './inc/filter-search/package/src/editor.scss' ],
			} )
		)
		.pipe( autoprefixer() )
		.pipe( cleanCss() )
		.pipe( gulp.dest( './inc/filter-search/package/build/' ) );
	done();
} );

gulp.task( 'replace_text_domain', function ( done ) {
	gulp.src( [ './inc/filter-search/package/**' ] )
		.pipe( replace( "'filter-search-textdomain'", "'vk-filter-search'" ) )
		.pipe( gulp.dest( './inc/filter-search/package/' ) );
	done();
} );

gulp.task( 'copy_filter_search', function ( done ) {
	gulp.src( [ './inc/filter-search/package/**' ] )
		.pipe( replace( "'vk-filter-search'", "'filter-search-textdomain'" ) )
		.pipe(
			gulp.dest( '../../vektor-wp-libraries/filter-search/package/' )
		);
	gulp.src( [ './inc/filter-search/package/**' ] )
		.pipe( replace( "'vk-filter-search'", "'vk-filter-search-pro'" ) )
		.pipe(
			gulp.dest( '../vk-filter-search-pro/inc/filter-search/package/' )
		);
	done();
} );
