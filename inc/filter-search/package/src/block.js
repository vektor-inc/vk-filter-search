/**
 * WordPress dependencies
 */
import '@wordpress/core-data';
import '@wordpress/notices';
// import '@wordpress/block-editor';
import {
	registerBlockType,
	unstable__bootstrapServerSideBlockDefinitions,
} from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import * as filterSearch from './filter-search';
import * as keywordSearch from './keyword-search';
import * as postTypeSearch from './post-type-search';
import * as taxonomySearch from './taxonomy-search';

/**
 * Function to get all the VK Blocks in an array.
 */
export const __getVKFilterSearchBlocks = () => [
	filterSearch,
	keywordSearch,
	postTypeSearch,
	taxonomySearch,
];

/**
 * Function to register an individual block.
 *
 * @param {Object} block The block to be registered.
 *
 */
const registerBlock = ( block ) => {
	if ( ! block ) {
		return;
	}

	let { metadata, settings, name } = block;

	if ( metadata ) {
		unstable__bootstrapServerSideBlockDefinitions( { [ name ]: metadata } );
	}
	registerBlockType( name, settings );
};

/**
 * Function to register VK Blocks.
 */
__getVKFilterSearchBlocks().forEach( registerBlock );