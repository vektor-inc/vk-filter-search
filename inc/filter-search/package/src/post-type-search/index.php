<?php

/**
 * Registers the `vk-filter-search/post-type-search` block.
 */
if( function_exists('register_block_type') ) {

	function register_block_vkfs_post_type_search() {
		register_block_type(
			__DIR__,
			array(
				'style'           => 'vk-filter-search-style',
				'editor_style'    => 'vk-filter-search-editor',
				'editor_script'   => 'vk-filter-search-block',
				'attributes'      => array(
					'isCheckedPostType' => array(
						'type'    => 'string',
						'default' => '["post","page"]',
					),
					'className'         => array(
						'type'    => 'string',
						'default' => '',
					),
				),
				'render_callback' => 'vkfs_post_type_search_render_callback',
			)
		);
	}
	add_action( 'init', 'register_block_vkfs_post_type_search', 9999 );
}

/**
 * Rendering Post Type Search Block
 *
 * @param array $attributes attributes.
 * @param html  $content content.
 */
function vkfs_post_type_search_render_callback( $attributes, $content ) {
	$attributes = wp_parse_args(
		$attributes,
		array(
			'isCheckedPostType' => '["post","page"]',
			'className'         => '',
		)
	);

	if ( ! empty( $attributes['isCheckedPostType'] ) ) {
		$attributes['isCheckedPostType'] = str_replace( '[', '', $attributes['isCheckedPostType'] );
		$attributes['isCheckedPostType'] = str_replace( ']', '', $attributes['isCheckedPostType'] );
		$attributes['isCheckedPostType'] = str_replace( '"', '', $attributes['isCheckedPostType'] );
	}

	// 投稿タイプを処理
	$post_types    = ! empty( $attributes['isCheckedPostType'] ) ? explode( ',', $attributes['isCheckedPostType'] ) : array();
	
	// オプションを設定
	$options = array(
		'class_name'    => ! empty( $attributes['className'] ) ? $attributes['className'] : '',
	);

	return VK_Filter_Search::get_post_type_form_html( $post_types, $options );
	
}