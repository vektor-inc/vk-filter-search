import { InnerBlocks } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

export default function save( props ) {
	const { attributes } = props;

	const { TargetPostType, DisplayOnResult, FormID } = attributes;

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

	let hiddenResult;
	if ( DisplayOnResult ) {
		hiddenResult = (
			<input type="hidden" name="vkfs_form_id" value={ FormID } />
		);
	} else {
		hiddenResult = '';
	}

	return (
		<form
			className={ `vk-filter-search vkfs` }
			method={ `get` }
			//eslint-disable-next-line camelcase,no-undef
			action={ vk_filter_search_url }
		>
			<div className={ `vkfs__labels` }>
				<InnerBlocks.Content />
			</div>
			[no_keyword_hidden_input]
			{ hiddenPostTypes }
			{ hiddenResult }
			<input type="hidden" name="vkfs_submitted" value="true" />
			<input
				className={ `btn btn-primary` }
				type={ `submit` }
				value={ __( 'Search', 'vk-filter-search' ) }
			/>
		</form>
	);
}
