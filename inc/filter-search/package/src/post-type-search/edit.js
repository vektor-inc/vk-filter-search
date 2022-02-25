import { __ } from '@wordpress/i18n';
import { AdvancedCheckboxControl } from '@vk-filter-search/common/component';
import { PanelBody, BaseControl } from '@wordpress/components';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';

export default function PostTypeSearchEdit(props) {
	const { attributes } = props;

	const { isCheckedPostType } = attributes;

	let editContent;

	if (isCheckedPostType !== '[]') {
		editContent = (
			<ServerSideRender
				block="vk-filter-search/post-type-search"
				attributes={props.attributes}
			/>
		);
	} else {
		editContent = (
			<div className="vkfs_warning">
				<div className="vkfs__label-name">
					{__('Post Type', 'vk-filter-search-pro')}
				</div>
				<div className="vkfs__warning-text">
					{__(
						'This block will not be displayed because the post type is not selected.',
						'vk-filter-search-pro'
					)}
				</div>
			</div>
		);
	}

	const blockProps = useBlockProps({
		className: `vkfs-postType-search`,
	});

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={__('Post Type Option', 'vk-filter-search-pro')}
					initialOpen={true}
				>
					<BaseControl
						id={'vsfs02'}
						label={__('Post Types', 'vk-filter-search-pro')}
					>
						<AdvancedCheckboxControl
							schema={'isCheckedPostType'}
							rawData={
								//eslint-disable-next-line camelcase,no-undef
								vk_filter_search_params.post_type_checkbox
							}
							checkedData={JSON.parse(isCheckedPostType)}
							{...props}
						/>
					</BaseControl>
				</PanelBody>
			</InspectorControls>
			<div {...blockProps}>{editContent}</div>
		</>
	);
}
