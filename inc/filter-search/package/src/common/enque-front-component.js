/**
 * Enque Front Component
 */

/* eslint camelcase: 0 */
/* eslint no-shadow: 0 */

export const query_string = window.location.search.slice(1); // 文頭?を除外

export const get_url_queries = () => {
	const queries = {};

	// クエリがない場合は空のオブジェクトを返す
	if (!query_string) {
		return queries;
	}

	// クエリ文字列を & で分割して処理
	query_string.split('&').forEach(function (query_string) {
		// = で分割してkey,valueをオブジェクトに格納
		const query_array = query_string.split('=');
		query_array[0] = query_array[0].replace('%5B%5D', '');
		queries[query_array[0]] += ',' + query_array[1];
		queries[query_array[0]] = queries[query_array[0]].replace(
			'undefined,',
			''
		);
		queries[query_array[0]] = queries[query_array[0]].replace(
			'undefined',
			''
		);
	});
	return queries;
};
