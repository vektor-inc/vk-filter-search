/**
 * Enque Front Component
 * 無料版 / Pro番 共通で使用されている
 * URLを取得してクエリのパラメーター配列を生成する
 */

/* eslint camelcase: 0 */
/* eslint no-shadow: 0 */

// window.location.search でURLの ? 以降の文字列を取得して、slice(1)で ? より後の文字列だけ返す
export const query_string = window.location.search.slice( 1 );

export const get_url_queries = () => {
	// URLから取得するクエリ情報を格納する配列を定義
	const queries = {};

	// クエリがない場合は空のオブジェクトを返す
	if ( ! query_string ) {
		return queries;
	}

	// クエリ文字列を & で分割された配列の value（query_string） をループ処理する
	// チェックボックスなど複数選択可能な項目は、vkfs_category[]=aaa&vkfs_category[]=bbbb のように
	// 同じパラメーター名で複数存在するURLになる
	// ★ 元の query_string と 投げる query_string の中身は違うのに同じ名前は誤認の元になるので変更したほうが良いと思いますがどうでしょう？
	query_string.split( '&' ).forEach( function ( query_string ) {
		// = で分割してkey,valueをオブジェクトに格納
		const query_array = query_string.split( '=' );

		// チェックボックスの項目などはパラメーターに[]が含まれるので置換削除
		query_array[ 0 ] = query_array[ 0 ].replace( '%5B%5D', '' );

		// 新しいクエリ配列に値を , 区切りの文字列で追加
		// パラメーター名の場合があるので、一旦連結していく
		queries[ query_array[ 0 ] ] += ',' + query_array[ 1 ];

		// 値がない場合は クエリ文字列に undefined が含まれるので undefined を削除
		queries[ query_array[ 0 ] ] = queries[ query_array[ 0 ] ].replace(
			'undefined',
			''
		);

		// クエリ文字列に二重カンマ が含まれる場合カンマに置換
		queries[ query_array[ 0 ] ] = queries[ query_array[ 0 ] ].replace(
			',,',
			','
		);

		// クエリ文字列がカンマで始まる場合先頭のカンマを削除
		if ( queries[ query_array[ 0 ] ].startsWith( ',' ) ) {
			queries[ query_array[ 0 ] ] =
				queries[ query_array[ 0 ] ].slice( 1 );
		}

		// クエリ文字列がカンマで終わる場合末尾のカンマを削除
		if ( queries[ query_array[ 0 ] ].endsWith( ',' ) ) {
			queries[ query_array[ 0 ] ] = queries[ query_array[ 0 ] ].slice(
				0,
				-1
			);
		}

		// クエリ文字列が undefined の場合削除
		if (
			queries[ query_array[ 0 ] ] === undefined ||
			queries[ query_array[ 0 ] ] === 'undefined'
		) {
			queries[ query_array[ 0 ] ] = '';
		}
	} );
	return queries;
};
