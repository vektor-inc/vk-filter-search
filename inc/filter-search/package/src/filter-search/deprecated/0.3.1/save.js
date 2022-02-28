import { InnerBlocks } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

export default function save( props ) {
	const { attributes } = props;

	const { TargetPostType, DisplayOnResult } = attributes;

	const postId = wp.data.select( 'core/editor' ).getCurrentPostId();

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
			<input type="hidden" name="vkfs_form_id" value={ postId } />
		);
	} else {
		hiddenResult = '';
	}

	return (
		<form
			className={ `vk-filter-search vkfs` }
			method={ `get` }
			//eslint-disable-next-line camelcase,no-undef
			action={ vk_filter_search_params.home_url }
		>
			<div className={ `vkfs__labels` }>
				{ hiddenPostTypes }
				<InnerBlocks.Content />
			</div>
			[no_keyword_hidden_input]
			<input type="hidden" name="vkfs_submitted" value="true" />
			{ hiddenResult }
			<input
				className={ `btn btn-primary` }
				type={ `submit` }
				value={ __( 'Search', 'vk-filter-search' ) }
			/>
		</form>
	);
}
