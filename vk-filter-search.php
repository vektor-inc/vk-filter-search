<?php
/**
 * Plugin Name: VK Filter Search
 * Plugin URI: https://vk-filter-search.com/
 * Description: This plugin for filter search.
 * Version: 1.10.13
 * Requires at least: 5.7
 * Author:  Vektor,Inc.
 * Author URI: https://vektor-inc.co.jp
 * Text Domain: vk-filter-search
 * License: GPL 2.0 or Later
 *
 * @package VK Filter Search
 */

defined( 'ABSPATH' ) || exit;

// Define Plugin  Root Path
define( 'VKFS_PLUGIN_ROOT_PATH', plugin_dir_path( __FILE__ ) );
// Define Plugin Root URL
define( 'VKFS_PLUGIN_ROOT_URL', plugin_dir_url( __FILE__ ) );
// Define Plugin Version
$plugin_data = get_file_data( __FILE__, array( 'version' => 'Version' ) );
define( 'VKFS_PLUGIN_VERSION', $plugin_data['version'] );

// Plugin Version
global $vkfs_prefix;
$vkfs_prefix = apply_filters( 'vkfs_prefix', 'VK ' );

// Load Modules
require_once plugin_dir_path( __FILE__ ) . 'inc/patches/config.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/dropdown-categories/config.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/filter-search/config.php';

// Add a link to this plugin's settings page
function vkfs_free_set_plugin_meta( $links ) {
    $link_url = __( 'https://vk-filter-search.com/', 'vk-filter-search' );
	$settings_link = '<a href="' . $link_url . '?ref=admin-plugin-list"  target="_blank" rel="noopener noreferrer">' . __( 'Buy Pro', 'vk-filter-search' ) . '</a>';
	array_push( $links, $settings_link );
	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'vkfs_free_set_plugin_meta', 10, 1 );
