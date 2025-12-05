/**
 * Get URL Queries
 */
/* eslint camelcase: 0 */
/* eslint no-shadow: 0 */

import {
	get_url_queries,
	query_string,
} from '@vk-filter-search/common/enqueue-front-component';

const generate_query_strings = () => {
	const url_queries = get_url_queries();
	const search_query = {};
	Object.keys( url_queries ).forEach( ( key ) => {
		if ( key === 's' || key === 'keyword' ) {
			let keyword = String( url_queries[ key ] || '' );
			keyword = keyword.replace( /\+/g, ' ' );
			keyword = decodeURIComponent( keyword );
			keyword = keyword.replace( /　/g, '+' ); // eslint-disable-line no-irregular-whitespace
			keyword = encodeURIComponent( keyword );
			search_query.keyword = `keyword=${ keyword }`;
		} else if ( key === 'vkfs_post_type' ) {
			search_query.post_type = `post_type=${ url_queries[ key ] }`;
		} else if ( key === 'vkfs_category' ) {
			search_query.category_name = `category_name=${ url_queries[ key ] }`;
			if ( url_queries.vkfs_category_operator === 'and' ) {
				search_query.category_name = search_query.category_name.replace(
					/,/g,
					'+'
				);
			}
		} else if ( key === 'vkfs_post_tag' ) {
			search_query.post_tag = `tag=${ url_queries[ key ] }`;
			if ( url_queries.vkfs_post_tag_operator === 'and' ) {
				search_query.post_tag = search_query.post_tag.replace(
					/,/g,
					'+'
				);
			}
		} else if ( key !== 'vkfs_submitted' && key !== 'vkfs_form_id' ) {
			if ( key.indexOf( '_operator' ) === -1 ) {
				const taxonomy_key = key.replace( 'vkfs_', '' );
				search_query[
					taxonomy_key
				] = `${ taxonomy_key }=${ url_queries[ key ] }`;
				if (
					url_queries[ `vkfs_${ taxonomy_key }_operator` ] === 'and'
				) {
					search_query[ taxonomy_key ] = search_query[
						taxonomy_key
					].replace( /,/g, '+' );
				}
			}
		} else if ( key === 'vkfs_form_id' ) {
			search_query.vkfs_form_id = `vkfs_form_id=${ url_queries[ key ] }`;
		}
	} );

	return search_query;
};

const build_redirect_url = () => {
	const search_query = { ...generate_query_strings() };
	if ( search_query.post_type === undefined ) {
		search_query.post_type = 'post_type=any';
	}
	// If post_type includes "any" alongside other types, drop "any".
	if ( search_query.post_type ) {
		const postTypeValue = search_query.post_type.replace(
			/^post_type=/,
			''
		);
		const postTypes = postTypeValue.split( ',' ).filter( Boolean );
		if ( postTypes.includes( 'any' ) && postTypes.length > 1 ) {
			const filtered = postTypes.filter( ( type ) => type !== 'any' );
			search_query.post_type = `post_type=${ filtered.join( ',' ) }`;
		}
	}
	const vkParams =
		typeof window !== 'undefined' &&
		typeof window.vk_filter_search_params !== 'undefined'
			? window.vk_filter_search_params
			: {};
	const result_page_url = vkParams.search_result_url || '';
	const uses_result_page = result_page_url !== '';
	let search_url = uses_result_page
		? result_page_url
		: vkParams.home_url || '';
	if ( search_url === '' ) {
		return null;
	}
	let hasQueryParams = search_url.indexOf( '?' ) !== -1;
	if ( search_query.keyword === undefined ) {
		search_query.keyword = 'keyword=';
	}
	const legacyKeywordParam = search_query.keyword.replace(
		/^keyword=/,
		's='
	);

	const append_query = ( query ) => {
		if ( query === undefined ) {
			return;
		}
		if ( ! hasQueryParams ) {
			search_url += '?' + query;
			hasQueryParams = true;
		} else {
			search_url += '&' + query;
		}
	};

	if ( search_query.post_type !== undefined ) {
		if ( uses_result_page ) {
			append_query(
				search_query.post_type.replace(
					/^post_type=/,
					'vkfs_post_type='
				)
			);
		} else {
			append_query( search_query.post_type );
		}
	}
	append_query( search_query.category_name );
	append_query( search_query.post_tag );
	Object.keys( search_query ).forEach( ( query ) => {
		if (
			search_query[ query ] !== undefined &&
			query !== 'post_type' &&
			query !== 'category_name' &&
			query !== 'post_tag' &&
			query !== 'keyword' &&
			query !== 'vkfs_form_id'
		) {
			append_query( search_query[ query ] );
		}
	} );
	if ( uses_result_page ) {
		append_query( search_query.keyword );
	} else {
		append_query( legacyKeywordParam );
	}
	append_query( search_query.vkfs_form_id );
	return search_url;
};

if ( query_string.indexOf( 'vkfs_submitted=true' ) !== -1 ) {
	const redirect_url = build_redirect_url();
	if ( redirect_url ) {
		if ( window.location.replace ) {
			window.location.replace( redirect_url );
		} else {
			window.location.href = redirect_url;
		}
	} else {
		// eslint-disable-next-line no-console
		console.warn( 'vkfs: redirect_url is invalid, skipping redirect' );
	}
}
