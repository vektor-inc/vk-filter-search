<?php

/**
 * Registers the `vk-filter-search/filter-search` block.
 */
if ( function_exists( 'register_block_type' ) ) {

	function register_block_vkfs_filter_search() {
		register_block_type(
			__DIR__,
			array(
				'render_callback' => 'vkfs_filter_search_render_callback',
			)
		);
	}
	add_action( 'init', 'register_block_vkfs_filter_search', 9999 );
}

/**
 * Rendering Filter Search Block
 *
 * @param array $attributes attributes.
 * @param html  $content content.
 */
function vkfs_filter_search_render_callback( $attributes, $content ) {
	$attributes = wp_parse_args(
		$attributes,
		array(
			'TargetPostType'           => '',
			'DisplayOnResult'          => false,
			'DisplayOnPosttypeArchive' => '[]',
			'SearchResultPageID'       => '',
			'FormID'                   => null,
			'PostID'                   => null,
		)
	);

	// 多言語プラグイン等で検索結果の基準となる URL が変わる場合があるため action の URL を変更
	$content = str_replace( 'action="' . home_url( '/' ) . '"', 'action="' . VK_Filter_Search::get_search_root_url() . '"', $content );

	// 検索としての扱いになるようにキーワードサーチが追加されるようにしている /////////////////////
	// キーワードサーチのブロックが含まれていない場合
	if ( false === strpos( $content, 'vkfs__keyword' ) ) {
		// 予め用意しているショートコード風の識別文字列を置換してキーワードサーチフォームを type="hidden" で追加
		$content = str_replace( '[no_keyword_hidden_input]', '<input type="hidden" name="s" value="" />', $content );
	} else {
		// キーワードブロックがある場合は別途累加は不要なため、ショートコード風の識別文字列を削除処理
		$content = str_replace( '[no_keyword_hidden_input]', '', $content );
	}

	// 検索結果の移動先を設置
	if ( true === $attributes['DisplayOnResult'] ) {
		$content = str_replace( '[filter_search_result_input]', '<input type="hidden" name="vkfs_form_id" value="' . esc_attr( $attributes['FormID'] ) . '" />', $content );
	} else {
		$content = str_replace( '[filter_search_result_input]', '', $content );
	}

	// 検索結果ページ・アーカイブに出す設定は、投稿を保存したときに書き込む（VK_Filter_Search_Form_Display_Settings）
	// 描画は閲覧のたびに動くため、ここでは書き込まない

	return $content;
}
