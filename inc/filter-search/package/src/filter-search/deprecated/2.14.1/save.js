import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

export default function save( props ) {
	const { attributes } = props;

	const { TargetPostType } = attributes;

	let hiddenPostTypes;

	if ( TargetPostType === '' ) {
		hiddenPostTypes = '';
	} else {
		hiddenPostTypes = (
			<input
				type="hidden"
				name="vkfs_post_type[]"
				value={ TargetPostType }
			/>
		);
	}

	const blockProps = useBlockProps.save( {
		className: `vk-filter-search vkfs`,
	} );

	return (
		<form
			{ ...blockProps }
			method={ `get` }
			//eslint-disable-next-line camelcase,no-undef
			action={ vk_filter_search_params.home_url }
		>
			<div className={ `vkfs__labels` }>
				<InnerBlocks.Content />
			</div>
			[no_keyword_hidden_input]
			{ hiddenPostTypes }
			[filter_search_result_input]
			<input type="hidden" name="vkfs_submitted" value="true" />
			<button className={ `btn btn-primary` } type={ `submit` }>
				{ __( 'Search', 'vk-filter-search' ) }
			</button>
		</form>
	);
}
