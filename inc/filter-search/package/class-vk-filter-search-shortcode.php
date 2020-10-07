<?php
/**
 * VK Fiter Search Shortcode
 *
 * @package VK Filter Search
 */

/**
 * VK Filter Search Shortcode
 */
class VK_Filter_Search_Shortcode {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_shortcode( 'vk_filter_search', array( __CLASS__, 'add_search_form_shortcode' ) );
		add_shortcode( 'vk_filter_search_keyword', array( __CLASS__, 'add_keyword_form_shortcode' ) );
		add_shortcode( 'vk_filter_search_post_type', array( __CLASS__, 'add_post_type_form_shortcode' ) );
		add_shortcode( 'vk_filter_search_taxonomy', array( __CLASS__, 'add_taxonomy_form_shortcode' ) );
	}

	/**
	 * Search Form Shortcode
	 *
	 * @param array  $atts    Attributes.
	 * @param string $content Inner Contents.
	 */
	public static function add_search_form_shortcode( $atts = array(), $content = null ) {

		$form_before_html  = '<form class="vk-filter-search vkfs" method="get" action="' . site_url( '/' ) . '">';
		$form_before_html .= '<div class="vkfs__labels">';

		$content = do_shortcode( shortcode_unautop( $content ) );

		$form_after_html  = '</div>';
		$form_after_html .= '<input class="btn btn-primary" type="submit" value="' . __( 'Refine search', 'vk-filter-search' ) . '" />';
		$form_after_html .= '</form>';

		return $form_before_html . $content . $form_after_html;
	}

	/**
	 * Keyword Form Shortcode
	 *
	 * @param array  $atts    Attributes.
	 * @param string $content Inner Contents.
	 */
	public static function add_keyword_form_shortcode( $atts = array(), $content = null ) {
		return VK_Filter_Search::get_keyword_form_html();
	}

	/**
	 * Post Type Form Shortcode
	 *
	 * @param array  $atts    Attributes.
	 * @param string $content Inner Contents.
	 */
	public static function add_post_type_form_shortcode( $atts = array(), $content = null ) {
		$atts = shortcode_atts(
			array(
				'post_types' => 'post,page',
			),
			$atts
		);

		$post_types = ! empty( $atts['post_types'] ) ? explode( ',', $atts['post_types'] ) : array();
		return VK_Filter_Search::get_post_type_form_html( $post_types );
	}

	/**
	 * Taxonomy Form Shortcode
	 *
	 * @param array  $atts    Attributes.
	 * @param string $content Inner Contents.
	 */
	public static function add_taxonomy_form_shortcode( $atts = array(), $content = null ) {
		$atts = shortcode_atts(
			array(
				'taxonomy' => 'category',
			),
			$atts
		);

		$taxonomy = ! empty( $atts['taxonomy'] ) ? $atts['taxonomy'] : '';
		return VK_Filter_Search::get_taxonomy_form_html( $taxonomy );
	}
}
new VK_Filter_Search_Shortcode();
