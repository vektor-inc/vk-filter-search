<?php
/**
 * 結果を一時的に保存するドロップダウン用ウォーカー
 *
 * @package VK Filter Search Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once __DIR__ . '/class-vk-walker-catrgory-dropdown.php';

if ( ! class_exists( 'VK_Walker_CategoryDropdown_Cache' ) ) {
	/**
	 * ウォーカーが作った選択肢（<option>）の並びを wp_cache に保存して使い回すウォーカー
	 *
	 * 保存するのは選択肢の並びだけ。<select> の外側と先頭の選択肢は vk_dropdown_categories() が毎回組み立てる.
	 * キーには、選択肢の並びを決める値をすべて含めること（含めない値が変わっても、古い並びが返るため）.
	 */
	class VK_Walker_CategoryDropdown_Cache extends VK_Walker_CategoryDropdown {

		/**
		 * キャッシュのグループ
		 *
		 * @var string
		 */
		const CACHE_GROUP = 'vkfs';

		/**
		 * キャッシュのキー
		 *
		 * @var string
		 */
		private $cache_key;

		/**
		 * キャッシュの有効期限（秒）
		 *
		 * @var int
		 */
		private $expire;

		/**
		 * コンストラクタ
		 *
		 * @param string $cache_key キャッシュのキー.
		 * @param int    $expire    キャッシュの有効期限（秒）.
		 */
		public function __construct( $cache_key, $expire = HOUR_IN_SECONDS ) {
			$this->cache_key = (string) $cache_key;
			$this->expire    = (int) $expire;
		}

		/**
		 * 選択肢の並びを返す。保存済みならそれを返し、無ければ作って保存する
		 *
		 * @param array $elements  ターム（WP_Term）の配列.
		 * @param int   $max_depth 表示する階層の深さ.
		 * @param mixed ...$args   ウォーカーに渡す引数.
		 * @return string 選択肢（<option>）の並びの HTML.
		 */
		public function walk( $elements, $max_depth, ...$args ) {
			// 保存済みの並びがあれば、件数の数え直しなどを走らせずに返す
			$found  = false;
			$cached = wp_cache_get( $this->cache_key, self::CACHE_GROUP, false, $found );
			if ( $found && is_string( $cached ) ) {
				return $cached;
			}

			// 無ければ通常どおり作り、保存する
			$output = parent::walk( $elements, $max_depth, ...$args );
			wp_cache_set( $this->cache_key, $output, self::CACHE_GROUP, $this->expire );

			return $output;
		}
	}
}
