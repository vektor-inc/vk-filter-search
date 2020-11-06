const { InnerBlocks } = wp.blockEditor;
const { __ } = wp.i18n;

export const deprecated_v2 = {
	attributes: {
		TargetPostType: {
			type: 'string',
			default: '',
		},
	},
	save: ( props ) => {
		const { attributes } = props;

		const {
			TargetPostType,
		} = attributes;

		const post_id = wp.data.select("core/editor").getCurrentPostId();

		let hiddenPostTypes;

		if ( TargetPostType === '' ) {
			hiddenPostTypes = '';
		}
		else {
			hiddenPostTypes = <input type="hidden" name="vkfs_post_type[]" value={ TargetPostType } />;
		}

		return (
				<form className={ `vk-filter-search vkfs`} method={ `get` } action={ vk_filter_search_url }>
					<div className={ `vkfs__labels` } >
						{ hiddenPostTypes }
						<InnerBlocks.Content />
					</div>
					[no_keyword_hidden_input]
					<input type="hidden" name="vkfs_submitted" value="true" />
					<input type="hidden" name="vkfs_form_id" value={ post_id } />
					<input className={`btn btn-primary`} type={`submit`} value={ __( 'Refine search', 'vk-filter-search' ) } />
				</form>
		);
	},
};