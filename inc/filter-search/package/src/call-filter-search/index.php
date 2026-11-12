<?php
/**
 * Call Filter Search Block
 *
 * @package VK Filter Search
 */

/**
 * Registers the `vk-filter-search/call-filter-search` block.
 *
 * @return void
 */
function vkfs_register_block_call_filter_search() {
	register_block_type(
		__DIR__,
		array(
			'render_callback' => 'vkfs_call_filter_search_render_callback',
		)
	);
}
add_action( 'init', 'vkfs_register_block_call_filter_search', 9999 );

/**
 * 検索フォーム呼び出しブロックの追加 CSS クラスを、描画の前に無害化する
 *
 * 外側の要素の class は get_block_wrapper_attributes() が属性 className から組み立てるため、
 * 描画に渡る前の属性の段階で、英数字・ハイフン・アンダースコア以外を取り除いておく。
 *
 * @param array $parsed_block 描画するブロックの情報.
 * @return array 追加 CSS クラスを無害化したブロックの情報
 */
function vkfs_sanitize_call_filter_search_class_name( $parsed_block ) {
	// 検索フォーム呼び出しブロックで、追加 CSS クラスがあるときだけ処理する
	if ( ! is_array( $parsed_block ) || ! isset( $parsed_block['blockName'] ) || 'vk-filter-search/call-filter-search' !== $parsed_block['blockName'] ) {
		return $parsed_block;
	}
	if ( ! isset( $parsed_block['attrs'] ) || ! is_array( $parsed_block['attrs'] ) || ! array_key_exists( 'className', $parsed_block['attrs'] ) ) {
		return $parsed_block;
	}

	// 文字列でない値は空文字になる
	$parsed_block['attrs']['className'] = VK_Filter_Search::sanitize_class_names( $parsed_block['attrs']['className'] );

	return $parsed_block;
}
add_filter( 'render_block_data', 'vkfs_sanitize_call_filter_search_class_name' );

/**
 * Set the data of `vk-filter-search/call-filter-search` block
 */
function vkfs_set_call_filter_search_data() {
	$posts = get_posts(
		array(
			'posts_per_page' => -1,
			'post_type'      => 'filter-search',
			'post_status'    => 'publish,private',
		)
	);

	$post_ids = array();

	if ( ! empty( $posts ) ) {
		$has_filter_search_posts = true;
		foreach ( $posts as $post ) {
			$post_ids[] = $post->ID;
		}
	} else {
		$has_filter_search_posts = false;
	}

	$post_selection = array(
		array(
			'label' => __( 'Unspecified', 'vk-blocks' ),
			'value' => -1,
		),
	);

	foreach ( $posts as $post ) {
		$post_selection[] = array(
			'label' => $post->post_title,
			'value' => $post->ID,
		);
	}

	// ブロックに値を渡す
	wp_localize_script(
		'vk-filter-search-block',
		'callFilterSearch',
		array(
			'adminURL'             => admin_url(),
			'hasFilterSearchPosts' => $has_filter_search_posts,
			'filterSearchPostIDs'  => $post_ids,
			'targetPosts'          => $post_selection,
		)
	);
}
add_action( 'enqueue_block_editor_assets', 'vkfs_set_call_filter_search_data' );

/**
 * Render Callback of Page Content Block
 *
 * 呼び出し先が表示してよい検索フォーム（投稿タイプ VK Filter Search で、公開か非公開、パスワード保護なし）の場合だけ出力する。
 *
 * @param array $attributes attributes.
 * @return string 出力する HTML。出力しない場合は空文字
 */
function vkfs_call_filter_search_render_callback( $attributes ) {
	// 投稿タイプ VK Filter Search で作った投稿のID（正の整数だけを受け付ける）
	$target_id = isset( $attributes['TargetPost'] ) ? $attributes['TargetPost'] : -1;
	if ( is_string( $target_id ) && ctype_digit( $target_id ) ) {
		$target_id = (int) $target_id;
	} elseif ( is_float( $target_id ) && is_finite( $target_id ) && floor( $target_id ) === $target_id && $target_id < PHP_INT_MAX ) {
		// block.json の型が number のため、エディタのプレビュー（REST）では 8.0 のような float で届く。小数部の無いものだけを整数として扱う
		$target_id = (int) $target_id;
	}
	if ( ! is_int( $target_id ) || $target_id <= 0 ) {
		return '';
	}

	// 呼び出し先が表示してよい検索フォームでなければ、本文を取り出さずに何も出さない
	if ( ! VK_Filter_Search::is_displayable_form_post( $target_id ) ) {
		return '';
	}

	// 投稿タイプ VK Filter Search で作成した投稿（フォーム）コンテンツを取得
	$target_content = get_post( $target_id )->post_content;

	// 本文がある場合は、検索結果ページでフォームを特定するための hidden を差し込む
	if ( ! empty( $target_content ) ) {
		// 表示するフォームに、フォームの投稿IDを追加 -> IDが投げられるので、結果に表示するフォームを特定できる
		$target_content = str_replace( '[filter_search_result_input]', '<input type="hidden" name="vkfs_form_id" value="' . esc_attr( $target_id ) . '" />', $target_content );
	} else {
		$target_content = str_replace( '[filter_search_result_input]', '', $target_content );
	}

	// 外側の div の属性を組み立てる（追加 CSS クラスは WordPress のブロックサポートが付ける。描画前に無害化済み）
	$wrapper_attributes = get_block_wrapper_attributes(
		array(
			'class' => 'vkfs__call-filter-search vkfs__call-filter-search-id-' . $target_id,
		)
	);

	// 呼び出し先のフォームと、編集画面を開くボタンを出力する
	$page_html  = '<div ' . $wrapper_attributes . '>';
	$page_html .= apply_filters( 'filter_search_content', $target_content );
	$url        = get_edit_post_link( $target_id );
	if ( $url ) {
		$page_html .= '<button type="button" onClick="window.open(\'' . esc_url( $url ) . '\', \'_blank\', \'noopener,noreferrer\')" class="vkfs__call-filter-search_editBtn btn btn-outline-primary btn-sm veu_adminEdit">' . __( 'Edit Search Form', 'vk-filter-search' ) . '</button>';
	}
	$page_html .= '</div>';

	return $page_html;
}
