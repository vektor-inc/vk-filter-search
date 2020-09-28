<?php
/**
 * VK Filter Search Config
 *
 * @package VK Filter Search
 */

if ( ! class_exists( 'VK_Filter_Search' ) && ! class_exists( 'VK_Filter_Search_Block' ) && ! class_exists( 'VK_Filter_Search_Shortcode' ) ) {
	require_once dirname( __FILE__ ) . '/package/class-vk-filter-search.php';
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	if ( is_plugin_active( 'vk-filter-search/vk-filter-search.php' ) ) {
		require_once dirname( __FILE__ ) . '/package/class-vk-filter-search-block.php';
		require_once dirname( __FILE__ ) . '/package/class-vk-filter-search-shortcode.php';
	}
}
