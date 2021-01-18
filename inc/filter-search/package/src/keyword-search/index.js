import { __ } from '@wordpress/i18n';
import { ReactComponent as Icon } from './icon.svg';

import metadata from './block.json';
import edit from './edit';

const { name } = metadata;

export { metadata, name };

export const settings = {
	title: __( 'VK Keyword Search', 'vk-filter-search' ),
	icon: <Icon />,
	category: 'vk-blocks-cat',
	edit,
};
