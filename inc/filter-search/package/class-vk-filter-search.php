<?php
/**
 * VK Fiter Search
 *
 * @package VK Filter Search
 */

/**
 * VK Filter Search
 */
class VK_Filter_Search {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_shortcode( 'vk_filter_search', array( __CLASS__, 'display_shortcode' ) );
	}

	/**
	 * Get Search Form HTML
	 *
	 * @param bool  $keyword    Filer by Keyword or not.
	 * @param array $post_types Names of Post Types.
	 * @param array $taxonomies Names of Taxonomies.
	 */
	public static function get_search_form_html( $keyword = true, $post_types = array(), $taxonomies = array() ) {
		$form_html  = '<form class="vk-filter-search vkfs" method="get" action="' . site_url( '/' ) . '">';
		$form_html .= '<div class="vkfs__labels">';

		if ( ! empty( $taxonomies ) ) {
			foreach ( $taxonomies as $taxonomy ) {
				if ( 'category' === $taxonomy ) {
					$terms    = get_terms( $taxonomy );
					$taxonomy = get_taxonomy( $taxonomy );
					if ( ! empty( $taxonomy ) && ! empty( $terms ) ) {
						$form_html .= '<label>';
						$form_html .= '<div class="vkfs__label-name">' . $taxonomy->labels->singular_name . '</div>';
						$form_html .= wp_dropdown_categories(
							array(
								// Translators: All of Category.
								'show_option_all'  => sprintf( __( 'All of %s', 'vk-filter-search' ), $taxonomy->labels->singular_name ),
								// Translators: None of Category.
								'show_option_none' => sprintf( __( 'None of %s', 'vk-filter-search' ), $taxonomy->labels->singular_name ),
								'orderby'          => 'name',
								'echo'             => false,
								'selected'         => get_query_var( 'tag' ),
								'name'             => 'category_name',
								'taxonomy'         => 'category',
								'value_field'      => 'slug',
							)
						);
						$form_html .= '</label>';
					}
				} elseif ( 'post_tag' === $taxonomy ) {
					$terms    = get_terms( $taxonomy );
					$taxonomy = get_taxonomy( $taxonomy );
					if ( ! empty( $taxonomy ) && ! empty( $terms ) ) {
						$form_html .= '<label>';
						$form_html .= '<div class="vkfs__label-name">' . $taxonomy->labels->singular_name . '</div>';
						$form_html .= wp_dropdown_categories(
							array(
								// Translators: All of Tag.
								'show_option_all'  => sprintf( __( 'All of %s', 'vk-filter-search' ), $taxonomy->labels->singular_name ),
								// Translators: None of Tag.
								'show_option_none' => sprintf( __( 'None of %s', 'vk-filter-search' ), $taxonomy->labels->singular_name ),
								'orderby'          => 'name',
								'echo'             => false,
								'selected'         => get_query_var( 'tag' ),
								'name'             => 'tag',
								'taxonomy'         => 'post_tag',
								'value_field'      => 'slug',
							)
						);
						$form_html .= '</label>';
					}
				} else {
					$terms    = get_terms( $taxonomy );
					$taxonomy = get_taxonomy( $taxonomy );
					if ( ! empty( $taxonomy ) && ! empty( $terms ) ) {
						$form_html .= '<label>';
						$form_html .= '<div class="vkfs__label-name">' . $taxonomy->labels->singular_name . '</div>';
						$form_html .= wp_dropdown_categories(
							array(
								// Translators: All of the taxonomy.
								'show_option_all'  => sprintf( __( 'All of %s', 'vk-filter-search' ), $taxonomy->labels->singular_name ),
								// Translators: None of the taxonomy.
								'show_option_none' => sprintf( __( 'None of %s', 'vk-filter-search' ), $taxonomy->labels->singular_name ),
								'orderby'          => 'name',
								'selected'         => get_query_var( $taxonomy->name ),
								'echo'             => false,
								'name'             => $taxonomy->name,
								'taxonomy'         => $taxonomy->name,
								'value_field'      => 'slug',
							)
						);
						$form_html .= '</label>';
					}
				}
			}
		}

		if ( ! empty( $post_types ) ) {
			$form_html .= '<label>';
			$form_html .= '<div class="vkfs__label-name">' . __( 'Post Type', 'vk-filter-search' ) . '</div>';
			$form_html .= '<select name="post_type" id="post_type">';
			foreach ( $post_types as $post_type ) {
				$form_html .= '<option value="' . $post_type . '">' . get_post_type_object( $post_type )->labels->singular_name . '</option>';
			}
			$form_html .= '</select>';
			$form_html .= '</label>';
		}

		if ( true === $keyword ) {
			$form_html .= '<label>';
			$form_html .= '<div class="vkfs__label-name">' . __( 'Keyword', 'vk-filter-search' ) . '</div>';
			$form_html .= '<input type="text" name="s" id="s" placeholder="' . __( 'Input Keyword', 'vk-filter-search' ) . '" />';
			$form_html .= '</label>';
		}

		$form_html .= '</div>';
		$form_html .= '<input class="btn btn-primary" type="submit" value="' . __( 'Refine search', 'vk-filter-search' ) . '" />';
		$form_html .= '</form>';
		return $form_html;
	}

	/**
	 * Display Search Form HTML
	 *
	 * @param bool  $keyword    Filer by Keyword or not.
	 * @param array $post_types Names of Post Types.
	 * @param array $taxonomies Names of Taxonomies.
	 */
	public static function display_search_form_html( $keyword = true, $post_types = array(), $taxonomies = array() ) {

		$display_html = self::get_search_form_html( $keyword, $post_types, $taxonomies );

		$allowed_html = array(
			'form'   => array(
				'class'  => array(),
				'id'     => array(),
				'method' => array(),
				'action' => array(),
			),
			'label'  => array(
				'class' => array(),
				'id'    => array(),
				'for'   => array(),
			),
			'select' => array(
				'class' => array(),
				'id'    => array(),
				'name'  => array(),
			),
			'input'  => array(
				'class'       => array(),
				'id'          => array(),
				'type'        => array(),
				'name'        => array(),
				'placeholder' => array(),
			),
		);

		echo wp_kses( $display_html, $allowed_html );
	}

	/**
	 * Display Shortcode
	 *
	 * @param array $atts Attributes..
	 */
	public static function display_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'keyword'    => true,
				'post_types' => 'post,page',
				'taxonomies' => 'category,post_tag',
			),
			$atts
		);

		$keyword    = ! empty( $atts['keyword'] ) ? $atts['keyword'] : false;
		$post_types = ! empty( $atts['post_types'] ) ? explode( ',', $atts['post_types'] ) : array();
		$taxonomies = ! empty( $atts['taxonomies'] ) ? explode( ',', $atts['taxonomies'] ) : array();

		return self::get_search_form_html( $keyword, $post_types, $taxonomies );
	}
}
new VK_Filter_Search();
