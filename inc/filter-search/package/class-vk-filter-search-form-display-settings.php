<?php
/**
 * 検索結果ページ・投稿タイプアーカイブに出すフォームの設定
 *
 * 設定は投稿を保存したときに、保存中の投稿の本文にある検索フォームのブロックから書き込む。
 * - 投稿タイプ VK Filter Search（filter-search）の投稿: その投稿自身のメタ
 * - それ以外の投稿に直接置いた旧版のフォーム: option vk_filter_search の display_on_result / display_on_post_type_archive
 *
 * 旧版のフォームの option には { form_post_id, 表示の設定 } だけを保存し、
 * 表示するときに元の投稿の本文から FormID が一致するブロックを描画する。
 *
 * @package VK Filter Search
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // 直接アクセスされたら終了する。
}

if ( ! class_exists( 'VK_Filter_Search_Form_Display_Settings' ) ) {
	/**
	 * 検索結果ページ・投稿タイプアーカイブに出すフォームの設定
	 */
	class VK_Filter_Search_Form_Display_Settings {

		/**
		 * 旧版のフォームの設定を増やすのに必要な権限
		 */
		const APPROVE_CAPABILITY = 'edit_others_posts';

		/**
		 * 移行が済んだことを示す option 名
		 */
		const MIGRATION_OPTION = 'vk_filter_search_form_display_migrated';

		/**
		 * 移行のときに判定できなかった旧版のフォームの項目を置いておく option 名（表示には使わない）
		 *
		 * 値は { signature: 判定したときの get_environment_signature(), entries: { option のキー: { FormID: 項目 } } }
		 * 項目は { form_post_id: 置いた投稿の ID, post_type: 置いた投稿の投稿タイプ }
		 */
		const PENDING_OPTION = 'vk_filter_search_form_display_pending';

		/**
		 * 旧版のフォームを描画している最中か（入れ子の描画で同じ処理を繰り返さないため）
		 *
		 * @var bool
		 */
		private static $is_rendering = false;

		/**
		 * 旧版のフォームの設定を保存する option のキーを返す
		 *
		 * @return string[] option vk_filter_search の中のキー
		 */
		public static function get_legacy_option_keys() {
			return array( 'display_on_result', 'display_on_post_type_archive' );
		}

		/**
		 * フックを登録する
		 *
		 * @return void
		 */
		public static function init() {
			add_action( 'wp_after_insert_post', array( __CLASS__, 'save_on_insert_post' ), 10, 4 );
			add_action( 'deleted_post', array( __CLASS__, 'delete_legacy_entries_of_post' ) );
			// 投稿タイプとブロック名の登録（init のどの優先度でも）が終わったあとに動かす
			add_action( 'wp_loaded', array( __CLASS__, 'migrate' ) );
			add_action( 'wp_loaded', array( __CLASS__, 'maybe_resolve_pending_entries' ), 11 );
		}

		/**
		 * 検索フォームのブロック名の一覧を返す
		 *
		 * @return string[] ブロック名の配列
		 */
		public static function get_form_block_names() {
			/**
			 * 検索結果ページ・アーカイブに出す設定を持つ検索フォームのブロック名
			 *
			 * @param string[] $block_names ブロック名の配列.
			 */
			$block_names = apply_filters( 'vkfs_form_block_names', array( 'vk-filter-search/filter-search' ) );
			return is_array( $block_names ) ? $block_names : array();
		}

		/**
		 * ブロックの一覧（parse_blocks() の結果）から、検索フォームのブロックを入れ子まで含めて取り出す
		 *
		 * @param array $blocks parse_blocks() の結果.
		 * @return array 検索フォームのブロックの配列（本文に出てくる順）
		 */
		public static function find_form_blocks( $blocks ) {
			$form_blocks = array();
			if ( ! is_array( $blocks ) ) {
				return $form_blocks;
			}
			$block_names = self::get_form_block_names();
			foreach ( $blocks as $block ) {
				if ( ! is_array( $block ) ) {
					continue;
				}
				if ( ! empty( $block['blockName'] ) && in_array( $block['blockName'], $block_names, true ) ) {
					$form_blocks[] = $block;
				}
				if ( ! empty( $block['innerBlocks'] ) ) {
					$form_blocks = array_merge( $form_blocks, self::find_form_blocks( $block['innerBlocks'] ) );
				}
			}
			return $form_blocks;
		}

		/**
		 * 本文から、FormID が一致する検索フォームのブロックを探す
		 *
		 * @param string     $content 投稿の本文.
		 * @param string|int $form_id 探す FormID.
		 * @return array|null 見つかったブロック（parse_blocks() の要素）。無ければ null
		 */
		public static function find_form_block( $content, $form_id ) {
			if ( ! is_string( $content ) || '' === $content || ! has_blocks( $content ) ) {
				return null;
			}
			foreach ( self::find_form_blocks( parse_blocks( $content ) ) as $block ) {
				$block_form_id = self::get_block_form_id( $block );
				if ( '' !== $block_form_id && (string) $form_id === $block_form_id ) {
					return $block;
				}
			}
			return null;
		}

		/**
		 * ブロックの FormID を返す
		 *
		 * @param array $block 検索フォームのブロック（parse_blocks() の要素）.
		 * @return string FormID。無い・形式に合わない場合は空文字
		 */
		public static function get_block_form_id( $block ) {
			if ( ! isset( $block['attrs']['FormID'] ) ) {
				return '';
			}
			$form_id = $block['attrs']['FormID'];
			if ( ! is_string( $form_id ) && ! is_int( $form_id ) ) {
				return '';
			}
			$form_id = (string) $form_id;
			if ( '' === $form_id || ! VK_Filter_Search::is_safe_saved_form_id( $form_id ) ) {
				return '';
			}
			return $form_id;
		}

		/**
		 * ブロックの「投稿タイプアーカイブに表示」の設定を、投稿タイプ名の配列にして返す
		 *
		 * 属性は ["post","event"] の形の文字列で保存されている。
		 *
		 * @param array $block 検索フォームのブロック（parse_blocks() の要素）.
		 * @return string[] 投稿タイプ名の配列
		 */
		public static function get_block_archive_post_types( $block ) {
			if ( empty( $block['attrs']['DisplayOnPosttypeArchive'] ) || ! is_string( $block['attrs']['DisplayOnPosttypeArchive'] ) ) {
				return array();
			}
			$value      = str_replace( array( '[', ']', '"' ), '', $block['attrs']['DisplayOnPosttypeArchive'] );
			$post_types = array();
			foreach ( explode( ',', $value ) as $post_type ) {
				$post_type = trim( $post_type );
				// 投稿タイプ名に使えない文字を含む値は捨てる
				if ( '' === $post_type || sanitize_key( $post_type ) !== $post_type ) {
					continue;
				}
				$post_types[] = $post_type;
			}
			return array_values( array_unique( $post_types ) );
		}

		/**
		 * ブロックの表示の設定を返す
		 *
		 * @param array $block 検索フォームのブロック（parse_blocks() の要素）.
		 * @return array { result: 検索結果ページに出すか, archive: 出す投稿タイプアーカイブの投稿タイプ名の配列 }
		 */
		public static function get_block_display_settings( $block ) {
			return array(
				'result'  => ! empty( $block['attrs']['DisplayOnResult'] ),
				'archive' => self::get_block_archive_post_types( $block ),
			);
		}

		/**
		 * 本文にある検索フォームのブロックの表示の設定を、FormID ごとに返す
		 *
		 * 同じ FormID のブロックが複数あるときは、先に出てくるものを使う（表示時に描画するブロックと揃えるため）。
		 *
		 * @param string $content 投稿の本文.
		 * @return array FormID をキーにした get_block_display_settings() の配列
		 */
		public static function get_display_settings_from_content( $content ) {
			$settings = array();
			if ( ! is_string( $content ) || '' === $content || ! has_blocks( $content ) ) {
				return $settings;
			}
			foreach ( self::find_form_blocks( parse_blocks( $content ) ) as $block ) {
				$form_id = self::get_block_form_id( $block );
				if ( '' === $form_id || isset( $settings[ $form_id ] ) ) {
					continue;
				}
				$settings[ $form_id ] = self::get_block_display_settings( $block );
			}
			return $settings;
		}

		/**
		 * 旧版のフォームを置ける投稿タイプか
		 *
		 * 投稿タイプ VK Filter Search と、公開画面を持たない投稿タイプ（再利用ブロック・テンプレートなど）は対象にしない。
		 *
		 * @param string $post_type 投稿タイプ名.
		 * @return bool 対象なら true
		 */
		public static function is_legacy_form_source_post_type( $post_type ) {
			if ( ! is_string( $post_type ) || '' === $post_type || 'filter-search' === $post_type ) {
				return false;
			}
			return is_post_type_viewable( $post_type );
		}

		/**
		 * 本文を見直していない保存か
		 *
		 * 次の保存は、保存した人が本文を開いていないため、権限があっても承認を増やさない判定に使う。
		 * - ゴミ箱に入れる・ゴミ箱から戻す操作
		 * - 投稿一覧のクイック編集（admin-ajax.php の inline-save）
		 * - 投稿一覧の一括編集（edit.php から bulk_edit_posts() を呼ぶ保存）
		 *
		 * 旧版のフォームの表示の設定と、Pro の並び替えブロック・カスタムフィールド検索の内部用のフィールドの承認で共用する。
		 *
		 * @param WP_Post|null $post      保存した投稿.
		 * @param bool         $was_trash 保存前にゴミ箱に入っていたか（ゴミ箱から戻す操作か）.
		 * @return bool 本文を見直していない保存なら true。
		 */
		public static function is_save_without_content_review( $post, $was_trash = false ) {
			// ゴミ箱に入れる・戻す操作
			if ( $was_trash || ( $post instanceof WP_Post && 'trash' === $post->post_status ) ) {
				return true;
			}

			// 投稿の保存の要求は、WordPress 本体がノンスと権限を確かめ終えてから処理されるため、ここではリクエストの種類を見分けるだけにする
			// phpcs:disable WordPress.Security.NonceVerification.Recommended
			// クイック編集（wp_ajax_inline_save() → edit_post()）
			if ( wp_doing_ajax() && isset( $_REQUEST['action'] ) && 'inline-save' === sanitize_key( wp_unslash( $_REQUEST['action'] ) ) ) {
				return true;
			}

			// 一括編集（wp-admin/edit.php は bulk_edit があるときに bulk_edit_posts() を呼ぶ）
			if ( is_admin() && ! wp_doing_ajax() && isset( $_REQUEST['bulk_edit'] ) ) {
				return true;
			}
			// phpcs:enable WordPress.Security.NonceVerification.Recommended

			return false;
		}

		/**
		 * 投稿の保存時に、フォームの表示の設定を書き込む
		 *
		 * 書き込み先は常に保存中の投稿で、ブロックの属性 PostID は使わない。
		 *
		 * @param int          $post_id     投稿 ID.
		 * @param WP_Post      $post        保存した投稿.
		 * @param bool         $update      既存の投稿の更新か.
		 * @param WP_Post|null $post_before 保存前の投稿（新規作成のときは null）.
		 * @return void
		 */
		public static function save_on_insert_post( $post_id, $post, $update = false, $post_before = null ) {
			// リビジョン・自動保存では書き込まない
			if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
				return;
			}
			if ( ! $post instanceof WP_Post ) {
				return;
			}

			// VK Filter Search の投稿は、その投稿自身のメタに書く
			if ( 'filter-search' === $post->post_type ) {
				self::update_filter_search_post_meta( $post );
				return;
			}

			if ( ! self::is_legacy_form_source_post_type( $post->post_type ) ) {
				return;
			}

			// ログインしていない処理（予約投稿の公開・cron など）では保存した人が分からないため、変えない
			if ( ! get_current_user_id() ) {
				return;
			}

			// ゴミ箱の操作・クイック編集・一括編集は本文を見直した保存ではないため、権限があっても増やさない
			$was_trash = $post_before instanceof WP_Post && 'trash' === $post_before->post_status;
			$can_add   = ! self::is_save_without_content_review( $post, $was_trash ) && current_user_can( self::APPROVE_CAPABILITY );

			$options     = VK_Filter_Search::get_options();
			$new_options = self::get_updated_legacy_options( $options, $post_id, $post->post_content, $can_add );
			if ( $new_options !== $options ) {
				update_option( 'vk_filter_search', $new_options );
			}

			// 編集者以上が本文を見直して保存したので、その投稿の保留の項目は、まだ判定できないものだけを残す
			if ( $can_add ) {
				$pending = self::get_pending();
				$entries = self::get_pending_entries_after_save( $pending['entries'], $post_id, $post->post_content );
				if ( $entries !== $pending['entries'] ) {
					self::update_pending( $entries, $pending['signature'] );
				}
			}
		}

		/**
		 * VK Filter Search の投稿のメタを、本文の検索フォームのブロックから書き込む
		 *
		 * 本文に検索フォームのブロックが無い場合は、どこにも表示しない値にする。
		 *
		 * @param WP_Post $post 投稿タイプ filter-search の投稿.
		 * @return void
		 */
		public static function update_filter_search_post_meta( $post ) {
			$blocks = has_blocks( $post->post_content ) ? self::find_form_blocks( parse_blocks( $post->post_content ) ) : array();
			$block  = ! empty( $blocks ) ? $blocks[0] : array();

			$settings              = self::get_block_display_settings( $block );
			$search_result_page_id = ! empty( $block['attrs']['SearchResultPageID'] ) && is_scalar( $block['attrs']['SearchResultPageID'] ) ? absint( $block['attrs']['SearchResultPageID'] ) : 0;

			update_post_meta( $post->ID, 'vkfs_display_result', $settings['result'] );
			update_post_meta( $post->ID, 'vkfs_display_archive', implode( ',', $settings['archive'] ) );
			update_post_meta( $post->ID, 'vkfs_search_result_page_id', $search_result_page_id );
		}

		/**
		 * 保存した投稿の本文に合わせて、旧版のフォームの option を組み立て直す
		 *
		 * - 保存した投稿の項目のうち、本文に無い設定は消す
		 * - ただし、検索フォームとして登録されていないブロックに FormID がある項目は、判定できないため変えない
		 * - $can_add が true のときだけ、本文にある設定を足す（false のときは減らすだけ）
		 * - ほかの投稿の項目は、同じ FormID でも変えない
		 *
		 * @param array|false $options 今の option vk_filter_search.
		 * @param int         $post_id 保存した投稿の ID.
		 * @param string      $content 保存した投稿の本文.
		 * @param bool        $can_add 設定を足してよいか.
		 * @return array|false 組み立て直した option。変える項目が無いときは $options をそのまま返す
		 */
		public static function get_updated_legacy_options( $options, $post_id, $content, $can_add ) {
			$post_id     = absint( $post_id );
			$settings    = self::get_display_settings_from_content( $content );
			$new_options = is_array( $options ) ? $options : array();

			foreach ( self::get_legacy_option_keys() as $option_key ) {
				$entries = isset( $new_options[ $option_key ] ) && is_array( $new_options[ $option_key ] ) ? $new_options[ $option_key ] : array();

				// 保存した投稿の項目を、本文の設定の範囲まで減らす
				foreach ( $entries as $form_id => $entry ) {
					if ( self::get_entry_post_id( $entry ) !== $post_id ) {
						continue;
					}
					// 検索フォームとして登録されていないブロックにある項目（Pro が無効のときの Pro のブロックなど）は、判定できないため今の設定のまま残す
					// 表示するときは、ブロック名が登録されてブロックが見つかるまで出ない
					if ( ! isset( $settings[ $form_id ] ) && self::has_unregistered_form_block( $content, $form_id ) ) {
						continue;
					}
					$allowed = self::get_entry_from_settings( $option_key, $post_id, isset( $settings[ $form_id ] ) ? $settings[ $form_id ] : null );
					if ( null === $allowed ) {
						unset( $entries[ $form_id ] );
						continue;
					}
					if ( 'display_on_post_type_archive' === $option_key ) {
						$current_post_types = isset( $entry['display_post_type'] ) && is_array( $entry['display_post_type'] ) ? $entry['display_post_type'] : array();
						$post_types         = array_values( array_intersect( $current_post_types, $allowed['display_post_type'] ) );
						if ( empty( $post_types ) ) {
							unset( $entries[ $form_id ] );
							continue;
						}
						$allowed['display_post_type'] = $post_types;
					}
					$entries[ $form_id ] = $allowed;
				}

				// 権限があるときは、本文の設定をそのまま反映する
				if ( $can_add ) {
					foreach ( $settings as $form_id => $setting ) {
						// ほかの投稿の項目は上書きしない
						if ( isset( $entries[ $form_id ] ) && self::get_entry_post_id( $entries[ $form_id ] ) !== $post_id && 0 !== self::get_entry_post_id( $entries[ $form_id ] ) ) {
							continue;
						}
						$entry = self::get_entry_from_settings( $option_key, $post_id, $setting );
						if ( null === $entry ) {
							continue;
						}
						$entries[ $form_id ] = $entry;
					}
				}

				// 元から無いキーは、足す項目があるときだけ作る
				if ( ! empty( $entries ) || isset( $new_options[ $option_key ] ) ) {
					$new_options[ $option_key ] = $entries;
				}
			}

			if ( ! is_array( $options ) && empty( $new_options ) ) {
				return $options;
			}
			return $new_options;
		}

		/**
		 * 表示の設定から、旧版のフォームの option の項目を作る
		 *
		 * @param string     $option_key display_on_result か display_on_post_type_archive.
		 * @param int        $post_id    フォームを置いた投稿の ID.
		 * @param array|null $setting    get_block_display_settings() の値.
		 * @return array|null option の項目。その設定で表示しない場合は null
		 */
		public static function get_entry_from_settings( $option_key, $post_id, $setting ) {
			if ( ! is_array( $setting ) ) {
				return null;
			}
			if ( 'display_on_result' === $option_key ) {
				return ! empty( $setting['result'] ) ? array( 'form_post_id' => $post_id ) : null;
			}
			if ( empty( $setting['archive'] ) ) {
				return null;
			}
			return array(
				'display_post_type' => array_values( $setting['archive'] ),
				'form_post_id'      => $post_id,
			);
		}

		/**
		 * 旧版のフォームの option の項目から、フォームを置いた投稿の ID を取り出す
		 *
		 * @param mixed $entry option の項目.
		 * @return int 投稿 ID。取り出せない場合は 0
		 */
		public static function get_entry_post_id( $entry ) {
			if ( ! is_array( $entry ) || empty( $entry['form_post_id'] ) || ! is_numeric( $entry['form_post_id'] ) ) {
				return 0;
			}
			return absint( $entry['form_post_id'] );
		}

		/**
		 * 削除した投稿に置いてあった旧版のフォームの項目を消す
		 *
		 * @param int $post_id 削除した投稿の ID.
		 * @return void
		 */
		public static function delete_legacy_entries_of_post( $post_id ) {
			$post_id     = absint( $post_id );
			$options     = VK_Filter_Search::get_options();
			$new_options = self::remove_entries_of_post( $options, $post_id );
			if ( $new_options !== $options ) {
				update_option( 'vk_filter_search', $new_options );
			}

			// 保留の項目も消す
			$pending = self::get_pending();
			$entries = self::remove_entries_of_post( $pending['entries'], $post_id );
			if ( $entries !== $pending['entries'] ) {
				self::update_pending( $entries, $pending['signature'] );
			}
		}

		/**
		 * 旧版のフォームの項目の一覧から、指定した投稿に置いた項目を除く
		 *
		 * @param array $entries option のキー（display_on_result など）ごとの項目の一覧.
		 * @param int   $post_id 投稿 ID.
		 * @return array 除いたあとの一覧
		 */
		public static function remove_entries_of_post( $entries, $post_id ) {
			foreach ( self::get_legacy_option_keys() as $option_key ) {
				if ( empty( $entries[ $option_key ] ) || ! is_array( $entries[ $option_key ] ) ) {
					continue;
				}
				foreach ( $entries[ $option_key ] as $form_id => $entry ) {
					if ( self::get_entry_post_id( $entry ) === $post_id ) {
						unset( $entries[ $option_key ][ $form_id ] );
					}
				}
			}
			return $entries;
		}

		/**
		 * 旧版のフォームの項目に対応するブロックを、置いた投稿の本文から探す
		 *
		 * @param string|int $form_id FormID（option のキー）.
		 * @param mixed      $entry   option の項目.
		 * @return array|null 見つかったブロック。項目・投稿・ブロックのどれかが正しくなければ null
		 */
		public static function find_legacy_form_block( $form_id, $entry ) {
			if ( ! VK_Filter_Search::is_safe_saved_form_id( $form_id ) ) {
				return null;
			}
			$post_id = self::get_entry_post_id( $entry );
			if ( ! $post_id ) {
				return null;
			}
			$post = get_post( $post_id );
			if ( ! $post instanceof WP_Post || ! self::is_legacy_form_source_post_type( $post->post_type ) ) {
				return null;
			}
			return self::find_form_block( $post->post_content, $form_id );
		}

		/**
		 * 検索フォームのブロックを描画する
		 *
		 * 描画の処理（render_callback）を通すため、Pro の data 属性の補いなども、投稿に置いたときと同じ結果になる。
		 *
		 * @param array $block 検索フォームのブロック（parse_blocks() の要素）.
		 * @return string 描画した HTML。描画中に同じ処理が呼ばれた場合は空文字
		 */
		public static function render_form_block( $block ) {
			// ブロックの中に検索結果フォームのブロックがあっても、描画が繰り返されないようにする
			if ( self::$is_rendering ) {
				return '';
			}
			self::$is_rendering = true;
			// 描画中に例外が出ても、印が立ったままにならないようにする
			try {
				$html = render_block( $block );
			} finally {
				self::$is_rendering = false;
			}
			return is_string( $html ) ? $html : '';
		}

		/**
		 * 一度だけ、既存の設定を新しい形に移す
		 *
		 * - 旧版のフォームの項目は、元の投稿に同じ FormID のブロックがあり、作成者が編集者以上のものだけを、
		 *   そのブロックの今の設定から作り直す
		 * - 投稿タイプ・ブロック名がまだ登録されていないため判定できない項目は、保留の option に移す（表示には使わない）
		 * - それ以外の項目は消す
		 * - 使わなくなった custom_fields を消す
		 * - VK Filter Search の投稿のメタを本文から計算し直す
		 *
		 * @return bool 移行した場合は true。移行済み・option を保存できなかった場合は false
		 */
		public static function migrate() {
			if ( get_option( self::MIGRATION_OPTION ) ) {
				return false;
			}

			// 旧版のフォームの項目を作り直す
			$options = get_option( 'vk_filter_search' );
			if ( is_array( $options ) ) {
				$new_options = $options;
				$pending     = array();
				foreach ( self::get_legacy_option_keys() as $option_key ) {
					if ( ! isset( $new_options[ $option_key ] ) ) {
						continue;
					}
					$entries = array();
					foreach ( (array) $new_options[ $option_key ] as $form_id => $entry ) {
						$result = self::classify_legacy_entry( $option_key, $form_id, $entry );
						if ( 'keep' === $result['status'] ) {
							$entries[ $form_id ] = $result['entry'];
						} elseif ( 'pending' === $result['status'] ) {
							$pending[ $option_key ][ $form_id ] = $result['entry'];
						}
					}
					$new_options[ $option_key ] = $entries;
				}

				// どこからも読まなくなったカスタムフィールドの一覧を消す
				unset( $new_options['custom_fields'] );

				// 保留の項目を先に保存する（option だけが保存されて、保留にする項目が失われないようにするため）
				// どちらかを保存できなかったときは移行済みにせず、次の読み込みでやり直す
				if ( ! self::update_pending( $pending, self::get_environment_signature( $pending ) ) ) {
					return false;
				}
				if ( $new_options !== $options && ! update_option( 'vk_filter_search', $new_options ) ) {
					return false;
				}
			} elseif ( ! self::update_pending( array(), self::get_environment_signature( array() ) ) ) {
				// 保留の option を空で作っておく（読み込みのたびに、無い option を問い合わせないようにするため）
				return false;
			}

			// VK Filter Search の投稿のメタを本文から計算し直す
			$post_ids = get_posts(
				array(
					'post_type'        => 'filter-search',
					'post_status'      => 'any',
					'posts_per_page'   => -1,
					'fields'           => 'ids',
					'no_found_rows'    => true,
					'suppress_filters' => true,
				)
			);
			foreach ( $post_ids as $post_id ) {
				$post = get_post( $post_id );
				if ( $post instanceof WP_Post ) {
					self::update_filter_search_post_meta( $post );
				}
			}

			update_option( self::MIGRATION_OPTION, 1 );
			return true;
		}

		/**
		 * 移行で、旧版のフォームの項目を残すか・保留にするか・消すかを判定する
		 *
		 * @param string     $option_key display_on_result か display_on_post_type_archive.
		 * @param string|int $form_id    FormID（option のキー）.
		 * @param mixed      $entry      今の option の項目.
		 * @return array { status: keep（残す）/ pending（今は判定できない）/ drop（消す）, entry: 残す・保留にする項目（drop のときは null） }
		 */
		public static function classify_legacy_entry( $option_key, $form_id, $entry ) {
			$drop = array(
				'status' => 'drop',
				'entry'  => null,
			);
			if ( ! VK_Filter_Search::is_safe_saved_form_id( $form_id ) ) {
				return $drop;
			}
			$post_id = self::get_entry_post_id( $entry );
			$post    = $post_id ? get_post( $post_id ) : null;
			if ( ! $post instanceof WP_Post || 'filter-search' === $post->post_type ) {
				return $drop;
			}
			$pending = array(
				'status' => 'pending',
				// 判定し直すきっかけの値を、読み込みのたびに投稿を読まずに作れるよう、投稿タイプも持たせる
				'entry'  => array(
					'form_post_id' => $post_id,
					'post_type'    => $post->post_type,
				),
			);

			// 投稿タイプがまだ登録されていない
			if ( ! post_type_exists( $post->post_type ) ) {
				return $pending;
			}
			if ( ! self::is_legacy_form_source_post_type( $post->post_type ) ) {
				return $drop;
			}

			$block = self::find_form_block( $post->post_content, $form_id );
			if ( null === $block ) {
				// 検索フォームとして登録されていないブロックに同じ FormID がある（Pro が無効のときの Pro のブロックなど）
				return self::has_unregistered_form_block( $post->post_content, $form_id ) ? $pending : $drop;
			}

			// 作成者が編集者以上のものだけ残す
			if ( empty( $post->post_author ) || ! user_can( (int) $post->post_author, self::APPROVE_CAPABILITY ) ) {
				return $drop;
			}
			$new_entry = self::get_entry_from_settings( $option_key, $post_id, self::get_block_display_settings( $block ) );
			if ( null === $new_entry ) {
				return $drop;
			}
			return array(
				'status' => 'keep',
				'entry'  => $new_entry,
			);
		}

		/**
		 * 検索フォームのブロック名の一覧に無いブロックに、指定した FormID が付いているか
		 *
		 * @param string     $content 投稿の本文.
		 * @param string|int $form_id FormID.
		 * @return bool 付いているブロックがあれば true
		 */
		public static function has_unregistered_form_block( $content, $form_id ) {
			if ( ! is_string( $content ) || '' === $content || ! has_blocks( $content ) ) {
				return false;
			}
			return self::has_unregistered_form_block_in( parse_blocks( $content ), (string) $form_id, self::get_form_block_names() );
		}

		/**
		 * ブロックの一覧を入れ子までたどり、検索フォームのブロック名の一覧に無いブロックに FormID が付いているかを返す
		 *
		 * @param array    $blocks      parse_blocks() の結果.
		 * @param string   $form_id     FormID.
		 * @param string[] $block_names 検索フォームのブロック名の一覧.
		 * @return bool 付いているブロックがあれば true
		 */
		private static function has_unregistered_form_block_in( $blocks, $form_id, $block_names ) {
			foreach ( $blocks as $block ) {
				if ( ! is_array( $block ) ) {
					continue;
				}
				if ( ! empty( $block['blockName'] ) && ! in_array( $block['blockName'], $block_names, true ) && self::get_block_form_id( $block ) === $form_id ) {
					return true;
				}
				if ( ! empty( $block['innerBlocks'] ) && self::has_unregistered_form_block_in( $block['innerBlocks'], $form_id, $block_names ) ) {
					return true;
				}
			}
			return false;
		}

		/**
		 * 保留の項目の判定に関係する登録状況を表す値を返す
		 *
		 * この値が変わったとき（Pro を有効にした・投稿タイプを登録するプラグインを入れたなど）に、保留の項目を判定し直す。
		 * 保留の項目に関係しない投稿タイプは含めない（管理画面だけで登録される投稿タイプなどで値が変わり、画面を移るたびに判定し直さないようにするため）。
		 *
		 * @param array $entries option のキーごとの保留の項目の一覧.
		 * @return string 保留の項目の置き場所の投稿タイプが登録されているかと、検索フォームのブロック名から作った値
		 */
		public static function get_environment_signature( $entries ) {
			// 保留の項目の置き場所の投稿タイプが、今登録されているかを集める（項目に持たせた投稿タイプを使い、投稿は読まない）
			$post_types = array();
			foreach ( (array) $entries as $option_entries ) {
				foreach ( (array) $option_entries as $entry ) {
					if ( is_array( $entry ) && ! empty( $entry['post_type'] ) && is_string( $entry['post_type'] ) ) {
						$post_types[ $entry['post_type'] ] = post_type_exists( $entry['post_type'] );
					}
				}
			}
			ksort( $post_types );

			$block_names = self::get_form_block_names();
			sort( $block_names );
			return md5( (string) wp_json_encode( array( $post_types, $block_names ) ) );
		}

		/**
		 * 保留の option を返す
		 *
		 * @return array { signature: string, entries: { option のキー: { FormID: 項目 } } }
		 */
		public static function get_pending() {
			$pending = get_option( self::PENDING_OPTION );
			return array(
				'signature' => isset( $pending['signature'] ) && is_string( $pending['signature'] ) ? $pending['signature'] : '',
				'entries'   => isset( $pending['entries'] ) && is_array( $pending['entries'] ) ? $pending['entries'] : array(),
			);
		}

		/**
		 * 保留の option を保存する
		 *
		 * 読み込みのたびに確かめるため、項目が無くなっても消さずに自動読み込みの option として残す（無い option を読むと、そのたびにデータベースへ問い合わせるため）。
		 *
		 * @param array  $entries   option のキーごとの項目の一覧.
		 * @param string $signature get_environment_signature() の値.
		 * @return bool 保存できた（または今の値と同じだった）場合は true
		 */
		public static function update_pending( $entries, $signature ) {
			// 空になった option のキーは残さない
			$value = array(
				'signature' => (string) $signature,
				'entries'   => array_filter( (array) $entries ),
			);
			if ( get_option( self::PENDING_OPTION ) === $value ) {
				return true;
			}
			return update_option( self::PENDING_OPTION, $value, true );
		}

		/**
		 * 投稿タイプ・ブロック名の登録状況が変わっていたら、保留の項目を判定し直す
		 *
		 * 残す項目は option vk_filter_search に移し、消す項目は保留から除く。まだ判定できない項目は保留に残す。
		 *
		 * @return bool 判定し直した場合は true
		 */
		public static function maybe_resolve_pending_entries() {
			$pending = self::get_pending();
			if ( empty( $pending['entries'] ) ) {
				return false;
			}
			if ( self::get_environment_signature( $pending['entries'] ) === $pending['signature'] ) {
				return false;
			}

			// 保留の項目を1件ずつ判定し直す
			$options     = VK_Filter_Search::get_options();
			$new_options = $options;
			$entries     = array();
			foreach ( self::get_legacy_option_keys() as $option_key ) {
				if ( empty( $pending['entries'][ $option_key ] ) || ! is_array( $pending['entries'][ $option_key ] ) ) {
					continue;
				}
				foreach ( $pending['entries'][ $option_key ] as $form_id => $entry ) {
					$result = self::classify_legacy_entry( $option_key, $form_id, $entry );
					if ( 'pending' === $result['status'] ) {
						$entries[ $option_key ][ $form_id ] = $result['entry'];
						continue;
					}
					// 同じ FormID の項目が既にある（その後の保存で書き込まれたなど）ときは、そちらを使う
					if ( 'keep' === $result['status'] && ! isset( $new_options[ $option_key ][ $form_id ] ) ) {
						$new_options[ $option_key ][ $form_id ] = $result['entry'];
					}
				}
			}

			// option を保存できなかったときは保留を変えず、次の読み込みでやり直す
			if ( $new_options !== $options && ! update_option( 'vk_filter_search', $new_options ) ) {
				return false;
			}
			// 残った項目について、今の登録状況で判定したことを残す
			self::update_pending( $entries, self::get_environment_signature( $entries ) );
			return true;
		}

		/**
		 * 編集者以上が投稿を保存したあとの、保留の項目の一覧を返す
		 *
		 * その投稿の保留の項目は、保存で本文から書き込み直したため除く。
		 * ただし、検索フォームとして登録されていないブロックに FormID があるもの（まだ判定できないもの）は残す。
		 *
		 * @param array  $entries option のキーごとの保留の項目の一覧.
		 * @param int    $post_id 保存した投稿の ID.
		 * @param string $content 保存した投稿の本文.
		 * @return array 保存後の保留の項目の一覧
		 */
		public static function get_pending_entries_after_save( $entries, $post_id, $content ) {
			$post_id = absint( $post_id );
			foreach ( self::get_legacy_option_keys() as $option_key ) {
				if ( empty( $entries[ $option_key ] ) || ! is_array( $entries[ $option_key ] ) ) {
					continue;
				}
				foreach ( $entries[ $option_key ] as $form_id => $entry ) {
					if ( self::get_entry_post_id( $entry ) === $post_id && ! self::has_unregistered_form_block( $content, $form_id ) ) {
						unset( $entries[ $option_key ][ $form_id ] );
					}
				}
			}
			return $entries;
		}
	}

	VK_Filter_Search_Form_Display_Settings::init();
}
