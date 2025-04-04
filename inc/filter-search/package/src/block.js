/**
 * WordPress dependencies
 */
import '@wordpress/core-data';
import '@wordpress/notices';
// import '@wordpress/block-editor';
import {
	registerBlockType,
	unstable__bootstrapServerSideBlockDefinitions, // eslint-disable-line camelcase
} from '@wordpress/blocks';
import { vkfsCategoryIcon } from './block-category';

/**
 * Internal dependencies
 */
import * as callFilterSearch from './call-filter-search';
import * as filterSearch from './filter-search';
import * as keywordSearch from './keyword-search';
import * as searchResultCount from './search-result-count';
import * as searchResultForm from './search-result-form';
import * as searchResultTitle from './search-result-title';
import * as postTypeSearch from './post-type-search';
import * as taxonomySearch from './taxonomy-search';

/**
 * Function to get all the VK Blocks in an array.
 */
export const __getVKFilterSearchBlocks = () => [
	callFilterSearch,
	filterSearch,
	searchResultCount,
	searchResultForm,
	searchResultTitle,
	keywordSearch,
	postTypeSearch,
	taxonomySearch,
];

/**
 * Function to register an individual block.
 *
 * @param {Object} block The block to be registered.
 */
const registerBlock = ( block ) => {
	if ( ! block ) {
		return;
	}

	const { metadata, settings, name } = block;

	if ( metadata ) {
		unstable__bootstrapServerSideBlockDefinitions( { [ name ]: metadata } );
	}
	registerBlockType( name, settings );
};

/**
 * Function to register VK Blocks.
 */
__getVKFilterSearchBlocks().forEach( registerBlock );

vkfsCategoryIcon();
