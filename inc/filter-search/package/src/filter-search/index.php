<?php

/**
 * Registers the `vk-filter-search/filter-search` block.
 */
if( function_exists('register_block_type_from_metadata')) {

	function register_block_vkfs_filter_search() {
		register_block_type_from_metadata(
			__DIR__,
			array(
				'style'           => 'vk-filter-search',
				'editor_style'    => 'vk-filter-search-editor',
				'editor_script'   => 'vk-filter-search-js',
				'attributes'      => array(
					'TargetPostType'           => array(
						'type'    => 'string',
						'default' => '',
					),
					'DisplayOnResult'          => array(
						'type'    => 'boolean',
						'default' => false,
					),
					'DisplayOnPosttypeArchive' => array(
						'type'    => 'string',
						'default' => '[]',
					),
					'FormID'                   => array(
						'type'    => 'string',
						'default' => null,
					),
					'PostID'                   => array(
						'type'    => 'number',
						'default' => null,
					),
				),
				'render_callback' => 'render_filter_search_callback',
			)
		);
	}
	add_action( 'init', 'register_block_vkfs_filter_search', 99 );
}

/**
 * Rendering Filter Search Block
 *
 * @param array $attributes attributes.
 * @param html  $content content.
 */
function render_filter_search_callback( $attributes, $content = '' ) {
	$attributes = wp_parse_args(
		$attributes,
		array(
			'TargetPostType'           => '',
			'DisplayOnResult'          => false,
			'DisplayOnPosttypeArchive' => '[]',
			'FormID'                   => null,
			'PostID'                   => null,
		)
	);

	if ( false === strpos( $content, 'vkfs__keyword' ) ) {
		$content = str_replace( '[no_keyword_hidden_input]', '<input type="hidden" name="s" value="" />', $content );
	} else {
		$content = str_replace( '[no_keyword_hidden_input]', '', $content );
	}

	if ( ! empty( $attributes['DisplayOnPosttypeArchive'] ) ) {
		$attributes['DisplayOnPosttypeArchive'] = str_replace( '[', '', $attributes['DisplayOnPosttypeArchive'] );
		$attributes['DisplayOnPosttypeArchive'] = str_replace( ']', '', $attributes['DisplayOnPosttypeArchive'] );
		$attributes['DisplayOnPosttypeArchive'] = str_replace( '"', '', $attributes['DisplayOnPosttypeArchive'] );
	}

	$post_types = ! empty( $attributes['DisplayOnPosttypeArchive'] ) ? explode( ',', $attributes['DisplayOnPosttypeArchive'] ) : array();

	$options = VK_Filter_Search::get_options();

	if ( true === $attributes['DisplayOnResult'] ) {
		$options['display_on_result'][ $attributes['FormID'] ] = array(
			'form_post_id' => $attributes['PostID'],
			'form_content' => $content,
		);
	} else {
		unset( $options['display_on_result'][ $attributes['FormID'] ] );
	}

	if ( ! empty( $post_types ) ) {
		$options['display_on_post_type_archive'][ $attributes['FormID'] ] = array(
			'display_post_type' => $post_types,
			'form_post_id'      => $attributes['PostID'],
			'form_content'      => $content,
		);
	} else {
		unset( $options['display_on_post_type_archive'][ $attributes['FormID'] ] );
	}

	update_option( 'vk_filter_search', $options );

	return $content;
}