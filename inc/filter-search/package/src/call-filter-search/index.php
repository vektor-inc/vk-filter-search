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
			'render_callback' => 'vkfs_call_filteer_search_render_callback',
		)
	);
}
add_action( 'init', 'vkfs_register_block_call_filter_search', 9999 );

/**
 * Set the data of `vk-filter-search/call-filter-search` block
 */
function vkfs_set_call_filteer_search_data() {
	$posts = get_posts(
		array(
			'posts_per_page' => -1,
			'post_type'      => 'filter-search',
			'post_status'    => 'publish,private',
		)
	);

	if ( ! empty( $posts ) ) {
		$has_filter_search_posts = true;
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
			'targetPosts'          => $post_selection,
		)
	);
}
add_action( 'enqueue_block_editor_assets', 'vkfs_set_call_filteer_search_data' );

/**
 * Render Callback of Page Content Block
 *
 * @param array $attributes attributes.
 * @return string
 */
function vkfs_call_filteer_search_render_callback( $attributes ) {
	// 投稿タイプ VK Filter Search で作った投稿のID
	$target_id = ! empty( $attributes['TargetPost'] ) ? $attributes['TargetPost'] : -1;
	// 投稿タイプ VK Filter Search で作成した投稿（フォーム）コンテンツを取得
	$target_content = -1 !== $target_id ? get_post( $target_id )->post_content : '';
	// 検索結果ページに表示するかどうか
	$display_result = get_post_meta( $target_id, 'vkfs_display_result', true );

	// 検索結果に表示する設定の場合
	if ( ! empty( $target_content ) && ! empty( $display_result ) ) {
		// 表示するフォームに、フォームの投稿IDを追加 -> IDが投げられるので、結果に表示するフォームを特定できる
		$target_content = str_replace( '[filter_search_result_input]', '<input type="hidden" name="vkfs_form_id" value="' . $target_id . '" />', $target_content );
	} else {
		$target_content = str_replace( '[filter_search_result_input]', '', $target_content );
	}

	$classes   = '';
	$page_html = '';

	if ( -1 !== $target_id ) {
		$classes .= 'vkfs__call-filter-search';
		if ( isset( $attributes['TargetPost'] ) ) {
			$classes .= ' vkfs__call-filter-search-id-' . $target_id;
		}
		if ( isset( $attributes['className'] ) ) {
			$classes .= ' ' . $attributes['className'];
		}

		$page_html .= '<div class="' . $classes . '">';
		$page_html .= apply_filters( 'filter_search_content', $target_content );
		$url        = get_edit_post_link( $target_id );
		if ( $url ) {
			$page_html .= '<a href="' . esc_url( $url ) . '" class="vkfs__call-filter-search_editBtn btn btn-outline-primary btn-sm veu_adminEdit" target="_blank">' . __( 'Edit Search Form', 'vk-filter-search' ) . '</a>';
		}
		$page_html .= '</div>';
	}

	return $page_html;
}
