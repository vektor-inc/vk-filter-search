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

		$editor_css = '../../../build/index.css';
		wp_register_style(
			'vk-filter-search-editor',
			plugins_url( $editor_css, __FILE__ ),
			array(),
			$plugin_version
		);

		$style_css = '../../../build/style-index.css';
		wp_register_style(
			'vk-filter-search',
			plugins_url( $style_css, __FILE__ ),
			array(),
			$plugin_version
		);

		wp_register_script(
			'vk-filter-search-js',
			plugins_url( '../../../build/index.js', __FILE__ ),
			array( 'wp-components', 'wp-data', 'wp-element', 'wp-polyfill', 'wp-i18n' ),
			$plugin_version,
			true
		);

		wp_set_script_translations( 'vk-filter-search-js', 'vk-filter-search', VKFS_PATH . '/languages' );

		register_block_type(
			'vk-filter-search/filter-search',
			array(
				'attributes'      => array_merge(
					array(
						'showKeyword'       => array(
							'type'    => 'boolean',
							'default' => true,
						),
						'isCheckedPostType' => array(
							'type'    => 'string',
							'default' => '["post","page"]',
						),
						'isCheckedTaxonomy' => array(
							'type'    => 'string',
							'default' => '["category","post_tag"]',
						),
					)
				),
				'style'           => 'vk-filter-search',
				'editor_style'    => 'vk-filter-search-editor',
				'editor_script'   => 'vk-filter-search-js',
				'render_callback' => array( __CLASS__, 'render_callback' ),
			)
		);
	}

	/**
	 * Rendering Block
	 *
	 * @param array $attributes attributes.
	 * @param html  $content content.
	 */
	public static function render_callback( $attributes, $content = '' ) {
		$attributes = wp_parse_args(
			$attributes,
			array(
				'showKeyword'       => true,
				'isCheckedPostType' => '["post","page"]',
				'isCheckedTaxonomy' => '["category","post_tag"]',
			)
		);

		if ( ! empty( $attributes['isCheckedPostType'] ) ) {
			$attributes['isCheckedPostType'] = str_replace( '[', '', $attributes['isCheckedPostType'] );
			$attributes['isCheckedPostType'] = str_replace( ']', '', $attributes['isCheckedPostType'] );
			$attributes['isCheckedPostType'] = str_replace( '"', '', $attributes['isCheckedPostType'] );
		}

		if ( ! empty( $attributes['isCheckedTaxonomy'] ) ) {
			$attributes['isCheckedTaxonomy'] = str_replace( '[', '', $attributes['isCheckedTaxonomy'] );
			$attributes['isCheckedTaxonomy'] = str_replace( ']', '', $attributes['isCheckedTaxonomy'] );
			$attributes['isCheckedTaxonomy'] = str_replace( '"', '', $attributes['isCheckedTaxonomy'] );
		}

		$keyword    = ! empty( $attributes['showKeyword'] ) ? $attributes['showKeyword'] : false;
		$post_types = ! empty( $attributes['isCheckedPostType'] ) ? explode( ',', $attributes['isCheckedPostType'] ) : array();
		$taxonomies = ! empty( $attributes['isCheckedTaxonomy'] ) ? explode( ',', $attributes['isCheckedTaxonomy'] ) : array();

		return VK_Filter_Search::get_search_form_html( $keyword, $post_types, $taxonomies );
	}
}
new VK_Filter_Search_Block();
