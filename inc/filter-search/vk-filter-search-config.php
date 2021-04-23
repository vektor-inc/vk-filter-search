<?php
/**
 * VK Filter Search Config
 *
 * @package VK Filter Search
 */

if ( ! function_exists( 'vkfs_themes_hook' ) ) {
	/**
	 * Theme Hook Array
	 *
	 * @param array $theme_hook_array themes and hooks of the themes.
	 */
	function vkfs_themes_hook( $theme_hook_array ) {
		$theme_hooks      = array(
			'lightning'     => 'lightning_loop_before',
			'lightning-pro' => 'lightning_loop_before',
			'katawara'      => 'katawara_loop_before',
		);
		$theme_hook_array = array_merge( $theme_hook_array, $theme_hooks );
		return $theme_hook_array;
	}
	add_filter( 'vkfs_theme_hook_array', 'vkfs_themes_hook' );
}

if ( ! class_exists( 'VK_Filter_Search' ) && ! class_exists( 'VK_Filter_Search_Block' ) && ! class_exists( 'VK_Filter_Search_Shortcode' ) ) {

	// 読み込むファイルを調整.
	require_once dirname( __FILE__ ) . '/package/class-vk-filter-search.php';
	require_once dirname( __FILE__ ) . '/package/class-vk-filter-search-block.php';
	require_once dirname( __FILE__ ) . '/package/class-vk-filter-search-shortcode.php';
}

if ( ! function_exists( 'vkfs_set_script_translations' ) ) {
	/**
	 * テキストドメインの設定
	 */
	function vkfs_set_script_translations() {
		if ( function_exists( 'wp_set_script_translations' ) ) {
			wp_set_script_translations( 'vk-filter-search-js', 'vk-filter-search' );
		}
	}
	add_action( 'init', 'vkfs_set_script_translations' );
}
