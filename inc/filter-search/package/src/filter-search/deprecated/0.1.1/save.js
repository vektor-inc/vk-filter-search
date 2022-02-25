import { InnerBlocks } from '@wordpress/block-editor';
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
			<input
				className={ `btn btn-primary` }
				type={ `submit` }
				value={ __( 'Refine search', 'vk-filter-search-pro' ) }
			/>
		</form>
	);
}
