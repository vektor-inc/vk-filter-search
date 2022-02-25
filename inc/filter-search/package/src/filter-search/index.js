import { ReactComponent as Icon } from './icon.svg';

import { __ } from '@wordpress/i18n';

import metadata from './block.json';
import edit from './edit';
import save from './save';
import deprecated from './deprecated/';

const { name } = metadata;

export { metadata, name };

export const settings = {
	title: __( 'VK Filter Search', 'vk-filter-search-pro' ),
	icon: <Icon />,
	example: {
		attributes: {
			TargetPostType: 'post',
			DisplayOnResult: false,
			FormID: null,
		},
		innerBlocks: [
			{
				name: 'vk-filter-search/taxonomy-search',
				attributes: {
					isSelectedTaxonomy: 'category',
				},
			},
			{
				name: 'vk-filter-search/taxonomy-search',
				attributes: {
					isSelectedTaxonomy: 'post_tag',
				},
			},
			{
				name: 'vk-filter-search/keyword-search',
			},
		],
	},
	edit,
	save,
	deprecated,
};
