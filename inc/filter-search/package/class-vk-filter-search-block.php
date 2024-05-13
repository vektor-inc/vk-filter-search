<?php
/**
 * VK Fiter Search block
 *
 * @package VK Filter Search
 */

/**
 * VK Filter Search Block
 */
class VK_Filter_Search_Block {

	/**
	 * Constructor
	 */
	public function __construct() {
		// ver5.8.0 block_categories_all
		if ( function_exists( 'get_default_block_categories' ) && function_exists( 'get_block_editor_settings' ) ) {
			add_filter( 'block_categories_all', array( __CLASS__, 'register_block_category' ), 10, 2 );
		} else {
			add_filter( 'block_categories', array( __CLASS__, 'register_block_category' ), 10, 2 );
		}
		add_action( 'init', array( __CLASS__, 'register_blocks' ), 11 );
		add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'set_block_data' ) );
	}

	/**
	 * 現在のテーマがブロックテーマか否か
	 */
	public static function is_block_theme() {

		if ( function_exists( 'wp_is_block_theme' ) ) {
			$is_block_theme = wp_is_block_theme();
		} else {
			$is_block_theme = false;
		}
		return $is_block_theme;
	}

	/**
	 * ブロックに必要なデータを設定
	 */
	public static function get_block_data() {

		// データを初期化
		$data = array(
			'post_type_checkbox'         => array(),
			'post_type_archive_checkbox' => array(),
			'post_type_select'           => array(
				array(
					'label' => __( 'Any', 'vk-filter-search' ),
					'value' => '',
				),
			),
			'taxonomy_list'              => array(),
			'taxonomy_option'            => array(
				array(
					'label' => __( 'Any', 'vk-filter-search' ),
					'value' => '',
				),
			),
		);

		// 投稿タイプのリスト
		$post_types_all = array(
			'post' => 'post',
			'page' => 'page',
		);
		$post_types_all = array_merge(
			$post_types_all,
			get_post_types(
				array(
					'public'   => true,
					'show_ui'  => true,
					'_builtin' => false,
				),
				'names',
				'and'
			)
		);
		foreach ( $post_types_all as $post_type ) {

			// 投稿タイプのオブジェクトを取得
			$post_type_object = get_post_type_object( $post_type );

			// 投稿があるかないか判定
			$get_posts = get_posts(
				array(
					'post_type'        => $post_type_object->name,
					'suppress_filters' => false,
				)
			);

			// 投稿があれば配列に追加
			if ( ! empty( $get_posts ) ) {
				// 投稿タイプのチェックボックスリストに投稿タイプを追加
				$data['post_type_checkbox'][] = array(
					'label' => $post_type_object->labels->singular_name,
					'slug'  => $post_type_object->name,
				);
				// 投稿タイプの選択肢に投稿タイプを追加
				$data['post_type_select'][] = array(
					'label' => $post_type_object->labels->singular_name,
					'value' => $post_type_object->name,
				);
			}
		}

		// 投稿タイプ（アーカイブあり）のリスト
		$post_types_has_archive = array(
			'post' => 'post',
		);
		$post_types_has_archive = array_merge(
			$post_types_has_archive,
			get_post_types(
				array(
					'public'      => true,
					'show_ui'     => true,
					'has_archive' => true,
					'_builtin'    => false,
				),
				'names',
				'and'
			)
		);
		foreach ( $post_types_has_archive as $post_type ) {

			// 投稿タイプのオブジェクトを取得
			$post_type_object = get_post_type_object( $post_type );

			// 投稿があるかないか判定
			$get_posts = get_posts(
				array(
					'post_type'        => $post_type_object->name,
					'suppress_filters' => false,
				)
			);

			// 投稿があれば配列に追加
			if ( ! empty( $get_posts ) ) {
				// 投稿タイプ（アーカイブあり）のチェックボックスリストに投稿タイプを追加
				$data['post_type_archive_checkbox'][] = array(
					'label' => $post_type_object->labels->singular_name,
					'slug'  => $post_type_object->name,
				);
			}
		}

		/**
		 * タクソノミーの選択肢のリスト
		 */
		// タクソノミーリストを生成.
		$the_taxonomies = get_taxonomies(
			array(
				'public'  => true,
				'show_ui' => true,
			),
			'objects',
			'and'
		);
		foreach ( $the_taxonomies as $the_taxonomy ) {
			$data['taxonomy_list'][] = array(
				'label' => $the_taxonomy->labels->singular_name,
				'value' => $the_taxonomy->name,
			);
			$terms                   = get_terms( $the_taxonomy->name );
			if ( ! empty( $terms ) ) {
				$data['taxonomy_option'][] = array(
					'label' => $the_taxonomy->labels->singular_name,
					'value' => $the_taxonomy->name,
				);
			}
		}
		$data = apply_filters( 'vkfs_block_data', $data );

		return $data;
	}

	/**
	 * Register Block Category
	 *
	 * @param array  $categories Block Categories.
	 * @param Object $post       Post Object.
	 */
	public static function register_block_category( $categories, $post ) {

		foreach ( $categories as $key => $value ) {
			$keys[] = $value['slug'];
		}

		if ( ! in_array( 'vk-blocks-cat', $keys, true ) ) {
			$categories = array_merge(
				$categories,
				array(
					array(
						'slug'  => 'vk-blocks-cat',
						'title' => __( 'VK Blocks', 'vk-filter-search' ),
						'icon'  => '',
					),
				)
			);
		}

		return $categories;
	}

	/**
	 * Register Blocks
	 */
	public static function register_blocks() {

		$asset_file = include plugin_dir_path( __FILE__ ) . '/build/block.asset.php';

		wp_register_style(
			'vk-filter-search-editor',
			VKFS_FREE_MODULE_ROOT_URL . 'build/editor.css',
			array(),
			VKFS_FREE_MODULE_VERSION
		);

		wp_register_style(
			'vk-filter-search-style',
			VKFS_FREE_MODULE_ROOT_URL . 'build/style.css',
			array(),
			VKFS_FREE_MODULE_VERSION
		);

		wp_register_script(
			'vk-filter-search-block',
			plugins_url( '/build/block.js', __FILE__ ),
			$asset_file['dependencies'],
			VKFS_FREE_MODULE_VERSION,
			true
		);

		$block_array = array(
			'filter-search',
			'keyword-search',
			'post-type-search',
			'taxonomy-search',
			'search-result-form',
			'search-result-title',
			'call-filter-search',
		);

		foreach ( $block_array as $block ) {
			require_once plugin_dir_path( __FILE__ ) . 'src/' . $block . '/index.php';
		}
	}

	/**
	 * Set Block Data
	 */
	public static function set_block_data() {
		// ブロックデータを取得
		$block_data = self::get_block_data();

		// ブロックに値を渡す
		wp_localize_script(
			'vk-filter-search-block',
			'vk_filter_search_params',
			array(
				'home_url'                   => home_url( '/' ),
				'post_type_checkbox'         => $block_data['post_type_checkbox'],
				'post_type_select'           => $block_data['post_type_select'],
				'post_type_archive_checkbox' => $block_data['post_type_archive_checkbox'],
				'taxonomy_list'              => $block_data['taxonomy_list'],
				'taxonomy_option'            => $block_data['taxonomy_option'],
				'isBlockTheme'               => self::is_block_theme(),
			)
		);
	}
}
new VK_Filter_Search_Block();
