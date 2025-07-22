import { ReactComponent as Icon } from './icon.svg';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';
import edit from './edit';

const { name } = metadata;

export { metadata, name };

export const settings = {
	icon: <Icon />,
	attributes: {
		...metadata.attributes,
		queriesFormat: {
			type: 'string',
			// translators: %s is replaced with search query
			default: __( 'Search Result for %s', 'vk-filter-search' ),
		},
		queryDateMinFormat: {
			type: 'string',
			// translators: %s is replaced with date
			default: __( 'From %s', 'vk-filter-search' ),
		},
		queryDateMaxFormat: {
			type: 'string',
			// translators: %s is replaced with date
			default: __( 'To %s', 'vk-filter-search' ),
		},
		queryDaterRangeFormat: {
			type: 'string',
			// translators: %1$s is replaced with date1, %2$s is replaced with date2
			default: __( 'From %1$s to %2$s', 'vk-filter-search' ),
		},
		queriesAfter: {
			type: 'string',
			default: ' | ' + VKSearchTitle.blogInfoName, //eslint-disable-line no-undef
		},
	},
	edit,
};
