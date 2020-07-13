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
			add_shortcode( 'vk_filter_search', array( __CLASS__, 'shortcode_display' ) );
		}

		/**
		 * Search Form
		 *
		 * @param bool  $keyword    Filer by Keyword or not.
		 * @param array $post_types Names of Post Types.
		 * @param array $taxonomies Names of Taxonomies.
		 */
		public static function search_form( $keyword = true, $post_types = array(), $taxonomies = array() ) {
			$form_html = '<form method="get" action="' . site_url( '/' ) . '">';
			if ( true === $keyword ) {
				$form_html .= '<label for="s">' . __( 'Keyword Search', 'vk-filter-search' ) . '</label>';
				$form_html .= '<input type="text" name="s" id="s" placeholder="' . __( 'Input Keyword', 'vk-filter-search' ) . '" />';
			}

			if ( ! empty( $post_types ) ) {
				$form_html .= '<label for="post_type">' . __( 'Filter by post type', 'vk-filter-search' ) . '</label>';
				$form_html .= '<select name="post_type" id="post_type">';
				$form_html .= '<option>' . __( 'Post Types', 'vk-filter-search' ) . '</option>';
				foreach ( $post_types as $post_type ) {
					$form_html .= '<option value="' . $post_type . '">' . get_post_type_object( $post_type )->labels->singular_name . '</option>';
				}
				$form_html .= '</select>';
			}

			if ( ! empty( $taxonomies ) ) {
				foreach ( $taxonomies as $taxonomy ) {
					if ( 'category' === $taxonomy ) {
						$taxonomy   = get_taxonomy( $taxonomy );
						$form_html .= '<label for="cat">' . __( 'Filter by', 'vk-filter-search' ) . $taxonomy->labels->singular_name . '</label>';
						$form_html .= wp_dropdown_categories(
							array(
								'show_option_all'  => $taxonomy->labels->singular_name . __( ' list', 'vk-filter-search' ),
								'show_option_none' => $taxonomy->labels->singular_name . __( ' none', 'vk-filter-search' ),
								'orderby'          => 'name',
								'hide_if_empty'    => true,
								'echo'             => false,
								'selected'         => get_query_var( 'cat' ),
								'name'             => 'cat',
								'taxonomy'         => 'category',
								'value_field'      => 'slug',
							)
						);
					} elseif ( 'post_tag' === $taxonomy ) {
						$taxonomy   = get_taxonomy( $taxonomy );
						$form_html .= '<label for="tag">' . __( 'Filter by', 'vk-filter-search' ) . $taxonomy->labels->singular_name . '</label>';
						$form_html .= wp_dropdown_categories(
							array(
								'show_option_all'  => $taxonomy->labels->singular_name . __( ' list', 'vk-filter-search' ),
								'show_option_none' => $taxonomy->labels->singular_name . __( ' none', 'vk-filter-search' ),
								'orderby'          => 'name',
								'hide_if_empty'    => true,
								'echo'             => false,
								'selected'         => get_query_var( 'tag' ),
								'name'             => 'tag',
								'taxonomy'         => 'post_tag',
								'value_field'      => 'slug',
							)
						);
					} else {
						$taxonomy   = get_taxonomy( $taxonomy );
						$form_html .= '<label for="' . esc_html( $taxonomy->name ) . '">' . __( 'Filter by', 'vk-filter-search' ) . $taxonomy->labels->singular_name . '</label>';
						$form_html .= wp_dropdown_categories(
							array(
								'show_option_all'  => $taxonomy->labels->singular_name . __( ' list', 'vk-filter-search' ),
								'show_option_none' => $taxonomy->labels->singular_name . __( ' none', 'vk-filter-search' ),
								'orderby'          => 'name',
								'selected'         => get_query_var( $taxonomy->name ),
								'hide_if_empty'    => true,
								'echo'             => false,
								'name'             => $taxonomy->name,
								'taxonomy'         => $taxonomy->name,
								'value_field'      => 'slug',
							)
						);
					}
				}
			}

			$form_html .= '<input type="submit" value="' . __( 'Search', 'vk-filter-search' ) . '" />';
			$form_html .= '</form>';
		}

		/**
		 * Shortcode Display
		 *
		 * @param array $atts Attributes..
		 */
		public static function shortcode_display( $atts ) {
			$atts = shortcode_atts(
				array(
					'keyword'    => true,
					'post_types' => 'post,page',
					'taxonomies' => 'category,post_tag',
				),
				$atts
			);

			$keyword    = $atts['keyword'];
			$post_types = explode( ',', $atts['post_types'] );
			$taxonomies = explode( ',', $atts['taxonomies'] );

			return self::search_form( $keyword, $post_types, $taxonomies );
		}
	}
	new VK_Filter_Search();
}
