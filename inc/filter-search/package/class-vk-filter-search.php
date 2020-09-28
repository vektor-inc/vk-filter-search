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
	 * Get Keyword Filter Form HTML
	 */
	public static function get_keyword_form_html() {
		$keyword_form_html  = '<label>';
		$keyword_form_html .= '<div class="vkfs__label-name">' . __( 'Keyword', 'vk-filter-search' ) . '</div>';
		$keyword_form_html .= '<input type="text" name="s" id="s" placeholder="' . __( 'Input Keyword', 'vk-filter-search' ) . '" />';
		$keyword_form_html .= '</label>';
		return apply_filters( 'vk_filter_search_keyword_form_html', $keyword_form_html );
	}

	/**
	 * Display Search Form HTML
	 */
	public static function display_keyword_form_html() {

		$display_html = self::get_keyword_form_html();
		$allowed_html = array(
			'label' => array(
				'class' => array(),
				'id'    => array(),
				'for'   => array(),
			),
			'div'   => array(
				'class' => array(),
			),
			'input' => array(
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
	 * Get Post Type Filter Form HTML
	 *
	 * @param array $post_types filtering post types.
	 */
	public static function get_post_type_form_html( $post_types = array() ) {
		$post_type_form_html = '';
		if ( ! empty( $post_types ) ) {
			$post_type_form_html .= '<label>';
			$post_type_form_html .= '<div class="vkfs__label-name">' . $post_type_label . '</div>';
			$post_type_form_html .= '<select name="post_type" id="post_type">';
			foreach ( $post_types as $post_type ) {
				$post_type_form_html .= '<option value="' . $post_type . '">' . get_post_type_object( $post_type )->labels->singular_name . '</option>';
			}
			$post_type_form_html .= '</select>';
			$post_type_form_html .= '</label>';
		}
		return apply_filters( 'vk_filter_search_post_type_form_html', $post_type_form_html );
	}

	/**
	 * Display Post Type Filter Form HTML
	 *
	 * @param array $post_types filtering post types.
	 */
	public static function display_post_type_form_html( $post_types = array() ) {

		$display_html = self::get_post_type_form_html( $post_types );
		$allowed_html = array(
			'label'  => array(
				'class' => array(),
				'id'    => array(),
				'for'   => array(),
			),
			'div'    => array(
				'class' => array(),
			),
			'select' => array(
				'class' => array(),
				'id'    => array(),
				'name'  => array(),
			),
			'option' => array(
				'value' => array(),
			),
		);

		echo wp_kses( $display_html, $allowed_html );
	}

	/**
	 * Get Taxonomy Filter Form HTML
	 *
	 * @param string $taxonomy name of taxonomy.
	 */
	public static function get_taxonomy_form_html( $taxonomy = '' ) {
		$taxonomy_form_html = '';

		if ( ! empty( $taxonomy ) ) {
			$taxonomy_object = get_taxonomy( $taxonomy );
			$taxonomy_terms  = get_terms( $taxonomy );
			$taxonomy_label  = ! empty( $label ) ? $label : $taxonomy_object->labels->singular_name;
			$taxonomy_design = ! empty( $design ) ? $design : 'pull-down';

			if ( ! empty( $taxonomy_object ) && ! empty( $taxonomy_terms ) ) {
				$taxonomy_form_html .= '<label>';
				$taxonomy_form_html .= '<div class="vkfs__label-name">' . $taxonomy_label . '</div>';
				if ( 'category' === $taxonomy ) {
					$taxonomy_form_html .= wp_dropdown_categories(
						array(
							// Translators: All of Category.
							'show_option_all'  => sprintf( __( 'All of %s', 'vk-filter-search' ), $taxonomy_label ),
							// Translators: None of Category.
							'show_option_none' => sprintf( __( 'None of %s', 'vk-filter-search' ), $taxonomy_label ),
							'orderby'          => 'name',
							'echo'             => false,
							'selected'         => get_query_var( 'tag' ),
							'name'             => 'category_name',
							'taxonomy'         => 'category',
							'value_field'      => 'slug',
						)
					);
				} elseif ( 'post_tag' === $taxonomy ) {
					$taxonomy_form_html .= wp_dropdown_categories(
						array(
							// Translators: All of Tag.
							'show_option_all'  => sprintf( __( 'All of %s', 'vk-filter-search' ), $taxonomy_label ),
							// Translators: None of Tag.
							'show_option_none' => sprintf( __( 'None of %s', 'vk-filter-search' ), $taxonomy_label ),
							'orderby'          => 'name',
							'echo'             => false,
							'selected'         => get_query_var( 'tag' ),
							'name'             => 'tag',
							'taxonomy'         => 'post_tag',
							'value_field'      => 'slug',
						)
					);
				} else {
					$taxonomy_form_html .= '<label>';
					$taxonomy_form_html .= '<div class="vkfs__label-name">' . $taxonomy_label . '</div>';
					$taxonomy_form_html .= wp_dropdown_categories(
						array(
							// Translators: All of the taxonomy.
							'show_option_all'  => sprintf( __( 'All of %s', 'vk-filter-search' ), $taxonomy_label ),
							// Translators: None of the taxonomy.
							'show_option_none' => sprintf( __( 'None of %s', 'vk-filter-search' ), $taxonomy_label ),
							'orderby'          => 'name',
							'selected'         => get_query_var( $taxonomy_object->name ),
							'echo'             => false,
							'name'             => $taxonomy_object->name,
							'taxonomy'         => $taxonomy_object->name,
							'value_field'      => 'slug',
						)
					);
				}
			}
			$taxonomy_form_html .= '</label>';
		}
		return apply_filters( 'vk_filter_search_taxonomy_form_html', $taxonomy_form_html );
	}

	/**
	 * Display Taxonomy Filter Form HTML
	 *
	 * @param string $taxonomy filtering taxonomy.
	 */
	public static function display_taxonomy_form_html( $taxonomy = '' ) {

		$display_html = self::get_taxonomy_form_html( $taxonomy );
		$allowed_html = array(
			'label'  => array(
				'class' => array(),
				'id'    => array(),
				'for'   => array(),
			),
			'div'    => array(
				'class' => array(),
			),
			'select' => array(
				'class' => array(),
				'id'    => array(),
				'name'  => array(),
			),
			'option' => array(
				'value' => array(),
			),
		);

		echo wp_kses( $display_html, $allowed_html );
	}


}
new VK_Filter_Search();
