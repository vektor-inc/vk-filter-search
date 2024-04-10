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
	public static function add_search_form_shortcode( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'class_name' => '',
				'post_type'  => '',
			),
			$atts
		);

		$class_name = ! empty( $atts['class_name'] ) ? ' ' . $atts['class_name'] : '';

		$form_before_html  = '<form class="vk-filter-search vkfs' . $class_name . '" method="get" action="' . VK_Filter_Search::get_search_root_url() . '">';
		$form_before_html .= '<div class="vkfs__labels">';

		$inner_content = shortcode_unautop( $content );
		$content       = do_shortcode( $inner_content );

		$form_after_html = '</div>';
		if ( ! empty( $atts['post_type'] ) ) {
			$form_after_html .= '<input type="hidden" name="vkfs_post_type[]" value="' . $atts['post_type'] . '" />';
		}
		if ( false === strpos( $inner_content, 'vk_filter_search_keyword' ) ) {
			$form_after_html .= '<input type="hidden" name="s" value="" />';
		}
		$form_after_html .= '<input type="hidden" name="vkfs_submitted" value="true" />';
		$form_after_html .= '<input class="btn btn-primary" type="submit" value="' . __( 'Search', 'vk-filter-search' ) . '" />';
		$form_after_html .= '</form>';

		$search_form = $form_before_html . $content . $form_after_html;
		$search_form = preg_replace( '/\<p\>|\<\/p\>|\<br \/\>/', '', $search_form );

		return wp_kses( $search_form, VK_Filter_Search::kses_allowed() );
	}

	/**
	 * Keyword Form Shortcode
	 *
	 * @param array  $atts    Attributes.
	 * @param string $content Inner Contents.
	 */
	public static function add_keyword_form_shortcode( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'class_name' => '',
			),
			$atts
		);

		$options = array(
			'class_name' => ! empty( $atts['class_name'] ) ? $atts['class_name'] : '',
		);

		return VK_Filter_Search::get_keyword_form_html( $options );
	}

	/**
	 * Post Type Form Shortcode
	 *
	 * @param array  $atts    Attributes.
	 * @param string $content Inner Contents.
	 */
	public static function add_post_type_form_shortcode( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'post_types' => 'post,page',
				'class_name' => '',
			),
			$atts
		);

		$post_types = ! empty( $atts['post_types'] ) ? explode( ',', $atts['post_types'] ) : array();

		$options = array(
			'class_name' => ! empty( $atts['class_name'] ) ? $atts['class_name'] : '',
		);

		return VK_Filter_Search::get_post_type_form_html( $post_types, $options );
	}

	/**
	 * Taxonomy Form Shortcode
	 *
	 * @param array  $atts    Attributes.
	 * @param string $content Inner Contents.
	 */
	public static function add_taxonomy_form_shortcode( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'taxonomy'   => 'category',
				'class_name' => '',
			),
			$atts
		);

		$taxonomy = ! empty( $atts['taxonomy'] ) ? $atts['taxonomy'] : '';

		$options = array(
			'class_name' => ! empty( $atts['class_name'] ) ? $atts['class_name'] : '',
		);

		return VK_Filter_Search::get_taxonomy_form_html( $taxonomy, $options );
	}
}
new VK_Filter_Search_Shortcode();
