<?php
/**
 * Plugin Name: VK Filter Search
 * Plugin URI: https://vk-filter-search.com/
 * Description: This plugin for filter search.
 * Version: 2.15.0.3
 * Requires at least: 5.7
 * Author:  Vektor,Inc.
 * Author URI: https://vektor-inc.co.jp
 * Text Domain: vk-filter-search
 * License: GPL 2.0 or Later
 *
 * @package VK Filter Search
 */

defined( 'ABSPATH' ) || exit;
require_once ABSPATH . 'wp-admin/includes/plugin.php';

/**
 * Deactive VK Filter Search
 * ( Attend to Deactive Plugin VK Filter Search ( free ) when Pro version is activated
 */
if (
	is_plugin_active( 'vk-filter-search-pro/vk-filter-search-pro.php' ) ||
	is_plugin_active( 'vk-filter-search-pro-global-edition/vk-filter-search-pro-global-edition.php' )
) {
	deactivate_plugins( 'vk-filter-search/vk-filter-search.php' );
	return;
}

if ( 'vk-filter-search/vk-filter-search.php' === plugin_basename( __FILE__ ) ) {
		
	// Define Plugin Root Path
	if ( ! defined( 'VKFS_PLUGIN_ROOT_PATH' ) ) {
		define( 'VKFS_PLUGIN_ROOT_PATH', plugin_dir_path( __FILE__ ) );
	}

	// Define Plugin Root URL
	if ( ! defined( 'VKFS_PLUGIN_ROOT_URL' ) ) {
		define( 'VKFS_PLUGIN_ROOT_URL', plugin_dir_path( __FILE__ ) );
	}

	// Define Plugin Version
	if ( ! defined( 'VKFS_PLUGIN_VERSION' ) ) {
		$plugin_data = get_file_data( __FILE__, array( 'version' => 'Version' ) );
		define( 'VKFS_PLUGIN_VERSION', $plugin_data['version'] );
	}

	// Plugin Version
	global $vkfs_prefix;
	$vkfs_prefix = apply_filters( 'vkfs_prefix', 'VK ' );

	// Load Modules
	require_once plugin_dir_path( __FILE__ ) . 'inc/patches/config.php';
	require_once plugin_dir_path( __FILE__ ) . 'inc/dropdown-categories/dropdown-categories.php';
	require_once plugin_dir_path( __FILE__ ) . 'inc/filter-search/config.php';

	// Add a link to this plugin's settings page
	function vkfs_free_set_plugin_meta( $links ) {
		$link_url      = __( 'https://vk-filter-search.com/', 'vk-filter-search' );
		$settings_link = '<a href="' . $link_url . '?ref=admin-plugin-list"  target="_blank" rel="noopener noreferrer">' . __( 'Buy Pro', 'vk-filter-search' ) . '</a>';
		array_push( $links, $settings_link );
		return $links;
	}
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'vkfs_free_set_plugin_meta', 10, 1 );

}
