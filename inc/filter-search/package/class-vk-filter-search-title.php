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
			if ( ! empty( $post_type_value ) && $post_type_value !== 'any' ) {

				// 演算子を初期化
				$operator = $search_title_args['query_element_or'];

				// 一旦配列に統一
				if ( ! is_array( $post_type_value ) ) {
					$post_type_value = array( $post_type_value );
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
				} else {

					// タクソノミーの ID の配列を初期化
					$taxnomy_value = array();
					// 演算子を初期化
					$operator = $search_title_args['query_element_or'];

					// タクソノミーの 配列を取得
					if ( ! empty( get_query_var( $taxonomy ) ) ) {
						$taxnomy_value = get_query_var( $taxonomy );
						if ( strpos( $taxnomy_value, '+' ) !== false ) {
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
				}
			}

			return $search_title;
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
			if ( ! is_search() ) {
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

			if ( ! is_search() ) {
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
