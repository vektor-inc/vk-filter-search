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
	 * Form Stryle Option.
	 */
	public static function form_style_option() {
		$form_style_option = array(
			'select',
		);
		return apply_filters( 'vk_filter_search_form_style', $form_style_option );
	}

	/**
	 * Get Keyword Filter Form HTML
	 *
	 * @param string $label       label of form.
	 * @param string $placeholder placeholder of text.
	 */
	public static function get_keyword_form_html( $label = '', $placeholder = '' ) {
		$label       = ! empty( $label ) ? $label : __( 'Keyword', 'vk-filter-search' );
		$placeholder = ! empty( $placeholder ) ? $placeholder : __( 'Input Keyword', 'vk-filter-search' );

		$keyword_form_html  = '<label>';
		$keyword_form_html .= '<div class="vkfs__label-name">' . $label . '</div>';
		$keyword_form_html .= '<input type="text" name="s" id="s" placeholder="' . $placeholder . '" />';
		$keyword_form_html .= '</label>';
		return apply_filters( 'vk_filter_search_keyword_form_html', $keyword_form_html );
	}

	/**
	 * Display Search Form HTML
	 *
	 * @param string $label       label of form.
	 * @param string $placeholder placeholder of text.
	 */
	public static function display_keyword_form_html( $label = '', $placeholder = '' ) {

		$display_html = self::get_keyword_form_html( $label, $placeholder );
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

	/**
	 * Get Post Type Filter Form HTML
	 *
	 * @param array  $post_types  filtering post types.
	 * @param string $label       label of form.
	 * @param string $form_design design of form.
	 */
	public static function get_post_type_form_html( $post_types = array(), $label = '', $form_design = '' ) {

		// 投稿タイプの調整.
		$post_types = ! empty( $post_types ) ? $post_types : array();

		// ラベルの調整.
		$label = ! empty( $label ) ? $label : __( 'Post Type', 'vk-filter-search' );

		// デザインの調整.
		$form_style_option = self::form_style_option();
		$form_design       = ! empty( $form_design ) && in_array( $form_design, $form_style_option, true ) ? $form_design : 'select';

		// 変数の初期化.
		$post_type_form_html   = '';
		$post_type_design_html = '';

		// 描画開始.
		if ( ! empty( $post_types ) ) {
			$post_type_form_html .= '<label>';
			$post_type_form_html .= '<div class="vkfs__label-name">' . __( 'Post Type', 'vk-filter-search' ) . '</div>';
			// デザインに応じて切り替え開始.
			if ( 'select' === $form_design ) {
				$post_type_design_html .= '<select name="post_type" id="post_type">';
				foreach ( $post_types as $post_type ) {
					if ( ! empty( get_post_type_object( $post_type ) ) ) {
						$post_type_design_html .= '<option value="' . $post_type . '">' . get_post_type_object( $post_type )->labels->singular_name . '</option>';
					}
				}
				$post_type_design_html .= '</select>';
			}
			$post_type_form_html .= apply_filters( 'vk_search_filter_post_type_design_html', $post_type_design_html );
			$post_type_form_html .= '</label>';
		}

		$form_html .= '</div>';
		$form_html .= '<input class="btn btn-primary" type="submit" value="' . __( 'Refine search', 'vk-filter-search' ) . '" />';
		$form_html .= '</form>';
		return $form_html;
	}

	/**
	 * Display Search Form HTML
	 *
	 * @param array  $post_types  filtering post types.
	 * @param string $label       label of form.
	 * @param string $form_design design of form.
	 */
	public static function display_post_type_form_html( $post_types = array(), $label = '', $form_design = '' ) {

		$display_html = self::get_post_type_form_html( $post_types, $label, $form_design );
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
	 * Get Taxonomy Filter Form HTML
	 *
	 * @param string $taxonomy name of taxonomy.
	 * @param string $label       label of form.
	 * @param string $form_design design of form.
	 */
	public static function get_taxonomy_form_html( $taxonomy = '', $label = '', $form_design = '' ) {

		// タクソノミーの調整.
		$taxonomy        = ! empty( $taxonomy ) ? $taxonomy : '';
		$taxonomy_object = get_taxonomy( $taxonomy );
		$taxonomy_terms  = get_terms( $taxonomy );

		// ラベルの調整.
		$label = ! empty( $label ) ? $label : $taxonomy_object->labels->singular_name;

		// デザインの調整.
		$form_style_option = self::form_style_option();
		$form_design       = ! empty( $form_design ) && in_array( $form_design, $form_style_option, true ) ? $form_design : 'select';

		// 変数を初期化.
		$taxonomy_form_html   = '';
		$taxonomy_design_html = '';

		// 描画開始.
		if ( ! empty( $taxonomy_object ) && ! empty( $taxonomy_terms ) ) {
			$taxonomy_form_html .= '<label>';
			$taxonomy_form_html .= '<div class="vkfs__label-name">' . $label . '</div>';
			// デザインに応じて HTML を描画.
			if ( 'select' === $form_design ) {
				// 分類毎に出力を表示.
				if ( 'category' === $taxonomy ) {
					$taxonomy_design_html .= wp_dropdown_categories(
						array(
							// Translators: All of Category.
							'show_option_all'  => sprintf( __( 'All of %s', 'vk-filter-search' ), $label ),
							// Translators: None of Category.
							'show_option_none' => sprintf( __( 'None of %s', 'vk-filter-search' ), $label ),
							'orderby'          => 'name',
							'echo'             => false,
							'selected'         => get_query_var( 'tag' ),
							'name'             => 'category_name',
							'taxonomy'         => 'category',
							'value_field'      => 'slug',
						)
					);
				} elseif ( 'post_tag' === $taxonomy ) {
					$taxonomy_design_html .= wp_dropdown_categories(
						array(
							// Translators: All of Tag.
							'show_option_all'  => sprintf( __( 'All of %s', 'vk-filter-search' ), $label ),
							// Translators: None of Tag.
							'show_option_none' => sprintf( __( 'None of %s', 'vk-filter-search' ), $label ),
							'orderby'          => 'name',
							'echo'             => false,
							'selected'         => get_query_var( 'tag' ),
							'name'             => 'tag',
							'taxonomy'         => 'post_tag',
							'value_field'      => 'slug',
						)
					);
				} else {
					$taxonomy_design_html .= wp_dropdown_categories(
						array(
							// Translators: All of the taxonomy.
							'show_option_all'  => sprintf( __( 'All of %s', 'vk-filter-search' ), $label ),
							// Translators: None of the taxonomy.
							'show_option_none' => sprintf( __( 'None of %s', 'vk-filter-search' ), $label ),
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
			$taxonomy_form_html .= apply_filters( 'vk_search_filter_taxonomy_design_html', $taxonomy_design_html );
			$taxonomy_form_html .= '</label>';
		}
		return apply_filters( 'vk_filter_search_taxonomy_form_html', $taxonomy_form_html );
	}

	/**
	 * Display Taxonomy Filter Form HTML
	 *
	 * @param string $taxonomy name of taxonomy.
	 * @param string $label       label of form.
	 * @param string $form_design design of form.
	 */
	public static function display_taxonomy_form_html( $taxonomy = '', $label = '', $form_design = '' ) {

		$display_html = self::get_taxonomy_form_html( $taxonomy, $label, $form_design );
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
			$atts
		);

		echo wp_kses( $display_html, $allowed_html );
	}
}
new VK_Filter_Search();
