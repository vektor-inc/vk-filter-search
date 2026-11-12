<?php
/**
 * 検索フォームの要素に付ける id を、ページ内で重複しないようにする
 *
 * @package VK Filter Search
 */

if ( ! class_exists( 'VK_Filter_Search_Html_Id' ) ) {

	/**
	 * ページ（1回のリクエスト）の中で出力した id を覚えておき、2つ目以降に番号を付ける
	 */
	class VK_Filter_Search_Html_Id {

		/**
		 * このリクエストで出力済みの id（キーが id）
		 *
		 * @var array<string, true>
		 */
		private static $used_ids = array();

		/**
		 * 指定した id を使用済みとして登録し、ページ内で重複しない id を返す
		 *
		 * 最初に出たものは指定した id のまま返し、2つ目以降は「-2」「-3」のように番号を付ける。
		 *
		 * @param string $base_id 元の id.
		 * @return string ページ内で重複しない id（$base_id が空のときは空文字）.
		 */
		public static function reserve_unique_id( $base_id ) {
			$base_id = (string) $base_id;
			if ( '' === $base_id ) {
				return '';
			}

			// 番号を付けた id が別のタクソノミーの id と同じになる場合もあるため、空きが見つかるまで番号を進める.
			$unique_id = $base_id;
			$number    = 1;
			while ( isset( self::$used_ids[ $unique_id ] ) ) {
				++$number;
				$unique_id = $base_id . '-' . $number;
			}

			self::$used_ids[ $unique_id ] = true;
			return $unique_id;
		}

		/**
		 * 選択肢の入れ物（最初の開始タグの ul / select）の id を、ページ内で重複しない id に置き換える
		 *
		 * フィルターで差し替えた後の、実際に出力する HTML に対して1回だけ呼ぶこと
		 * （差し替え前の HTML にも呼ぶと、出力しない要素の分まで番号が進む）。
		 *
		 * @param string $html 選択肢の入れ物の HTML.
		 * @return string id を置き換えた HTML（最初の開始タグ（コメント・閉じタグ・テキストは読み飛ばす）が id 付きの ul / select でなければそのまま）.
		 */
		public static function make_wrapper_id_unique( $html ) {
			if ( ! is_string( $html ) || '' === $html ) {
				return $html;
			}

			// 先頭（空白・改行を除く）が「<」でなければ対象外.
			if ( '<' !== substr( ltrim( $html ), 0, 1 ) ) {
				return $html;
			}

			// 属性の読み取りは WordPress 本体の HTML 解析に任せる（属性の値の中の「id=」や、大文字・空白入りの書き方も仕様どおりに扱う）.
			// 最初の開始タグ（コメント・閉じタグ・テキストは読み飛ばす）だけを対象にし、中の選択肢には触れない.
			$processor = new WP_HTML_Tag_Processor( $html );
			if ( ! $processor->next_tag() || ! in_array( $processor->get_tag(), array( 'UL', 'SELECT' ), true ) ) {
				return $html;
			}

			$base_id = $processor->get_attribute( 'id' );
			if ( ! is_string( $base_id ) || '' === $base_id ) {
				return $html;
			}

			// 1つ目は番号が付かないため、元の HTML を1文字も変えずに返す.
			$unique_id = self::reserve_unique_id( $base_id );
			if ( $unique_id === $base_id ) {
				return $html;
			}

			$processor->set_attribute( 'id', $unique_id );
			return $processor->get_updated_html();
		}

		/**
		 * 覚えている id をすべて消す
		 *
		 * 1回のリクエストの中で状態を持つため、wp_body_open や、テストなどで描画をやり直す前に呼ぶ。
		 *
		 * @return void
		 */
		public static function reset_used_ids() {
			self::$used_ids = array();
		}

		/**
		 * ブロックテーマでないときだけ、覚えている id をすべて消す
		 *
		 * ブロックテーマはテンプレートを wp_head より前に描画するため、ここで消すと
		 * wp_body_open より後に描画したフォームが、本文のフォームと同じ id に戻ってしまう。
		 *
		 * @return void
		 */
		public static function reset_used_ids_unless_block_theme() {
			if ( function_exists( 'wp_is_block_theme' ) && wp_is_block_theme() ) {
				return;
			}
			self::reset_used_ids();
		}
	}

	// wp_head の中（SEO プラグインが本文の抜粋を作るときなど）で描画された、画面に出ないフォームの分を数えないよう、<body> の直後で数え直す.
	// <body> の中で画面に出さずに描画された場合（関連記事の抜粋など）は防げず、見えている1つ目に番号が付くことがある.
	// テーマやプラグインが wp_body_open で出したフォームの id を消さないよう、wp_body_open の中で最初に動かす（優先度を PHP_INT_MIN から変えないこと）.
	add_action( 'wp_body_open', array( 'VK_Filter_Search_Html_Id', 'reset_used_ids_unless_block_theme' ), PHP_INT_MIN ); // phpcs:ignore PHPCompatibility.Constants.NewConstants.php_int_minFound -- プラグインの動作要件が PHP 7.4 以上のため使える.
}
