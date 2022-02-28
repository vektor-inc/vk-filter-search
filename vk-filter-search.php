<?php
/**
 * Plugin Name: VK Filter Search
 * Plugin URI: https://vk-filter-search.com/
 * Description: This plugin for filter search.
 * Version: 1.6.1
 * Requires at least: 5.7
 * Author:  Vektor,Inc.
 * Author URI: https://vektor-inc.co.jp
 * Text Domain: vk-filter-search
 * License: GPL 2.0 or Later
 *
 * @package VK Filter Search
 */

defined( 'ABSPATH' ) || exit;

// Define Plugin Path
define( 'VKFS_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

// Plugin Version
global $vkfs_prefix;
$vkfs_prefix = apply_filters( 'vkfs_prefix', 'VK ' );

// Load Modules
require_once plugin_dir_path( __FILE__ ) . 'inc/filter-search/vk-filter-search-config.php';
