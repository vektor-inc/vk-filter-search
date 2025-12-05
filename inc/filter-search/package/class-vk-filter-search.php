<?php
/**
 * VK Fiter Search
 *
 * @package VK Filter Search
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'VK_Filter_Search' ) ) {
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
			add_filter( 'query_loop_block_query_vars', array( __CLASS__, 'adjust_query_loop_query_vars' ), 10, 2 );
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
		 * Get Search Root URL
		 */
		public static function get_search_root_url() {
			$search_root_url = apply_filters( 'vkfs_search_root_url', home_url( '/' ) );
			return esc_url( $search_root_url );
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
					'menu_icon'     => 'dashicons-filter',
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
					'data-vkfs-label-accordion' => array(),
				),
				'div'    => array(
					'id'                           => array(),
					'class'                        => array(),
					'style'                        => array(),
					'data-vkfs-dropdown-options'   => array(),
					'data-vkfs-taxonomy-accordion' => array(),
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
					'min'         => array(),
					'max'         => array(),
					'step'        => array(),
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
					'id'     => array(),
					'class'  => array(),
					'style'  => array(),
					'href'   => array(),
					'target' => array(),
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
				'br'     => array(),
			);
		}

		public static function label_sanitize( $label ) {
			// ラベルのサニタイズ.
			$label = wp_kses(
				$label,
				array(
					'span'   => array(
						'class' => array(),
						'style' => array(),
					),
					'i'      => array(
						'class' => array(),
						'style' => array(),
					),
					'br'    => array(
						'class' => array(),
						'style' => array(),
					),
				)
			);
			return $label;
		}

		public static function get_outer_column_width_method( $options = array() ) {
			if ( empty( $options['outerColumnWidthMethod'] ) ) {
				return 'column';
			} elseif ( 'minimum' === $options['outerColumnWidthMethod'] ) {
				return 'minimum';
			} else {
				return 'column';
			}
		}

		/**
		 * カラム制御用のクラス及びスタイル制御用のブロックidを取得
		 *
		 * @param array $options options.
		 * @return string $outer_classes
		 */
		public static function get_outer_column_class( $options = array() ) {
			$outer_classes = '';
			// カラムクラスの調整 //////////////////////////////////////
			if ( 'column' === self::get_outer_column_width_method( $options ) ) {
				foreach ( $options['outer_columns'] as $key => $value ) {
					$outer_classes .= ' vkfs__outer-wrap--col-' . $key . '-' . $value;
				}
			}

			// ブロックIDの追加.
			$outer_classes .= ! empty( $options['blockId'] ) ? ' vkfs__block-id--' . $options['blockId'] : '';
			return $outer_classes;
		}

		/**
		 * Get Column Dynamic Style
		 *
		 * @since 2.3.0
		 * @param array $options options.
		 * @return string $column_dynamic_style
		 */
		public static function get_column_dynamic_style( $options = array() ) {
			$column_dynamic_style = '';
			// Outerカラムが最小幅指定の場合はCSSを追加.
			if ( isset( $options['outerColumnWidthMethod'] ) &&
				isset( $options['blockId'] ) &&
				'minimum' === $options['outerColumnWidthMethod'] &&
				! empty( $options['outerColumnWidthMin'] )
				) {
				$column_dynamic_style .= "<style type='text/css'>";
				$column_dynamic_style .= '.vk-filter-search.vkfs__layout--min .vkfs__outer-wrap.vkfs__block-id--' . $options['blockId'] . '{
					flex-basis:' . $options['outerColumnWidthMin'] . ';
					min-width:' . $options['outerColumnWidthMin'] . ';
				}';
				$column_dynamic_style .= '</style>';
			}

			// インナーブロックで最小幅指定の場合はCSSを追加.
			if ( method_exists( 'VK_Filter_Search_Pro', 'get_inner_column_width_method' ) ) {
				if ( 'minimum' === VK_Filter_Search_Pro::get_inner_column_width_method( $options ) ) {
					$column_dynamic_style .= "<style type='text/css'>";
					$column_dynamic_style .= '.vkfs__block-id--' . $options['blockId'] . ' > ul.vkfs__input-wrap > li:where(:not(.vkfs__has-children )){
						flex-basis:' . $options['innerColumnWidthMin'] . ';
						min-width:' . $options['innerColumnWidthMin'] . ';
					}';
					$column_dynamic_style .= '</style>';
				}
			}
			return $column_dynamic_style;
		}

		/**
		 * is hex color
		 *
		 * @param string color color
		 */
		public static function is_hex_color( $color ) {
			$is_hex = false;
			if ( $color && preg_match( '/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $color ) ) {
				$is_hex = true;
			}
			return $is_hex;
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

			$keyword_name = 's';

			$outer_classes = '';

			// カラム制御関連クラスの追加.
			$outer_classes .= self::get_outer_column_class( $options );

			$outer_classes .= ! empty( $options['class_name'] ) ? ' ' . $options['class_name'] : '';

			$keyword_form_html  = '<div class="vkfs__outer-wrap vkfs__keyword' . $outer_classes . '">';
			$keyword_form_html .= '<div class="vkfs__label-name"><div class="vkfs__label-name-inner">' . self::label_sanitize( $options['label'] ) . '</div></div>';
			$keyword_form_html .= '<div class="vkfs__input-form vkfs__input-wrap vkfs__input-wrap--text vkfs__input-wrap--keyword">';
			$keyword_form_html .= '<input type="text" name="' . $keyword_name . '" id="s" placeholder="' . esc_attr( $options['placeholder'] ) . '" />';
			$keyword_form_html .= '</div>';
			$keyword_form_html .= '</div>';

			$form_html  = wp_kses( $keyword_form_html, self::kses_allowed() );
			$form_html .= self::get_column_dynamic_style( $options );
			return $form_html;
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

			// カラム制御関連クラスの追加.
			$outer_classes .= self::get_outer_column_class( $options );

			// 追加クラスの調整.
			$outer_classes .= ! empty( $options['class_name'] ) ? ' ' . $options['class_name'] : '';

			// 変数の初期化.
			$post_type_form_html = '';

			// 描画開始.
			if ( ! empty( $post_types ) ) {
				$post_type_form_html .= '<div class="vkfs__outer-wrap vkfs__post-type' . $outer_classes . '">';
				$post_type_form_html .= '<div class="vkfs__label-name"><div class="vkfs__label-name-inner">' . self::label_sanitize( $options['label'] ) . '</div></div>';
				$post_type_form_html .= self::get_post_type_design_html( $post_types, $options );
				$post_type_form_html .= '</div>';
			}
			$form_html  = wp_kses( $post_type_form_html, self::kses_allowed() );
			$form_html .= self::get_column_dynamic_style( $options );
			return $form_html;
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
				$post_type_design_html .= '<select class="vkfs__input-form vkfs__input-wrap vkfs__input-wrap--select vkfs__input-wrap--post_type" name="' . $post_type_name . '" id="post_type">';

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
				'class_name'            => '',
				'label'                 => $taxonomy_object->labels->singular_name,
				'form_design'           => 'select',
				'non_selected_label'    => '',
				'post_type'             => '',
				'operator'              => 'or',
				'enable_child_dropdown' => false,
				'show_count'            => false,
				'auto_count'            => false,
				'hide_empty'            => true,
				'outer_columns'         => array(),
				'inner_columns'         => array(),
				'accordion_type'        => 'none',
			);
			$options = wp_parse_args( $options, $default );

			// デザインの調整.
			$form_style_option = self::form_style_option();
			$form_design       = ! empty( $options['form_design'] ) && in_array( $options['form_design'], $form_style_option, true ) ? $options['form_design'] : 'select';

			$outer_classes = '';

			// カラム制御関連クラスの追加.
			$outer_classes .= self::get_outer_column_class( $options );

			// 追加クラスの調整.
			$outer_classes .= ! empty( $options['class_name'] ) ? ' ' . $options['class_name'] : '';

			$dropdown_options      = array();
			$data_dropdown_options = '';
			if ( ! empty( $options['enable_child_dropdown'] ) ) {
				$outer_classes        .= ' vkfs__child-dropdown';
				$dropdown_options      = array(
					'post_type'  => $options['post_type'],
					'operator'   => $options['operator'],
					'show_count' => $options['show_count'],
					'auto_count' => $options['auto_count'],
					'hide_empty' => $options['hide_empty'],
				);
				$data_dropdown_options = ' data-vkfs-dropdown-options="' . esc_html( wp_json_encode( $dropdown_options, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT ) ) . '"';
			}

			// 変数を初期化.
			$taxonomy_form_html   = '';
			$taxonomy_design_html = '';

			$accordion_data               = array();
			$data_vkfs_taxonomy_accordion = '';

			if ( $options['accordion_type'] !== 'none' ) {
				$accordion_data               = array(
					'AccordionType' => $options['accordion_type'],
				);
				$data_vkfs_taxonomy_accordion = ' data-vkfs-taxonomy-accordion="' . esc_html( wp_json_encode( $accordion_data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT ) ) . '"';
			}

			// 描画開始.
			if ( ! empty( $taxonomy_object ) && ! empty( $taxonomy_terms ) ) {
				$taxonomy_form_html .= '<div class="vkfs__outer-wrap vkfs__taxonomy' . $outer_classes . '"' . $data_vkfs_taxonomy_accordion . $data_dropdown_options . '>';

				$taxonomy_form_html .= '<div class="vkfs__label-name">';
				if ( 'user' !== $options['operator'] ) {
					$taxonomy_form_html .= '<div class="vkfs__label-name-inner">' . self::label_sanitize( $options['label'] ) . '</div>';
				} elseif ( 'user' === $options['operator'] ) {
					$taxonomy_form_html .= '<div class="vkfs__label-name-wrap">';
					$taxonomy_form_html .= '<span class="vkfs__label-name-item">';
					$taxonomy_form_html .= self::label_sanitize( $options['label'] );
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
			$taxonomy_form_html = wp_kses( $taxonomy_form_html, self::kses_allowed() );

			$taxonomy_form_html .= self::get_column_dynamic_style( $options );
			return $taxonomy_form_html;
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
				'post_type'          => '',
				'operator'           => 'or',
				'show_count'         => false,
				'auto_count'         => false,
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
				'post_type'         => $options['post_type'],
				'operator'          => $options['operator'],
				'show_count'        => $options['show_count'],
				'auto_count'        => $options['auto_count'],
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
					$taxonomy_design_html = vk_dropdown_categories(
						array_merge(
							$common_args,
							$custom_args,
							array(
								'name'  => 'vkfs_category[]',
								'id'    => 'vkfs_category',
								'class' => 'vkfs__input-form vkfs__input-wrap vkfs__input-wrap--select vkfs__input-wrap--category_name',
							)
						)
					);
				} elseif ( 'post_tag' === $taxonomy ) {
					$taxonomy_design_html = vk_dropdown_categories(
						array_merge(
							$common_args,
							$custom_args,
							array(
								'name'  => 'vkfs_post_tag[]',
								'id'    => 'vkfs_post_tag',
								'class' => 'vkfs__input-form vkfs__input-wrap vkfs__input-wrap--select vkfs__input-wrap--tag',
							)
						)
					);
				} else {
					$taxonomy_design_html = vk_dropdown_categories(
						array_merge(
							$common_args,
							$custom_args,
							array(
								'name'  => 'vkfs_' . $taxonomy_object->name . '[]',
								'id'    => 'vkfs_' . $taxonomy_object->name,
								'class' => 'vkfs__input-form vkfs__input-wrap vkfs__input-wrap--select vkfs__input-wrap--' . $taxonomy_object->name,
							)
						)
					);
				}
			}
			// プロ版のチェックボックスなどはフィルターで全部差し替え.
			return apply_filters( 'vk_search_filter_taxonomy_design_html', $taxonomy_design_html, $taxonomy, $options );
		}

		public static function get_search_count_html( $options ) {
			$default = array(
				'outer'             => true,
				'before_text'       => __( 'Search Results:', 'vk-filter-search' ),
				'after_text'        => __( 'articles found.', 'vk-filter-search' ),
				'number_color'      => '',
				'number_font_size'  => '',
				'number_font_style' => '',
				'number_font_weight' => '',
			);
			$options = wp_parse_args( $options, $default );

			global $wp_query;

			$content = '';

			if ( is_search() ) {

				$number_style = '';
				$number_class = '';

				// 数字の色の処理
				if ( ! empty( $options['number_color'] ) ) {
					if ( self::is_hex_color( $options['number_color'] ) ) {
						$number_style .= 'color: ' . $options['number_color'] . ';';
					} else {
						$number_class .= 'has-text-color has-' . $options['number_color'] . '-color';
					}
				}

				// 数字のフォントサイズ
				if ( ! empty( $options['number_font_size'] ) ) {
					$number_style .= 'font-size: ' . $options['number_font_size'] . ';';
				}

				// 数字のフォントスタイル
				if ( ! empty( $options['number_font_style'] ) ) {
					$number_style .= 'font-style: ' . $options['number_font_style'] . ';';
				}

				// 数字のフォントウェイト
				if ( ! empty( $options['number_font_weight'] ) ) {
					$number_style .= 'font-weight: ' . $options['number_font_weight'] . ';';
				}

				// スタイルの処理
				if ( ! empty( $number_style ) ) {
					$number_style = ' style="' . $number_style . '"';
				}

				// クラスの処理
				if ( ! empty( $number_class ) ) {
					$number_class = ' class="' . $number_class . '"';
				}

				if ( ! empty( $options['outer'] ) ) {
					$content .= '<div class="vkfs__search-result-count">';
				}

				$content .= $options['before_text'];
				$content .= ' <span' . $number_style . $number_class . '>' . $wp_query->found_posts . '</span> ';
				$content .= $options['after_text'];

				if ( ! empty( $options['outer'] ) ) {
					$content .= '</div>';
				}
			}

			return $content;
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
		 * Adjust Query Loop block query vars based on Filter Search parameters.
		 *
		 * @param array $query_vars Query vars generated for the Query Loop block.
		 * @param array $block Block settings.
		 * @return array
		 */
		public static function adjust_query_loop_query_vars( $query_vars, $block ) {
			if ( empty( $_GET['vkfs_form_id'] ) ) {
				return $query_vars;
			}

			$keyword = self::get_request_param( 'keyword' );
			if ( '' === $keyword ) {
				$keyword = self::get_request_param( 's' );
			}
			if ( '' !== $keyword ) {
				$query_vars['s'] = $keyword;
			}

			$post_types = self::get_request_keys( 'vkfs_post_type' );
			if ( empty( $post_types ) ) {
				$post_types = self::get_request_keys( 'post_type' );
			}
			if ( ! empty( $post_types ) ) {
				$query_vars['post_type'] = ( 1 === count( $post_types ) ) ? reset( $post_types ) : $post_types;
			}

			$category_name = self::get_request_param( 'category_name' );
			if ( '' !== $category_name ) {
				if ( false !== strpos( $category_name, ' ' ) ) {
					$term_array     = array_filter( array_map( 'trim', explode( ' ', $category_name ) ) );
					$category_array = self::convert_slugs_to_ids( $term_array, 'category' );
					if ( ! empty( $category_array ) ) {
						$query_vars['category__and'] = $category_array;
					}
				} elseif ( false !== strpos( $category_name, ',' ) ) {
					$term_array     = array_filter( array_map( 'trim', explode( ',', $category_name ) ) );
					$category_array = self::convert_slugs_to_ids( $term_array, 'category' );
					if ( ! empty( $category_array ) ) {
						$query_vars['category__in'] = $category_array;
					}
				} else {
					$query_vars['category_name'] = $category_name;
				}
			}

			$tag = self::get_request_param( 'tag' );
			if ( '' !== $tag ) {
				if ( false !== strpos( $tag, ' ' ) ) {
					$term_array = array_filter( array_map( 'trim', explode( ' ', $tag ) ) );
					$tag_array  = self::convert_slugs_to_ids( $term_array, 'post_tag' );
					if ( ! empty( $tag_array ) ) {
						$query_vars['tag__and'] = $tag_array;
					}
				} elseif ( false !== strpos( $tag, ',' ) ) {
					$term_array = array_filter( array_map( 'trim', explode( ',', $tag ) ) );
					$tag_array  = self::convert_slugs_to_ids( $term_array, 'post_tag' );
					if ( ! empty( $tag_array ) ) {
						$query_vars['tag__in'] = $tag_array;
					}
				} else {
					$query_vars['tag'] = $tag;
				}
			}

			// その他の公開タクソノミー（カテゴリ・タグを除く）を GET パラメータから tax_query に反映.
			$taxonomies = get_taxonomies(
				array(
					'public' => true,
				),
				'objects'
			);
			if ( ! empty( $taxonomies ) ) {
				$tax_query = isset( $query_vars['tax_query'] ) ? $query_vars['tax_query'] : array();
				foreach ( $taxonomies as $taxonomy_slug => $taxonomy_object ) {
					if ( 'category' === $taxonomy_slug || 'post_tag' === $taxonomy_slug ) {
						continue;
					}
					$query_var = $taxonomy_object->query_var ? $taxonomy_object->query_var : $taxonomy_slug;
					$terms     = self::get_request_terms( $query_var );
					if ( empty( $terms ) ) {
						continue;
					}
					$operator_param = self::get_request_param( $query_var . '_operator' );
					$operator       = ( 'and' === strtolower( $operator_param ) ) ? 'AND' : 'IN';

					$tax_query[] = array(
						'taxonomy' => $taxonomy_slug,
						'field'    => 'slug',
						'terms'    => $terms,
						'operator' => $operator,
					);
				}

				if ( ! empty( $tax_query ) ) {
					if ( ! isset( $tax_query['relation'] ) ) {
						$tax_query = array_merge( array( 'relation' => 'AND' ), $tax_query );
					}
					$query_vars['tax_query'] = $tax_query;
				}
			}

			$query_vars['ignore_sticky_posts'] = true;

			return apply_filters( 'vkfs_query_loop_query_vars', $query_vars, $block );
		}

		/**
		 * Get sanitized request parameter.
		 *
		 * @param string $key Parameter key.
		 * @return string
		 */
		protected static function get_request_param( $key ) {
			if ( ! isset( $_GET[ $key ] ) ) {
				return '';
			}
			$value = $_GET[ $key ];
			if ( is_array( $value ) ) {
				$value = reset( $value );
			}
			return sanitize_text_field( wp_unslash( $value ) );
		}

		/**
		 * Get sanitized request terms as array (supports array / space / comma separated).
		 *
		 * @param string $key Parameter key.
		 * @return array
		 */
		protected static function get_request_terms( $key ) {
			if ( ! isset( $_GET[ $key ] ) ) {
				return array();
			}
			$value = wp_unslash( $_GET[ $key ] );
			$terms = array();
			if ( is_array( $value ) ) {
				$terms = $value;
			} else {
				$terms = preg_split( '/[\\s,]+/', $value );
			}

			return array_filter(
				array_map(
					'sanitize_title',
					(array) $terms
				)
			);
		}

		/**
		 * Get sanitized request parameter as array of keys (supports array / space / comma separated).
		 *
		 * @param string $key Parameter key.
		 * @return array
		 */
		protected static function get_request_keys( $key ) {
			if ( ! isset( $_GET[ $key ] ) ) {
				return array();
			}
			$value = wp_unslash( $_GET[ $key ] );
			if ( is_array( $value ) ) {
				$keys = $value;
			} else {
				$keys = preg_split( '/[\\s,]+/', $value );
			}

			return array_filter(
				array_map(
					'sanitize_key',
					(array) $keys
				)
			);
		}

		/**
		 * Convert term slugs to IDs.
		 *
		 * @param array  $slugs    Slug list.
		 * @param string $taxonomy Taxonomy name.
		 * @return array
		 */
		protected static function convert_slugs_to_ids( $slugs, $taxonomy ) {
			$ids = array();
			if ( empty( $slugs ) || ! is_array( $slugs ) ) {
				return $ids;
			}
			foreach ( $slugs as $slug ) {
				$slug = sanitize_title( $slug );
				if ( '' === $slug ) {
					continue;
				}
				$term = get_term_by( 'slug', $slug, $taxonomy );
				if ( $term && ! is_wp_error( $term ) ) {
					$ids[] = $term->term_id;
				}
			}
			return $ids;
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

			update_option( 'vk_filter_search', $options );

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
							// 公開済み or 非公開でなければそのフォームのデータを削除
							if ( 'publish' !== $post_object->post_status && 'private' !== $post_object->post_status ) {
								unset( $options['display_on_result'][ $block_id_array[ $i ] ] );
							}
						}
					} else {
						// フォームの保存データに投稿 ID がない場合はそのフォームは削除
						unset( $options['display_on_result'][ $block_id_array[ $i ] ] );
					}
					++$i;
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
							// 公開済み or 非公開でなければそのフォームのデータを削除
							if ( 'publish' !== $post_object->post_status && 'private' !== $post_object->post_status ) {
								unset( $options['display_on_post_type_archive'][ $block_id_array[ $i ] ] );
							}
						}
					} else {
						// フォームの保存データに投稿 ID がない場合はそのフォームは削除
						unset( $options['display_on_post_type_archive'][ $block_id_array[ $i ] ] );
					}
					++$i;
				}
			}

			return $options;
		}

		/**
		 * Search Result Form Display Condition
		 *
		 * 特定の条件に基づいて検索結果フォームと投稿タイプアーカイブフォームの表示可否を判断します。
		 * 返り値は連想配列で、以下のキーを含みます。
		 *
		 * - 'search_result' (bool):
		 *      true : 検索結果画面で、かつフォームIDが指定されている場合
		 *      false : それ以外の場合
		 * - 'post_type_archive' (bool):
		 *      true : 投稿タイプのアーカイブページ、またはホームページである場合に true。
		 *      false : それ以外の場合、または検索結果画面である場合
		 *
		 * @return array 以下の形式の連想配列。
		 *               [
		 *                 'search_result' => bool,
		 *                 'post_type_archive' => bool,
		 *               ]
		 */
		public static function search_result_form_display_condition() {
			// 通常の場合は両方とも false
			$display_result = array(
				'search_result'     => false,
				'post_type_archive' => false,
			);

			$target_id = isset( $_GET['vkfs_form_id'] ) ? sanitize_text_field( wp_unslash( $_GET['vkfs_form_id'] ) ) : '';

			// 検索結果画面かつフォーム ID がある場合は検索結果用のフォームを表示する
			if ( is_search() && ! empty( $target_id ) ) {
				$display_result['search_result'] = true;
			}

			if ( ! empty( $target_id ) && is_numeric( $target_id ) ) {
				$target_id              = absint( $target_id );
				$search_result_page_id = get_post_meta( $target_id, 'vkfs_search_result_page_id', true );
				if ( ! empty( $search_result_page_id ) && is_page( $search_result_page_id ) ) {
					$display_result['search_result'] = true;
				}
			}

			// 検索結果画面でなく投稿タイプのアーカイブの場合は投稿タイプアーカイブ用のフォームを表示する
			// 実質投稿タイプ「投稿」のアーカイブであるホーム画面でも投稿タイプアーカイブ用のフォームを表示する
			if ( is_post_type_archive() && ! is_search() || is_home() ) {
				$display_result['post_type_archive'] = true;
			}

			return $display_result;
		}

		/**
		 * フォームの編集時にのみ表示するコンテンツ
		 *
		 * @param int  $post_id 編集する投稿のID
		 * @param bool $old_flag 古いフラグがtrueの場合、古いフォームの警告を表示します
		 * @return string 生成された編集コンテンツのHTML
		 */
		public static function form_edit_content( $post_id, $old_flag ) {
			$edit_content = '';
			if ( current_user_can( 'edit_pages' ) ) {
				if ( true === $old_flag ) {
					$edit_content .= '<div class="vkfs_old-form-alert" data-nosnippet">';
					$edit_content .= '<div class="vkfs_old-form-alert--icon"><i class="fa-solid fa-circle-info"></i></div>';
					$edit_content .= '<div class="vkfs_old-form-alert--text">';
					$edit_content .= __( 'This form is obsolete and may eventually be deleted.', 'vk-filter-search' );
					$edit_content .= '<br>';
					$edit_content .= __( 'We recommend creating a form with the post type "VK Filter Search".', 'vk-filter-search' );
					$edit_content .= '<br>';
					$edit_content .= __( 'Posts of the "VK Filter Search" post type can be used via the "Call Filter Search" block.', 'vk-filter-search' );
					$edit_content .= '</div>';
					$edit_content .= '</div>';
				}
				$edit_content .= '<a class="btn btn-default btn-sm" href="' . get_edit_post_link( $post_id ) . '" target="_blank">';
				$edit_content .= __( 'Edit', 'vk-filter-search' );
				$edit_content .= '</a>';
			}
			return $edit_content;
		}

		/**
		 * Search Form on Loop
		 *
		 * @param bool $force_display_result 検索結果を強制表示するかどうか
		 */
		public static function search_result_form_content( $force_display_result = false ) {
			$content  = '';
			$old_flag = false;
			$options  = self::get_options();

			$display_condition = self::search_result_form_display_condition();

			// 検索結果画面にフォームを表示する場合
			if ( true === $display_condition['search_result'] ) {

				// 表示するフォームの ID を取得
				$target_id = sanitize_text_field( wp_unslash( $_GET['vkfs_form_id'] ) );

				// フォームのIDは 投稿タイプ VK Filter Search : 数値 / 直配置の場合 : 16進数と - の文字列
				// フォームの ID が数値型なら該当の投稿（VK Filter Search）を取得
				$target_post = is_numeric( $target_id ) ? get_post( $target_id ) : array();

				// 投稿タイプ VK Filter Search のフォームがある場合はそちらを優先する
				if ( ! empty( $target_post ) && ( 'publish' === $target_post->post_status || 'private' === $target_post->post_status ) ) {
					// 新しいのでフラグを消す

					$old_flag = false;

					// 検索結果に表示するか否かのカスタムフィールドを取得
					$display_result = get_post_meta( $target_post->ID, 'vkfs_display_result', true );

					// 上記カスタムフィールドを処理
					$display_result = ! empty( $display_result ) ? true : false;

					// 上記フィールドが true か強制表示フラグが true ならその投稿を表示
					if ( ! empty( $display_result ) || ! empty( $force_display_result ) ) {
						$content  = str_replace( '[filter_search_result_input]', '<input type="hidden" name="vkfs_form_id" value="' . $target_id . '" />', $target_post->post_content );
						$content  = apply_filters( 'filter_search_content', $content );
						$content .= self::form_edit_content( $target_post->ID, $old_flag );
					} else {
						$content = '';
					}
				}

				// 旧版のフォームを表示
				if ( ! empty( $options['display_on_result'] ) ) {

					// 古いのでフラグを立てる
					$old_flag = true;

					// ID に該当する情報があればそれを表示
					if ( array_key_exists( $target_id, $options['display_on_result'] ) ) {
						$content  = $options['display_on_result'][ $target_id ]['form_content'];
						$content .= self::form_edit_content( $options['display_on_result'][ $target_id ]['form_post_id'], $old_flag );
					}
				}
			}

			// 投稿タイプアーカイブにフォームを表示する場合
			if ( true === $display_condition['post_type_archive'] ) {

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

					// 新しいのでフラグを消す
					$old_flag = false;

					// 各投稿に対しループを回す
					foreach ( $posts as $post ) {

						// カスタムフィールドを取得
						$display_archive = get_post_meta( $post->ID, 'vkfs_display_archive', true );

						// カスタムフィールドを処理して配列に
						$display_archive = ! empty( $display_archive ) ? explode( ',', $display_archive ) : array();

						// 上記が空でなければループして投稿を呼び出す
						if ( ! empty( $display_archive ) && is_array( $display_archive ) ) {
							foreach ( $display_archive as $post_type ) {

								// 現在の投稿タイプが $post_type と一致した場合
								if ( get_post_type() === $post_type || get_query_var( 'post_type' ) === $post_type ) {

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
										$content .= self::form_edit_content( $post->ID, $old_flag );
									}
								}
							}
						}
					}
				}

				// 旧版のフォームを表示
				if ( ! empty( $options['display_on_post_type_archive'] ) ) {
					// 古いのでフラグを立てる
					$old_flag = true;
					$forms    = $options['display_on_post_type_archive'];
					foreach ( $forms as $form ) {
						foreach ( $form['display_post_type'] as $post_type ) {
							if ( in_array( get_post_type(), $form['display_post_type'], true ) ) {
								if ( is_home() || is_post_type_archive( $post_type ) ) {
									$content .= $form['form_content'];
									$content .= self::form_edit_content( $form['form_post_id'], $old_flag );
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
				$target_id             = ! empty( $_GET['vkfs_form_id'] ) ? sanitize_text_field( wp_unslash( $_GET['vkfs_form_id'] ) ) : '';
				$search_result_page_id = ( ! empty( $target_id ) && is_numeric( $target_id ) )
					? get_post_meta( absint( $target_id ), 'vkfs_search_result_page_id', true )
					: '';
				$search_result_url     = ! empty( $search_result_page_id ) ? get_permalink( $search_result_page_id ) : '';

				$header_script_params = array(
					'home_url'          => self::get_search_root_url(),
					'search_result_url' => $search_result_url,
				);

				$header_scripts  = '<script type="text/javascript" id="vk-filter-search-redirct-js-extra">/* <![CDATA[ */ var vk_filter_search_params = ' . json_encode( $header_script_params ) . '; /* ]]> */</script>';
				$header_scripts .= '<script type="text/javascript" id="vk-filter-search-redirct-js" src="' . VKFS_FREE_MODULE_ROOT_URL . 'build/vk-filter-search-redirect.min.js?ver=' . VKFS_FREE_MODULE_VERSION . '"></script>';
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

			if ( ! isset( $_GET['vkfs_submitted'] ) ) {
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
}
