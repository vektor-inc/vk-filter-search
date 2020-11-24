<?php
/**
 * Plugin Name: VK Filter Search
 * Plugin URI: https://github.com/vektor-inc/vk-filter-search/
 * Description: This plugin for filter search.
 * Version: 0.6.2
 * Author:  Vektor,Inc.
 * Author URI: https://vektor-inc.co.jp
 * Text Domain: vk-filter-search
 * License: GPL 2.0 or Later
 *
 * @package VK Filter Search
 */

defined( 'ABSPATH' ) || exit;

define( 'VKFS_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

global $vkfs_prefix;
$vkfs_prefix = apply_filters( 'vkfs_prefix', 'VK ' );

do_action( 'vkfs_load_modules_before' );
require_once plugin_dir_path( __FILE__ ) . 'inc/filter-search/vk-filter-search-config.php';
