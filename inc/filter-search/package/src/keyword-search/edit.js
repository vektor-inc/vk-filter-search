import ServerSideRender from '@wordpress/server-side-render';

export default function KeywordSearchEdit() {
	return (
		<ServerSideRender block="vk-filter-search/keyword-search" />
	);
}
