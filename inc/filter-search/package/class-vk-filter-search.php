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
		add_action( 'pre_get_posts', array( __CLASS__, 'pre_get_posts' ) );
		add_action( 'wp', array( __CLASS__, 'get_header' ) );
		// add_action( 'init', array( __CLASS__, 'register_post_types' ) );
		add_action( 'dynamic_sidebar_before', array( __CLASS__, 'dynamic_sidebar_before' ) );
		add_action( 'dynamic_sidebar_after', array( __CLASS__, 'dynamic_sidebar_after' ) );
		add_action( 'loop_start', array( __CLASS__, 'display_form_on_loop' ) );
		add_filter( 'vkfs_form_content', 'do_blocks', 9 );
		add_filter( 'vkfs_form_content', 'wptexturize' );
		add_filter( 'vkfs_form_content', 'convert_smilies', 20 );
		add_filter( 'vkfs_form_content', 'shortcode_unautop' );
		add_filter( 'vkfs_form_content', 'prepend_attachment' );
		add_filter( 'vkfs_form_content', 'wp_filter_content_tags' );
		add_filter( 'vkfs_form_content', 'do_shortcode', 11 );
		add_filter( 'vkfs_form_content', 'capital_P_dangit', 11 );
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
		$value       = ! empty( get_query_var( 's' ) ) ? get_query_var( 's' ) : '';

		$keyword_form_html  = '<div class="vkfs__keyword">';
		$keyword_form_html .= '<label>';
		$keyword_form_html .= '<div class="vkfs__label-name">' . $label . '</div>';
		$keyword_form_html .= '<input type="text" name="s" id="s" placeholder="' . $placeholder . '" value="' . $value . '" />';
		$keyword_form_html .= '</label>';
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
			$post_type_form_html .= '<div class="vkfs__post-type">';
			$post_type_form_html .= '<label>';
			$post_type_form_html .= '<div class="vkfs__label-name">' . $label . '</div>';
			$post_type_form_html .= self::get_post_type_design_html( $post_types, $label, $post_label, $page_label, $form_design );
			$post_type_form_html .= '</label>';
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
	public static function get_post_type_design_html( $post_types = array( 'post', 'page' ), $label = '', $post_label = '', $page_label = '', $form_design = 'select' ) {
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
				// translators: Don't specify Post Type.
				'label'    => sprintf( __( 'Do not specify a %s', 'vk-filter-search' ), $label ),
				'value'    => '',
				'selected' => '' === get_query_var( 'post_type' ) ? 'selected' : '',
				'checked'  => '' === get_query_var( 'post_type' ) ? 'checked' : '',
			),
		);

		foreach ( $post_types as $post_type ) {
			if ( ! empty( get_post_type_object( $post_type ) ) ) {
				$condition = false;
				if ( is_array( get_query_var( 'post_type' ) ) && in_array( $post_type, get_query_var( 'post_type' ), true ) ) {
					$condition = true;
				} elseif ( get_query_var( 'post_type' ) === $post_type ) {
					$condition = true;
				}
				$selected = true === $condition ? 'selected' : '';
				$checked  = true === $condition ? 'checked' : '';
				if ( 'post' === $post_type ) {
					$post_type_option_array[] = array(
						'value'    => $post_type,
						'selected' => $selected,
						'checked'  => $checked,
						'label'    => $post_label,
					);
				} elseif ( 'page' === $post_type ) {
					$post_type_option_array[] = array(
						'value'    => $post_type,
						'selected' => $selected,
						'checked'  => $checked,
						'label'    => $page_label,
					);
				} else {
					$post_type_option_array[] = array(
						'value'    => $post_type,
						'selected' => $selected,
						'checked'  => $checked,
						'label'    => get_post_type_object( $post_type )->labels->singular_name,
					);
				}
			}
		}

		// デザインに応じて切り替え開始.
		if ( 'select' === $form_design ) {

			// 配列を統合.
			$post_type_option_array = array_merge( $default_option_array, $post_type_option_array );

			// 描画開始.
			$post_type_design_html .= '<select class="vkfs__post_type-select" name="' . $post_type_name . '" id="post_type">';

			// 項目のループ.
			foreach ( $post_type_option_array as $post_type_option ) {
				$get_posts = get_posts(
					array(
						'post_type' => $post_type_option['value'],
					)
				);
				if ( ! empty( $get_posts ) ) {
					$post_type_design_html .= '<option value="' . $post_type_option['value'] . '" ' . $post_type_option['selected'] . '>' . $post_type_option['label'] . '</option>';
				}
			}

			$post_type_design_html .= '</select>';

		}
		return apply_filters( 'vk_search_filter_post_type_design_html', $post_type_design_html, $post_types, $label, $post_label, $page_label, $form_design );
	}

	/**
	 * Get Taxonomy Filter Form HTML
	 *
	 * @param string $taxonomy    name of taxonomy.
	 * @param string $label       label of form.
	 * @param string $form_design design of form.
	 * @param string $operator    filtering operator.
	 */
	public static function get_taxonomy_form_html( $taxonomy = 'category', $label = '', $form_design = 'select', $operator = 'or' ) {

		// タクソノミーの調整.
		$taxonomy        = ! empty( $taxonomy ) ? $taxonomy : '';
		$taxonomy_object = get_taxonomy( $taxonomy );
		$taxonomy_terms  = get_terms( $taxonomy );

		// ラベルの調整.
		$label = ! empty( $label ) ? $label : $taxonomy_object->labels->singular_name;

		// デザインの調整.
		$form_style_option = self::form_style_option();
		$form_design       = ! empty( $form_design ) && in_array( $form_design, $form_style_option, true ) ? $form_design : 'select';

		// 演算子の調整.
		$operator = ! empty( $form_design ) ? $operator : 'or';

		// 変数を初期化.
		$taxonomy_form_html   = '';
		$taxonomy_design_html = '';

		// 描画開始.
		if ( ! empty( $taxonomy_object ) && ! empty( $taxonomy_terms ) ) {
			$taxonomy_form_html .= '<div class="vkfs__taxonomy">';
			$taxonomy_form_html .= '<label>';
			$taxonomy_form_html .= '<div class="vkfs__label-name">' . $label . '</div>';
			$taxonomy_form_html .= self::get_taxonomy_design_html( $taxonomy, $label, $form_design );
			$taxonomy_form_html .= '</label>';
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
	public static function get_taxonomy_design_html( $taxonomy = 'category', $label = '', $form_design = 'select' ) {

		// タクソノミーの調整.
		$taxonomy        = ! empty( $taxonomy ) ? $taxonomy : '';
		$taxonomy_object = get_taxonomy( $taxonomy );
		$taxonomy_terms  = get_terms( $taxonomy );

		// デザインの調整.
		$form_style_option = self::form_style_option();
		$form_design       = ! empty( $form_design ) && in_array( $form_design, $form_style_option, true ) ? $form_design : 'select';

		// 変数を初期化.
		$taxonomy_design_html  = '';
		$taxonomy_option_array = array();

		// 共通オプションを定義.
		if ( 'category' === $taxonomy ) {

			// フォームの名前.
			$taxonomy_name = 'vkfs_category[]';

			// クエリの処理.
			$category_slug = array();
			$query_array   = array();
			if ( ! empty( get_query_var( 'category__in' ) ) ) {
				$query_array = get_query_var( 'category__in' );
			} elseif ( ! empty( get_query_var( 'category__and' ) ) ) {
				$query_array = get_query_var( 'category__and' );
			}
			if ( ! empty( $query_array ) ) {
				foreach ( $query_array as $query ) {
					$category_object = get_term_by( 'id', $query, 'category' );
					$category_slug[] = $category_object->slug;
				}
			} else {
				$category_slug[] = get_query_var( 'category_name' );
			}

			// 追加の選択肢.
			$default_option_array = array(
				array(
					// translators: Don't specify Term.
					'label'    => sprintf( __( 'Do not specify a %s', 'vk-filter-search' ), $label ),
					'value'    => '',
					'selected' => ( '' === get_query_var( 'category_name' ) ) ? 'selected' : '',
					'checked'  => ( '' === get_query_var( 'category_name' ) ) ? 'checked' : '',
				),
			);

			// タームの選択肢.
			foreach ( $taxonomy_terms as $taxonomy_term ) {
				$taxonomy_option_array[] = array(
					'label'    => $taxonomy_term->name,
					'value'    => $taxonomy_term->slug,
					'selected' => in_array( $taxonomy_term->slug, $category_slug, true ) ? 'selected' : '',
					'checked'  => in_array( $taxonomy_term->slug, $category_slug, true ) ? 'checked' : '',
				);
			}
		} elseif ( 'post_tag' === $taxonomy ) {

			// フォームの名前.
			$taxonomy_name = 'vkfs_post_tag[]';

			// クエリの処理.
			$tag_slug    = array();
			$query_array = array();
			if ( ! empty( get_query_var( 'tag__in' ) ) ) {
				$query_array = get_query_var( 'tag__in' );
			} elseif ( ! empty( get_query_var( 'tag__and' ) ) ) {
				$query_array = get_query_var( 'tag__and' );
			}
			if ( ! empty( $query_array ) ) {
				foreach ( $query_array as $query ) {
					$tag_object = get_term_by( 'id', $query, 'post_tag' );
					$tag_slug[] = $tag_object->slug;
				}
			} else {
				$tag_slug[] = get_query_var( 'tag' );
			}

			// 追加の選択肢.
			$default_option_array = array(
				array(
					// translators: Don't specify Term.
					'label'    => sprintf( __( 'Do not specify a %s', 'vk-filter-search' ), $label ),
					'value'    => '',
					'selected' => ( '' === get_query_var( 'tag' ) ) ? 'selected' : '',
					'checked'  => ( '' === get_query_var( 'tag' ) ) ? 'checked' : '',
				),
			);

			// タームの選択肢.
			foreach ( $taxonomy_terms as $taxonomy_term ) {
				$taxonomy_option_array[] = array(
					'label'    => $taxonomy_term->name,
					'value'    => $taxonomy_term->slug,
					'selected' => in_array( $taxonomy_term->slug, $tag_slug, true ) ? 'selected' : '',
					'checked'  => in_array( $taxonomy_term->slug, $tag_slug, true ) ? 'checked' : '',
				);
			}
		} else {

			// フォームの名前.
			$taxonomy_name = 'vkfs_' . $taxonomy_object->name . '[]';

			// クエリの処理.
			$term_slug   = array();
			$query_array = ! empty( get_query_var( 'tax_query' ) ) ? get_query_var( 'tax_query' ) : array();

			// 追加の選択肢.
			$default_option_array = array(
				array(
					// translators: Don't specify Term.
					'label'    => sprintf( __( 'Do not specify a %s', 'vk-filter-search' ), $label ),
					'value'    => '',
					'selected' => ( '' === get_query_var( $taxonomy_object->name ) ) ? 'selected' : '',
					'checked'  => ( '' === get_query_var( $taxonomy_object->name ) ) ? 'checked' : '',
				),
			);

			// タームの選択肢.
			foreach ( $taxonomy_terms as $taxonomy_term ) {
				$taxonomy_option_array[] = array(
					'label'    => $taxonomy_term->name,
					'value'    => $taxonomy_term->slug,
					'selected' => ( false !== strpos( urldecode( get_query_var( $taxonomy_object->name ) ), urldecode( $taxonomy_term->slug ) ) ) ? 'selected' : '',
					'checked'  => ( false !== strpos( urldecode( get_query_var( $taxonomy_object->name ) ), urldecode( $taxonomy_term->slug ) ) ) ? 'checked' : '',
				);
			}
		}

		// デザインに応じて HTML を描画.
		if ( 'select' === $form_design ) {

			// 配列を統合.
			$taxonomy_option_array = array_merge( $default_option_array, $taxonomy_option_array );

			// 描画開始.
			$taxonomy_design_html .= '<select class="vkfs__taxonomy-select" name="' . $taxonomy_name . '" id="' . $taxonomy_name . '">';

			// 項目のループ.
			foreach ( $taxonomy_option_array as $taxonomy_option ) {
				$taxonomy_design_html .= '<option value="' . $taxonomy_option['value'] . '" ' . $taxonomy_option['selected'] . '>' . $taxonomy_option['label'] . '</option>';
			}

			$taxonomy_design_html .= '</select>';

		}
		return apply_filters( 'vk_search_filter_taxonomy_design_html', $taxonomy_design_html, $taxonomy, $label, $form_design );

	}

	/**
	 * Get Header
	 */
	public static function get_header() {
		$url          = '/';
		$has_question = false;
		if ( isset( $_GET['vkfs_submitted'] ) ) {
			// 投稿タイプの処理.
			if ( isset( $_GET['vkfs_post_type'] ) ) {

				// 配列を取得.
				$the_post_types = wp_unslash( $_GET['vkfs_post_type'] );

				// 配列を操作.
				$post_type_array = array();
				if ( is_array( $the_post_types ) ) {
					foreach ( $the_post_types as $the_post_type ) {
						$post_type_array[] = sanitize_text_field( urldecode( $the_post_type ) );
					}
				} elseif ( empty( $the_post_types ) ) {
					$post_type_array[] = 'any';
				} else {
					$post_type_array[] = sanitize_text_field( urldecode( $the_post_types ) );
				}

				// 配列を文字列に変換.
				if ( 0 < count( $post_type_array ) ) {
					$post_type = implode( ',', $post_type_array );
				}

				// ? か & を追加.
				if ( false === $has_question ) {
					$url         .= '?';
					$has_question = true;
				} else {
					$url .= '&';
				}

				// 値を追加.
				$url .= 'post_type=' . $post_type;
			}

			// カテゴリーの処理.
			if ( isset( $_GET['vkfs_category'] ) ) {

				// 要素を取得.
				$the_categories    = wp_unslash( $_GET['vkfs_category'] );
				$category_operator = isset( $_GET['vkfs_category_operator'] ) ? wp_unslash( $_GET['vkfs_category_operator'] ) : 'or';

				// 配列を操作.
				$category_array = array();
				if ( is_array( $the_categories ) ) {
					foreach ( $the_categories as $the_category ) {
						$category_array[] = sanitize_text_field( urldecode( $the_category ) );
					}
				} elseif ( empty( $the_categories ) ) {
					$category_array[] = '';
				} else {
					$category_array[] = sanitize_text_field( urldecode( $the_categories ) );
				}

				// 配列を文字列に変換.
				if ( 0 < count( $category_array ) ) {
					if ( 'and' === $category_operator ) {
						$category = implode( '+', $category_array );
					} else {
						$category = implode( ',', $category_array );
					}
				}

				// ? か & を追加.
				if ( false === $has_question ) {
					$url         .= '?';
					$has_question = true;
				} else {
					$url .= '&';
				}

				// 値を追加.
				$url .= 'category_name=' . $category;
			}

			// タグの処理.
			if ( isset( $_GET['vkfs_post_tag'] ) ) {

				// 配列を取得.
				$the_tags     = wp_unslash( $_GET['vkfs_post_tag'] );
				$tag_operator = isset( $_GET['vkfs_post_tag_operator'] ) ? wp_unslash( $_GET['vkfs_post_tag_operator'] ) : 'or';

				// 配列を操作.
				$tag_array = array();
				if ( is_array( $the_tags ) ) {
					foreach ( $the_tags as $the_tag ) {
						$tag_array[] = sanitize_text_field( urldecode( $the_tag ) );
					}
				} elseif ( empty( $the_tags ) ) {
					$tag_array[] = '';
				} else {
					$tag_array[] = sanitize_text_field( urldecode( $the_tags ) );
				}

				// 配列を文字列に変換.
				if ( 0 < count( $tag_array ) ) {
					if ( 'and' === $tag_operator ) {
						$tag = implode( '+', $tag_array );
					} else {
						$tag = implode( ',', $tag_array );
					}
				}

				// ? か & を追加.
				if ( false === $has_question ) {
					$url         .= '?';
					$has_question = true;
				} else {
					$url .= '&';
				}

				// 値を追加.
				$url .= 'tag=' . $tag;
			}

			// カスタム分類の取得.
			$get_taxonomies = get_taxonomies(
				array(
					'public'   => true,
					'_builtin' => false,
				),
				'names',
				'and',
			);

			foreach ( $get_taxonomies as $get_taxonomy ) {
				if ( isset( $_GET[ 'vkfs_' . $get_taxonomy ] ) ) {

					// 配列を取得.
					$the_taxonomies    = wp_unslash( $_GET[ 'vkfs_' . $get_taxonomy ] );
					$taxonomy_operator = isset( $_GET[ 'vkfs_' . $get_taxonomy . '_operator' ] ) ? wp_unslash( $_GET[ 'vkfs_' . $get_taxonomy . '_operator' ] ) : 'or';

					// 配列を操作.
					$taxonomy_array = array();
					if ( is_array( $the_taxonomies ) ) {
						foreach ( $the_taxonomies as $the_taxonomy ) {
							$taxonomy_array[] = sanitize_text_field( urldecode( $the_taxonomy ) );
						}
					} elseif ( empty( $the_taxonomies ) ) {
						$taxonomy_array[] = '';
					} else {
						$taxonomy_array[] = sanitize_text_field( urldecode( $the_taxonomies ) );
					}

					// 配列を文字列に変換.
					if ( 0 < count( $taxonomy_array ) ) {
						if ( 'and' === $taxonomy_operator ) {
							$taxonomy = implode( '+', $taxonomy_array );
						} else {
							$taxonomy = implode( ',', $taxonomy_array );
						}
					}

					// ? か & を追加.
					if ( false === $has_question ) {
						$url         .= '?';
						$has_question = true;
					} else {
						$url .= '&';
					}

					// 値を追加.
					$url .= $get_taxonomy . '=' . $taxonomy;
				}
			}

			// キーワードの処理.
			if ( isset( $_GET['s'] ) ) {
				$keyword = sanitize_text_field( wp_unslash( $_GET['s'] ) );

				// ? か & を追加.
				if ( false === $has_question ) {
					$url         .= '?';
					$has_question = true;
				} else {
					$url .= '&';
				}

				// 値を追加.
				$url .= 's=' . $keyword;
			}

			// 呼び出し元パラメーターの処理.
			if ( isset( $_GET['vkfs_form_id'] ) ) {
				$vkfs_form_id = sanitize_text_field( wp_unslash( $_GET['vkfs_form_id'] ) );

				// ? か & を追加.
				if ( false === $has_question ) {
					$url         .= '?';
					$has_question = true;
				} else {
					$url .= '&';
				}

				// 値を追加.
				$url .= 'vkfs_form_id=' . $vkfs_form_id;
			}

			wp_safe_redirect( home_url() . $url );
			exit;
		}
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
				if ( false !== strpos( $post_types, ',' ) ) {
					$query->set( 'post_type', explode( ',', $post_types ) );
				} else {
					$query->set( 'post_type', $post_types );
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
	 * Register Post Type
	 */
	public static function register_post_types() {
		global $vkfs_prefix;
		register_post_type(
			'vk-filter-search',
			array(
				'label'        => $vkfs_prefix . __( 'Filter Search', 'vk-filter-search' ),
				'public'       => false,
				'show_ui'      => true,
				'show_in_menu' => true,
				'has_archive'  => false,
				'menu_icon'    => 'dashicons-screenoptions',
				'show_in_rest' => true,
				'supports'     => array( 'title', 'editor' ),
			)
		);
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
	 * Display Search Form on Loop
	 */
	public static function display_form_on_loop() {
		if ( isset( $_GET['vkfs_form_id'] ) ) {
			$form_id = intval( sanitize_text_field( wp_unslash( $_GET['vkfs_form_id'] ) ) );

			$block_content = get_post( $form_id )->post_content;
			if ( has_block( 'vk-filter-search/filter-search', $block_content ) && ! has_block( 'vk-filter-search/keyword-search', $block_content ) ) {
				$block_content = str_replace( '[no_keyword_hidden_input]', '<input type="hidden" name="s" value="" />', $block_content );
			} else {
				$block_content = str_replace( '[no_keyword_hidden_input]', '', $block_content );
			}
			$content_html = apply_filters( 'vkfs_form_content', $block_content );
			$allowed_html = array(
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
			);
			if ( is_search() && ! self::is_widget_area() ) {
				echo wp_kses( $content_html, $allowed_html );
			}
		}
	}
}
new VK_Filter_Search();
