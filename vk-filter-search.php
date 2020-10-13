<?php
/**
 * Plugin Name: VK Filter Search
 * Plugin URI: https://lightning.nagoya/
 * Description: This plugin for filter search.
 * Version: 0.1.3
 * Author:  Vektor,Inc.
 * Author URI: https://lightning.nagoya/
 * Text Domain: vk-filter-search
 * Domain Path: /languages
 * License: GPL 2.0 or Later
 *
 * @package VK Filter Search
 */

defined( 'ABSPATH' ) || exit;

define( 'VKFS_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

global $plugin_version;
$plugin_data    = get_file_data( __FILE__, array( 'version' => 'Version' ) );
$plugin_version = $plugin_data['version'];

load_plugin_textdomain( 'vk-filter-search', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
require_once plugin_dir_path( __FILE__ ) . 'inc/filter-search/vk-filter-search-config.php';


function exclude_category( $query ) {
    if ( !is_admin() && $query->is_main_query() ) {
        if ( isset( $_GET['post_type'] ) &&  isset( $_GET['s'] ) && $_GET['post_type'] === 'page' ){
            $query->set( 'post_type', 'page' );
        }
    }
}
add_action( 'pre_get_posts', 'exclude_category' );