import { AdvancedCheckboxControl } from '../common/component';

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

export default function FilterSearchEdit( props ) {
	const { attributes, setAttributes, clientId } = props;

	const {
		TargetPostType,
		DisplayOnResult,
		DisplayOnPosttypeArchive,
		FormID,
		PostID,
	} = attributes;

	if ( FormID === null || FormID === undefined ) {
		setAttributes( { FormID: clientId } );
	}

	if ( PostID === null || PostID === undefined ) {
		setAttributes( {
			PostID: wp.data.select( 'core/editor' ).getCurrentPostId(),
		} );
	}

	let allowedBlocks;
	let hiddenPostTypes;

	if ( TargetPostType === '' ) {
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
			<input type="hidden" name="post_type" value={ TargetPostType } />
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

	const blockProps = useBlockProps( {
		className: `vk-filter-search vkfs`,
	} );

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __( 'Target of Post Type', 'vk-filter-search' ) }
					initialOpen={ true }
				>
					<BaseControl id={ 'vkfs-search-form-01' }>
						<SelectControl
							label={ __(
								'Target of Post Type',
								'vk-filter-search'
							) }
							value={ TargetPostType }
							//eslint-disable-next-line camelcase,no-undef
							options={ vk_filter_search_post_type_select }
							onChange={ ( value ) =>
								setAttributes( { TargetPostType: value } )
							}
						/>
					</BaseControl>
					<BaseControl id={ 'vkfs-search-form-02' }>
						<ToggleControl
							label={ __(
								'Display this form on search result page',
								'vk-filter-search'
							) }
							checked={ DisplayOnResult }
							onChange={ ( checked ) =>
								setAttributes( {
									DisplayOnResult: checked,
								} )
							}
						/>
					</BaseControl>
					<BaseControl
						id={ 'vkfs-search-form-03' }
						label={ __(
							'Display on post type archive.',
							'vk-filter-search'
						) }
					>
						<AdvancedCheckboxControl
							schema={ 'DisplayOnPosttypeArchive' }
							rawData={
								//eslint-disable-next-line camelcase,no-undef
								vk_filter_search_post_type_archive_checkbox
							}
							checkedData={ JSON.parse(
								DisplayOnPosttypeArchive
							) }
							{ ...props }
						/>
					</BaseControl>
				</PanelBody>
			</InspectorControls>
			<form
				{ ...blockProps }
				method={ `get` }
				//eslint-disable-next-line camelcase,no-undef
				action={ vk_filter_search_url }
			>
				<div className={ `vkfs__labels` }>
					<InnerBlocks
						allowedBlocks={ allowedBlocks }
						templateLock={ false }
						template={ [
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
							[ 'vk-filter-search/keyword-search' ],
						] }
					/>
				</div>
				{ hiddenPostTypes }
				{ hiddenResult }
				<input type="hidden" name="vkfs_submitted" value="true" />
				<input
					className={ `btn btn-primary` }
					type={ `submit` }
					value={ __( 'Search', 'vk-filter-search' ) }
				/>
			</form>
		</>
	);
}
