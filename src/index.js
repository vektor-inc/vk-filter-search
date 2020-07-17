import { registerBlockType } from '@wordpress/blocks';
import ServerSideRender from '@wordpress/server-side-render';

registerBlockType( 'vk-filter-search/filter-search', {
    title: 'VK Filter Search',
    icon: 'search',
    category: 'widgets',

    edit: ( props ) => {
        return (
            <ServerSideRender
                block="vk-filter-search/filter-search"
                attributes={ props.attributes }
            />
        );
    },
} );