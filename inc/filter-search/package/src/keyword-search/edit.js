import ServerSideRender from '@wordpress/server-side-render';
import { useBlockProps } from '@wordpress/block-editor';

export default function KeywordSearchEdit() {
	const blockProps = useBlockProps( {
		className: `vkfs-keyword-search`,
	} );

	return (
		<div { ...blockProps }>
			<ServerSideRender block="vk-filter-search/keyword-search" />
		</div>
	);
}
