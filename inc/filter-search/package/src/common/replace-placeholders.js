/**
 * タイトルの書式の置き換える場所に値を入れる
 *
 * 次の3つだけを置き換え、それ以外の % は文字のまま残す。
 * - %%   : % にする
 * - %s   : 先頭から順番に値を入れる
 * - %n$s : n 番目の値を入れる（%s の順番は進めない）
 * 値が無い場所は空文字にする。
 * 公開ページ側（VK_Filter_Search_Title::replace_placeholders()）と同じ規則にそろえること。
 *
 * @param {string} format 置き換える場所を含む書式
 * @param {Array}  values 書式に入れる値の配列
 * @return {string} 値を入れた文字列
 */
export const replacePlaceholders = ( format, values = [] ) => {
	let sequenceIndex = 0;

	return String( format ?? '' ).replace(
		/%(?:(%)|([1-9][0-9]*)\$s|s)/g,
		( match, percent, position ) => {
			// %% は % にする
			if ( percent ) {
				return '%';
			}
			// %n$s は n 番目の値を入れる
			if ( position ) {
				const value = values[ Number( position ) - 1 ];
				return value === undefined || value === null
					? ''
					: String( value );
			}
			// %s は順番に値を入れる
			const value = values[ sequenceIndex ];
			sequenceIndex++;
			return value === undefined || value === null ? '' : String( value );
		}
	);
};
