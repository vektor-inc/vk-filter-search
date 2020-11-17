const { InnerBlocks } = wp.blockEditor;
const { __ } = wp.i18n;

export const deprecated_from_0_4_6 = {
	attributes: {
		TargetPostType: {
			type: 'string',
			default: '',
		},
		DisplayOnResult: {
			type: 'boolean',
			default: false,
		},
		FormID: {
			type: 'string',
			default: null,
		},
	},
	save: ( props ) => {
		const { attributes } = props;

		const {
			TargetPostType,
			DisplayOnResult,
			FormID
		} = attributes;

		let hiddenPostTypes;

		if ( TargetPostType === '' ) {
			hiddenPostTypes = '';
		}
		else {
			hiddenPostTypes = <input type="hidden" name="vkfs_post_type[]" value={ TargetPostType } />;
		}

		let hiddenResult;
		if ( DisplayOnResult ) {
			hiddenResult = <input type="hidden" name="vkfs_form_id" value={ FormID } />;
		} else {
			hiddenResult = '';
		}

		return (
				<form className={ `vk-filter-search vkfs`} method={ `get` } action={ vk_filter_search_url }>
					<div className={ `vkfs__labels` } >
						<InnerBlocks.Content />
					</div>
					[no_keyword_hidden_input]
					{ hiddenPostTypes }
					{ hiddenResult }
					<input type="hidden" name="vkfs_submitted" value="true" />
					<input className={`btn btn-primary`} type={`submit`} value={ __( 'Search', 'vk-filter-search' ) } />
				</form>
		);
	},
};