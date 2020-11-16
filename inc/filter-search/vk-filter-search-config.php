<?php
/**
 * VK Filter Search Config
 *
 * @package VK Filter Search
 */

if ( ! class_exists( 'VK_Filter_Search' ) && ! class_exists( 'VK_Filter_Search_Block' ) && ! class_exists( 'VK_Filter_Search_Shortcode' ) ) {
	/**
	 * Theme Hook Array
	 */
	function vkfs_theme_hook_array() {
		$theme_hook_array = array(
			'lightning'     => 'lightning_loop_before',
			'lightning-pro' => 'lightning_loop_before',
			'katawara'      => 'katawara_loop_before',
		);
		$theme_hook_array = apply_filters( 'vkfs_theme_hook_array', $theme_hook_array );
		return $theme_hook_array;
	}

	// 読み込むファイルを調整.
	require_once dirname( __FILE__ ) . '/package/class-vk-filter-search.php';
	require_once dirname( __FILE__ ) . '/package/class-vk-filter-search-block.php';
	require_once dirname( __FILE__ ) . '/package/class-vk-filter-search-shortcode.php';
}
