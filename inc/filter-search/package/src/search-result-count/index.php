<?php

/**
 * Registers the `vk-filter-search/search-result-count` block.
 */
if ( function_exists( 'register_block_type' ) ) {

	function register_block_vkfs_search_result_count() {
		register_block_type(
			__DIR__,
			array(
				'render_callback' => 'vkfs_search_result_count_render_callback',
			)
		);
	}
	add_action( 'init', 'register_block_vkfs_search_result_count', 9999 );
}

/**
 * Rendering Search Result count Block
 *
 * @param array $attributes attributes.
 * @param html  $content content.
 */
function vkfs_search_result_count_render_callback( $attributes, $content ) {
	$attributes = wp_parse_args(
		$attributes,
		array(
			'beforeText'       => '',
			'afterText'        => '',
			'numberColor'      => '',
			'numberFontSize'   => '',
			'numberFontStyle'  => '',
			'numberFontWeight' => '',
		)
	);

	$content = '';
	
	if ( VK_Filter_Search::has_search_query() ) {
		$classes = array( 'vkfs__search-result-count' );

		$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => implode( ' ', $classes ) ) );

		$options = array(
			'outer'              => false,
			'before_text'        => $attributes['beforeText'],
			'after_text'         => $attributes['afterText'],
			'number_color'       => $attributes['numberColor'],
			'number_font_size'   => $attributes['numberFontSize'],
			'number_font_style'  => $attributes['numberFontStyle'],
			'number_font_weight' => $attributes['numberFontWeight'],
		);
	
		$content = sprintf(
			'<%1$s %2$s>%3$s</%1$s>',
			'div',
			$wrapper_attributes,
			VK_Filter_Search::get_search_count_html( $options )
		);
	}

	return $content;
}

