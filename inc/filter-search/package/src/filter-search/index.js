import { ReactComponent as Icon } from './icon.svg';
import metadata from './block.json';
import edit from './edit';
import save from './save';
import deprecated from './deprecated/';

const { name } = metadata;

export { metadata, name };

export const settings = {
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
