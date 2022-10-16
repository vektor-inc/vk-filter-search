<?php

/**
 * Registers the `vk-filter-search/taxonomy-search` block.
 */
if( function_exists('register_block_type_from_metadata') ) {

	function register_block_vkfs_taxonomy_search() {
		register_block_type_from_metadata(
			__DIR__,
			array(
				'style'           => 'vk-filter-search-style',
				'editor_style'    => 'vk-filter-search-editor',
				'editor_script'   => 'vk-filter-search-block',
				'attributes'      => array(
					'isSelectedTaxonomy' => array(
						'type'    => 'string',
						'default' => 'category',
					),
					'className'          => array(
						'type'    => 'string',
						'default' => '',
					),
				),
				'render_callback' => 'vkfs_taxonomy_search_render_callback',
			)
		);
	}
	add_action( 'init', 'register_block_vkfs_taxonomy_search', 9999 );
}

/**
 * Rendering Taxonomy Search Block
 *
 * @param array $attributes attributes.
 * @param html  $content content.
 */
function vkfs_taxonomy_search_render_callback( $attributes, $content ) {
	$attributes = wp_parse_args(
		$attributes,
		array(
			'isSelectedTaxonomy' => 'category',
			'className'          => '',
		)
	);

	// タクソノミーを処理
	$taxonomy      = ! empty( $attributes['isSelectedTaxonomy'] ) ? $attributes['isSelectedTaxonomy'] : '';

	// オプションを設定
	$options = array(
		'class_name'    => ! empty( $attributes['className'] ) ? $attributes['className'] : '',
	);

	return VK_Filter_Search::get_taxonomy_form_html( $taxonomy, $options );
}