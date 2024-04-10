<?php
/**
 * VK Input Categories
 *
 * @package VK Input Categories
 */

if ( function_exists( 'vk_dropdown_categories' ) || function_exists( 'vk_walk_category_dropdown_tree' ) ) {
	return;
}

/**
 * VK Dropdown Categories
 */
function vk_dropdown_categories( $args ) {
	$defaults = array(
		'show_option_all'   => '',
		'show_option_none'  => '',
		'orderby'           => 'id',
		'order'             => 'ASC',
		'post_type'         => '',
		'show_count'        => 0,
		'auto_count'        => 0,
		'operator'          => 'or',
		'hide_empty'        => 1,
		'child_of'          => 0,
		'exclude'           => '',
		'echo'              => 1,
		'selected'          => 0,
		'hierarchical'      => 0,
		'name'              => 'cat',
		'id'                => '',
		'class'             => 'postform',
		'depth'             => 0,
		'tab_index'         => 0,
		'taxonomy'          => 'category',
		'hide_if_empty'     => false,
		'option_none_value' => -1,
		'value_field'       => 'term_id',
		'required'          => false,
		'aria_describedby'  => '',
	);

	$li_class = 'vkfs__level-0';

	$defaults['selected'] = ( is_category() ) ? get_query_var( 'cat' ) : 0;

	// Parse incoming $args into an array and merge it with $defaults.
	$parsed_args = wp_parse_args( $args, $defaults );

	$option_none_value = $parsed_args['option_none_value'];

	if ( ! isset( $parsed_args['pad_counts'] ) && $parsed_args['show_count'] && $parsed_args['hierarchical'] ) {
		$parsed_args['pad_counts'] = true;
	}

	$tab_index = $parsed_args['tab_index'];

	$tab_index_attribute = '';
	if ( (int) $tab_index > 0 ) {
		$tab_index_attribute = " tabindex=\"$tab_index\"";
	}

	// Avoid clashes with the 'name' param of get_terms().
	$get_terms_args = $parsed_args;
	unset( $get_terms_args['name'] );
	$categories = get_terms( $get_terms_args );

	$name     = esc_attr( $parsed_args['name'] );
	$class    = esc_attr( $parsed_args['class'] );
	$id       = $parsed_args['id'] ? esc_attr( $parsed_args['id'] ) : $name;
	$required = $parsed_args['required'] ? 'required' : '';

	$aria_describedby_attribute = $parsed_args['aria_describedby'] ? ' aria-describedby="' . esc_attr( $parsed_args['aria_describedby'] ) . '"' : '';

	if ( ! $parsed_args['hide_if_empty'] || ! empty( $categories ) ) {
		$output = "<select $required name='$name' id='$id' class='$class'$tab_index_attribute$aria_describedby_attribute>\n";
	} else {
		$output = '';
	}
	if ( empty( $categories ) && ! $parsed_args['hide_if_empty'] && ! empty( $parsed_args['show_option_none'] ) ) {

		/**
		 * Filters a taxonomy drop-down display element.
		 *
		 * A variety of taxonomy drop-down display elements can be modified
		 * just prior to display via this filter. Filterable arguments include
		 * 'show_option_none', 'show_option_all', and various forms of the
		 * term name.
		 *
		 * @since 1.2.0
		 *
		 * @see wp_dropdown_categories()
		 *
		 * @param string       $element  Category name.
		 * @param WP_Term|null $category The category object, or null if there's no corresponding category.
		 */
		$show_option_none = apply_filters( 'list_cats', $parsed_args['show_option_none'], null );
		$output          .= "\t<option value='" . esc_attr( $option_none_value ) . "' selected='selected'>$show_option_none</option>\n";
	}

	if ( ! empty( $categories ) ) {
		if ( $parsed_args['show_option_all'] ) {

			/** This filter is documented in wp-includes/category-template.php */
			$show_option_all = apply_filters( 'list_cats', $parsed_args['show_option_all'], null );
			$selected        = ( '0' === (string) $parsed_args['selected'] ) ? " selected='selected'" : '';
			$output         .= "\t<option value='0'$selected>$show_option_all</option>\n";
		}

		if ( $parsed_args['show_option_none'] ) {

			/** This filter is documented in wp-includes/category-template.php */
			$show_option_none = apply_filters( 'list_cats', $parsed_args['show_option_none'], null );
			$selected         = selected( $option_none_value, $parsed_args['selected'], false );
			$output          .= "\t<option value='" . esc_attr( $option_none_value ) . "'$selected>$show_option_none</option>\n";
		}

		if ( $parsed_args['hierarchical'] ) {
			$depth = $parsed_args['depth'];  // Walk the full depth.
		} else {
			$depth = -1; // Flat.
		}
		$output .= vk_walk_category_dropdown_tree( $categories, $depth, $parsed_args );
	}

	if ( ! $parsed_args['hide_if_empty'] || ! empty( $categories ) ) {
		$output .= "</select>\n";
	}

	/**
	 * Filters the taxonomy drop-down output.
	 *
	 * @since 2.1.0
	 *
	 * @param string $output      HTML output.
	 * @param array  $parsed_args Arguments used to build the drop-down.
	 */
	$output = apply_filters( 'wp_dropdown_cats', $output, $parsed_args );

	if ( $parsed_args['echo'] ) {
		echo $output;
	}

	return $output;
}

/**
 * Retrieves HTML dropdown (select) content for category list.
 *
 * @since 2.1.0
 * @since 5.3.0 Formalized the existing `...$args` parameter by adding it
 *              to the function signature.
 *
 * @uses Walker_CategoryDropdown to create HTML dropdown content.
 * @see Walker::walk() for parameters and return description.
 *
 * @param mixed ...$args Elements array, maximum hierarchical depth and optional additional arguments.
 * @return string
 */
function vk_walk_category_dropdown_tree( ...$args ) {
	require_once __DIR__ . '/class-vk-walker-catrgory-dropdown.php';
	// The user's options are the third parameter.
	if ( empty( $args[2]['walker'] ) || ! ( $args[2]['walker'] instanceof Walker ) ) {
		$walker = new VK_Walker_CategoryDropdown();
	} else {
		/**
		 * @var Walker $walker
		 */
		$walker = $args[2]['walker'];
	}
	return $walker->walk( ...$args );
}
