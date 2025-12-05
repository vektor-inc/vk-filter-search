/**
 * Get URL Queries
 */
/* eslint camelcase: 0 */
/* eslint no-shadow: 0 */
import {
	query_string,
	get_url_queries,
} from '@vk-filter-search/common/enqueue-front-component';

const form_html = document.getElementsByClassName( `vk-filter-search` );
const url_queries = get_url_queries();
const normalized_query_keys = [
	...new Set(
		Object.keys( url_queries )
			.map( ( key ) => {
				let normalized = key.replace( /^vkfs_/, '' );
				if ( normalized === 'keyword' ) {
					normalized = 's';
				}
				return normalized;
			} )
			.filter( ( key ) => {
				if ( key === '' ) {
					return false;
				}
				if ( key === 'submitted' ) {
					return false;
				}
				if ( key === 'form_id' ) {
					return false;
				}
				return true;
			} )
	),
];

const get_query_value = ( key ) => {
	if ( key === 's' ) {
		if ( url_queries.s !== undefined ) {
			return url_queries.s;
		}
		if ( url_queries.keyword !== undefined ) {
			return url_queries.keyword;
		}
	}
	if ( url_queries[ key ] !== undefined ) {
		return url_queries[ key ];
	}
	return url_queries[ `vkfs_${ key }` ];
};

const set_query_value = ( i ) => {
	normalized_query_keys.forEach( ( key ) => {
		const query_value = get_query_value( key );
		if ( query_value === undefined ) {
			return;
		}
		let value_array;
		if ( query_value.indexOf( ',' ) !== -1 ) {
			value_array = query_value.split( ',' );
		} else {
			value_array = [ query_value ];
		}
		if ( key === 's' ) {
			const keyword_selector = form_html[ i ].querySelector(
				'.vkfs__keyword input[name="s"]'
			);
			if ( keyword_selector !== null ) {
				keyword_selector.value = decodeURI( query_value );
			}
		} else if ( key === 'post_type' ) {
			const post_type_select_selector = form_html[ i ].querySelectorAll(
				'.vkfs__input-wrap--select.vkfs__input-wrap--post_type'
			);
			if (
				post_type_select_selector !== null &&
				post_type_select_selector !== undefined
			) {
				for ( let j = 0; j < post_type_select_selector.length; j++ ) {
					const post_type_select_options =
						post_type_select_selector[ j ].querySelectorAll(
							'option'
						);
					if (
						post_type_select_options !== null &&
						post_type_select_options !== undefined
					) {
						for (
							let k = 0;
							k < post_type_select_options.length;
							k++
						) {
							Object.keys( value_array ).forEach( ( key ) => {
								if (
									post_type_select_options[ k ].value ===
									decodeURI( value_array[ key ] )
								) {
									post_type_select_options[
										k
									].selected = true;
								}
							} );
						}
					}
				}
			}
		} else {
			const taxonomy_select_selector = form_html[ i ].querySelectorAll(
				`.vkfs__input-wrap--select.vkfs__input-wrap--${ key }`
			);
			if (
				taxonomy_select_selector !== null &&
				taxonomy_select_selector !== undefined
			) {
				for ( let j = 0; j < taxonomy_select_selector.length; j++ ) {
					const taxonomy_select_options =
						taxonomy_select_selector[ j ].querySelectorAll(
							'option'
						);
					if (
						taxonomy_select_options !== null &&
						taxonomy_select_options !== undefined
					) {
						for (
							let k = 0;
							k < taxonomy_select_options.length;
							k++
						) {
							Object.keys( value_array ).forEach( ( key ) => {
								if (
									taxonomy_select_options[ k ].value ===
									decodeURI( value_array[ key ] )
								) {
									taxonomy_select_options[
										k
									].selected = true;
								}
							} );
						}
					}
				}
			}
		}
	} );
};

if ( query_string.indexOf( 'vkfs_submitted=true' ) === -1 ) {
	for ( let i = 0; i < form_html.length; i++ ) {
		set_query_value( i );
	}
}
