<?php

/**
 * Registers the `vk-filter-search/keyword-search` block.
 */
if ( function_exists('register_block_type') ) {

	function register_block_vkfs_search_result_form() {
		register_block_type(
			__DIR__,
			array(
				'style'           => 'vk-filter-search-style',
				'editor_style'    => 'vk-filter-search-editor',
				'editor_script'   => 'vk-filter-search-block',
				'attributes'      => array(
					'className'   => array(
						'type'    => 'string',
						'default' => '',
					),
				),
				'render_callback' => 'vkfs_search_result_form_render_callback',
			)
		);
	}
	add_action( 'init', 'register_block_vkfs_search_result_form', 9999 );
}

/**
 * Rendering Keyword Search Block
 *
 * @param array $attributes attributes.
 * @param html  $content content.
 */
function vkfs_search_result_form_render_callback( $attributes, $content ) {
	return VK_Filter_Search::search_result_form_content();
}