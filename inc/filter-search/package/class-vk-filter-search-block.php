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
		add_filter( 'block_categories', array( __CLASS__, 'register_block_category' ), 10, 2 );
		add_action( 'init', array( __CLASS__, 'register_blocks' ) );
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

		$editor_css = 'build/editor.css';
		wp_register_style(
			'vk-filter-search-editor',
			plugins_url( $editor_css, __FILE__ ),
			array(),
			$asset_file['version']
		);

		$style_css = 'build/style.css';
		wp_register_style(
			'vk-filter-search-style',
			plugins_url( $style_css, __FILE__ ),
			array(),
			$asset_file['version']
		);

		wp_register_script(
			'vk-filter-search-js',
			plugins_url( '/build/block.js', __FILE__ ),
			$asset_file['dependencies'],
			$asset_file['version'],
			true
		);

		/**
		 * 選択させる投稿タイプのリストを生成し渡す
		 */
		// 投稿タイプ用のブロックで使うチェックボックスリスト.
		$post_type_checkbox = array();
		// アーカイブページで検索フォームを表示させる投稿タイプのチェックボックスリスト.
		$post_type_archive_checkbox = array();
		// フォーム用のブロックで使うプルダウンリスト.
		$post_type_select = array(
			array(
				'label' => __( 'Do not specify post type', 'vk-filter-search' ),
				'value' => '',
			),
		);

		// 投稿が空でない場合にリスト・選択肢に追加.
		$get_posts = get_posts(
			array(
				'post_type' => 'post',
			)
		);
		if ( ! empty( $get_posts ) ) {
			$post_type_checkbox[]         = array(
				'label' => get_post_type_object( 'post' )->labels->singular_name,
				'slug'  => get_post_type_object( 'post' )->name,
			);
			$post_type_archive_checkbox[] = array(
				'label' => get_post_type_object( 'post' )->labels->singular_name,
				'slug'  => get_post_type_object( 'post' )->name,
			);
			$post_type_select[]           = array(
				'label' => get_post_type_object( 'post' )->labels->singular_name,
				'value' => get_post_type_object( 'post' )->name,
			);

		}

		// 固定ページが空でない場合にリスト・選択肢に追加.
		$get_posts = get_posts(
			array(
				'post_type' => 'page',
			)
		);
		if ( ! empty( $get_posts ) ) {
			$post_type_checkbox[] = array(
				'label' => get_post_type_object( 'page' )->labels->singular_name,
				'slug'  => get_post_type_object( 'page' )->name,
			);
			$post_type_select[]   = array(
				'label' => get_post_type_object( 'page' )->labels->singular_name,
				'value' => get_post_type_object( 'page' )->name,
			);
		}

		// その他の投稿タイプが空でないい場合にリスト・選択肢に追加.
		$the_post_types = get_post_types(
			array(
				'public'   => true,
				'show_ui'  => true,
				'_builtin' => false,
			),
			'objects',
			'and'
		);
		foreach ( $the_post_types as $the_post_type ) {
			$get_posts = get_posts(
				array(
					'post_type' => $the_post_type->name,
				)
			);
			if ( ! empty( $get_posts ) ) {
				$post_type_checkbox[]         = array(
					'label' => $the_post_type->labels->singular_name,
					'slug'  => $the_post_type->name,
				);
				$post_type_archive_checkbox[] = array(
					'label' => $the_post_type->labels->singular_name,
					'slug'  => $the_post_type->name,
				);
				$post_type_select[]           = array(
					'label' => $the_post_type->labels->singular_name,
					'value' => $the_post_type->name,
				);
			}
		}

		/**
		 * 選択させるタクソノミーのリストを生成し渡す
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

		// タクソノミーブロックで警告を出す際に使うタクソノミーのリスト.
		$taxonomy_list = array();
		// タクソノミーブロックで使うタクソノミーの選択肢.
		$taxonomy_option = array(
			array(
				'label' => __( 'Do not specify taxonomy', 'vk-filter-search' ),
				'value' => '',
			),
		);
		foreach ( $the_taxonomies as $the_taxonomy ) {
			$taxonomy_list[] = array(
				'label' => $the_taxonomy->labels->singular_name,
				'value' => $the_taxonomy->name,
			);
			$terms           = get_terms( $the_taxonomy->name );
			if ( ! empty( $terms ) ) {
				$taxonomy_option[] = array(
					'label' => $the_taxonomy->labels->singular_name,
					'value' => $the_taxonomy->name,
				);
			}
		}

		// ブロックに値を渡す
		wp_localize_script(
			'vk-filter-search-js',
			'vk_filter_search_params',
			array(
				'home_url'                   => home_url( '/' ),
				'post_type_checkbox'         => $post_type_checkbox,
				'post_type_select'           => $post_type_select,
				'post_type_archive_checkbox' => $post_type_archive_checkbox,
				'taxonomy_list'              => $taxonomy_list,
				'taxonomy_option'            => $taxonomy_option,
			)
		);

		$block_array = array(
			'filter-search',
			'keyword-search',
			'post-type-search',
			'taxonomy-search',
		);

		foreach ( $block_array as $block ) {
			require_once plugin_dir_path( __FILE__ ) . 'src/' . $block . '/index.php';
		}
	}
}
new VK_Filter_Search_Block();
