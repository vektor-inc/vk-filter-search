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
import compareVersions from 'compare-versions';

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
export const __getVKBlocks = () => [
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

	//WP5.5未満の場合
	if ( compareVersions( window.wpVersion, "5.5" ) < 0 ){
		//nameを削除
		delete metadata.name;
		//カテゴリ等を追加
		settings = {
			...settings,
			...metadata
		}

	} else {
		if ( metadata ) {
			unstable__bootstrapServerSideBlockDefinitions( { [ name ]: metadata } );
		}
	}
	registerBlockType( name, settings );
};

/**
 * Function to register VK Blocks.
 */
export const registerVKBlocks = (
	blocks = __getVKBlocks()
) => {
	blocks.forEach( registerBlock );
};