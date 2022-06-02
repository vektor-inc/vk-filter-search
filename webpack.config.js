const defaultConfig = require('@wordpress/scripts/config/webpack.config');
module.exports = {
	...defaultConfig,
	entry: __dirname + '/inc/filter-search/package/src/block.js',
	output: {
		path: __dirname + '/inc/filter-search/package/build/',
		filename: 'block.js',
	},
	module: {
		...defaultConfig.module,
		rules: [
			...defaultConfig.module.rules,
			{
				test: /\.js$/,
				exclude: /(node_modules|bower_components)/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: ['@babel/preset-env'],
						plugins: [
							[
								'module-resolver',
								{
									alias: {
										'@vk-filter-search':
											'./inc/filter-search/package/src/',
									},
								},
							],
							'@babel/plugin-transform-react-jsx',
						],
					},
				},
			},
		],
	},
};
