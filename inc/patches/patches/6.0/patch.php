<?php
/**
 * VK Fiter Search Patch for WP 6.0
 *
 * @package VK Filter Search
 */

 /**
  * WordPress 6.0 のバグで記事のないタームが表示される問題を修正
  * https://github.com/vektor-inc/vk-filter-search-pro/pull/187
  */
add_filter(
	'terms_clauses',
	function( $clauses, $taxonomies, $args ) {
		$get_terms_data = array(
			'clauses'    => $clauses,
			'taxonomies' => $taxonomies,
			'args'       => $args,
		);
		add_filter(
			'terms_pre_query',
			function( $terms, $class_object ) use ( $get_terms_data ) {
				$args       = $get_terms_data['args'];
				$fields     = $args['fields'];
				$taxonomies = $get_terms_data['taxonomies'];

				$cache_args = wp_array_slice_assoc( $args, array_keys( $class_object->query_var_defaults ) );
				unset( $cache_args['pad_counts'], $cache_args['update_term_meta_cache'] );

				if ( ! empty( $fields ) && 'count' !== $fields && 'all_with_object_id' !== $fields ) {
					$cache_args['fields'] = 'all';
				}

				$key          = md5( serialize( $cache_args ) . serialize( $taxonomies ) . $class_object->request );
				$last_changed = wp_cache_get_last_changed( 'terms' );
				$cache_key    = "get_terms:$key:$last_changed";

				wp_cache_delete( $cache_key, 'terms' );

				return $terms;
			},
			10,
			2
		);
		return $clauses;
	},
	10,
	3
);
