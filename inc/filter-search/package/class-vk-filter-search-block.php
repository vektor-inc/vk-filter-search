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
		add_filter( 'render_block', array( __CLASS__, 'render_block_control' ), 10, 2 );
		add_action( 'loop_start', array( __CLASS__, 'display_form_on_loop' ) );
		add_filter( 'vkfs_form_content', 'do_blocks', 9 );
		add_filter( 'vkfs_form_content', 'wptexturize' );
		add_filter( 'vkfs_form_content', 'convert_smilies', 20 );
		add_filter( 'vkfs_form_content', 'shortcode_unautop' );
		add_filter( 'vkfs_form_content', 'prepend_attachment' );
		add_filter( 'vkfs_form_content', 'wp_filter_content_tags' );
		add_filter( 'vkfs_form_content', 'do_shortcode', 11 );
		add_filter( 'vkfs_form_content', 'capital_P_dangit', 11 );
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

		wp_localize_script( 'vk-filter-search-js', 'vk_filter_search_url', site_url( '/' ) );

		// 選択可能なリストを抽出.
		$option_posts = array(
			array(
				'label' => __( 'Unspecified', 'vk-filter-search' ),
				'value' => -1,
			),
		);

		$the_args = array(
			'posts_per_page' => -1,
			'post_type'      => 'vk-filter-search',
		);

		$the_posts = get_posts( $the_args );

		foreach ( $the_posts as $the_post ) {
			if ( has_block( 'vk-filter-search/filter-search', $the_post->ID ) ) {
				$option_posts[] = array(
					'label' => $the_post->post_title,
					'value' => $the_post->ID,
				);
			}
		}
		wp_localize_script( 'vk-filter-search-js', 'vk_filter_search_posts', $option_posts );

		if ( function_exists( 'wp_set_script_translations' ) ) {
			wp_set_script_translations( 'vk-filter-search-js', 'vk-filter-search', VKFS_PATH . '/languages' );
		}

		// call-search-form.
		register_block_type(
			'vk-filter-search/call-search-form',
			array(
				'style'           => 'vk-filter-search',
				'editor_style'    => 'vk-filter-search-editor',
				'editor_script'   => 'vk-filter-search-js',
				'attributes'      => array(
					'TargetPost' => array(
						'type'    => 'number',
						'default' => -1,
					),
				),
				'render_callback' => array( __CLASS__, 'render_call_form_callback' ),
			)
		);

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
			'vk-filter-search/taxonomy-search',
			array(
				'style'           => 'vk-filter-search',
				'editor_style'    => 'vk-filter-search-editor',
				'editor_script'   => 'vk-filter-search-js',
				'attributes'      => array(
					'isSelectedTaxonomy' => array(
						'type'    => 'string',
						'default' => 'category',
					),
				),
				'render_callback' => array( __CLASS__, 'render_taxonomy_callback' ),
			),
		);
	}

	/**
	 * Rendering Call Filter Search Block
	 *
	 * @param array $attributes attributes.
	 * @param html  $content content.
	 */
	public static function render_call_form_callback( $attributes, $content = '' ) {
		$attributes = wp_parse_args(
			$attributes,
			array(
				'TargetPost' => -1,
			)
		);
		$vkfs_before_form_id = ! empty( $attributes['TargetPost'] ) ? $attributes['TargetPost'] : -1;
		return apply_filters( 'vkfs_form_content', get_post( $vkfs_before_form_id )->post_content );
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
				'isSelectedTaxonomy' => 'category',
			)
		);

		$taxonomy = ! empty( $attributes['isSelectedTaxonomy'] ) ? $attributes['isSelectedTaxonomy'] : '';

		return VK_Filter_Search::get_taxonomy_form_html( $taxonomy );
	}

	/**
	 * Render Block Control
	 *
	 * @param string $block_content The block content about to be appended.
	 * @param array  $block         The full block, including name and attributes.
	 */
	public static function render_block_control( $block_content, $block ) {
		if ( has_block( 'vk-filter-search/filter-search' ) && ! has_block( 'vk-filter-search/keyword-search' ) ) {
			$block_content = str_replace( '[no_keyword_hidden_input]', '<input type="hidden" name="s" value="" />', $block_content );
		} else {
			$block_content = str_replace( '[no_keyword_hidden_input]', '', $block_content );
		}
		return $block_content;
	}

	/**
	 * Display Search Form on Loop
	 */
	public static function display_form_on_loop() {
		if ( isset( $_GET['vkfs_form_id'] ) ) {
			$form_id = intval( sanitize_text_field( wp_unslash( $_GET['vkfs_form_id'] ) ) );

			$content_html = apply_filters( 'vkfs_form_content', get_post( $form_id )->post_content );
			$allowed_html = array(
				'div'    => array(
					'id'    => array(),
					'class' => array(),
				),
				'label'  => array(
					'id'    => array(),
					'class' => array(),
					'for'   => array(),
				),
				'input'  => array(
					'id'          => array(),
					'class'       => array(),
					'type'        => array(),
					'name'        => array(),
					'value'       => array(),
					'placeholder' => array(),
					'checked'     => array(),
				),
				'select' => array(
					'id'    => array(),
					'class' => array(),
					'name'  => array(),
				),
				'option' => array(
					'id'       => array(),
					'class'    => array(),
					'value'    => array(),
					'selected' => array(),
				),
			);
			if ( is_search() ) {
				echo wp_kses( $content_html, $allowed_html );
			}
		}
	}
}
new VK_Filter_Search_Block();
