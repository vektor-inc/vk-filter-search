<?php

/**
 * Registers the `vk-filter-search/keyword-search` block.
 */
if ( function_exists( 'register_block_type' ) ) {

	function register_block_vkfs_keyword_search() {
		register_block_type(
			__DIR__,
			array(
				'render_callback' => 'vkfs_keyword_search_render_callback',
			)
		);
	}
	add_action( 'init', 'register_block_vkfs_keyword_search', 9999 );
}

/**
 * Rendering Keyword Search Block
 *
 * @param array $attributes attributes.
 * @param html  $content content.
 */
function vkfs_keyword_search_render_callback( $attributes, $content ) {
	$attributes = wp_parse_args(
		$attributes,
		array(
			'className' => '',
		)
	);

	// オプションを設定
	$options = array(
		'class_name' => ! empty( $attributes['className'] ) ? $attributes['className'] : '',
	);

	return VK_Filter_Search::get_keyword_form_html( $options );
}
