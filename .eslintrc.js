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
};
