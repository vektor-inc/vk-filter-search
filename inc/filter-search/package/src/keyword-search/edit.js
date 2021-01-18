import ServerSideRender from '@wordpress/serverSideRender';

export default function KeywordSearchEdit() {
	return (
		<>
			<ServerSideRender block="vk-filter-search/keyword-search" />
		</>
	);
}
