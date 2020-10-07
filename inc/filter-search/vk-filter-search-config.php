<?php
/**
 * VK Filter Search Config
 *
 * @package VK Filter Search
 */

if ( ! class_exists( 'VK_Filter_Search' ) && ! class_exists( 'VK_Filter_Search_Block' ) && ! class_exists( 'VK_Filter_Search_Shortcode' ) ) {
	// 読み込むファイルを調整.
	require_once dirname( __FILE__ ) . '/package/class-vk-filter-search.php';
	require_once dirname( __FILE__ ) . '/package/class-vk-filter-search-block.php';
	require_once dirname( __FILE__ ) . '/package/class-vk-filter-search-shortcode.php';
}
