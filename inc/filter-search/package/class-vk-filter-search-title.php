<?php
/**
 * VK Fiter Search Title
 *
 * @package VK Filter Search Title
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'VK_Filter_Search_Title' ) ) {
	/**
	 * VK Fiter Search Title
	 */
	class VK_Filter_Search_Title {

		public function __construct() {
			add_filter( 'pre_get_document_title', array( __CLASS__, 'get_search_title_filter' ), 12 );
		}

		/**
		 * デフォルトの区切り文字などの設定を取得
		 */
		public static function get_default_search_title_args() {
			$search_title_args = array(
				'queries_format'          => __( 'Search Result for %s', 'vk-filter-search' ),
				'query_title_display'     => 'display',
				'query_title_after'       => ': ',
				'query_element_or'        => ' or ',
				'query_element_and'       => ' and ',
				'query_element_before'    => '"',
				'query_element_after'     => '"',
				'query_elements_after'    => ' | ',
				/* translators: %s: taxonomy label (e.g. "Categories") */
				'query_exclude_format'    => __( 'Exclude %s', 'vk-filter-search' ),
				'query_exclude_separator' => ', ',
				'query_date_min_format'   => __( 'From %s', 'vk-filter-search' ),
				'query_date_max_format'   => __( 'To %s', 'vk-filter-search' ),
				'query_date_range_format' => __( 'From %1$s to %2$s', 'vk-filter-search' ),
				'queries_after'           => ' | ' . get_bloginfo( 'name' ),
			);
			return apply_filters( 'vkfs_default_search_title_args', $search_title_args );
		}
		/**
		 * 区切り文字などの設定を取得
		 *
		 * @param array $search_title_args 区切り文字など設定項目の配列
		 * @return array
		 */
		public static function get_search_title_args( $search_title_args = array() ) {
			// タイトル以外の任意の位置に表示するために VK_Filter_Search_Title::get_search_title( $search_title_args ) を配置した場合、
			// この中にフィルターがあって改変できるようにしてしまうと、指定した引数が上書きされて効かなくなってしまうのでここではフィルターを使わない。
			return wp_parse_args( $search_title_args, self::get_default_search_title_args() );
		}

		/**
		 * 投稿タイプの検索タイトルを取得
		 *
		 * @param array $search_title_args 区切り文字など設定項目の配列
		 * @return string
		 */
		public static function get_post_type_search_title( $search_title_args ) {

			// タイトルを初期化
			$search_title = '';
			// 投稿タイプを取得
			$post_type_value = get_query_var( 'post_type' );
			if ( empty( $post_type_value ) || 'any' === $post_type_value ) {
				$post_type_value = VK_Filter_Search::get_request_keys( 'vkfs_post_type' );
			}
			if ( empty( $post_type_value ) || 'any' === $post_type_value ) {
				$post_type_value = VK_Filter_Search::get_request_keys( 'post_type' );
			}
			if ( ! empty( $post_type_value ) && 'any' !== $post_type_value ) {

				// 演算子を初期化
				$operator = $search_title_args['query_element_or'];

				// 一旦配列に統一
				if ( ! is_array( $post_type_value ) ) {
					$post_type_value = array( $post_type_value );
				}

				$post_type_value = array_filter(
					$post_type_value,
					function( $post_type ) {
						return 'any' !== $post_type;
					}
				);

				if ( empty( $post_type_value ) ) {
					return '';
				}

				// 投稿タイプのラベルの配列を作成
				$post_types       = get_post_types(
					array(
						'public'   => true,
					),
					'names'
				);
				foreach ( $post_types as $post_type ) {
					$post_type_object               = get_post_type_object( $post_type );
					$post_type_labels[ $post_type ] = $post_type_object->labels->singular_name;
				}

				$count = 0;

				// query_title_display が display の場合はクエリタイトルを表示
				if ( 'display' === $search_title_args['query_title_display'] ) {
					$search_title .= __( 'Post Type', 'vk-filter-search' ) . $search_title_args['query_title_after'];
				}

				foreach ( $post_type_value as $post_type ) {
					$search_title .= $search_title_args['query_element_before'];
					$search_title .= $post_type_labels[ $post_type ];
					$search_title .= $search_title_args['query_element_after'];
					if ( $count < count( $post_type_value ) - 1 ) {
						$search_title .= $operator;
					}
					++$count;
				}
				$search_title .= $search_title_args['query_elements_after'];
				
			}
			return $search_title;
		}

		/**
		 * タクソノミーの検索タイトルを取得
		 *
		 * @param array $search_title_args 区切り文字など設定項目の配列
		 * @return string
		 */
		public static function get_taxonomy_search_title( $search_title_args ) {

			// タイトルを初期化
			$search_title = '';

			// 追加されたタクソノミーの取得
			$tax_args   = array(
				'public'   => true,
				'_builtin' => false,
			);
			$taxonomies = get_taxonomies( $tax_args, 'names' );

			// タクソノミーの配列を作成
			$taxonomy_array = array(
				'category_name',
				'tag',
			);

			// タクソノミーのラベルの配列を作成
			$taxonomy_label_array = array(
				'category_name' => get_taxonomy('category')->label,
				'tag'           => get_taxonomy('post_tag')->label,
			);
			foreach ( $taxonomies as $taxonomy ) {
				$taxonomy_array[]                  = $taxonomy;
				$taxonomy_label_array[ $taxonomy ] = get_taxonomy( $taxonomy )->labels->singular_name;
			}



			foreach ( $taxonomy_array as $taxonomy ) {
				if ( 'category_name' === $taxonomy ) {

					// カテゴリの ID の配列を初期化
					$taxnomy_value = array();

					// 演算子を初期化
					$operator = $search_title_args['query_element_or'];

					// カテゴリ ID の配列を取得
					if ( ! empty( get_query_var( 'category__and' ) ) ) {
						$taxnomy_value = get_query_var( 'category__and' );
						$operator      = $search_title_args['query_element_and'];
					} elseif ( ! empty( get_query_var( 'category__in' ) ) ) {
						$taxnomy_value = get_query_var( 'category__in' );
						$operator      = $search_title_args['query_element_or'];
					} elseif ( ! empty( get_query_var( 'category_name' ) ) && ! empty( get_category_by_slug( get_query_var( 'category_name' ) ) ) ) {
						$taxnomy_value = array( get_category_by_slug( get_query_var( 'category_name' ) )->term_id );
						$operator      = $search_title_args['query_element_or'];
					}

					// カテゴリのタイトルを作成
					if ( ! empty( $taxnomy_value ) ) {

						// query_title_display が display の場合はクエリタイトルを表示
						if ( 'display' === $search_title_args['query_title_display'] ) {
							$search_title .= get_taxonomy('category')->label . $search_title_args['query_title_after'];
						}

						$count = 0;
						foreach ( $taxnomy_value as $category_id ) {
							if ( ! empty( get_term_by( 'id', $category_id, 'category' ) ) ) {
								$search_title .= $search_title_args['query_element_before'];
								$search_title .= get_term_by( 'id', $category_id, 'category' )->name;
								$search_title .= $search_title_args['query_element_after'];
								if ( $count < count( $taxnomy_value ) - 1 ) {
									$search_title .= $operator;
								}
							}
							++$count;
						}
						$search_title .= $search_title_args['query_elements_after'];
					}

					// 除外カテゴリのタイトルを作成（$_GET から直接読み取る）
					$exclude_title = self::get_exclude_terms_title_by_slugs(
						VK_Filter_Search::get_request_terms( 'category_name_not' ),
						'category',
						get_taxonomy( 'category' )->label,
						$search_title_args
					);
					if ( '' !== $exclude_title ) {
						$search_title .= $exclude_title;
					}

				} elseif ( 'tag' === $taxonomy ) {

					// タグのの配列を初期化
					$taxnomy_value = array();

					// 演算子を初期化
					$operator = $search_title_args['query_element_or'];

					// タグの配列を取得
					if ( ! empty( get_query_var( 'tag_slug__and' ) ) ) {
						$taxnomy_value = get_query_var( 'tag_slug__and' );
						$operator      = $search_title_args['query_element_and'];
					} elseif ( ! empty( get_query_var( 'tag_slug__in' ) ) ) {
						$taxnomy_value = get_query_var( 'tag_slug__in' );
						$operator      = $search_title_args['query_element_or'];
					} elseif ( ! empty( get_query_var( 'tag' ) ) ) {
						$taxnomy_value = array( get_query_var( 'tag' ) );
					}

					// タグのタイトルを作成
					if ( ! empty( $taxnomy_value ) ) {

						// query_title_display が display の場合はクエリタイトルを表示
						if ( 'display' === $search_title_args['query_title_display'] ) {
							$search_title .= get_taxonomy( 'post_tag' )->label . $search_title_args['query_title_after'];
						}

						$count = 0;
						foreach ( $taxnomy_value as $tag ) {
							if ( ! empty( get_term_by( 'slug', $tag, 'post_tag' ) ) ) {
								$search_title .= $search_title_args['query_element_before'];
								$search_title .= get_term_by( 'slug', $tag, 'post_tag' )->name;
								$search_title .= $search_title_args['query_element_after'];
								if ( $count < count( $taxnomy_value ) - 1 ) {
												$search_title .= $operator;
								}
							}
							++$count;
						}
						$search_title .= $search_title_args['query_elements_after'];
					}

					// 除外タグのタイトルを作成（$_GET から直接読み取る）
					$exclude_title = self::get_exclude_terms_title_by_slugs(
						VK_Filter_Search::get_request_terms( 'tag_not' ),
						'post_tag',
						get_taxonomy( 'post_tag' )->label,
						$search_title_args
					);
					if ( '' !== $exclude_title ) {
						$search_title .= $exclude_title;
					}

				} else {

					// タクソノミーの ID の配列を初期化
					$taxnomy_value = array();
					// 演算子を初期化
					$operator = $search_title_args['query_element_or'];

					// タクソノミーの 配列を取得
					if ( ! empty( get_query_var( $taxonomy ) ) ) {
						$taxnomy_value = get_query_var( $taxonomy );
						// get_query_var() は配列を返す場合があるため、is_array() でチェックする。
						// PHP 8以降では strpos() の第1引数に配列を渡すと TypeError が発生するため、
						// 配列の場合は strpos() を呼び出さずにそのまま使用する。
						if ( is_array( $taxnomy_value ) ) {
							$operator = $search_title_args['query_element_or'];
						} elseif ( strpos( $taxnomy_value, '+' ) !== false ) {
							$taxnomy_value = explode( '+', $taxnomy_value );
							$operator      = $search_title_args['query_element_and'];
						} elseif ( strpos( $taxnomy_value, ',' ) !== false ) {
							$taxnomy_value = explode( ',', $taxnomy_value );
							$operator      = $search_title_args['query_element_or'];
						} else {
							$taxnomy_value = array( $taxnomy_value );
							$operator      = $search_title_args['query_element_or'];
						}
					}

					// タクソノミーのタイトルを作成
					if ( ! empty( $taxnomy_value ) ) {

						// query_title_display が display の場合はクエリタイトルを表示
						if ( 'display' === $search_title_args['query_title_display'] ) {
							$search_title .= $taxonomy_label_array[ $taxonomy ] . $search_title_args['query_title_after'];
						}

						$count         = 0;
						foreach ( $taxnomy_value as $term_slug ) {
							if ( ! empty( get_term_by( 'slug', $term_slug, $taxonomy ) ) ) {
								$search_title .= $search_title_args['query_element_before'];
								$search_title .= get_term_by( 'slug', $term_slug, $taxonomy )->name;
								$search_title .= $search_title_args['query_element_after'];
								if ( $count < count( $taxnomy_value ) - 1 ) {
									$search_title .= $operator;
								}
							}
							++$count;
						}
						$search_title .= $search_title_args['query_elements_after'];
					}

					// 除外カスタムタクソノミーのタイトルを作成
					$exclude_title = self::get_exclude_terms_title_by_slugs(
						VK_Filter_Search::get_request_terms( $taxonomy . '_not' ),
						$taxonomy,
						$taxonomy_label_array[ $taxonomy ],
						$search_title_args
					);
					if ( '' !== $exclude_title ) {
						$search_title .= $exclude_title;
					}
				}
			}

			return $search_title;
		}

		/**
		 * 除外ターム（スラッグ指定）のタイトル文字列を生成する。
		 *
		 * カスタムタクソノミーなど、除外条件がスラッグの配列で渡されるタクソノミー用。
		 *
		 * @param array  $term_slugs        除外タームスラッグの配列。
		 * @param string $taxonomy_slug     タクソノミーのスラッグ。
		 * @param string $taxonomy_label    タクソノミーの表示ラベル。
		 * @param array  $search_title_args 区切り文字など設定項目の配列。
		 * @return string 除外タイトル文字列。除外タームがない場合は空文字。
		 */
		public static function get_exclude_terms_title_by_slugs( $term_slugs, $taxonomy_slug, $taxonomy_label, $search_title_args ) {
			if ( empty( $term_slugs ) || ! is_array( $term_slugs ) ) {
				return '';
			}

			// ターム名の一覧を作成
			$term_names = array();
			foreach ( $term_slugs as $term_slug ) {
				$term = get_term_by( 'slug', $term_slug, $taxonomy_slug );
				if ( ! empty( $term ) ) {
					$term_names[] = $search_title_args['query_element_before'] . $term->name . $search_title_args['query_element_after'];
				}
			}

			if ( empty( $term_names ) ) {
				return '';
			}

			return self::build_exclude_title( $term_names, $taxonomy_label, $search_title_args );
		}

		/**
		 * 除外タイトル文字列を組み立てる。
		 *
		 * @param array  $term_names        装飾済みターム名の配列。
		 * @param string $taxonomy_label    タクソノミーの表示ラベル。
		 * @param array  $search_title_args 区切り文字など設定項目の配列。
		 * @return string 除外タイトル文字列。
		 */
		public static function build_exclude_title( $term_names, $taxonomy_label, $search_title_args ) {
			$title = '';

			// query_title_display が display の場合は「除外{タクソノミーラベル}」を表示
			if ( 'display' === $search_title_args['query_title_display'] ) {
				$exclude_label = sprintf( $search_title_args['query_exclude_format'], $taxonomy_label );
				$title        .= $exclude_label . $search_title_args['query_title_after'];
			}

			// ターム名をカンマ区切りで結合
			$title .= implode( $search_title_args['query_exclude_separator'], $term_names );
			$title .= $search_title_args['query_elements_after'];

			return $title;
		}

		/**
		 * キーワードの検索タイトルを取得
		 *
		 * @param array $search_title_args 区切り文字など設定項目の配列
		 * @return string
		 */
		public static function get_keyword_search_title( $search_title_args ) {

			// タイトルを初期化
			$search_title = '';

			// キーワードの配列を初期化
			$keyword_array = array();

			// 演算子を初期化
			$operator = $search_title_args['query_element_or'];

			// キーワードの配列を取得
			$keyword_value = get_query_var( 's' );

			if ( empty( $keyword_value ) ) {
				$keyword_value = VK_Filter_Search::get_request_param( 'keyword' );
			}

			if ( empty( $keyword_value ) ) {
				$keyword_value = VK_Filter_Search::get_request_param( 's' );
			}

			if ( ! empty( $keyword_value ) ) {
				if ( strpos( $keyword_value, ' ' ) !== false ) {
					$keyword_array = explode( ' ', $keyword_value );
					$operator      = $search_title_args['query_element_and'];
				} elseif ( strpos( $keyword_value, ',' ) !== false ) {
					$keyword_array = explode( ',', $keyword_value );
					$operator      = $search_title_args['query_element_or'];
				} else {
					$keyword_array = array( $keyword_value );
					$operator      = $search_title_args['query_element_or'];
				}
			}

			// キーワードのタイトルを作成
			if ( ! empty( $keyword_array ) ) {
				// query_title_display が display の場合はクエリタイトルを表示
				if ( 'display' === $search_title_args['query_title_display'] ) {
					$search_title .= __( 'Keyword', 'vk-filter-search' ) . $search_title_args['query_title_after'];
				}
				$count = 0;
				foreach ( $keyword_array as $keyword ) {
					$search_title .= $search_title_args['query_element_before'];
					$search_title .= urldecode( $keyword );
					$search_title .= $search_title_args['query_element_after'];
					if ( $count < count( $keyword_array ) - 1 ) {
						$search_title .= $operator;
					}
					++$count;
				}
				$search_title .= $search_title_args['query_elements_after'];
			}
			return $search_title;
		}

		/**
		 * タイトルのフィルター処理
		 *
		 * @param string $title タイトル : フィルターで落ちてくるタイトル。ExUnit などで指定したものが落ちてくる事がある。
		 * @return string
		 */
		public static function get_search_title_filter( $title ){
			if ( ! VK_Filter_Search::has_search_query() ) {
				// 検索結果ページ以外はそのまま返す
				return $title;
			} else {
				return self::get_search_title();
			}
		}

		/**
		 * 検索タイトルを取得
		 *
		 * @param array|string $search_title_args 区切り文字など設定項目の配列
		 * ただし、pre_get_document_title のフィルターで文字列が入ってくる事がある。
		 * 配列であれ文字列であれ self::get_search_title_args() に渡して処理して上書きする。
		 * @return string
		 */
		public static function get_search_title( $search_title_args = array() ) {

			if ( ! VK_Filter_Search::has_search_query() ) {
				// 検索結果ページ以外は '' を返す
				return '';
			}

			// 区切り文字の取得
			$search_title_args = self::get_search_title_args( $search_title_args );

			// クエリ内容を作成
			$queries  = self::get_post_type_search_title( $search_title_args );
			$queries .= self::get_taxonomy_search_title( $search_title_args );

			// プロ版で日付などの要素を追加した内容で入れ替えるためフィルターフック
			$queries = apply_filters( 'vkfs_search_title', $queries, $search_title_args );

			$queries .= self::get_keyword_search_title( $search_title_args );

			// クエリ内容末尾の query_elements_after を削除
			$queries = rtrim( $queries, $search_title_args['query_elements_after'] );

			// 検索結果のクエリ関連文字列
			$search_result_title = sprintf( $search_title_args['queries_format'], $queries );

			// 検索結果のクエリ関連文字列の末尾にサイト名を追加
			$search_result_title .= $search_title_args['queries_after'];

			// タイトル以外に表示する場合用に装飾のためのタグを許可
			$allowed_html = array(
				'span' => array(
					'class' => array(),
				),
			);

			return wp_kses( $search_result_title, $allowed_html );
		}
	}
	new VK_Filter_Search_Title();
}
