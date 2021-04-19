<?php

/**
 * Registers the `vk-filter-search/taxonomy-search` block.
 */
if( function_exists('register_block_type_from_metadata')) {

	function register_block_vkfs_taxonomy_search() {
		register_block_type_from_metadata(
			__DIR__,
			array(
				'style'           => 'vk-filter-search-style',
				'editor_style'    => 'vk-filter-search-editor',
				'editor_script'   => 'vk-filter-search-js',
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
	add_action( 'init', 'register_block_vkfs_taxonomy_search', 99 );
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

	$taxonomy    = ! empty( $attributes['isSelectedTaxonomy'] ) ? $attributes['isSelectedTaxonomy'] : '';
	$label       = '';
	$form_design = '';
	$operator    = '';
	$columns     = array();
	$class_name  = ! empty( $attributes['className'] ) ? $attributes['className'] : '';

	$content = '';
	if ( ! empty( $taxonomy ) ) {
		$content = VK_Filter_Search::get_taxonomy_form_html( $taxonomy, $label, $form_design, $operator, $columns, $class_name );
	}

	return $content;
}