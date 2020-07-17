<?php
/**
 * VK Fiter Search
 *
 * @package VK Filter Search
 */

if ( ! class_exists( 'VK_Filter_Search' ) ) {

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
			$form_html = '<form class="vk-filter-search" method="get" action="' . site_url( '/' ) . '">';
			if ( true === $keyword ) {
				$form_html .= '<label>';
				$form_html .= '<p>' . __( 'Keyword Search', 'vk-filter-search' ) . '</p>';
				$form_html .= '<input type="text" name="s" id="s" placeholder="' . __( 'Input Keyword', 'vk-filter-search' ) . '" />';
				$form_html .= '</label>';
			}

			if ( ! empty( $post_types ) ) {
				$form_html .= '<label>';
				$form_html .= '<p>' . __( 'Filter by post type', 'vk-filter-search' ) . '</p>';
				$form_html .= '<select name="post_type" id="post_type">';
				foreach ( $post_types as $post_type ) {
					$form_html .= '<option value="' . $post_type . '">' . get_post_type_object( $post_type )->labels->singular_name . '</option>';
				}
				$form_html .= '</select>';
				$form_html .= '</label>';
			}

			if ( ! empty( $taxonomies ) ) {
				foreach ( $taxonomies as $taxonomy ) {
					if ( 'category' === $taxonomy ) {
						$taxonomy   = get_taxonomy( $taxonomy );
						$form_html .= '<label>';
						$form_html .= '<p>' . __( 'Filter by', 'vk-filter-search' ) . $taxonomy->labels->singular_name . '</p>';
						$form_html .= wp_dropdown_categories(
							array(
								'show_option_all'  => __( 'All of ', 'vk-filter-search' ) . $taxonomy->labels->singular_name,
								'show_option_none' => __( 'None of ', 'vk-filter-search' ) . $taxonomy->labels->singular_name,
								'orderby'          => 'name',
								'hide_if_empty'    => true,
								'echo'             => false,
								'selected'         => get_query_var( 'tag' ),
								'name'             => 'category_name',
								'taxonomy'         => 'category',
								'value_field'      => 'slug',
							)
						);
						$form_html .= '</label>';
					} elseif ( 'post_tag' === $taxonomy ) {
						$taxonomy   = get_taxonomy( $taxonomy );
						$form_html .= '<label>';
						$form_html .= '<p>' . __( 'Filter by', 'vk-filter-search' ) . $taxonomy->labels->singular_name . '</p>';
						$form_html .= wp_dropdown_categories(
							array(
								'show_option_all'  => __( 'All of ', 'vk-filter-search' ) . $taxonomy->labels->singular_name,
								'show_option_none' => __( 'None of ', 'vk-filter-search' ) . $taxonomy->labels->singular_name,
								'orderby'          => 'name',
								'hide_if_empty'    => true,
								'echo'             => false,
								'selected'         => get_query_var( 'tag' ),
								'name'             => 'tag',
								'taxonomy'         => 'post_tag',
								'value_field'      => 'slug',
							)
						);
						$form_html .= '</label>';
					} else {
						$taxonomy   = get_taxonomy( $taxonomy );
						$form_html .= '<label>';
						$form_html .= '<p>' . __( 'Filter by', 'vk-filter-search' ) . $taxonomy->labels->singular_name . '</p>';
						$form_html .= wp_dropdown_categories(
							array(
								'show_option_all'  => __( 'All of ', 'vk-filter-search' ) . $taxonomy->labels->singular_name,
								'show_option_none' => __( 'None of ', 'vk-filter-search' ) . $taxonomy->labels->singular_name,
								'orderby'          => 'name',
								'selected'         => get_query_var( $taxonomy->name ),
								'hide_if_empty'    => true,
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

			$form_html .= '<input type="submit" value="' . __( 'Search', 'vk-filter-search' ) . '" />';
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
}
