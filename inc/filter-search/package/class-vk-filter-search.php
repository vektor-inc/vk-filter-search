<?php
/**
 * VK Fiter Search
 *
 * @package VK Filter Search
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once __DIR__ . '/class-vk-filter-search-form-display-settings.php';
require_once __DIR__ . '/class-vk-filter-search-html-id.php';

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
			// Fallback for theme editor (use enqueue_block_assets so styles load correctly in block editor iframe)
			add_action( 'enqueue_block_assets', array( __CLASS__, 'enqueue_style_on_theme_editor' ) );
		}

		/**
		 * Get Search Root URL
		 */
		public static function get_search_root_url() {
			$search_root_url = apply_filters( 'vkfs_search_root_url', home_url( '/' ) );
			return esc_url( $search_root_url );
		}

		/**
		 * Determine whether the current request contains filter search parameters.
		 *
		 * @return bool
		 */
		public static function has_search_query() {
			if ( is_search() ) {
				return true;
			}

			if ( ! empty( $_GET['vkfs_form_id'] ) || ! empty( $_GET['keyword'] ) || ! empty( $_GET['vkfs_post_type'] ) || ! empty( $_GET['post_type'] ) ) {
				return true;
			}

			// 除外パラメータのみの場合も検索クエリとして検知する。
			if ( ! empty( $_GET['category_name_not'] ) || ! empty( $_GET['tag_not'] ) ) {
				return true;
			}

			// カスタムタクソノミーの除外パラメータを検知する。
			$taxonomies = get_taxonomies(
				array(
					'public'   => true,
					'_builtin' => false,
				),
				'objects'
			);
			foreach ( $taxonomies as $taxonomy_slug => $taxonomy_object ) {
				$query_var = $taxonomy_object->query_var ? $taxonomy_object->query_var : $taxonomy_slug;
				if ( ! empty( $_GET[ $query_var . '_not' ] ) ) {
					return true;
				}
			}

			return false;
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
			if ( ! is_admin() ) {
				return;
			}
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
				// The column min-width style of each block is output as <style type="text/css">.
				// 各ブロックのカラム最小幅のスタイルは <style type="text/css"> として出力される.
				'style'  => array(
					'type' => array(),
				),
				// Allow the same attributes as label_sanitize() so that <br> in labels is kept as is.
				// ラベル内の <br> をそのまま残せるよう label_sanitize() と同じ属性を許可する.
				'br'     => array(
					'class' => array(),
					'style' => array(),
				),
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

		/**
		 * 保存済みのフォームの HTML を出力前に無害化する。
		 *
		 * 検索結果ページ・投稿タイプアーカイブに出す旧版のフォームは、置き場所の投稿に保存されたブロックを描画して出す。
		 * 置き場所の投稿は、設定を承認した編集者以上のほかに作成者も中身を変えられるため、出力の直前に許可リスト（kses_allowed()）で無害化する。
		 *
		 * @param string $form_content 描画したフォームの HTML.
		 * @return string 無害化したフォームの HTML.
		 */
		public static function sanitize_saved_form_content( $form_content ) {
			if ( ! is_string( $form_content ) || '' === $form_content ) {
				return '';
			}

			$form_content = wp_kses( $form_content, self::kses_allowed() );

			// wp_kses converts ">" outside of tags into "&gt;", which breaks the child combinator ">"
			// in the <style> output for the column min-width setting. Any "<" has already been handled
			// by wp_kses, so restoring "&gt;" to ">" only inside <style> cannot form a new tag.
			// wp_kses はタグの外にある > を &gt; に変えるため、カラム最小幅の指定で出力する <style> 内の
			// 子セレクタの > が壊れる。< は wp_kses が処理済みなので、<style> の中だけ &gt; を > に戻しても
			// 新しいタグにはならない.
			$form_content = preg_replace_callback(
				'#(<style\b[^>]*>)(.*?)(?:(</style>)|\z)#is',
				/**
				 * Restore ">" inside a <style> element, and drop the element unless its CSS has the shape this plugin generates.
				 * <style> 要素の中の > を元に戻し、CSS がこのプラグインが生成する形でなければ要素ごと取り除く。
				 *
				 * @param array $matches [ 1 => opening tag, 2 => CSS, 3 => closing tag ( unset if missing ) ]. [ 1 => 開始タグ, 2 => CSS, 3 => 終了タグ（無い場合は未設定） ].
				 * @return string The <style> element, or an empty string. <style> 要素。または空文字.
				 */
				function ( $matches ) {
					if ( empty( $matches[3] ) ) {
						return '';
					}
					$css = str_replace( '&gt;', '>', $matches[2] );
					if ( ! self::is_safe_generated_css( $css ) ) {
						return '';
					}
					return $matches[1] . $css . $matches[3];
				},
				$form_content
			);

			// preg_replace_callback() returns null on a PCRE error, so output nothing in that case ( fail-closed ).
			// preg_replace_callback() は PCRE のエラー時に null を返すため、その場合は何も出力しない（fail-closed）.
			return $form_content ?? '';
		}

		/**
		 * Check that the CSS in a saved <style> element has the shape this plugin generates.
		 * 保存済みの <style> 要素の CSS が、このプラグインが生成する形かを判定する。
		 *
		 * Only rules whose selector starts with .vkfs or .vk-filter-search, of the form "selector { flex-basis / min-width / gap / margin-top : value; }" are accepted.
		 * The selector and the value cannot contain { } ; @ backslash or quotes, so the CSS cannot leave its rule or add at-rules, and only calc / var / min / max / clamp are accepted as functions ( no url / expression ).
		 * 「セレクタ { flex-basis / min-width / gap / margin-top : 値; }」の規則だけを許可する。
		 * セレクタと値には { } ; @ バックスラッシュ・引用符を含められないため規則の外に出られず、@ ルールも足せない。関数は calc / var / min / max / clamp のみ（url / expression は不可）.
		 *
		 * @param string $css CSS. CSS.
		 * @return bool True if the CSS is of the generated shape. 生成される形なら true.
		 */
		public static function is_safe_generated_css( $css ) {
			if ( ! is_string( $css ) || false !== strpos( $css, '/*' ) ) {
				return false;
			}
			$selector = '\.(?:vkfs|vk-filter-search)[A-Za-z0-9_.\-:()\[\]=>\s]*+';
			$value    = '[A-Za-z0-9_.%()+\-*\/,\s]++';
			$decl     = '(?:flex-basis|min-width|gap|margin-top)\s*:' . $value;
			$rule     = $selector . '\{\s*' . $decl . '(?:;\s*' . $decl . ')*+;?\s*\}\s*';
			if ( 1 !== preg_match( '#\A\s*(?:' . $rule . ')++\z#', $css ) ) {
				return false;
			}
			// Functions other than the allowed ones are rejected. 許可した関数以外は不可.
			$count = preg_match_all( '#(?<![A-Za-z0-9_-])([A-Za-z0-9_-]++)\s*\(#', $css, $functions );
			if ( false === $count ) {
				return false;
			}
			foreach ( $functions[1] as $name ) {
				if ( ! in_array( strtolower( $name ), array( 'calc', 'var', 'min', 'max', 'clamp', 'where', 'not' ), true ) ) {
					return false;
				}
			}
			return true;
		}

		/**
		 * Check whether the key ( FormID ) of a saved form can be output.
		 * 保存済みフォームのキー（FormID）が出力してよいものかを判定する。
		 *
		 * A regular FormID is the post ID of the post type VK Filter Search ( digits ) or the clientId of the block ( hexadecimal digits and hyphens ),
		 * so it never contains any of the HTML special characters < > " '. A key containing one of them is treated as crafted and is not output.
		 * 正規の FormID は投稿タイプ VK Filter Search の投稿 ID（数字）かブロックの clientId（16進数とハイフン）で、
		 * HTML の特殊文字 < > " ' を含むことはない。いずれかを含むキーは細工されたものとみなして出力しない。
		 *
		 * @param string|int $form_id Key of the saved form in the option. option に保存されたフォームのキー.
		 * @return bool True if the key contains none of < > " '. < > " ' のいずれも含まなければ true.
		 */
		public static function is_safe_saved_form_id( $form_id ) {
			return false === strpbrk( (string) $form_id, '<>"\'' );
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
			if ( isset( $options['blockId'] ) && self::is_valid_block_id( $options['blockId'] ) ) {
				$outer_classes .= ' vkfs__block-id--' . $options['blockId'];
			}
			return $outer_classes;
		}

		/**
		 * 列の最小幅として出力してよい値かを判定する
		 *
		 * 0 以上の数値と、許可した単位（px / % / em / rem / vw / vh）の組み合わせだけを受け付ける。
		 * エディタのプレビュー（inc/filter-search-pro/package/src/common/column-style-validation.js の isValidColumnWidth）と同じ規則にそろえること。
		 *
		 * @param mixed $width 判定する幅の値.
		 * @return bool 出力してよい形なら true.
		 */
		public static function is_valid_column_width( $width ) {
			if ( ! is_string( $width ) ) {
				return false;
			}
			// D 修飾子が無いと末尾の改行も通るため外さないこと（JS 側の判定とずれる）.
			return 1 === preg_match( '/^(?:\d+(?:\.\d+)?|\.\d+)(?:px|%|em|rem|vw|vh)$/D', $width );
		}

		/**
		 * ブロックの識別子（blockId）として出力してよい値かを判定する
		 *
		 * 英数字・アンダースコア・ハイフンだけで構成された値を受け付ける。
		 *
		 * @param mixed $block_id 判定するブロックの識別子.
		 * @return bool 出力してよい形なら true.
		 */
		public static function is_valid_block_id( $block_id ) {
			if ( ! is_string( $block_id ) ) {
				return false;
			}
			// D 修飾子が無いと末尾の改行も通るため外さないこと.
			return 1 === preg_match( '/^[A-Za-z0-9_-]+$/D', $block_id );
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

			// blockId が出力できない形なら、セレクタを組み立てられないため何も出さない.
			if ( ! isset( $options['blockId'] ) || ! self::is_valid_block_id( $options['blockId'] ) ) {
				return $column_dynamic_style;
			}
			$block_id = $options['blockId'];

			// Outerカラムが最小幅指定の場合はCSSを追加.
			if ( isset( $options['outerColumnWidthMethod'] ) &&
				'minimum' === $options['outerColumnWidthMethod'] &&
				isset( $options['outerColumnWidthMin'] ) &&
				self::is_valid_column_width( $options['outerColumnWidthMin'] )
				) {
				$column_dynamic_style .= "<style type='text/css'>";
				$column_dynamic_style .= '.vk-filter-search.vkfs__layout--min .vkfs__outer-wrap.vkfs__block-id--' . $block_id . '{
					flex-basis:' . $options['outerColumnWidthMin'] . ';
					min-width:' . $options['outerColumnWidthMin'] . ';
				}';
				$column_dynamic_style .= '</style>';
			}

			// インナーブロックで最小幅指定の場合はCSSを追加.
			if ( method_exists( 'VK_Filter_Search_Pro', 'get_inner_column_width_method' ) ) {
				if ( 'minimum' === VK_Filter_Search_Pro::get_inner_column_width_method( $options ) &&
					isset( $options['innerColumnWidthMin'] ) &&
					self::is_valid_column_width( $options['innerColumnWidthMin'] )
				) {
					$column_dynamic_style .= "<style type='text/css'>";
					$column_dynamic_style .= '.vkfs__block-id--' . $block_id . ' > ul.vkfs__input-wrap > li:where(:not(.vkfs__has-children )){
						flex-basis:' . $options['innerColumnWidthMin'] . ';
						min-width:' . $options['innerColumnWidthMin'] . ';
					}';
					$column_dynamic_style .= '</style>';
				}
			}
			return $column_dynamic_style;
		}

		/**
		 * タクソノミー検索で受け付ける検索方式の一覧を取得する
		 *
		 * @return string[] 検索方式（and / or / not / user）の配列.
		 */
		public static function get_allowed_taxonomy_operators() {
			return array( 'and', 'or', 'not', 'user' );
		}

		/**
		 * 子タームのドロップダウンで件数に関わる設定を、真偽値にそろえて取り出す
		 *
		 * 署名の作成と照合で同じ形にそろえるために使う。値の真偽は、描画側（vk_dropdown_categories）の判定と同じく空かどうかで決める.
		 *
		 * @param array $settings show_count / auto_count / hide_empty を含む設定.
		 * @return array{show_count: bool, auto_count: bool, hide_empty: bool} 真偽値にそろえた設定.
		 */
		public static function get_dropdown_count_settings( $settings ) {
			$settings = is_array( $settings ) ? $settings : array();
			return array(
				'show_count' => ! empty( $settings['show_count'] ),
				'auto_count' => ! empty( $settings['auto_count'] ),
				'hide_empty' => ! empty( $settings['hide_empty'] ),
			);
		}

		/**
		 * 子タームのドロップダウンで件数に関わる設定の署名を作る
		 *
		 * サイトの秘密鍵から作る wp_hash() を使うため、画面からは作れない。
		 * 署名に含めるのはタクソノミーと show_count / auto_count / hide_empty だけ.
		 *
		 * @param string $taxonomy タクソノミー名.
		 * @param array  $settings show_count / auto_count / hide_empty を含む設定.
		 * @return string 署名.
		 */
		public static function get_dropdown_count_signature( $taxonomy, $settings ) {
			$count_settings = self::get_dropdown_count_settings( $settings );
			$data           = implode(
				'|',
				array(
					'vkfs_dropdown_count',
					(string) $taxonomy,
					$count_settings['show_count'] ? '1' : '0',
					$count_settings['auto_count'] ? '1' : '0',
					$count_settings['hide_empty'] ? '1' : '0',
				)
			);
			return wp_hash( $data );
		}

		/**
		 * 子タームのドロップダウンで件数に関わる設定の署名を照合する
		 *
		 * @param string $taxonomy  タクソノミー名.
		 * @param array  $settings  show_count / auto_count / hide_empty を含む設定.
		 * @param mixed  $signature 画面から送られた署名.
		 * @return bool 照合できたら true.
		 */
		public static function is_valid_dropdown_count_signature( $taxonomy, $settings, $signature ) {
			if ( ! is_string( $signature ) || '' === $signature ) {
				return false;
			}
			return hash_equals( self::get_dropdown_count_signature( $taxonomy, $settings ), $signature );
		}

		/**
		 * 追加 CSS クラスを、class 属性に出力してよい形にそろえる
		 *
		 * 空白で区切ったクラス名を1つずつ sanitize_html_class() に通し、空になったものを除いて空白でつなぐ。
		 *
		 * @param mixed $class_names 空白区切りのクラス名.
		 * @return string 空白区切りのクラス名（先頭・末尾に空白は付けない）.
		 */
		public static function sanitize_class_names( $class_names ) {
			if ( ! is_string( $class_names ) ) {
				return '';
			}

			$sanitized_classes = array();
			foreach ( preg_split( '/\s+/', $class_names, -1, PREG_SPLIT_NO_EMPTY ) as $class_name ) {
				$sanitized_class = sanitize_html_class( $class_name );
				if ( '' !== $sanitized_class ) {
					$sanitized_classes[] = $sanitized_class;
				}
			}
			return implode( ' ', $sanitized_classes );
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

			$additional_classes = ! empty( $options['class_name'] ) ? self::sanitize_class_names( $options['class_name'] ) : '';
			$outer_classes     .= '' !== $additional_classes ? ' ' . $additional_classes : '';

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
			$additional_classes = ! empty( $options['class_name'] ) ? self::sanitize_class_names( $options['class_name'] ) : '';
			$outer_classes     .= '' !== $additional_classes ? ' ' . $additional_classes : '';

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
				'exclude'               => array(),
			);
			$options = wp_parse_args( $options, $default );

			// 検索方式は hidden の value 属性などにそのまま出力するため、決まった値だけを受け付ける.
			// 検索時の判定は大文字小文字を区別しないため、ショートコードの operator="AND" なども受け付けられるよう小文字にそろえる.
			$options['operator'] = is_string( $options['operator'] ) ? strtolower( $options['operator'] ) : '';
			if ( ! in_array( $options['operator'], self::get_allowed_taxonomy_operators(), true ) ) {
				$options['operator'] = 'or';
			}

			// デザインの調整.
			$form_style_option = self::form_style_option();
			$form_design       = ! empty( $options['form_design'] ) && in_array( $options['form_design'], $form_style_option, true ) ? $options['form_design'] : 'select';

			$outer_classes = '';

			// カラム制御関連クラスの追加.
			$outer_classes .= self::get_outer_column_class( $options );

			// 追加クラスの調整.
			$additional_classes = ! empty( $options['class_name'] ) ? self::sanitize_class_names( $options['class_name'] ) : '';
			$outer_classes     .= '' !== $additional_classes ? ' ' . $additional_classes : '';

			$dropdown_options      = array();
			$data_dropdown_options = '';
			if ( ! empty( $options['enable_child_dropdown'] ) ) {
				$outer_classes   .= ' vkfs__child-dropdown';
				$dropdown_options = array(
					'post_type'  => $options['post_type'],
					'operator'   => $options['operator'],
					'show_count' => $options['show_count'],
					'auto_count' => $options['auto_count'],
					'hide_empty' => $options['hide_empty'],
				);
				// 子タームの AJAX は件数の設定をこの署名と照合してから使う（画面から書き換えた設定を受け付けないため）.
				$dropdown_options['count_signature'] = self::get_dropdown_count_signature( $taxonomy, $dropdown_options );
				$data_dropdown_options               = ' data-vkfs-dropdown-options="' . esc_html( wp_json_encode( $dropdown_options, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT ) ) . '"';
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
				if ( 'user' !== $options['operator'] && 'not' !== $options['operator'] ) {
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
				'exclude'            => array(),
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
				'exclude'           => ! empty( $options['exclude'] ) ? $options['exclude'] : array(),
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
			$taxonomy_design_html = apply_filters( 'vk_search_filter_taxonomy_design_html', $taxonomy_design_html, $taxonomy, $options );

			// 同じタクソノミーの検索フォームを1ページに複数置いたときに id が重複しないよう、2つ目以降に番号を付ける.
			// 差し替え前の HTML で番号を進めないよう、フィルターの後で付けること.
			return VK_Filter_Search_Html_Id::make_wrapper_id_unique( $taxonomy_design_html );
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

			$target_query = $wp_query;
			if ( ! is_search() && self::has_search_query() ) {
				// Build base query vars and then let Query Loop filters add conditions (e.g. custom fields).
				$query_vars   = self::adjust_query_loop_query_vars( array(), array() );
				$target_query = new WP_Query( $query_vars );
			}

			$content = '';

			if ( self::has_search_query() ) {

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
				// esc_attr() to prevent Stored XSS via number_font_size/number_font_style/number_font_weight block attributes (issue #526).
				// number_font_size・number_font_style・number_font_weight ブロック属性経由の Stored XSS を防ぐため esc_attr() を適用（issue #526）.
				if ( ! empty( $number_style ) ) {
					$number_style = ' style="' . esc_attr( $number_style ) . '"';
				}

				// クラスの処理
				// esc_attr() to prevent Stored XSS via the non-HEX number_color block attribute (issue #526).
				// 非HEXの number_color ブロック属性経由の Stored XSS を防ぐため esc_attr() を適用（issue #526）.
				if ( ! empty( $number_class ) ) {
					$number_class = ' class="' . esc_attr( $number_class ) . '"';
				}

				if ( ! empty( $options['outer'] ) ) {
					$content .= '<div class="vkfs__search-result-count">';
				}

				// Allow span class / style and bare strong / em for decoration (same policy as the title block's get_search_title()).
				// wp_kses strips <script>, event-handler attributes and javascript:, and style is filtered by safecss_filter_attr, preventing Stored XSS (issue #526).
				// 装飾用に span は class / style を、strong / em は裸のタグとして許可（title ブロックの get_search_title() と同方針）。
				// wp_kses が <script>・イベントハンドラ属性・javascript: 等を除去し、style は safecss_filter_attr でフィルタされるため Stored XSS を防ぐ（issue #526）.
				$allowed_html = array(
					'span'   => array(
						'class' => array(),
						'style' => array(),
					),
					'strong' => array(),
					'em'     => array(),
				);
				$content .= wp_kses( $options['before_text'], $allowed_html );
				$content .= ' <span' . $number_style . $number_class . '>' . $target_query->found_posts . '</span> ';
				$content .= wp_kses( $options['after_text'], $allowed_html );

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
						// Use only the post types allowed for the search (if none remain, post_type is not set).
						// 検索対象にしてよい種類だけを使う（残りが無ければ post_type は設定しない）.
						$allowed_post_types = self::filter_allowed_post_types( explode( ',', $post_types ) );
						if ( ! empty( $allowed_post_types ) ) {
							$query->set( 'post_type', ( 1 === count( $allowed_post_types ) ) ? reset( $allowed_post_types ) : $allowed_post_types );
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

				// 除外カテゴリー.
				if ( isset( $_GET['category_name_not'] ) ) {
					$terms = sanitize_text_field( wp_unslash( $_GET['category_name_not'] ) );
					$term_array     = array_filter( array_map( 'trim', preg_split( '/[\\s,]+/', $terms ) ) );
					$category_array = self::convert_slugs_to_ids( $term_array, 'category' );
					if ( ! empty( $category_array ) ) {
						$query->set( 'category__not_in', $category_array );
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

				// 除外タグ.
				if ( isset( $_GET['tag_not'] ) ) {
					$terms = sanitize_text_field( wp_unslash( $_GET['tag_not'] ) );
					$term_array = array_filter( array_map( 'trim', preg_split( '/[\\s,]+/', $terms ) ) );
					$tag_array  = self::convert_slugs_to_ids( $term_array, 'post_tag' );
					if ( ! empty( $tag_array ) ) {
						$query->set( 'tag__not_in', $tag_array );
					}
				}

				// その他の公開タクソノミー（カテゴリ・タグを除く）の除外条件.
				$taxonomies = get_taxonomies(
					array(
						'public' => true,
					),
					'objects'
				);
				if ( ! empty( $taxonomies ) ) {
					$tax_query = $query->get( 'tax_query' );
					if ( empty( $tax_query ) || ! is_array( $tax_query ) ) {
						$tax_query = array();
					}
					foreach ( $taxonomies as $taxonomy_slug => $taxonomy_object ) {
						if ( 'category' === $taxonomy_slug || 'post_tag' === $taxonomy_slug ) {
							continue;
						}
						$query_var = $taxonomy_object->query_var ? $taxonomy_object->query_var : $taxonomy_slug;
						$terms     = self::get_request_terms( $query_var . '_not' );
						if ( empty( $terms ) ) {
							continue;
						}
						$tax_query[] = array(
							'taxonomy' => $taxonomy_slug,
							'field'    => 'slug',
							'terms'    => $terms,
							'operator' => 'NOT IN',
						);
					}

					if ( ! empty( $tax_query ) ) {
						if ( ! isset( $tax_query['relation'] ) ) {
							$tax_query = array_merge( array( 'relation' => 'AND' ), $tax_query );
						}
						$query->set( 'tax_query', $tax_query );
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

			// Use only the post types allowed for the search (if none remain, the post_type of the block is kept).
			// 検索対象にしてよい種類だけを使う（残りが無ければ、ブロック側の post_type のまま）.
			$post_types = self::get_request_post_types();
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

			$category_name_not = self::get_request_param( 'category_name_not' );
			if ( '' !== $category_name_not ) {
				$term_array     = array_filter( array_map( 'trim', preg_split( '/[\\s,]+/', $category_name_not ) ) );
				$category_array = self::convert_slugs_to_ids( $term_array, 'category' );
				if ( ! empty( $category_array ) ) {
					$query_vars['category__not_in'] = $category_array;
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

			$tag_not = self::get_request_param( 'tag_not' );
			if ( '' !== $tag_not ) {
				$term_array = array_filter( array_map( 'trim', preg_split( '/[\\s,]+/', $tag_not ) ) );
				$tag_array  = self::convert_slugs_to_ids( $term_array, 'post_tag' );
				if ( ! empty( $tag_array ) ) {
					$query_vars['tag__not_in'] = $tag_array;
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

				foreach ( $taxonomies as $taxonomy_slug => $taxonomy_object ) {
					if ( 'category' === $taxonomy_slug || 'post_tag' === $taxonomy_slug ) {
						continue;
					}
					$query_var = $taxonomy_object->query_var ? $taxonomy_object->query_var : $taxonomy_slug;
					$not_terms = self::get_request_terms( $query_var . '_not' );
					if ( empty( $not_terms ) ) {
						continue;
					}
					$tax_query[] = array(
						'taxonomy' => $taxonomy_slug,
						'field'    => 'slug',
						'terms'    => $not_terms,
						'operator' => 'NOT IN',
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
		public static function get_request_param( $key ) {
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
		public static function get_request_terms( $key ) {
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
		public static function get_request_keys( $key ) {
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
		 * Get the slugs of the post types allowed for the search by the URL.
		 * URL の指定で検索対象にしてよい投稿タイプのスラッグを取得する.
		 *
		 * The targets are public post types (public is true) and post types that may be queried through the URL (publicly_queryable is true).
		 * 一般公開している種類（public が true）と、URL での検索を許している種類（publicly_queryable が true）が対象.
		 * To allow a post type that is not public, use the filter vkfs_allowed_post_types.
		 * 一般公開していない種類を足したい場合は、フィルター vkfs_allowed_post_types を使う.
		 *
		 * @return string[] Post type slugs allowed for the search. 検索対象にしてよい投稿タイプのスラッグの配列.
		 */
		public static function get_allowed_post_types() {
			// Gather the public post types and the post types that may be queried through the URL.
			// 一般公開している種類と、URL での検索を許している種類をまとめる.
			$allowed_post_types = array_values(
				array_unique(
					array_merge(
						array_values( get_post_types( array( 'public' => true ) ) ),
						array_values( get_post_types( array( 'publicly_queryable' => true ) ) )
					)
				)
			);

			/**
			 * Filter that adds or removes the post types allowed for the search by the URL.
			 * URL の指定で検索対象にしてよい投稿タイプを、足したり減らしたりするフィルター.
			 *
			 * @param string[] $allowed_post_types Post type slugs allowed for the search. 検索対象にしてよい投稿タイプのスラッグの配列.
			 */
			$filtered_post_types = apply_filters( 'vkfs_allowed_post_types', $allowed_post_types );

			// If the filter returns something other than an array, use the original list without widening the allowance.
			// フィルターが配列以外を返した場合は、許可を広げずに元の一覧を使う.
			if ( ! is_array( $filtered_post_types ) ) {
				return $allowed_post_types;
			}

			return array_values( array_filter( $filtered_post_types, 'is_string' ) );
		}

		/**
		 * Keep only the post types allowed for the search among those specified in the URL.
		 * URL で指定された投稿タイプから、検索対象にしてよい種類だけを残す.
		 *
		 * Keep 'any' (all types) as it is, and remove the post types that are not allowed.
		 * 'any'（すべての種類）はそのまま残す. 許可されない種類は取り除く.
		 *
		 * @param string[]|string $post_types Post type slug(s) specified in the URL (an array or a single string). URL で指定された投稿タイプのスラッグ（配列または1つの文字列）.
		 * @return string[] Remaining post type slugs (no duplicates, in the specified order). An empty array if none remain. 残った投稿タイプのスラッグの配列（重複なし・指定順）. 残りが無ければ空配列.
		 */
		public static function filter_allowed_post_types( $post_types ) {
			$allowed_post_types = self::get_allowed_post_types();

			// Collect only the allowed ones among the specified post types.
			// 指定された種類のうち、許可されたものだけを集める.
			$result = array();
			foreach ( (array) $post_types as $post_type ) {
				if ( is_string( $post_type ) && ( 'any' === $post_type || in_array( $post_type, $allowed_post_types, true ) ) ) {
					$result[] = $post_type;
				}
			}

			return array_values( array_unique( $result ) );
		}

		/**
		 * Get the slugs of the post types allowed for the search that are specified by vkfs_post_type (or post_type if absent) in the URL.
		 * URL の vkfs_post_type（なければ post_type）で指定された、検索対象にしてよい投稿タイプのスラッグを取得する.
		 *
		 * @return string[] Post type slugs allowed for the search. An empty array if none is specified or none is allowed. 検索対象にしてよい投稿タイプのスラッグの配列. 指定が無い、またはすべて許可されない場合は空配列.
		 */
		public static function get_request_post_types() {
			$post_types = self::filter_allowed_post_types( self::get_request_keys( 'vkfs_post_type' ) );
			if ( empty( $post_types ) ) {
				$post_types = self::filter_allowed_post_types( self::get_request_keys( 'post_type' ) );
			}

			return $post_types;
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
		 * option vk_filter_search を取得する
		 *
		 * 取得だけを行い、書き込みはしない。古い項目の整理は、移行（VK_Filter_Search_Form_Display_Settings::migrate()）と投稿の保存時に行う。
		 *
		 * @return array option の値。未保存・配列でない場合は空配列
		 */
		public static function get_options() {
			$options = get_option( 'vk_filter_search' );
			return is_array( $options ) ? $options : array();
		}

		/**
		 * 旧版のフォームの項目のうち、存在価値がないものを除いた option を返す
		 *
		 * 次のどれかに当たる項目を除く。値を返すだけで、option には書き込まない。
		 * - 項目が配列でない・置いた投稿の ID が無い
		 * - キー（FormID）の形式が正しくない
		 * - 置いた投稿が無い・旧版のフォームを置けない投稿タイプ
		 * - 置いた投稿の本文に、FormID が一致する検索フォームのブロックが無い（parse_blocks() で判定する）
		 *
		 * 置いた投稿の状態（公開・下書きなど）は、表示するときに確かめるためここでは見ない。
		 *
		 * @param array|mixed $options option vk_filter_search の値.
		 * @return array|mixed 整理した option の値。配列でない場合はそのまま返す
		 */
		public static function option_reduction( $options ) {
			if ( ! is_array( $options ) ) {
				return $options;
			}
			foreach ( VK_Filter_Search_Form_Display_Settings::get_legacy_option_keys() as $option_key ) {
				if ( empty( $options[ $option_key ] ) || ! is_array( $options[ $option_key ] ) ) {
					continue;
				}
				// 置いた投稿に、FormID が一致するブロックが無い項目を除く
				foreach ( $options[ $option_key ] as $form_id => $entry ) {
					if ( null === VK_Filter_Search_Form_Display_Settings::find_legacy_form_block( $form_id, $entry ) ) {
						unset( $options[ $option_key ][ $form_id ] );
					}
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
		 * 検索結果ページ・投稿タイプアーカイブに表示するフォームの HTML を返す。
		 *
		 * On the search result page, only forms of the VK Filter Search post type (filter-search) are displayed, and password protected forms are not.
		 * 検索結果ページでは、投稿タイプ VK Filter Search（filter-search）のフォームだけを表示し、パスワード保護されたフォームは表示しない。
		 *
		 * @param bool $force_display_result 検索結果を強制表示するかどうか
		 * @return string 表示するフォームの HTML
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
				if ( self::is_displayable_form_post( $target_post ) ) {
					// 新しいのでフラグを消す

					$old_flag = false;

					// 検索結果に表示するか否かのカスタムフィールドを取得
					$display_result = get_post_meta( $target_post->ID, 'vkfs_display_result', true );

					// 上記カスタムフィールドを処理
					$display_result = ! empty( $display_result ) ? true : false;

					// 上記フィールドが true か強制表示フラグが true ならその投稿を表示
					if ( ! empty( $display_result ) || ! empty( $force_display_result ) ) {
						$content  = str_replace( '[filter_search_result_input]', '<input type="hidden" name="vkfs_form_id" value="' . esc_attr( $target_id ) . '" />', $target_post->post_content );
						$content  = apply_filters( 'filter_search_content', $content );
						$content .= self::form_edit_content( $target_post->ID, $old_flag );
					} else {
						$content = '';
					}
				}

				// 旧版のフォームを表示
				if ( ! empty( $options['display_on_result'] ) && is_array( $options['display_on_result'] ) ) {

					// 古いのでフラグを立てる
					$old_flag = true;

					// ID に該当する情報があり、置き場所の投稿が今も表示してよい状態なら、置き場所の投稿のブロックを描画して表示
					// 置き場所の投稿をパスワード保護・下書きにした後も option は残るため、表示時にも確かめる
					$form         = array_key_exists( $target_id, $options['display_on_result'] ) ? $options['display_on_result'][ $target_id ] : null;
					$form_post_id = VK_Filter_Search_Form_Display_Settings::get_entry_post_id( $form );
					$block        = self::is_displayable_form_source_post( $form_post_id ) ? VK_Filter_Search_Form_Display_Settings::find_legacy_form_block( $target_id, $form ) : null;
					// ブロックの今の設定でも検索結果ページに出す場合だけ表示する
					if ( null !== $block ) {
						$block_settings = VK_Filter_Search_Form_Display_Settings::get_block_display_settings( $block );
						if ( $block_settings['result'] ) {
							// 置き場所の投稿の作成者が編集者未満でも中身を変えられるため、出力の直前に無害化する
							$form_html = self::sanitize_saved_form_content( VK_Filter_Search_Form_Display_Settings::render_form_block( $block ) );
							// 描画できなかったフォームには、編集リンクも出さない
							if ( '' !== $form_html ) {
								$content  = $form_html;
								$content .= self::form_edit_content( $form_post_id, $old_flag );
							}
						}
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

						// パスワード保護されたフォームは出さない
						if ( ! self::is_displayable_form_post( $post ) ) {
							continue;
						}

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
										// 同じフォームを2回以上出さない
										break;
									}
								}
							}
						}
					}
				}

				// 旧版のフォームを表示
				if ( ! empty( $options['display_on_post_type_archive'] ) && is_array( $options['display_on_post_type_archive'] ) ) {
					// 古いのでフラグを立てる
					$old_flag          = true;
					$current_post_type = get_post_type();
					foreach ( $options['display_on_post_type_archive'] as $form_id => $form ) {
						// 保存した設定に今の投稿タイプが無い項目は、置き場所の投稿を読まずに飛ばす
						$saved_post_types = isset( $form['display_post_type'] ) && is_array( $form['display_post_type'] ) ? $form['display_post_type'] : array();
						if ( ! in_array( $current_post_type, $saved_post_types, true ) ) {
							continue;
						}
						// 置き場所の投稿をパスワード保護・下書きにした後も option は残るため、表示時にも確かめる
						$form_post_id = VK_Filter_Search_Form_Display_Settings::get_entry_post_id( $form );
						if ( ! self::is_displayable_form_source_post( $form_post_id ) ) {
							continue;
						}
						// 置き場所の投稿から、FormID が一致するブロックを探す（キーの形式もここで確かめる）
						$block = VK_Filter_Search_Form_Display_Settings::find_legacy_form_block( $form_id, $form );
						if ( null === $block ) {
							continue;
						}
						// 保存した設定と、ブロックの今の設定の両方にある投稿タイプだけに出す
						$block_settings = VK_Filter_Search_Form_Display_Settings::get_block_display_settings( $block );
						$post_types     = array_values( array_intersect( $saved_post_types, $block_settings['archive'] ) );
						if ( ! in_array( $current_post_type, $post_types, true ) ) {
							continue;
						}
						// ホーム、またはそのどれかの投稿タイプのアーカイブなら、1つのフォームを1回だけ出す
						$is_target_archive = is_home();
						foreach ( $post_types as $post_type ) {
							if ( is_post_type_archive( $post_type ) ) {
								$is_target_archive = true;
								break;
							}
						}
						if ( ! $is_target_archive ) {
							continue;
						}
						// 置き場所の投稿の作成者が編集者未満でも中身を変えられるため、出力の直前に無害化する
						$form_html = self::sanitize_saved_form_content( VK_Filter_Search_Form_Display_Settings::render_form_block( $block ) );
						// 描画できなかったフォームには、編集リンクも出さない
						if ( '' === $form_html ) {
							continue;
						}
						$content .= $form_html;
						$content .= self::form_edit_content( $form_post_id, $old_flag );
					}
				}
			}

			return $content;
		}

		/**
		 * 投稿タイプ VK Filter Search のフォームを、検索結果ページ・アーカイブに表示してよいか判定する
		 *
		 * 投稿タイプが filter-search で、状態が公開済みか非公開で、パスワードが付いていない投稿だけを対象にする。
		 * パスワードは閲覧者のクッキーで結果が変わる post_password_required() ではなく、投稿に付いているかどうかで判定する。
		 *
		 * @param WP_Post|int|null $post 判定する投稿または投稿 ID.
		 * @return bool 表示してよい場合は true
		 */
		public static function is_displayable_form_post( $post ) {
			// get_post() は空の値を渡すと表示中の投稿を返すため、先に除外する
			if ( empty( $post ) ) {
				return false;
			}
			$post = get_post( $post );
			if ( ! $post instanceof WP_Post || 'filter-search' !== $post->post_type ) {
				return false;
			}
			return self::is_displayable_form_source_post( $post );
		}

		/**
		 * 旧方式の検索フォームブロックを置いた投稿のフォームを、検索結果ページ・アーカイブに表示してよいか判定する
		 *
		 * 投稿タイプは問わず、状態が公開済みか非公開で、パスワードが付いていない投稿だけを対象にする。
		 * パスワードは閲覧者のクッキーで結果が変わる post_password_required() ではなく、投稿に付いているかどうかで判定する。
		 *
		 * @param WP_Post|int|null $post 判定する投稿または投稿 ID.
		 * @return bool 表示してよい場合は true
		 */
		public static function is_displayable_form_source_post( $post ) {
			// get_post() は空の値を渡すと表示中の投稿を返すため、先に除外する
			if ( empty( $post ) ) {
				return false;
			}
			$post = get_post( $post );
			if ( ! $post instanceof WP_Post ) {
				return false;
			}
			if ( 'publish' !== $post->post_status && 'private' !== $post->post_status ) {
				return false;
			}
			return '' === $post->post_password;
		}

		/**
		 * フォームに設定した検索結果の移動先ページの URL を取得する
		 *
		 * フォームが is_displayable_form_post() を満たし、移動先が固定ページで、閲覧中の人が見られる場合
		 * （一般公開されているか、閲覧中の人に読む権限がある）だけ URL を返す。
		 * それ以外は空文字を返し、移動のスクリプトはサイト標準の検索結果ページへ移動する。
		 *
		 * @param string|int $form_id フォームの ID（投稿タイプ VK Filter Search の投稿 ID）.
		 * @return string 移動先ページの URL。移動先を使わない場合は空文字
		 */
		public static function get_search_result_page_url( $form_id ) {
			// 投稿タイプ VK Filter Search のフォーム ID は正の整数なので、それ以外（-5・1e1・1.9 等）は対象外
			if ( ! is_int( $form_id ) && ! is_string( $form_id ) ) {
				return '';
			}
			if ( ! ctype_digit( (string) $form_id ) ) {
				return '';
			}

			// 表示してよいフォームだけを対象にする
			$form_post = get_post( absint( $form_id ) );
			if ( ! self::is_displayable_form_post( $form_post ) ) {
				return '';
			}

			// 移動先ページを取得
			$page_id = absint( get_post_meta( $form_post->ID, 'vkfs_search_result_page_id', true ) );
			$page    = ! empty( $page_id ) ? get_post( $page_id ) : null;
			// 移動先はエディタで固定ページから選ぶため、固定ページ以外は使わない
			if ( ! $page instanceof WP_Post || 'page' !== $page->post_type ) {
				return '';
			}

			// 閲覧中の人が見られない移動先ページの URL は出さない
			if ( ! is_post_publicly_viewable( $page ) && ! current_user_can( 'read_post', $page->ID ) ) {
				return '';
			}

			$url = get_permalink( $page );
			return ! empty( $url ) ? $url : '';
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
				$target_id = ! empty( $_GET['vkfs_form_id'] ) ? sanitize_text_field( wp_unslash( $_GET['vkfs_form_id'] ) ) : '';

				$header_script_params = array(
					'home_url'          => self::get_search_root_url(),
					'search_result_url' => self::get_search_result_page_url( $target_id ),
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
