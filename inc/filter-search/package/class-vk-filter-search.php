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
		add_action( 'pre_get_posts', array( __CLASS__, 'pre_get_posts_on_page_result' ) );
	}

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
		$value       = ! empty( get_query_var( 's' ) ) ? 'value="' . get_query_var( 's' ) . '"' : '';

		$keyword_form_html  = '<label>';
		$keyword_form_html .= '<div class="vkfs__label-name">' . $label . '</div>';
		$keyword_form_html .= '<input type="text" name="s" id="s" placeholder="' . $placeholder . '"' . $value . '/>';
		$keyword_form_html .= '</label>';
		return $keyword_form_html;
	}

	/**
	 * Get Post Type Filter Form HTML
	 *
	 * @param array  $post_types  filtering post types.
	 * @param string $label       label of form.
	 * @param string $post_label  label for post.
	 * @param string $page_label  label for page.
	 * @param string $form_design design of form.
	 */
	public static function get_post_type_form_html( $post_types = array( 'post', 'page' ), $label = '', $post_label = '', $page_label = '', $form_design = 'select' ) {

		// 投稿タイプの調整.
		$post_types = ! empty( $post_types ) ? $post_types : array( 'post', 'page' );

		// ラベルの調整.
		$label      = ! empty( $label ) ? $label : __( 'Post Type', 'vk-filter-search' );
		$post_label = ! empty( $post_label ) ? $post_label : get_post_type_object( 'post' )->labels->singular_name;
		$page_label = ! empty( $page_label ) ? $page_label : get_post_type_object( 'page' )->labels->singular_name;

		// デザインの調整.
		$form_style_option = self::form_style_option();
		$form_design       = ! empty( $form_design ) && in_array( $form_design, $form_style_option, true ) ? $form_design : 'select';

		// 変数の初期化.
		$post_type_form_html = '';

		// 描画開始.
		if ( ! empty( $post_types ) ) {
			$post_type_form_html .= '<label>';
			$post_type_form_html .= '<div class="vkfs__label-name">' . $label . '</div>';
			$post_type_form_html .= self::get_post_type_design_html( $post_types, $post_label, $page_label, $form_design );
			$post_type_form_html .= '</label>';
		} elseif ( ! is_front_page() && ! is_home() && ! is_singular() && ! is_archive() && ! is_search() && ! is_404() && ! is_preview() ) {
			$post_type_form_html .= '<div class="vkfs__warning">';
			$post_type_form_html .= '<label>';
			$post_type_form_html .= '<div class="vkfs__label-name">' . $label . '</div>';
			$post_type_form_html .= '<div class="vkfs__warning-text">';
			$post_type_form_html .= __( 'Because no post type is selected, this block will not render.', 'vk-filter-search' );
			$post_type_form_html .= '</div>';
			$post_type_form_html .= '</label>';
			$post_type_form_html .= '</div>';
		}

		return $post_type_form_html;
	}

	/**
	 * Get Post Type Filter Design HTML
	 *
	 * @param array  $post_types  filtering post types.
	 * @param string $post_label  label for post.
	 * @param string $page_label  label for page.
	 * @param string $form_design design of form.
	 */
	public static function get_post_type_design_html( $post_types = array( 'post', 'page' ), $post_label = '', $page_label = '', $form_design = 'select' ) {
		// 投稿タイプの調整.
		$post_types = ! empty( $post_types ) ? $post_types : array( 'post', 'page' );

		// ラベルの調整.
		$post_label = ! empty( $post_label ) ? $post_label : get_post_type_object( 'post' )->labels->singular_name;
		$page_label = ! empty( $page_label ) ? $page_label : get_post_type_object( 'page' )->labels->singular_name;

		// デザインの調整.
		$form_style_option = self::form_style_option();
		$form_design       = ! empty( $form_design ) && in_array( $form_design, $form_style_option, true ) ? $form_design : 'select';

		// 変数の初期化.
		$post_type_design_html = '';

		// デザインに応じて切り替え開始.
		if ( 'select' === $form_design ) {

			// パーツを配列に格納.
			$option_parts = array(
				array(
					'value'    => 'any',
					'selected' => selected( 'any', get_query_var( 'post_type' ), false ),
					'label'    => __( 'Do not specify a post type', 'vk-filter-search' ),
				),
			);

			foreach ( $post_types as $post_type ) {
				if ( ! empty( get_post_type_object( $post_type ) ) ) {
					$selected = selected( $post_type, get_query_var( 'post_type' ), false );
					if ( 'post' === $post_type ) {
						$option_parts[] = array(
							'value'    => $post_type,
							'selected' => $selected,
							'label'    => $post_label,
						);
					} elseif ( 'page' === $post_type ) {
						$option_parts[] = array(
							'value'    => $post_type,
							'selected' => $selected,
							'label'    => $page_label,
						);
					} else {
						$option_parts[] = array(
							'value'    => $post_type,
							'selected' => $selected,
							'label'    => get_post_type_object( $post_type )->labels->singular_name,
						);
					}
				}
			}

			// 描画開始.
			$post_type_design_html .= '<select name="post_types[]" id="post_type">';

			foreach ( $option_parts as $option_part ) {
				$post_type_design_html .= '<option value="' . $option_part['value'] . '" ' . $option_part['selected'] . '>' . $option_part['label'] . '</option>';
			}
			$post_type_design_html .= '</select>';
		}
		return apply_filters( 'vk_search_filter_post_type_design_html', $post_type_design_html, $post_types, $post_label, $page_label, $form_design );
	}

	/**
	 * Get Taxonomy Filter Form HTML
	 *
	 * @param string $taxonomy    name of taxonomy.
	 * @param string $label       label of form.
	 * @param string $form_design design of form.
	 */
	public static function get_taxonomy_form_html( $taxonomy = 'category', $label = '', $form_design = 'select' ) {

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
			$taxonomy_form_html .= self::get_taxonomy_design_html( $taxonomy, $label, $form_design );
			$taxonomy_form_html .= '</label>';
		} elseif ( ! is_front_page() && ! is_home() && ! is_singular() && ! is_archive() && ! is_search() && ! is_404() && ! is_preview() ) {
			$taxonomy_form_html .= '<div class="vkfs__warning">';
			$taxonomy_form_html .= '<label>';
			$taxonomy_form_html .= '<div class="vkfs__label-name">' . $label . '</div>';
			$taxonomy_form_html .= '<div class="vkfs__warning-text">';

			$taxonomy_form_html .= sprintf(
				// translators: %s is taxonomy's name.
				__( 'Because %s has no term, this block will not render.', 'vk-filter-search' ),
				$taxonomy_object->labels->singular_name
			);

			$taxonomy_form_html .= '</div>';
			$taxonomy_form_html .= '</label>';
			$taxonomy_form_html .= '</div>';
		}
		return $taxonomy_form_html;
	}

	/**
	 * Get Taxonomy Filter Design HTML
	 *
	 * @param string $taxonomy    name of taxonomy.
	 * @param string $label       label of form.
	 * @param string $form_design design of form.
	 */
	public static function get_taxonomy_design_html( $taxonomy = 'category', $label = '', $form_design = 'select' ) {

		// タクソノミーの調整.
		$taxonomy        = ! empty( $taxonomy ) ? $taxonomy : '';
		$taxonomy_object = get_taxonomy( $taxonomy );
		$taxonomy_terms  = get_terms( $taxonomy );

		// デザインの調整.
		$form_style_option = self::form_style_option();
		$form_design       = ! empty( $form_design ) && in_array( $form_design, $form_style_option, true ) ? $form_design : 'select';

		// 変数を初期化.
		$taxonomy_design_html = '';

		// デザインに応じて HTML を描画.
		if ( 'select' === $form_design ) {
			// 分類毎に出力を表示.
			if ( 'category' === $taxonomy ) {
				$taxonomy_design_html .= wp_dropdown_categories(
					array(
						// Translators: All of Category.
						// 'show_option_all'  => sprintf( __( 'All of %s', 'vk-filter-search' ), $label ),
						// Translators: None of Category.
						'show_option_none'  => sprintf( __( 'Do not specify a %s', 'vk-filter-search' ), $label ),
						'option_none_value' => '',
						'orderby'           => 'name',
						'echo'              => false,
						'selected'          => get_query_var( 'category_name' ),
						'name'              => 'category_name',
						'taxonomy'          => 'category',
						'value_field'       => 'slug',
					)
				);
			} elseif ( 'post_tag' === $taxonomy ) {
				$taxonomy_design_html .= wp_dropdown_categories(
					array(
						// Translators: All of Tag.
						// 'show_option_all'  => sprintf( __( 'All of %s', 'vk-filter-search' ), $label ),
						// Translators: None of Tag.
						'show_option_none'  => sprintf( __( 'Do not specify a %s', 'vk-filter-search' ), $label ),
						'option_none_value' => '',
						'orderby'           => 'name',
						'echo'              => false,
						'selected'          => get_query_var( 'tag' ),
						'name'              => 'tag',
						'taxonomy'          => 'post_tag',
						'value_field'       => 'slug',
					)
				);
			} else {
				$taxonomy_design_html .= wp_dropdown_categories(
					array(
						// Translators: All of the taxonomy.
						// 'show_option_all'  => sprintf( __( 'All of %s', 'vk-filter-search' ), $label ),
						// Translators: None of the taxonomy.
						'show_option_none'  => sprintf( __( 'Do not specify a %s', 'vk-filter-search' ), $label ),
						'option_none_value' => '',
						'orderby'           => 'name',
						'selected'          => get_query_var( $taxonomy_object->name ),
						'echo'              => false,
						'name'              => $taxonomy_object->name,
						'taxonomy'          => $taxonomy_object->name,
						'value_field'       => 'slug',
					)
				);
			}
		}
		return apply_filters( 'vk_search_filter_taxonomy_design_html', $taxonomy_design_html, $taxonomy, $label, $form_design );

	}

	/**
	 * Pre Get Post of Search Result on Only Page.
	 *
	 * @param opject $query WP Query.
	 */
	public static function pre_get_posts_on_page_result( $query ) {
		if ( ! is_admin() && $query->is_main_query() ) {
			if ( isset( $_GET['post_types'] ) ) {
				$query->set( 'post_type', wp_unslash( $_GET['post_types'] ) );
			}
		}
	}
}
new VK_Filter_Search();
