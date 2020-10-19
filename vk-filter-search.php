<?php
/**
 * Plugin Name: VK Filter Search
 * Plugin URI: https://lightning.nagoya/
 * Description: This plugin for filter search.
 * Version: 0.1.0
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
do_action( 'vkfs_load_modules_before' );
require_once plugin_dir_path( __FILE__ ) . 'inc/filter-search/vk-filter-search-config.php';
