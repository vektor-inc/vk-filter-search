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
		add_action( 'init', array( __CLASS__, 'register_block' ) );
	}

	/**
	 * VK Filter Search Block
	 */
	public static function register_block() {
		global $plugin_version;

		$script_dependencies = include dirname( __FILE__ ) . '/build/index.asset.php';

		$editor_css = 'build/index.css';
		wp_register_style(
			'vk-filter-search-editor',
			plugins_url( $editor_css, __FILE__ ),
			array(),
			$plugin_version
		);

		$style_css = 'build/style-index.css';
		wp_register_style(
			'vk-filter-search',
			plugins_url( $style_css, __FILE__ ),
			array(),
			$plugin_version
		);

		wp_register_script(
			'vk-filter-search-js',
			plugins_url( '/build/index.js', __FILE__ ),
			$script_dependencies['dependencies'],
			$plugin_version,
			true
		);

		if ( function_exists( 'wp_set_script_translations' ) ) {
			wp_set_script_translations( 'vk-filter-search-js', 'vk-filter-search', VKFS_PATH . '/languages' );
		}

		// filter-search.
		register_block_type(
			'vk-filter-search/filter-search',
			array(
				'style'         => 'vk-filter-search',
				'editor_style'  => 'vk-filter-search-editor',
				'editor_script' => 'vk-filter-search-js',
			)
		);

		// keyword-search.
		register_block_type(
			'vk-filter-search/keyword-search',
			array(
				'style'           => 'vk-filter-search',
				'editor_style'    => 'vk-filter-search-editor',
				'editor_script'   => 'vk-filter-search-js',
				'render_callback' => array( __CLASS__, 'render_keyword_callback' ),
			)
		);

		// post-type-search.
		register_block_type(
			'vk-filter-search/post-type-search',
			array(
				'style'           => 'vk-filter-search',
				'editor_style'    => 'vk-filter-search-editor',
				'editor_script'   => 'vk-filter-search-js',
				'attributes'      => array(
					'isCheckedPostType' => array(
						'type'    => 'string',
						'default' => '["post","page"]',
					),
				),
				'render_callback' => array( __CLASS__, 'render_post_type_callback' ),
			)
		);

		// taxmony-search.
		register_block_type(
			'vk-filter-search/taxmony-search',
			array(
				'style'           => 'vk-filter-search',
				'editor_style'    => 'vk-filter-search-editor',
				'editor_script'   => 'vk-filter-search-js',
				'attributes'      => array(
					'isCheckedTaxonomy' => array(
						'type'    => 'string',
						'default' => 'category',
					),
				),
				'render_callback' => array( __CLASS__, 'render_taxonomy_callback' ),
			)
		);
	}

	/**
	 * Rendering Keyword Search Block
	 *
	 * @param array $attributes attributes.
	 * @param html  $content content.
	 */
	public static function render_keyword_callback( $attributes, $content = '' ) {
		return VK_Filter_Search::get_keyword_form_html();
	}

	/**
	 * Rendering Post Type Search Block
	 *
	 * @param array $attributes attributes.
	 * @param html  $content content.
	 */
	public static function render_post_type_callback( $attributes, $content = '' ) {
		$attributes = wp_parse_args(
			$attributes,
			array(
				'isCheckedPostType' => '["post","page"]',
			)
		);

		if ( ! empty( $attributes['isCheckedPostType'] ) ) {
			$attributes['isCheckedPostType'] = str_replace( '[', '', $attributes['isCheckedPostType'] );
			$attributes['isCheckedPostType'] = str_replace( ']', '', $attributes['isCheckedPostType'] );
			$attributes['isCheckedPostType'] = str_replace( '"', '', $attributes['isCheckedPostType'] );
		}

		$post_types = ! empty( $attributes['isCheckedPostType'] ) ? explode( ',', $attributes['isCheckedPostType'] ) : array();

		return VK_Filter_Search::get_post_type_form_html( $post_types );
	}

	/**
	 * Rendering Taxonomy Search Block
	 *
	 * @param array $attributes attributes.
	 * @param html  $content content.
	 */
	public static function render_taxonomy_callback( $attributes, $content = '' ) {
		$attributes = wp_parse_args(
			$attributes,
			array(
				'isCheckedTaxonomy' => 'category',
			)
		);

		$taxonomy = ! empty( $attributes['isCheckedTaxonomy'] ) ? $attributes['isCheckedTaxonomy'] : '';

		return VK_Filter_Search::get_taxonomy_form_html( $taxonomy );
	}
}
new VK_Filter_Search_Block();
