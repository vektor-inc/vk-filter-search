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
import { select } from '@wordpress/data';
import { useEffect } from '@wordpress/element';

export default function FilterSearchEdit( props ) {
	const { attributes, setAttributes, clientId } = props;

	const {
		TargetPostType,
		DisplayOnResult,
		DisplayOnPosttypeArchive,
		FormID,
	} = attributes;

	const pathString = window.location.pathname;

	//eslint-disable-next-line camelcase,no-undef
	const isBlockTheme = vk_filter_search_params.isBlockTheme;

	let currentPostType = null;
	let currentPostID = null;
	if (
		pathString.indexOf( 'site-editor.php' ) === -1 &&
		pathString.indexOf( 'widgets.php' ) === -1
	) {
		currentPostType = select( 'core/editor' ).getCurrentPostType();
		currentPostID = select( 'core/editor' ).getCurrentPostId();
	}

	const isParentReusableBlock = !! select(
		'core/block-editor'
	).getBlockParentsByBlockName( clientId, [ 'core/block' ] ).length;

	useEffect( () => {
		if ( clientId ) {
			// 先祖のブロックに再利用ブロックがない場合
			if ( ! isParentReusableBlock.length ) {
				// 投稿タイプが Filter Search の場合は現在の投稿 ID をそうでなければブロックの ID を FormID に格納
				if ( currentPostType === 'filter-search' && !! currentPostID ) {
					setAttributes( { FormID: currentPostID } );
				} else {
					setAttributes( { FormID: clientId } );
				}
				// 一応投稿 ID を PostID に格納しておく
				setAttributes( {
					PostID: !! currentPostID ? currentPostID : null,
				} );
			}
		}
	}, [ clientId ] );

	let blockThemeAlert = '';
	if ( isBlockTheme && DisplayOnResult ) {
		blockThemeAlert = (
			<p
				className={ `vkfs__alert vkfs__alert--danger vkfs__alert--blockTheme` }
			>
				{ __(
					'If you want to display the Search Form on the results screen, you need to put a "Search Result Form" block in the "Search" template on theme editor.',
					'vk-filter-search'
				) }
			</p>
		);
	}

	let blockThemeAlertArchive = '';

	if ( isBlockTheme && '[]' !== DisplayOnPosttypeArchive ) {
		blockThemeAlertArchive = (
			<p
				className={ `vkfs__alert vkfs__alert--danger vkfs__alert--blockTheme` }
			>
				{ __(
					'If you want to display the Search Form on the Post Type Archive screen, you need to put a "Search Result Form" block in the "Archive" template on theme editor.',
					'vk-filter-search'
				) }
				{ __(
					'Alternatively, uncheck it and place the search form directly in the archive page template.',
					'vk-filter-search'
				) }
			</p>
		);
	}

	let formOptionControl = '';
	if (
		pathString.indexOf( 'site-editor.php' ) === -1 &&
		pathString.indexOf( 'widgets.php' ) === -1
	) {
		formOptionControl = (
			<>
				<BaseControl id={ 'vkfs-search-form-DisplayOnResult' }>
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
					{ blockThemeAlert }
				</BaseControl>
				<BaseControl
					id={ 'vkfs-search-form-DisplayOnPosttypeArchive' }
					label={ __(
						'Display on post type archive.',
						'vk-filter-search'
					) }
				>
					<AdvancedCheckboxControl
						schema={ 'DisplayOnPosttypeArchive' }
						rawData={
							//eslint-disable-next-line camelcase,no-undef
							vk_filter_search_params.post_type_archive_checkbox
						}
						checkedData={ JSON.parse( DisplayOnPosttypeArchive ) }
						{ ...props }
					/>
					{ blockThemeAlertArchive }
				</BaseControl>
			</>
		);
	}

	let hiddenPostTypes;

	if ( TargetPostType === '' ) {
		hiddenPostTypes = '';
	} else {
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
					title={ __( 'Search Form Setting', 'vk-filter-search' ) }
					initialOpen={ true }
				>
					<BaseControl id={ 'vkfs-search-TargetPostType' }>
						<SelectControl
							label={ __(
								'Target of Post Type',
								'vk-filter-search'
							) }
							value={ TargetPostType }
							//eslint-disable-next-line camelcase,no-undef
							options={ vk_filter_search_params.post_type_select }
							onChange={ ( value ) =>
								setAttributes( { TargetPostType: value } )
							}
						/>
					</BaseControl>
					{ formOptionControl }
				</PanelBody>
				<PanelBody
					title={ __( 'VK Filter Search', 'vk-filter-search' ) }
					initialOpen={ true }
					className={ 'vkfs__pro' }
				>
					<BaseControl id={ 'vkfs-search-form-03' }>
						<p>
							<strong>
								{ __(
									'Get more features',
									'vk-filter-search'
								) }
							</strong>
						</p>
						<ul>
							<li>
								{ __( 'Post date search', 'vk-filter-search' ) }
							</li>
							<li>
								{ __(
									'Search Result Single Order',
									'vk-filter-search'
								) }
							</li>
							<li>
								{ __(
									'Custom Field Search (beta)',
									'vk-filter-search'
								) }
							</li>
							<li>
								{ __(
									'Editable text for search buttons, labels and placeholder',
									'vk-filter-search'
								) }
							</li>
						</ul>
						<p>{ __( 'and more…', 'vk-filter-search' ) }</p>
						<a
							className={ 'button button-primary' }
							target={ '_blank' }
							href={ __(
								'https://vk-filter-search.com/',
								'vk-filter-search'
							) }
							rel="noreferrer"
						>
							<span>
								{ __(
									'Check the Pro Features',
									'vk-filter-search'
								) }
							</span>
						</a>
					</BaseControl>
				</PanelBody>
			</InspectorControls>
			<form
				{ ...blockProps }
				method={ `get` }
				//eslint-disable-next-line camelcase,no-undef
				action={ vk_filter_search_params.home_url }
			>
				<div className={ `vkfs__labels` }>
					<InnerBlocks
						// allowedBlocks は子ブロックの block.json から parent で指定されている
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
				<button className={ `btn btn-primary` } type={ `submit` }>
					{ __( 'Search', 'vk-filter-search' ) }
				</button>
			</form>
		</>
	);
}
