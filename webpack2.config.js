const path = require( 'path' );
module.exports = [
	{
		entry:
			__dirname +
			'/inc/filter-search/package/src/common/enque-front-redirect.js',
		output: {
			path: __dirname + '/inc/filter-search/package/build/',
			filename: 'vk-filter-search-redirect.min.js',
		},
		mode: 'production',
		resolve: {
			alias: {
				'@vk-filter-search': path.resolve(
					__dirname,
					'./inc/filter-search/package/src/'
				),
			},
		},
		module: {
			rules: [
				{
					test: /\.js$/,
					exclude: /(node_modules)/,
					use: {
						loader: 'babel-loader',
					},
				},
			],
		},
	},
	{
		entry:
			__dirname +
			'/inc/filter-search/package/src/filter-search/enque-front-result.js',
		output: {
			path: __dirname + '/inc/filter-search/package/build/',
			filename: 'vk-filter-search-result.min.js',
		},
		mode: 'production',
		resolve: {
			alias: {
				'@vk-filter-search': path.resolve(
					__dirname,
					'./inc/filter-search/package/src/'
				),
			},
		},
		module: {
			rules: [
				{
					test: /\.js$/,
					exclude: /(node_modules)/,
					use: {
						loader: 'babel-loader',
					},
				},
			],
		},
	},
];
