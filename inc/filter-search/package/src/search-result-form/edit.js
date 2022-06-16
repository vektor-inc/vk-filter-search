import ServerSideRender from '@wordpress/server-side-render';
import { useBlockProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

export default function KeywordSearchEdit() {
	const blockProps = useBlockProps( {
		className: `vkfs-search-result-form`,
	} );

	let editContent = '';
	const pathString = window.location.pathname;
	if (
		pathString.indexOf( 'site-editor.php' ) !== -1 ||
		pathString.indexOf( 'post.php' ) !== -1 ||
		pathString.indexOf( 'post-new.php' ) !== -1
	) {
		editContent = (
			<div className="vkfs__alert vkfs__alert--warning">
				<div className="vkfs__alert-title">
					{ __( 'Search Result Form', 'vk-filter-search' ) }
				</div>
				<p>
					{ __(
						'This block is to display search form that made on another page.',
						'vk-filter-search'
					) }
					{ __(
						'It use to "Post Type Archive Template" or "Search Result Template" for Block Theme.',
						'vk-filter-search'
					) }
					{ __(
						'The form is not displayed on the theme editor, but it is displayed on the actual publishing screen.',
						'vk-filter-search'
					) }
				</p>
			</div>
		);
	} else {
		editContent = (
			<ServerSideRender block="vk-filter-search/search-result-form" />
		);
	}

	return <div { ...blockProps }>{ editContent }</div>;
}
