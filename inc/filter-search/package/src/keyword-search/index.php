<?php

/**
 * Registers the `vk-filter-search/keyword-search` block.
 */
if( function_exists('register_block_type_from_metadata')) {

	function register_block_vkfs_keyword_search() {
		register_block_type_from_metadata(
			__DIR__,
			array(
				'style'           => 'vk-filter-search',
				'editor_style'    => 'vk-filter-search-editor',
				'editor_script'   => 'vk-filter-search-js',
				'render_callback' => 'render_keyword_search_callback',
			)
		);
	}
	add_action( 'init', 'register_block_vkfs_keyword_search', 99 );
}

/**
 * Rendering Keyword Search Block
 *
 * @param array $attributes attributes.
 * @param html  $content content.
 */
function render_keyword_search_callback( $attributes, $content = '' ) {
	return VK_Filter_Search::get_keyword_form_html();
}