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

		wp_register_style(
			'vk-filter-search',
			plugins_url( '/assets/css/style.css', __FILE__ ),
			array(),
			$plugin_version
		);

		wp_register_style(
			'vk-filter-search-editor',
			plugins_url( '/assets/css/editor.css', __FILE__ ),
			array( 'wp-edit-blocks' ),
			$plugin_version
		);

		wp_register_script(
			'vk-filter-search',
			plugins_url( '/assets/js/block.js', __FILE__ ),
			array( 'wp-components', 'wp-data', 'wp-element', 'wp-polyfill' ),
			$plugin_version,
			true
		);

		wp_set_script_translations( 'vk-filter-search', 'vk-filter-search', plugin_dir_path( __FILE__ ) . '/languages/' );

		register_block_type(
			'vk-filter-search/filter-search',
			array(
				'attributes'      => array_merge(
					array(
						'name'              => array(
							'type'    => 'string',
							'default' => 'vk-filter-search/filter-search',
						),
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
					),
				),
				'style'           => 'vk-filter-search',
				'editor_style'    => 'vk-filter-search-editor',
				'editor_script'   => 'vk-filter-search',
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
