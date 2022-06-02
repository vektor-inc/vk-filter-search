import { AdvancedCheckboxControl } from '@vk-filter-search/common/component';

import { __ } from '@wordpress/i18n';
import {
	InnerBlocks,
	InspectorControls,
	useBlockProps,
} from '@wordpress/block-editor';
import {
	PanelBody,
	BaseControl,
	SelectControl,
	ToggleControl,
} from '@wordpress/components';
import { useEffect } from '@wordpress/element';

export default function FilterSearchEdit(props) {
	const { attributes, setAttributes, clientId } = props;

	const {
		TargetPostType,
		DisplayOnResult,
		DisplayOnPosttypeArchive,
		FormID,
		PostID,
	} = attributes;

	//eslint-disable-next-line camelcase,no-undef
	const isBlockTheme = vk_filter_search_params.isBlockTheme;

	useEffect(() => {
		if (clientId) {
			if (FormID === null || FormID === undefined) {
				setAttributes({ FormID: clientId });
			}

			if (PostID === null || PostID === undefined) {
				setAttributes({
					PostID: wp.data.select('core/editor').getCurrentPostId(),
				});
			}
		}
	}, [clientId]);

	let allowedBlocks;
	let hiddenPostTypes;

	if (TargetPostType === '') {
		allowedBlocks = [
			'vk-filter-search/keyword-search',
			'vk-filter-search/post-type-search',
			'vk-filter-search/taxonomy-search',
		];
		hiddenPostTypes = '';
	} else {
		allowedBlocks = [
			'vk-filter-search/keyword-search',
			'vk-filter-search/taxonomy-search',
		];
		hiddenPostTypes = (
			<input type="hidden" name="post_type" value={TargetPostType} />
		);
	}

	let hiddenResult;
	if (DisplayOnResult) {
		hiddenResult = (
			<input type="hidden" name="vkfs_form_id" value={FormID} />
		);
	} else {
		hiddenResult = '';
	}

	const blockProps = useBlockProps({
		className: `vk-filter-search vkfs`,
	});

	let blockThemeAlert = '';
	if (isBlockTheme && DisplayOnResult) {
		blockThemeAlert = (
			<p
				className={`vkfs__alert vkfs__alert--danger vkfs__alert--blockTheme`}
			>
				{__(
					'If you want to display the Search Form on the results screen, you need to put a "Search Result Form" block in the "Search" template on theme editor.',
					'vk-filter-search'
				)}
			</p>
		);
	}

	let blockThemeAlertArchive = '';

	if (isBlockTheme && '[]' !== DisplayOnPosttypeArchive) {
		blockThemeAlertArchive = (
			<p
				className={`vkfs__alert vkfs__alert--danger vkfs__alert--blockTheme`}
			>
				{__(
					'If you want to display the Search Form on the Post Type Archive screen, you need to put a "Search Result Form" block in the "Archive" template on theme editor.',
					'vk-filter-search'
				)}
				{__(
					'Alternatively, uncheck it and place the search form directly in the archive page template.',
					'vk-filter-search'
				)}
			</p>
		);
	}

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={__('Search Form Setting', 'vk-filter-search')}
					initialOpen={true}
				>
					<BaseControl id={'vkfs-search-form-01'}>
						<SelectControl
							label={__(
								'Target of Post Type',
								'vk-filter-search'
							)}
							value={TargetPostType}
							//eslint-disable-next-line camelcase,no-undef
							options={vk_filter_search_params.post_type_select}
							onChange={(value) =>
								setAttributes({ TargetPostType: value })
							}
						/>
					</BaseControl>
					<BaseControl id={'vkfs-search-form-02'}>
						<ToggleControl
							label={__(
								'Display this form on search result page',
								'vk-filter-search'
							)}
							checked={DisplayOnResult}
							onChange={(checked) =>
								setAttributes({
									DisplayOnResult: checked,
								})
							}
						/>
						{blockThemeAlert}
					</BaseControl>
					<BaseControl
						id={'vkfs-search-form-03'}
						label={__(
							'Display on post type archive.',
							'vk-filter-search'
						)}
					>
						<AdvancedCheckboxControl
							schema={'DisplayOnPosttypeArchive'}
							rawData={
								//eslint-disable-next-line camelcase,no-undef
								vk_filter_search_params.post_type_archive_checkbox
							}
							checkedData={JSON.parse(DisplayOnPosttypeArchive)}
							{...props}
						/>
						{blockThemeAlertArchive}
					</BaseControl>
				</PanelBody>
			</InspectorControls>
			<form
				{...blockProps}
				method={`get`}
				//eslint-disable-next-line camelcase,no-undef
				action={vk_filter_search_params.home_url}
			>
				<div className={`vkfs__labels`}>
					<InnerBlocks
						allowedBlocks={allowedBlocks}
						templateLock={false}
						template={[
							[
								'vk-filter-search/taxonomy-search',
								{
									isSelectedTaxonomy: 'category',
								},
							],
							[
								'vk-filter-search/taxonomy-search',
								{
									isSelectedTaxonomy: 'post_tag',
								},
							],
							['vk-filter-search/keyword-search'],
						]}
					/>
				</div>
				{hiddenPostTypes}
				{hiddenResult}
				<input type="hidden" name="vkfs_submitted" value="true" />
				<button className={`btn btn-primary`} type={`submit`}>
					{__('Search', 'vk-filter-search')}
				</button>
			</form>
		</>
	);
}
