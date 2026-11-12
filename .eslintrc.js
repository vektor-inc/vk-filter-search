module.exports = {
	root: true,
	extends: [ 'plugin:@wordpress/eslint-plugin/recommended' ],
	rules: {
		'@wordpress/no-unsafe-wp-apis': 'off',
		'import/no-unresolved': 'off',
		'import/no-extraneous-dependencies': 'off',
		'react-hooks/exhaustive-deps': 'off',
		camelcase: 'off',
	},
	overrides: [
		{
			// @jest-environment の docblock は、ファイルの先頭に無いと
			// jest-docblock が読み取らない（前に別のコメントがあると効かない）。
			// 先頭に置くと jsdoc の規則に触れるため、このタグだけ許可する。
			// off にすると、以後この配下でタグの打ち間違いを拾えなくなる
			files: [ 'tests/unit-js/**/*.js' ],
			rules: {
				'jsdoc/check-tag-names': [
					'error',
					{ definedTags: [ 'jest-environment' ] },
				],
			},
		},
	],
};
