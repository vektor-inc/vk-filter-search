<?php

/**
 * Registers the `vk-filter-search/post-type-search` block.
 */
if( function_exists('register_block_type_from_metadata')) {

	function register_block_vkfs_post_type_search() {
		register_block_type_from_metadata(
			__DIR__,
			array(
				'style'           => 'vk-filter-search',
				'editor_style'    => 'vk-filter-search-editor',
				'editor_script'   => 'vk-filter-search-js',
				'attributes'      => array(
					'isCheckedPostType' => array(
						'type'    => 'string',
						'default' => '["post","page"]',
					),
				),
				'render_callback' => 'vkfs_post_type_search_render_callback',
			)
		);
	}
	add_action( 'init', 'register_block_vkfs_post_type_search', 99 );
}

/**
 * Rendering Post Type Search Block
 *
 * @param array $attributes attributes.
 * @param html  $content content.
 */
function vkfs_post_type_search_render_callback( $attributes, $content = '' ) {
	$attributes = wp_parse_args(
		$attributes,
		array(
			'isCheckedPostType' => '["post","page"]',
		)
	);

	if ( ! empty( $attributes['isCheckedPostType'] ) ) {
		$attributes['isCheckedPostType'] = str_replace( '[', '', $attributes['isCheckedPostType'] );
		$attributes['isCheckedPostType'] = str_replace( ']', '', $attributes['isCheckedPostType'] );
		$attributes['isCheckedPostType'] = str_replace( '"', '', $attributes['isCheckedPostType'] );
	}

	$post_types = ! empty( $attributes['isCheckedPostType'] ) ? explode( ',', $attributes['isCheckedPostType'] ) : array();

	return VK_Filter_Search::get_post_type_form_html( $post_types );
}