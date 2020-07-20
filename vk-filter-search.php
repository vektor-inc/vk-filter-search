<?php
/**
 * Plugin Name: VK Filter Search
 * Plugin URI: https://lightning.nagoya/
 * Description: This plugin for filter search.
 * Version: 1.0.0
 * Author:  Vektor,Inc.
 * Author URI: https://lightning.nagoya/
 * Text Domain: vk-filter-search
 * Domain Path: /languages
 * License: GPL 2.0 or Later
 *
 * @package VK Filter Search
 */

defined( 'ABSPATH' ) || exit;

global $plugin_version;
$plugin_data    = get_file_data( __FILE__, array( 'version' => 'Version' ) );
$plugin_version = $plugin_data['version'];

load_plugin_textdomain( 'vk-filter-search', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
require_once plugin_dir_path( __FILE__ ) . 'inc/vk-filter-search/vk-filter-search-config.php';

/**
 * VK Filter Search Block
 */
function vk_search_filter_block() {
	// automatically load dependencies and version.
	$asset_file = include plugin_dir_path( __FILE__ ) . 'build/index.asset.php';

	wp_register_style(
		'vk-filter-search',
		plugins_url( 'style.css', __FILE__ ),
		array(),
		$asset_file['version'],
	);

	wp_register_style(
		'vk-filter-search-editor',
		plugins_url( 'editor.css', __FILE__ ),
		array( 'wp-edit-blocks' ),
		$asset_file['version'],
	);

	wp_register_script(
		'vk-filter-search',
		plugins_url( 'build/index.js', __FILE__ ),
		$asset_file['dependencies'],
		$asset_file['version'],
		true
	);

	register_block_type(
		'vk-filter-search/filter-search',
		array(
			'style'           => 'vk-filter-search',
			'editor_style'    => 'vk-filter-search-editor',
			'editor_script'   => 'vk-filter-search',
			'render_callback' => 'vk_search_filter_block_render',
		)
	);
}
add_action( 'init', 'vk_search_filter_block' );

/**
 * Rendering Block
 *
 * @param array $attributes attributes.
 * @param html  $content content.
 */
function vk_search_filter_block_render( $attributes, $content = '' ) {
	$attributes = wp_parse_args(
		$attributes,
		array(
			'showKeyword'       => true,
			'isCheckedPostType' => '["post","page"]',
			'isCheckedTaxonomy' => '["category","post_tag"]',
		)
	);

	if ( ! empty( $attributes['isCheckedPostType'] ) ) {
		$attributes['isCheckedPostType'] = str_replace( '[', '', $attributes['isCheckedPostType'] );
		$attributes['isCheckedPostType'] = str_replace( ']', '', $attributes['isCheckedPostType'] );
		$attributes['isCheckedPostType'] = str_replace( '"', '', $attributes['isCheckedPostType'] );
	}

	if ( ! empty( $attributes['isCheckedTaxonomy'] ) ) {
		$attributes['isCheckedTaxonomy'] = str_replace( '[', '', $attributes['isCheckedTaxonomy'] );
		$attributes['isCheckedTaxonomy'] = str_replace( ']', '', $attributes['isCheckedTaxonomy'] );
		$attributes['isCheckedTaxonomy'] = str_replace( '"', '', $attributes['isCheckedTaxonomy'] );
	}

	$keyword    = ! empty( $attributes['keyword'] ) ? $attributes['keyword'] : false;
	$post_types = ! empty( $attributes['isCheckedPostType'] ) ? explode( ',', $attributes['isCheckedPostType'] ) : array();
	$taxonomies = ! empty( $attributes['isCheckedTaxonomy'] ) ? explode( ',', $attributes['isCheckedTaxonomy'] ) : array();

	return VK_Filter_Search::get_search_form_html( $keyword, $post_types, $taxonomies );
}
