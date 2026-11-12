/**
 * ユニットテストの設定
 *
 * wp-scripts の既定の設定をそのまま引き継ぎ、webpack のエイリアス
 * （webpack2.config.js の resolve.alias）だけを jest にも教える。
 * これが無いと、エイリアスで import しているフロントの入口
 * （enqueue-front-result.js 等）をテストから読み込めない。
 *
 * エイリアスの定義を増やしたら webpack2.config.js と両方に足す事。
 */

const defaultConfig = require( '@wordpress/scripts/config/jest-unit.config' );

module.exports = {
	...defaultConfig,
	moduleNameMapper: {
		...defaultConfig.moduleNameMapper,
		'^@vk-filter-search-pro/(.*)$':
			'<rootDir>/inc/filter-search-pro/package/src/$1',
		'^@vk-filter-search/(.*)$':
			'<rootDir>/inc/filter-search/package/src/$1',
	},
};
