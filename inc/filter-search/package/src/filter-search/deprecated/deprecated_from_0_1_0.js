const { InnerBlocks } = wp.blockEditor;
const { __ } = wp.i18n;

export const deprecated_from_0_1_0 = {
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

		let hiddenPostTypes;

		if ( TargetPostType === '' ) {
			hiddenPostTypes = '';
		}
		else {
			hiddenPostTypes = <input type="hidden" name="post_type" value={ TargetPostType } />;
		}

		return (
				<form className={ `vk-filter-search vkfs`} method={ `get` } action={ vk_filter_search_url }>
					<div className={ `vkfs__labels` } >
						{ hiddenPostTypes }
						<InnerBlocks.Content />
					</div>
					[no_keyword_hidden_input]
					<input className={`btn btn-primary`} type={`submit`} value={ __( 'Refine search', 'vk-filter-search' ) } />
				</form>
		);
	}
};