<?php

/**
 * Registers the `vk-filter-search/search-result-title` block.
 */
if ( function_exists( 'register_block_type' ) ) {

	function register_block_vkfs_search_result_title() {
		register_block_type(
			__DIR__,
			array(
				'render_callback' => 'vkfs_search_result_title_render_callback',
			)
		);
	}
	add_action( 'init', 'register_block_vkfs_search_result_title', 9999 );
}

/**
 * Add Script Parameters
 */
function vkfs_search_result_title_block_enqueue_block_editor_assets() {

	require_once ABSPATH . 'wp-admin/includes/plugin.php';

	// ブロックに値を渡す
	wp_localize_script(
		'vk-filter-search-block',
		'VKSearchTitle',
		array(
			'vkfsIsPro' => is_plugin_active( 'vk-filter-search-pro/vk-filter-search-pro.php' ) || is_plugin_active( 'vk-filter-search-pro-global-edition/vk-filter-search-pro-global-edition.php' ),
			'minDate'   => date( get_option( 'date_format' ), strtotime( '2024-01-01' ) ),
			'maxDate'   => date( get_option( 'date_format' ), strtotime( '2024-12-31' ) ),
		)
	);
}
add_action( 'enqueue_block_editor_assets', 'vkfs_search_result_title_block_enqueue_block_editor_assets' );

/**
 * Rendering Search Result Title Block
 *
 * @param array $attributes attributes.
 * @param html  $content content.
 */
function vkfs_search_result_title_render_callback( $attributes, $content ) {
	$attributes = wp_parse_args(
		$attributes,
		array(
			'outerTagName'          => 'div',
			'queriesFormat'         => __( 'Search Result for %s', 'vk-filter-search' ),
			'queryTitleDisplay'     => true,
			'queryTitleAfter'       => ': ',
			'queryElementOR'        => 'or',
			'queryElementAND'       => 'and',
			'queryElementBefore'    => '"',
			'queryElementAfter'     => '"',
			'queryElementsAfter'    => ' , ',
			'queryDateMinFormat'    => __( 'From %s', 'vk-filter-search' ),
			'queryDateMaxFormat'    => __( 'To %s', 'vk-filter-search' ),
			'queryDaterRangeFormat' => __( 'From %1$s to %2$s', 'vk-filter-search' ),
		)
	);

	$tag_name = $attributes['outerTagName'];

	$options = array(
		'queries_format'          => ! empty( $attributes['queriesFormat'] ) ? $attributes['queriesFormat'] : __( 'Search Result for %s', 'vk-filter-search' ),
		'query_title_display'     => $attributes['queryTitleDisplay'],
		'query_title_after'       => ! empty( $attributes['queryTitleAfter'] ) ? $attributes['queryTitleAfter'] : ': ',
		'query_element_or'        => ! empty( $attributes['queryElementOR'] ) ? $attributes['queryElementOR'] : 'or',
		'query_element_and'       => ! empty( $attributes['queryElementAND'] ) ? $attributes['queryElementAND'] : 'and',
		'query_element_before'    => ! empty( $attributes['queryElementBefore'] ) ? $attributes['queryElementBefore'] : '"',
		'query_element_after'     => ! empty( $attributes['queryElementAfter'] ) ? $attributes['queryElementAfter'] : '"',
		'query_elements_after'    => ! empty( $attributes['queryElementsAfter'] ) ? $attributes['queryElementsAfter'] : ' | ',
		'query_date_min_format'   => ! empty( $attributes['queryDateMinFormat'] ) ? $attributes['queryDateMinFormat'] : __( 'From %s', 'vk-filter-search' ),
		'query_date_max_format'   => ! empty( $attributes['queryDateMaxFormat'] ) ? $attributes['queryDateMaxFormat'] : __( 'To %s', 'vk-filter-search' ),
		'query_date_range_format' => ! empty( $attributes['queryDaterRangeFormat'] ) ? $attributes['queryDaterRangeFormat'] : __( 'From %1$s to %2$s', 'vk-filter-search' ),
		'queries_after'           => '',
	);

	$classes = array( 'vkfs__search-result-title' );

	if ( ! empty( $attributes['textAlign'] ) ) {
		$classes[] = 'has-text-align-' . $attributes['textAlign'];
	}
	$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => implode( ' ', $classes ) ) );

	$content = sprintf(
		'<%1$s %2$s>%3$s</%1$s>',
		$tag_name,
		$wrapper_attributes,
		VK_Filter_Search_Title::get_search_title( $options )
	);

	return $content;
}
