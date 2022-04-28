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

		$theme_hook_array     = self::theme_hook_array();
		$current_parent_theme = get_template();

		add_action( 'pre_get_posts', array( __CLASS__, 'pre_get_posts' ) );
		add_action( 'dynamic_sidebar_before', array( __CLASS__, 'dynamic_sidebar_before' ) );
		add_action( 'dynamic_sidebar_after', array( __CLASS__, 'dynamic_sidebar_after' ) );

		if ( array_key_exists( $current_parent_theme, $theme_hook_array ) ) {
			add_action( $theme_hook_array[ $current_parent_theme ], array( __CLASS__, 'display_search_result_form_content' ) );
		} elseif ( ! wp_is_block_theme() ) {
			add_action( 'loop_start', array( __CLASS__, 'display_search_result_form_content' ) );
		}

		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );

		// Fallback for theme editor
		add_action( 'admin_init', array( __CLASS__, 'enqueue_style_on_theme_editor' ) );
	}

	/**
	 * Fallback for theme editor
	 *
	 * @return void
	 */
	public static function enqueue_style_on_theme_editor() {
		wp_enqueue_style(
			'vk-filter-search-theme-editor-style',
			VKFS_FREE_MODULE_ROOT_URL . 'build/style.css',
			array(),
			VKFS_FREE_MODULE_VERSION
		);
		wp_enqueue_style(
			'vk-filter-search-theme-editor-editor-style',
			VKFS_FREE_MODULE_ROOT_URL . 'build/editor.css',
			array(),
			VKFS_FREE_MODULE_VERSION
		);
	}

	/**
	 * Theme Hook Array.
	 */
	public static function theme_hook_array() {
		return apply_filters( 'vkfs_theme_hook_array', array() );
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
	public static function get_keyword_form_html( $label, $placeholder, $outer_columns, $class_name ) {
		$label       = ! empty( $label ) ? $label : __( 'Keyword', 'vk-filter-search' );
		$placeholder = ! empty( $placeholder ) ? $placeholder : __( 'Input Keyword', 'vk-filter-search' );

		$column_classes = '';
		if ( ! empty( $outer_columns ) ) {
			foreach ( $outer_columns as $key => $value ) {
				$column_classes .= ' vkfs__outer-wrap--col-' . $key . '-' . $value;
			}
		}

		$class_name = ! empty( $class_name ) ? ' ' . $class_name : '';

		$keyword_form_html  = '<div class="vkfs__outer-wrap vkfs__keyword' . $column_classes . $class_name . '">';
		$keyword_form_html .= '<div class="vkfs__label-name">' . $label . '</div>';
		$keyword_form_html .= '<div class="vkfs__input-wrap vkfs__input-wrap--text vkfs__input-wrap--keyword">';
		$keyword_form_html .= '<input type="text" name="s" id="s" placeholder="' . $placeholder . '" />';
		$keyword_form_html .= '</div>';
		$keyword_form_html .= '</div>';
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
	public static function get_post_type_form_html( $post_types, $label, $post_label, $page_label, $form_design, $outer_columns, $inner_columns, $class_name ) {

		// 投稿タイプの調整.
		$post_types = ! empty( $post_types ) ? $post_types : array( 'post', 'page' );

		// ラベルの調整.
		$label      = ! empty( $label ) ? $label : __( 'Post Type', 'vk-filter-search' );
		$post_label = ! empty( $post_label ) ? $post_label : get_post_type_object( 'post' )->labels->singular_name;
		$page_label = ! empty( $page_label ) ? $page_label : get_post_type_object( 'page' )->labels->singular_name;

		// デザインの調整.
		$form_style_option = self::form_style_option();
		$form_design       = ! empty( $form_design ) && in_array( $form_design, $form_style_option, true ) ? $form_design : 'select';

		// カラムの調整
		$column_classes = '';
		if ( ! empty( $outer_columns ) ) {
			foreach ( $outer_columns as $key => $value ) {
				$column_classes .= ' vkfs__outer-wrap--col-' . $key . '-' . $value;
			}
		}

		// 追加クラスの調整.
		$class_name = ! empty( $class_name ) ? ' ' . $class_name : '';

		// 変数の初期化.
		$post_type_form_html = '';

		// 描画開始.
		if ( ! empty( $post_types ) ) {
			$post_type_form_html .= '<div class="vkfs__outer-wrap vkfs__post_type' . $column_classes . $class_name . '">';
			$post_type_form_html .= '<div class="vkfs__label-name">' . $label . '</div>';
			$post_type_form_html .= self::get_post_type_design_html( $post_types, $label, $post_label, $page_label, $form_design, $inner_columns );
			$post_type_form_html .= '</div>';
		}
		return $post_type_form_html;
	}

	/**
	 * Get Post Type Filter Design HTML
	 *
	 * @param array  $post_types  filtering post types.
	 * @param string $label       label for form.
	 * @param string $post_label  label for post.
	 * @param string $page_label  label for page.
	 * @param string $form_design design of form.
	 */
	public static function get_post_type_design_html( $post_types, $label, $post_label, $page_label, $form_design, $inner_columns ) {
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
		$post_type_design_html  = '';
		$post_type_option_array = array();

		$post_type_name = 'vkfs_post_type[]';

		// 共通オプション.
		$default_option_array = array(
			array(
				'label' => __( 'Any', 'vk-filter-search' ),
				'value' => '',
			),
		);

		foreach ( $post_types as $post_type ) {
			if ( ! empty( get_post_type_object( $post_type ) ) ) {
				if ( 'post' === $post_type ) {
					$post_type_option_array[] = array(
						'label' => $post_label,
						'value' => $post_type,
					);
				} elseif ( 'page' === $post_type ) {
					$post_type_option_array[] = array(
						'label' => $page_label,
						'value' => $post_type,
					);
				} else {
					$post_type_option_array[] = array(
						'label' => get_post_type_object( $post_type )->labels->singular_name,
						'value' => $post_type,
					);
				}
			}
		}

		// デザインに応じて切り替え開始.
		if ( 'select' === $form_design ) {

			// 配列を統合.
			$post_type_option_array = array_merge( $default_option_array, $post_type_option_array );

			// 描画開始.
			$post_type_design_html .= '<select class="vkfs__input-wrap vkfs__input-wrap--select vkfs__input-wrap--post_type" name="' . $post_type_name . '" id="post_type">';

			// 項目のループ.
			foreach ( $post_type_option_array as $post_type_option ) {
				$get_posts = get_posts(
					array(
						'post_type' => $post_type_option['value'],
					)
				);
				if ( ! empty( $get_posts ) ) {
					$post_type_design_html .= '<option value="' . $post_type_option['value'] . '">' . $post_type_option['label'] . '</option>';
				}
			}

			$post_type_design_html .= '</select>';

		}
		return apply_filters( 'vk_search_filter_post_type_design_html', $post_type_design_html, $post_types, $label, $post_label, $page_label, $form_design, $inner_columns );
	}

	/**
	 * Get Taxonomy Filter Form HTML
	 *
	 * @param string $taxonomy    name of taxonomy.
	 * @param string $label       label of form.
	 * @param string $form_design design of form.
	 * @param string $operator    filtering operator.
	 */
	public static function get_taxonomy_form_html( $taxonomy, $label, $form_design, $operator, $outer_columns, $inner_columns, $class_name ) {

		// タクソノミーの調整.
		$taxonomy        = ! empty( $taxonomy ) ? $taxonomy : 'category';
		$taxonomy_object = get_taxonomy( $taxonomy );
		$taxonomy_terms  = get_terms( $taxonomy );

		// ラベルの調整.
		$label = ! empty( $label ) ? $label : $taxonomy_object->labels->singular_name;

		// デザインの調整.
		$form_style_option = self::form_style_option();
		$form_design       = ! empty( $form_design ) && in_array( $form_design, $form_style_option, true ) ? $form_design : 'select';

		// 演算子の調整.
		$operator = ! empty( $operator ) ? $operator : 'or';

		// カラムの調整
		$column_classes = '';
		if ( ! empty( $outer_columns ) ) {
			foreach ( $outer_columns as $key => $value ) {
				$column_classes .= ' vkfs__outer-wrap--col-' . $key . '-' . $value;
			}
		}

		// 追加クラスの調整.
		$class_name = ! empty( $class_name ) ? ' ' . $class_name : '';

		// 変数を初期化.
		$taxonomy_form_html   = '';
		$taxonomy_design_html = '';

		// 描画開始.
		if ( ! empty( $taxonomy_object ) && ! empty( $taxonomy_terms ) ) {
			$taxonomy_form_html .= '<div class="vkfs__outer-wrap vkfs__taxonomy' . $column_classes . $class_name . '">';
			$taxonomy_form_html .= '<div class="vkfs__label-name">' . $label . '</div>';
			$taxonomy_form_html .= self::get_taxonomy_design_html( $taxonomy, $label, $form_design, $inner_columns );
			$taxonomy_form_html .= '<input type="hidden" name="vkfs_' . $taxonomy . '_operator" value="' . $operator . '" />';
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
	public static function get_taxonomy_design_html( $taxonomy, $label, $form_design, $inner_columns ) {

		// タクソノミーの調整.
		$taxonomy        = ! empty( $taxonomy ) ? $taxonomy : 'category';
		$taxonomy_object = get_taxonomy( $taxonomy );
		$taxonomy_terms  = get_terms( $taxonomy );

		// デザインの調整.
		$form_style_option = self::form_style_option();
		$form_design       = ! empty( $form_design ) && in_array( $form_design, $form_style_option, true ) ? $form_design : 'select';

		// 変数を初期化.
		$taxonomy_design_html  = '';
		$taxonomy_option_array = array();

		// 共通の設定項目.
		$common_args = array(
			'show_option_none'  => __( 'Any', 'vk-filter-search' ),
			'option_none_value' => '',
			'echo'              => false,
			'taxonomy'          => $taxonomy,
			'value_field'       => 'slug',     
		);

		// 共通かつカスタマイズの余地がある設定項目.
		$custom_args = array(
			'orderby'      => 'NAME',
			'order'        => 'ASC',
			'hierarchical' => true,
			'show_count'   => 0,
			'hide_empty'   => 1,
		);
		$custom_args = apply_filters( 'vkfs_taxonomy_custom_setting', $custom_args );

		// デザインに応じて HTML を描画.
		if ( 'select' === $form_design ) {
			if ( 'category' === $taxonomy ) {
				$taxonomy_design_html = wp_dropdown_categories(
					array_merge(
						$common_args,
						$custom_args,
						array(
							'name'   => 'vkfs_category[]',
							'id'     => 'vkfs_category',
							'class'  => 'vkfs__input-wrap vkfs__input-wrap--select vkfs__input-wrap--category_name',
							'walker' =>  new VK_Walker_Category_Dropdown(),
						)
					)
				);
			} elseif ( 'post_tag' === $taxonomy ) {
				$taxonomy_design_html = wp_dropdown_categories(
					array_merge(
						$common_args,
						$custom_args,
						array(
							'name'   => 'vkfs_post_tag[]',
							'id'     => 'vkfs_post_tag',
							'class'  => 'vkfs__input-wrap vkfs__input-wrap--select vkfs__input-wrap--tag',
							'walker' =>  new VK_Walker_Category_Dropdown(),
						)
					)
				);
			} else {
				$taxonomy_design_html = wp_dropdown_categories(
					array_merge(
						$common_args,
						$custom_args,
						array(
							'name'   => 'vkfs_' . $taxonomy_object->name . '[]',
							'id'     => 'vkfs_' . $taxonomy_object->name,
							'class'  => 'vkfs__input-wrap vkfs__input-wrap--select vkfs__input-wrap--' . $taxonomy_object->name,
							'walker' =>  new VK_Walker_Category_Dropdown(),
						)
					)
				);
			}
		}
		return apply_filters( 'vk_search_filter_taxonomy_design_html', $taxonomy_design_html, $taxonomy, $label, $form_design, $inner_columns );

	}

	/**
	 * Pre Get Posts
	 *
	 * @param WP_Query $query WP_Query.
	 */
	public static function pre_get_posts( $query ) {
		if ( ! is_admin() && $query->is_main_query() && ! isset( $_GET['vkfs_submitted'] ) ) {

			// 投稿タイプ.
			if ( isset( $_GET['post_type'] ) ) {
				$post_types = sanitize_text_field( wp_unslash( $_GET['post_type'] ) );
				if ( ! empty( $post_types ) ) {
					if ( false !== strpos( $post_types, ',' ) ) {
						$query->set( 'post_type', explode( ',', $post_types ) );
					} else {
						$query->set( 'post_type', $post_types );
					}
				} else {
					$query->set( 'post_type', 'any' );
				}
			}

			// カテゴリー.
			if ( isset( $_GET['category_name'] ) ) {
				$terms = sanitize_text_field( wp_unslash( $_GET['category_name'] ) );
				if ( false !== strpos( $terms, ' ' ) ) {
					$term_array = explode( ' ', $terms );
					foreach ( $term_array as $term ) {
						$category_object  = get_term_by( 'slug', $term, 'category' );
						$category_array[] = $category_object->term_id;
					}
					$query->set( 'category__and', $category_array );
				} elseif ( false !== strpos( $terms, ',' ) ) {
					$term_array = explode( ',', $terms );
					foreach ( $term_array as $term ) {
						$category_object  = get_term_by( 'slug', $term, 'category' );
						$category_array[] = $category_object->term_id;
					}
					$query->set( 'category__in', $category_array );
				} else {
					$query->set( 'category_name', $terms );
				}
			}

			// タグ.
			if ( isset( $_GET['tag'] ) ) {
				$terms = sanitize_text_field( wp_unslash( $_GET['tag'] ) );

				if ( false !== strpos( $terms, ' ' ) ) {
					$term_array = explode( ' ', $terms );
					foreach ( $term_array as $term ) {
						$tag_object  = get_term_by( 'slug', $term, 'post_tag' );
						$tag_array[] = $tag_object->term_id;
					}
					$query->set( 'tag__and', $tag_array );
				} elseif ( false !== strpos( $terms, ',' ) ) {
					$term_array = explode( ',', $terms );
					foreach ( $term_array as $term ) {
						$tag_object  = get_term_by( 'slug', $term, 'post_tag' );
						$tag_array[] = $tag_object->term_id;
					}
					$query->set( 'tag__in', $tag_array );
				} else {
					$query->set( 'tag', $terms );
				}
			}
		}
	}

	/**
	 * Dynamic Sidebar Before
	 */
	public static function dynamic_sidebar_before() {
		global $vkfs_is_widget_area;
		$vkfs_is_widget_area = true;
	}

	/**
	 * Dynamic Sidebar After
	 */
	public static function dynamic_sidebar_after() {
		global $vkfs_is_widget_area;
		$vkfs_is_widget_area = false;
	}

	/**
	 * Dynamic Sidebar After
	 */
	public static function is_widget_area() {
		global $vkfs_is_widget_area;
		return $vkfs_is_widget_area ? true : false;
	}

	/**
	 * Get Option
	 */
	public static function get_options() {
		$options = get_option( 'vk_filter_search' );
		return $options;
	}

	/**
	 * Search Form on Loop
	 */
	public static function search_result_form_content() {
		$content = '';
		$options = self::get_options();

		if ( ! empty( $options['display_on_result'] ) ) {
			$block_id_array = array_keys( $options['display_on_result'] );
			$i              = 0;
			foreach ( $options['display_on_result'] as $the_post ) {
				if ( ! is_array( $options['display_on_result'][ $block_id_array[ $i ] ] ) ) {
					unset( $options['display_on_result'][ $block_id_array[ $i ] ] );
				} else {
					if ( ! empty( $the_post['form_post_id'] ) && is_numeric( $the_post['form_post_id'] ) ) {
						$post_object = get_post( $the_post['form_post_id'] );
						if ( empty( $post_object ) ) {
							unset( $options['display_on_result'][ $block_id_array[ $i ] ] );
						} else {
							$post_content = $post_object->post_content;
							if ( false === strpos( $post_content, $block_id_array[ $i ] ) ) {
								unset( $options['display_on_result'][ $block_id_array[ $i ] ] );
							}
						}
					}
				}
				$i++;
			}
		}

		if ( ! empty( $options['display_on_post_type_archive'] ) ) {
			$block_id_array = array_keys( $options['display_on_post_type_archive'] );
			$i              = 0;
			foreach ( $options['display_on_post_type_archive'] as $the_post ) {
				if ( ! is_array( $options['display_on_post_type_archive'][ $block_id_array[ $i ] ] ) ) {
					unset( $options['display_on_post_type_archive'][ $block_id_array[ $i ] ] );
				} else {
					if ( ! empty( $the_post['form_post_id'] ) && is_numeric( $the_post['form_post_id'] ) ) {
						$post_object = get_post( $the_post['form_post_id'] );
						if ( empty( $post_object ) ) {
							unset( $options['display_on_post_type_archive'][ $block_id_array[ $i ] ] );
						} else {
							$post_content = $post_object->post_content;
							if ( false === strpos( $post_content, $block_id_array[ $i ] ) ) {
								unset( $options['display_on_post_type_archive'][ $block_id_array[ $i ] ] );
							}
						}
					}
				}
				$i++;
			}
		}
		update_option( 'vk_filter_search', $options );

		if ( ! self::is_widget_area() && is_main_query() ) {
			if ( is_search() && isset( $_GET['vkfs_form_id'] ) && ! empty( $options['display_on_result'] ) ) {
				$form_id = sanitize_text_field( wp_unslash( $_GET['vkfs_form_id'] ) );
				if ( array_key_exists( $form_id, $options['display_on_result'] ) ) {
					$content = $options['display_on_result'][ $form_id ]['form_content'];
				}
			} elseif ( ( is_post_type_archive() || is_home() ) && ! empty( $options['display_on_post_type_archive'] ) ) {
				$forms = $options['display_on_post_type_archive'];
				foreach ( $forms as $form ) {
					foreach ( $form['display_post_type'] as $post_type ) {
						if ( in_array( get_post_type(), $form['display_post_type'], true ) ) {
							if ( 'post' === $post_type && is_home() || is_post_type_archive( $post_type ) ) {
								$content .= $form['form_content'];
								if ( current_user_can( 'edit_pages' ) ) {
									$content .= '<a class="btn btn-default btn-sm" href="' . get_edit_post_link( $form['form_post_id'] ) . '" target="_blank">';
									$content .= __( 'Edit', 'vk-filter-search' );
									$content .= '</a>';
								}
							}
						}
					}
				}
			}
		}
		return $content;
	}

	/**
	 * Search Form on Loop
	 */
	public static function display_search_result_form_content() {
		$content = self::search_result_form_content();
		$allowed = array(
			'form'   => array(
				'id'     => array(),
				'class'  => array(),
				'method' => array(),
				'action' => array(),
			),
			'div'    => array(
				'id'    => array(),
				'class' => array(),
			),
			'ul'     => array(
				'id'    => array(),
				'class' => array(),
			),
			'li'     => array(
				'id'    => array(),
				'class' => array(),
			),
			'label'  => array(
				'id'    => array(),
				'class' => array(),
				'for'   => array(),
			),
			'input'  => array(
				'id'          => array(),
				'class'       => array(),
				'type'        => array(),
				'name'        => array(),
				'value'       => array(),
				'placeholder' => array(),
				'checked'     => array(),
			),
			'select' => array(
				'id'    => array(),
				'class' => array(),
				'name'  => array(),
			),
			'option' => array(
				'id'       => array(),
				'class'    => array(),
				'value'    => array(),
				'selected' => array(),
			),
			'a'      => array(
				'id'    => array(),
				'class' => array(),
				'href'  => array(),
			),
			'button' => array(
				'id'    => array(),
				'type'  => array(),
				'class' => array(),
				'href'  => array(),
			),
		);
		echo wp_kses( $content, $allowed );
	}

	/**
	 * Enqueue Scripts
	 */
	public static function enqueue_scripts() {
		wp_enqueue_style(
			'vk-filter-search-style',
			VKFS_FREE_MODULE_ROOT_URL . 'build/style.css',
			array(),
			VKFS_FREE_MODULE_VERSION
		);
		if ( isset( $_GET['vkfs_submitted'] ) ) {
			wp_enqueue_script(
				'vk-filter-search-redirct',
				VKFS_FREE_MODULE_ROOT_URL . 'build/vk-filter-search-redirect.min.js',
				array(),
				VKFS_FREE_MODULE_VERSION,
				false
			);
			// ブロックに値を渡す
			wp_localize_script(
				'vk-filter-search-redirct',
				'vk_filter_search_params',
				array(
					'home_url' => home_url( '/' ),
				)
			);
		}

		if ( isset( $_GET['vkfs_form_id'] ) && ! isset( $_GET['vkfs_submitted'] ) ) {
			wp_enqueue_script(
				'vk-filter-search-result',
				VKFS_FREE_MODULE_ROOT_URL . 'build/vk-filter-search-result.min.js',
				array(),
				VKFS_FREE_MODULE_VERSION,
				true
			);
		}
		do_action( 'vkfs_enqueue_scripts' );
	}
}
new VK_Filter_Search();
