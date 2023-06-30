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
		add_action( 'init', array( __CLASS__, 'register_post_type' ), 0 );
		add_action( 'pre_get_posts', array( __CLASS__, 'pre_get_posts' ) );
		add_action( 'dynamic_sidebar_before', array( __CLASS__, 'dynamic_sidebar_before' ) );
		add_action( 'dynamic_sidebar_after', array( __CLASS__, 'dynamic_sidebar_after' ) );
		add_action( 'after_setup_theme', array( __CLASS__, 'content_filter' ) );
		add_action( 'after_setup_theme', array( __CLASS__, 'insert_theme_hook' ) );
		add_action( 'wp_head', array( __CLASS__, 'header_scripts' ), 0 );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
		// Fallback for theme editor
		add_action( 'admin_init', array( __CLASS__, 'enqueue_style_on_theme_editor' ) );
	}

	/**
	 * 投稿タイプを追加
	 */
	public static function register_post_type() {
		// Filter Search 用の投稿タイプを追加.
		register_post_type(
			'filter-search',
			array(
				'label'         => __( 'VK Filter Search', 'vk-filter-search-addon' ),
				'public'        => false,
				'has_archive'   => false,
				'show_ui'       => true,
				'show_in_menu'  => true,
				'menu_position' => 20,
				'show_in_rest'  => true,
				'supports'      => array( 'title', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'editor' ),
			)
		);
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
	 * コンテンツにかけるフィルター
	 */
	public static function content_filter() {
		add_filter( 'filter_search_content', 'do_blocks', 9 );
		add_filter( 'filter_search_content', 'wptexturize' );
		add_filter( 'filter_search_content', 'convert_smilies', 20 );
		add_filter( 'filter_search_content', 'shortcode_unautop' );
		add_filter( 'filter_search_content', 'prepend_attachment' );
		add_filter( 'filter_search_content', 'wp_filter_content_tags' );
		add_filter( 'filter_search_content', 'do_shortcode', 11 );
		add_filter( 'filter_search_content', 'capital_P_dangit', 11 );
		add_filter( 'filter_search_content', 'wp_replace_insecure_home_url' );
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
	 * Hook Setting
	 */
	public static function insert_theme_hook() {
		$theme_hook_array     = self::theme_hook_array();
		$current_parent_theme = get_template();
		$is_block_theme       = function_exists( 'wp_is_block_theme' ) && wp_is_block_theme() ? true : false;
		if ( array_key_exists( $current_parent_theme, $theme_hook_array ) ) {
			add_action( $theme_hook_array[ $current_parent_theme ], array( __CLASS__, 'display_search_result_form_content' ) );
		} elseif ( false === $is_block_theme ) {
			add_action( 'loop_start', array( __CLASS__, 'display_search_result_form_content' ) );
		}
	}

	/**
	 * HTML Allowed
	 */
	public static function kses_allowed() {
		return array(
			'form'   => array(
				'id'     => array(),
				'class'  => array(),
				'style'  => array(),
				'method' => array(),
				'action' => array(),
			),
			'div'    => array(
				'id'    => array(),
				'class' => array(),
				'style' => array(),
			),
			'h1'     => array(
				'id'    => array(),
				'class' => array(),
				'style' => array(),
			),
			'h2'     => array(
				'id'    => array(),
				'class' => array(),
				'style' => array(),
			),
			'h3'     => array(
				'id'    => array(),
				'class' => array(),
				'style' => array(),
			),
			'h4'     => array(
				'id'    => array(),
				'class' => array(),
				'style' => array(),
			),
			'h5'     => array(
				'id'    => array(),
				'class' => array(),
				'style' => array(),
			),
			'h6'     => array(
				'id'    => array(),
				'class' => array(),
				'style' => array(),
			),
			'p'      => array(
				'id'    => array(),
				'class' => array(),
				'style' => array(),
			),
			'ul'     => array(
				'id'    => array(),
				'class' => array(),
				'style' => array(),
			),
			'ol'     => array(
				'id'    => array(),
				'class' => array(),
				'style' => array(),
			),
			'li'     => array(
				'id'    => array(),
				'class' => array(),
				'style' => array(),
			),
			'label'  => array(
				'id'    => array(),
				'class' => array(),
				'style' => array(),
				'for'   => array(),
			),
			'input'  => array(
				'id'          => array(),
				'class'       => array(),
				'style'       => array(),
				'type'        => array(),
				'name'        => array(),
				'value'       => array(),
				'placeholder' => array(),
				'checked'     => array(),
			),
			'select' => array(
				'id'    => array(),
				'class' => array(),
				'style' => array(),
				'name'  => array(),
			),
			'i'      => array(
				'id'    => array(),
				'class' => array(),
				'style' => array(),
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
				'style' => array(),
				'href'  => array(),
			),
			'span'   => array(
				'id'    => array(),
				'class' => array(),
				'style' => array(),
			),
			'button' => array(
				'id'    => array(),
				'type'  => array(),
				'class' => array(),
				'style' => array(),
				'href'  => array(),
			),
			'style'  => array(),
		);
	}

	/**
	 * Get Keyword Filter Form HTML
	 *
	 * @param array $options options.
	 */
	public static function get_keyword_form_html( $options = array() ) {
		// オプションの値を調整
		$default = array(
			'class_name'    => '',
			'label'         => __( 'Keyword', 'vk-filter-search' ),
			'placeholder'   => __( 'Input Keyword', 'vk-filter-search' ),
			'outer_columns' => array(),
		);
		$options = wp_parse_args( $options, $default );

		$keuword_name = 's';

		$outer_classes = '';
		if ( ! empty( $options['outer_columns'] ) ) {
			foreach ( $options['outer_columns'] as $key => $value ) {
				$outer_classes .= ' vkfs__outer-wrap--col-' . $key . '-' . $value;
			}
		}

		$outer_classes .= ! empty( $options['class_name'] ) ? ' ' . $options['class_name'] : '';

		$keyword_form_html  = '<div class="vkfs__outer-wrap vkfs__keyword' . $outer_classes . '">';
		$keyword_form_html .= '<div class="vkfs__label-name">' . $options['label'] . '</div>';
		$keyword_form_html .= '<div class="vkfs__input-wrap vkfs__input-wrap--text vkfs__input-wrap--keyword">';
		$keyword_form_html .= '<input type="text" name="' . $keuword_name . '" id="s" placeholder="' . $options['placeholder'] . '" />';
		$keyword_form_html .= '</div>';
		$keyword_form_html .= '</div>';
		return wp_kses( $keyword_form_html, self::kses_allowed() );
	}

	/**
	 * Get Post Type Filter Form HTML
	 *
	 * @param array $post_types filtering post types.
	 * @param array $options    options.
	 */
	public static function get_post_type_form_html( $post_types, $options = array() ) {

		// 投稿タイプの調整.
		$post_types = ! empty( $post_types ) ? $post_types : array( 'post', 'page' );

		// オプションの値を調整
		$default = array(
			'class_name'    => '',
			'label'         => __( 'Post Type', 'vk-filter-search' ),
			'post_label'    => get_post_type_object( 'post' )->labels->singular_name,
			'page_label'    => get_post_type_object( 'page' )->labels->singular_name,
			'form_design'   => 'select',
			'outer_columns' => array(),
			'inner_columns' => array(),
		);
		$options = wp_parse_args( $options, $default );

		// デザインの調整.
		$form_style_option = self::form_style_option();
		$form_design       = ! empty( $options['form_design'] ) && in_array( $options['form_design'], $form_style_option, true ) ? $options['form_design'] : 'select';

		// カラムの調整
		$outer_classes = '';
		if ( ! empty( $options['outer_columns'] ) ) {
			foreach ( $options['outer_columns'] as $key => $value ) {
				$outer_classes .= ' vkfs__outer-wrap--col-' . $key . '-' . $value;
			}
		}

		// 追加クラスの調整.
		$outer_classes .= ! empty( $options['class_name'] ) ? ' ' . $options['class_name'] : '';

		// 変数の初期化.
		$post_type_form_html = '';

		// 描画開始.
		if ( ! empty( $post_types ) ) {
			$post_type_form_html .= '<div class="vkfs__outer-wrap vkfs__post_type' . $outer_classes . '">';
			$post_type_form_html .= '<div class="vkfs__label-name">' . $options['label'] . '</div>';
			$post_type_form_html .= self::get_post_type_design_html( $post_types, $options );
			$post_type_form_html .= '</div>';
		}
		return wp_kses( $post_type_form_html, self::kses_allowed() );
	}

	/**
	 * Get Post Type Filter Design HTML
	 *
	 * @param array $post_types filtering post types.
	 * @param array $options    options.
	 */
	public static function get_post_type_design_html( $post_types, $options = array() ) {
		// 投稿タイプの調整.
		$post_types = ! empty( $post_types ) ? $post_types : array( 'post', 'page' );

		// オプションの値を調整
		$default = array(
			'class_name'    => '',
			'label'         => __( 'Post Type', 'vk-filter-search' ),
			'post_label'    => get_post_type_object( 'post' )->labels->singular_name,
			'page_label'    => get_post_type_object( 'page' )->labels->singular_name,
			'form_design'   => 'select',
			'outer_columns' => array(),
			'inner_columns' => array(),
		);
		$options = wp_parse_args( $options, $default );

		// デザインの調整.
		$form_style_option = self::form_style_option();
		$form_design       = ! empty( $options['form_design'] ) && in_array( $options['form_design'], $form_style_option, true ) ? $options['form_design'] : 'select';

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
						'label' => $options['post_label'],
						'value' => $post_type,
					);
				} elseif ( 'page' === $post_type ) {
					$post_type_option_array[] = array(
						'label' => $options['page_label'],
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
		return apply_filters( 'vk_search_filter_post_type_design_html', $post_type_design_html, $post_types, $options );
	}

	/**
	 * Get Taxonomy Filter Form HTML
	 *
	 * @param string $taxonomy name of taxonomy.
	 * @param array  $options  options.
	 */
	public static function get_taxonomy_form_html( $taxonomy, $options = array() ) {

		// タクソノミーの調整.
		$taxonomy        = ! empty( $taxonomy ) ? $taxonomy : 'category';
		$taxonomy_object = get_taxonomy( $taxonomy );
		$taxonomy_terms  = get_terms( $taxonomy );

		// オプションの値を調整
		$default = array(
			'class_name'         => '',
			'label'              => $taxonomy_object->labels->singular_name,
			'form_design'        => 'select',
			'non_selected_label' => '',
			'operator'           => 'or',
			'show_count'         => false,
			'hide_empty'         => true,
			'outer_columns'      => array(),
			'inner_columns'      => array(),
		);
		$options = wp_parse_args( $options, $default );

		// デザインの調整.
		$form_style_option = self::form_style_option();
		$form_design       = ! empty( $options['form_design'] ) && in_array( $options['form_design'], $form_style_option, true ) ? $options['form_design'] : 'select';

		// カラムの調整
		$outer_classes = '';
		if ( ! empty( $options['outer_columns'] ) ) {
			foreach ( $options['outer_columns'] as $key => $value ) {
				$outer_classes .= ' vkfs__outer-wrap--col-' . $key . '-' . $value;
			}
		}

		// 追加クラスの調整.
		$outer_classes .= ! empty( $options['class_name'] ) ? ' ' . $options['class_name'] : '';

		// 変数を初期化.
		$taxonomy_form_html   = '';
		$taxonomy_design_html = '';

		// 描画開始.
		if ( ! empty( $taxonomy_object ) && ! empty( $taxonomy_terms ) ) {
			$taxonomy_form_html .= '<div class="vkfs__outer-wrap vkfs__taxonomy' . $outer_classes . '">';
			$taxonomy_form_html .= '<div class="vkfs__label-name">';
			if ( 'user' !== $options['operator'] ) {
				$taxonomy_form_html .= $options['label'];
			} elseif ( 'user' === $options['operator'] ) {
				$taxonomy_form_html .= '<div class="vkfs__label-name-wrap">';
				$taxonomy_form_html .= '<span class="vkfs__label-name-item">';
				$taxonomy_form_html .= $options['label'];
				$taxonomy_form_html .= '</span>';
				$taxonomy_form_html .= '<ul class="vkfs__label-name-item vkfs__operator-wrap vkfs__input-wrap vkfs__input-wrap--radio">';
				$taxonomy_form_html .= '<li class="vkfs_prefix__level-0"><label>';
				$taxonomy_form_html .= '<input type="radio" name="vkfs_' . $taxonomy . '_operator" value="and">';
				$taxonomy_form_html .= __( 'AND Search', 'vk-filter-search' );
				$taxonomy_form_html .= '</label></li>';
				$taxonomy_form_html .= '<li class="vkfs_prefix__level-0"><label>';
				$taxonomy_form_html .= '<input type="radio" name="vkfs_' . $taxonomy . '_operator" value="or">';
				$taxonomy_form_html .= __( 'OR Search', 'vk-filter-search' );
				$taxonomy_form_html .= '</label></li>';
				$taxonomy_form_html .= '</ul>';
				$taxonomy_form_html .= '</div>';
			}
			$taxonomy_form_html .= '</div>';
			$taxonomy_form_html .= self::get_taxonomy_design_html( $taxonomy, $options );
			if ( 'user' !== $options['operator'] ) {
				$taxonomy_form_html .= '<input type="hidden" name="vkfs_' . $taxonomy . '_operator" value="' . $options['operator'] . '" />';
			}
			$taxonomy_form_html .= '</div>';
		}
		return wp_kses( $taxonomy_form_html, self::kses_allowed() );
	}

	/**
	 * Get Taxonomy Filter Design HTML
	 *
	 * @param string $taxonomy name of taxonomy.
	 * @param array  $options  options.
	 */
	public static function get_taxonomy_design_html( $taxonomy, $options = array() ) {

		// タクソノミーの調整.
		$taxonomy        = ! empty( $taxonomy ) ? $taxonomy : 'category';
		$taxonomy_object = get_taxonomy( $taxonomy );
		$taxonomy_terms  = get_terms( $taxonomy );

		// オプションの値を調整
		$default = array(
			'class_name'         => '',
			'label'              => $taxonomy_object->labels->singular_name,
			'form_design'        => 'select',
			'non_selected_label' => '',
			'operator'           => 'or',
			'show_count'         => false,
			'hide_empty'         => true,
			'outer_columns'      => array(),
			'inner_columns'      => array(),
		);
		$options = wp_parse_args( $options, $default );

		// デザインの調整.
		$form_style_option = self::form_style_option();
		$form_design       = ! empty( $options['form_design'] ) && in_array( $options['form_design'], $form_style_option, true ) ? $options['form_design'] : 'select';

		// 変数を初期化.
		$taxonomy_design_html  = '';
		$taxonomy_option_array = array();

		// 共通の設定項目.
		$common_args = array(
			'show_option_none'  => ! empty( $options['non_selected_label'] ) ? $options['non_selected_label'] : __( 'Any', 'vk-filter-search' ),
			'option_none_value' => '',
			'show_count'        => $options['show_count'],
			'hide_empty'        => $options['hide_empty'],
			'echo'              => false,
			'taxonomy'          => $taxonomy,
			'value_field'       => 'slug',
		);

		// 共通かつカスタマイズの余地がある設定項目.
		$custom_args = array(
			'orderby'      => 'NAME',
			'order'        => 'ASC',
			'hierarchical' => true,
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
							'walker' => new VK_Walker_Category_Dropdown(),
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
							'walker' => new VK_Walker_Category_Dropdown(),
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
							'walker' => new VK_Walker_Category_Dropdown(),
						)
					)
				);
			}
		}
		return apply_filters( 'vk_search_filter_taxonomy_design_html', $taxonomy_design_html, $taxonomy, $options );

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
		// オプションを取得
		$options = get_option( 'vk_filter_search' );

		// 存在価値がないフォームデータを削除
		$options = self::option_reduction( $options );

		return $options;
	}

	/**
	 *  Option Reduction
	 */
	public static function option_reduction( $options ) {

		// 検索結果のオプション値を整理
		if ( ! empty( $options['display_on_result'] ) ) {

			// オプション値のキーを取得
			$block_id_array = array_keys( $options['display_on_result'] );

			// ループ用の変数を初期化
			$i = 0;

			// それぞれのフォームデータに対して処理を実行
			foreach ( $options['display_on_result'] as $the_post ) {
				if ( ! is_array( $options['display_on_result'][ $block_id_array[ $i ] ] ) ) {
					// フォームの保存データが配列でなければそのフォームのデータを削除
					unset( $options['display_on_result'][ $block_id_array[ $i ] ] );
				} elseif ( ! empty( $the_post['form_post_id'] ) ) {
					// フォームの保存データに投稿 ID がある場合はまず投稿を取得
					$post_object = get_post( intval( $the_post['form_post_id'] ) );
					if ( empty( $post_object ) ) {
						// 投稿の中身がなければそのフォームのデータを削除
						unset( $options['display_on_result'][ $block_id_array[ $i ] ] );
					} else {
						// 投稿の中身に該当のブロックが設置されていなければそのフォームのデータを削除
						$post_content = $post_object->post_content;
						if ( false === strpos( $post_content, $block_id_array[ $i ] ) ) {
							unset( $options['display_on_result'][ $block_id_array[ $i ] ] );
						}
					}
				} else {
					// フォームの保存データに投稿 ID がない場合はそのフォームは削除
					unset( $options['display_on_result'][ $block_id_array[ $i ] ] );
				}
				$i++;
			}
		}

		// 投稿タイプアーカイブに関するオプション値を整理
		if ( ! empty( $options['display_on_post_type_archive'] ) ) {

			// オプション値のキーを取得
			$block_id_array = array_keys( $options['display_on_post_type_archive'] );

			// ループ用の変数を初期化
			$i = 0;

			// それぞれのフォームデータに対して処理を実行
			foreach ( $options['display_on_post_type_archive'] as $the_post ) {
				if ( ! is_array( $options['display_on_post_type_archive'][ $block_id_array[ $i ] ] ) ) {
					// フォームの保存データが配列でなければそのフォームのデータを削除
					unset( $options['display_on_post_type_archive'][ $block_id_array[ $i ] ] );
				} elseif ( ! empty( $the_post['form_post_id'] ) ) {
					// フォームの保存データに投稿 ID がある場合はまず投稿を取得
					$post_object = get_post( intval( $the_post['form_post_id'] ) );
					if ( empty( $post_object ) ) {
						// 投稿の中身がなければそのフォームのデータを削除
						unset( $options['display_on_post_type_archive'][ $block_id_array[ $i ] ] );
					} else {
						// 投稿の中身に該当のブロックが設置されていなければそのフォームのデータを削除
						$post_content = $post_object->post_content;
						if ( false === strpos( $post_content, $block_id_array[ $i ] ) ) {
							unset( $options['display_on_post_type_archive'][ $block_id_array[ $i ] ] );
						}
					}
				} else {
					// フォームの保存データに投稿 ID がない場合はそのフォームは削除
					unset( $options['display_on_post_type_archive'][ $block_id_array[ $i ] ] );
				}
				$i++;
			}
		}
		update_option( 'vk_filter_search', $options );

		return $options;
	}

	/**
	 * Search Form on Loop
	 */
	public static function search_result_form_content() {
		$content = '';
		$options = self::get_options();
		
		// 検索結果画面にフォームを表示する場合
		if ( is_search() && isset( $_GET['vkfs_form_id'] ) ) {

			// 表示するフォームの ID を取得
			$target_id = sanitize_text_field( wp_unslash( $_GET['vkfs_form_id'] ) );

			// フォームの ID が数値型なら該当の投稿を取得
			$target_post = is_numeric( $target_id ) ? get_post( $target_id ) : array();

			// Filter Search の投稿がある場合はそちらを優先する
			if ( ! empty( $target_post ) ) {

				// 検索結果に表示するか否かのカスタムフィールドを取得
				$display_result = get_post_meta( $target_post->ID, 'vkfs_display_result', true );

				// 上記カスタムフィールドを処理
				$display_result = ! empty( $display_result ) ? true : false;

				// 上記フィールドが true ならその投稿を表示
				if ( ! empty( $display_result ) ) {
					$content = str_replace( '[filter_search_result_input]', '<input type="hidden" name="vkfs_form_id" value="' . $target_id . '" />', $target_post->post_content );
					$content = apply_filters( 'filter_search_content', $content );
				} else {
					$content = apply_filters( 'filter_search_content', $target_post->post_content );
				}
			}

			// そうでない場合は旧来のフォームを表示（できればなくしたい）
			elseif ( ! empty( $options['display_on_result'] ) ) {
				// ID に該当する情報があればそれを表示
				if ( array_key_exists( $target_id, $options['display_on_result'] ) ) {
					$content = $options['display_on_result'][ $target_id ]['form_content'];
				}
			}
		}

		// 投稿タイプアーカイブにフォームを表示する場合
		elseif ( ( is_post_type_archive() || is_home() ) ) {

			// Filter Search の投稿一覧を取得
			$posts = get_posts(
				array(
					'posts_per_page' => -1,
					'post_type'      => 'filter-search',
					'post_status'    => 'publish,private',
				)
			);

			// Filter Search に投稿がある場合
			if ( ! empty( $posts ) ) {

				// 各投稿に対しループを回す
				foreach ( $posts as $post ) {

					// カスタムフィールドを取得
					$display_archive = get_post_meta( $post->ID, 'vkfs_display_archive', true );

					// カスタムフィールドを処理して配列に
					$display_archive = ! empty( $display_archive ) ? explode( ',', $display_archive ) : array();

					// 上記が空でなければループして投稿を呼び出す
					if ( ! empty( $display_archive ) && is_array( $display_archive ) ) {
						foreach ( $display_archive as $post_type ) {

							// 現在の投稿タイプが上記配列に該当した場合
							if (
								in_array( get_post_type(), $display_archive, true ) ||
								in_array( get_query_var( 'post_type' ), $display_archive, true )
							) {

								// 現在のページが投稿タイプアーカイブなら
								if ( 'post' === $post_type && is_home() || is_post_type_archive( $post_type ) ) {

									// 検索結果に表示するか否かのカスタムフィールドを取得
									$display_result = get_post_meta( $post->ID, 'vkfs_display_result', true );

									// 上記カスタムフィールドを処理
									$display_result = ! empty( $display_result ) ? true : false;

									// 上記フィールドが true ならその投稿を表示
									if ( ! empty( $display_result ) ) {
										$pre_content = str_replace( '[filter_search_result_input]', '<input type="hidden" name="vkfs_form_id" value="' . $post->ID . '" />', $post->post_content );
										$pre_content = apply_filters( 'filter_search_content', $pre_content );
									} else {
										$pre_content = str_replace( '[filter_search_result_input]', '', $post->post_content );
										$pre_content = apply_filters( 'filter_search_content', $pre_content );
									}

									$content .= $pre_content;

									// 一応編集リンクを追加
									if ( current_user_can( 'edit_pages' ) ) {
										$content .= '<a class="btn btn-default btn-sm" href="' . get_edit_post_link( $post->ID ) . '" target="_blank">';
										$content .= __( 'Edit', 'vk-filter-search' );
										$content .= '</a>';
									}
								}
							}
						}
					}
				}
			}

			// 旧来のフォームを表示
			if ( ! empty( $options['display_on_post_type_archive'] ) ) {
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
		if ( ! self::is_widget_area() && is_main_query() ) {
			$content = self::search_result_form_content();
			$allowed = self::kses_allowed();
			echo wp_kses( $content, $allowed );
		}
	}

	/**
	 * Header Scripts
	 */
	public static function header_scripts() {
		if ( isset( $_GET['vkfs_submitted'] ) ) {
			$header_script_params = array(
				'home_url' => home_url( '/' ),
			);

			$header_scripts  = '<script type="text/javascript" id="vk-filter-search-redirct-js-extra">/* <![CDATA[ */ var vk_filter_search_params = ' . json_encode( $header_script_params ) . '; /* ]]> */</script>';
			$header_scripts .= '<script type="text/javascript" id="vk-filter-search-redirct-js" src="' . VKFS_FREE_MODULE_ROOT_URL . 'build/vk-filter-search-redirect.min.js?ver=' . VKFS_FREE_MODULE_VERSION .'"></script>';
			$header_scripts  = apply_filters( 'vkfs_header_scripts', $header_scripts );
			echo $header_scripts;
		}
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
