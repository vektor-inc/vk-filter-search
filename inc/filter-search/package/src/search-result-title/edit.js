import { __, sprintf } from '@wordpress/i18n';
import {
	PanelBody,
	BaseControl,
	TextControl,
	SelectControl,
	Button,
	ButtonGroup,
} from '@wordpress/components';
import {
	InspectorControls,
	useBlockProps,
	BlockControls,
	AlignmentControl,
} from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';

/* eslint-disable @wordpress/i18n-translator-comments */
export default function SearchTitleEdit( props ) {
	const { attributes, setAttributes } = props;

	const {
		outerTagName,
		textAlign,
		queriesFormat,
		queryTitleDisplay,
		queryTitleAfter,
		queryElementOR,
		queryElementAND,
		queryElementBefore,
		queryElementAfter,
		queryElementsAfter,
		queryDateMinFormat,
		queryDateMaxFormat,
		queryDaterRangeFormat,
	} = attributes;

	const vkfsIsPro = VKSearchTitle.vkfsIsPro; // eslint-disable-line no-undef
	const minDate =
		queryElementBefore + VKSearchTitle.minDate + queryElementAfter; // eslint-disable-line no-undef
	const maxDate =
		queryElementBefore + VKSearchTitle.maxDate + queryElementAfter; // eslint-disable-line no-undef

	const blockProps = useBlockProps( {
		className: `vkfs-search-result-title has-text-align-${ textAlign }`,
	} );

	const pathString = window.location.pathname;

	let editContent = '';
	if (
		pathString.indexOf( 'site-editor.php' ) === -1 &&
		pathString.indexOf( 'widgets.php' ) === -1 &&
		pathString.indexOf( 'post-new.php' ) === -1 &&
		pathString.indexOf( 'post.php' ) === -1
	) {
		editContent = (
			<div { ...blockProps }>
				<ServerSideRender
					block="vk-filter-search/search-result-title"
					attributes={ props.attributes }
				/>
			</div>
		);
	} else {
		// 投稿タイプのクエリタイトル
		const postTypeQueryTitle =
			queryTitleDisplay === true
				? __( 'Post Type', 'vk-filter-search' ) + queryTitleAfter
				: '';

		// ジャンルのクエリタイトル
		const genreQueryTitle =
			queryTitleDisplay === true
				? __( 'Genre', 'vk-filter-search' ) + queryTitleAfter
				: '';

		// エリアのクエリタイトル
		const areaQueryTitle =
			queryTitleDisplay === true
				? __( 'Area', 'vk-filter-search' ) + queryTitleAfter
				: '';

		// 投稿日のクエリタイトル
		const postDateQueryTitle =
			queryTitleDisplay === true
				? __( 'Post Date', 'vk-filter-search' ) + queryTitleAfter
				: '';

		// 更新日のクエリタイトル
		const postModifiedaQueryTitle =
			queryTitleDisplay === true
				? __( 'Post Modified', 'vk-filter-search' ) + queryTitleAfter
				: '';

		// キーワードのクエリタイトル
		const keywordQueryTitle =
			queryTitleDisplay === true
				? __( 'Keyword', 'vk-filter-search' ) + queryTitleAfter
				: '';

		// 投稿タイプのタイトル
		const postTypeTitle =
			postTypeQueryTitle +
			queryElementBefore +
			__( 'Event', 'vk-filter-search' ) +
			queryElementAfter +
			queryElementsAfter;

		// ジャンルのタイトル
		const genreTitle = vkfsIsPro
			? genreQueryTitle +
			  queryElementBefore +
			  __( 'Web', 'vk-filter-search' ) +
			  queryElementAfter +
			  queryElementAND +
			  queryElementBefore +
			  __( 'Product', 'vk-filter-search' ) +
			  queryElementAfter +
			  queryElementsAfter
			: genreQueryTitle +
			  queryElementBefore +
			  __( 'Product', 'vk-filter-search' ) +
			  queryElementAfter +
			  queryElementsAfter;

		// エリアのタイトル
		const areaTitle = vkfsIsPro
			? areaQueryTitle +
			  queryElementBefore +
			  __( 'Aichi', 'vk-filter-search' ) +
			  queryElementAfter +
			  queryElementOR +
			  queryElementBefore +
			  __( 'Tokyo', 'vk-filter-search' ) +
			  queryElementAfter +
			  queryElementsAfter
			: areaQueryTitle +
			  queryElementBefore +
			  __( 'Aichi', 'vk-filter-search' ) +
			  queryElementAfter +
			  queryElementsAfter;

		// 投稿日のタイトル
		const postDateTitle =
			postDateQueryTitle +
			sprintf( queryDaterRangeFormat, minDate, maxDate ) +
			queryElementsAfter;

		// 更新日のタイトル
		const postModifiedTitle =
			postModifiedaQueryTitle +
			sprintf( queryDateMinFormat, minDate ) +
			queryElementsAfter;

		// キーワードのタイトル
		const keywordTitle =
			keywordQueryTitle +
			queryElementBefore +
			__( 'WordPress', 'vk-filter-search' ) +
			queryElementAfter +
			queryElementsAfter;

		// 検索結果のタイトル
		let searchTitle = vkfsIsPro
			? sprintf(
					queriesFormat,
					postTypeTitle +
						genreTitle +
						areaTitle +
						postDateTitle +
						postModifiedTitle +
						keywordTitle
			  )
			: sprintf(
					queriesFormat,
					postTypeTitle + genreTitle + areaTitle + keywordTitle
			  );
		searchTitle = searchTitle.slice( 0, searchTitle.length - 3 );
		const Tag = outerTagName;
		editContent = <Tag { ...blockProps }>{ searchTitle }</Tag>;
	}

	return (
		<>
			<BlockControls group="block">
				<AlignmentControl
					value={ textAlign }
					onChange={ ( value ) => {
						setAttributes( { textAlign: value } );
					} }
				/>
			</BlockControls>
			<InspectorControls>
				<PanelBody
					title={ __( 'Search Title Option', 'vk-filter-search' ) }
					initialOpen={ true }
				>
					<BaseControl id={ 'vkfs_searchTitle_outerTagName' }>
						<SelectControl
							label={ __( 'HTML element', 'vk-filter-search' ) }
							value={ outerTagName }
							options={ [
								{ label: 'Default (<div>)', value: 'div' },
								{ label: '<h1>', value: 'h1' },
								{ label: '<h2>', value: 'h2' },
							] }
							onChange={ ( value ) =>
								setAttributes( { outerTagName: value } )
							}
						/>
					</BaseControl>
					<BaseControl id={ 'vkfs_searchTitle_queriesFormat' }>
						<TextControl
							label={ __(
								'Queries title format',
								'vk-filter-search'
							) }
							value={ queriesFormat }
							onChange={ ( value ) =>
								setAttributes( { queriesFormat: value } )
							}
							help={ __(
								'eg) Search Result for %s',
								'vk-filter-search'
							) }
						/>
					</BaseControl>
					<BaseControl
						id={ 'vkfs_searchTitle_queryTitleDisplay' }
						label={ __(
							'Queries titile display',
							'vk-filter-search'
						) }
					>
						<ButtonGroup>
							<Button
								variant={
									queryTitleDisplay === true
										? 'primary'
										: 'secondary'
								}
								onClick={ () =>
									setAttributes( { queryTitleDisplay: true } )
								}
							>
								{ __( 'Display', 'vk-filter-search' ) }
							</Button>
							<Button
								variant={
									queryTitleDisplay === false
										? 'primary'
										: 'secondary'
								}
								onClick={ () =>
									setAttributes( {
										queryTitleDisplay: false,
									} )
								}
							>
								{ __( 'Hide', 'vk-filter-search' ) }
							</Button>
						</ButtonGroup>
					</BaseControl>
					<BaseControl id={ 'vkfs_searchTitle_queryTitleAfter' }>
						<TextControl
							label={ __(
								'String of the query title after',
								'vk-filter-search'
							) }
							value={ queryTitleAfter }
							onChange={ ( value ) =>
								setAttributes( { queryTitleAfter: value } )
							}
							help={ __( 'eg) :', 'vk-filter-search' ) }
						/>
					</BaseControl>
					{ vkfsIsPro && (
						<>
							<BaseControl
								id={ 'vkfs_searchTitle_queryElementOR' }
							>
								<TextControl
									label={ __(
										'Query element "or"',
										'vk-filter-search'
									) }
									value={ queryElementOR }
									onChange={ ( value ) =>
										setAttributes( {
											queryElementOR: value,
										} )
									}
									help={ __( 'eg) or', 'vk-filter-search' ) }
								/>
							</BaseControl>
							<BaseControl
								id={ 'vkfs_searchTitle_queryElementAND' }
							>
								<TextControl
									label={ __(
										'Query element "and"',
										'vk-filter-search'
									) }
									value={ queryElementAND }
									onChange={ ( value ) =>
										setAttributes( {
											queryElementAND: value,
										} )
									}
									help={ __( 'eg) and', 'vk-filter-search' ) }
								/>
							</BaseControl>
						</>
					) }
					<BaseControl id={ 'vkfs_searchTitle_queryElementBefore' }>
						<TextControl
							label={ __(
								'String before the query element',
								'vk-filter-search'
							) }
							value={ queryElementBefore }
							onChange={ ( value ) =>
								setAttributes( { queryElementBefore: value } )
							}
							help={ __( 'eg) "', 'vk-filter-search' ) }
						/>
					</BaseControl>
					<BaseControl id={ 'vkfs_searchTitle_queryElementAfter' }>
						<TextControl
							label={ __(
								'String after the query element',
								'vk-filter-search'
							) }
							value={ queryElementAfter }
							onChange={ ( value ) =>
								setAttributes( { queryElementAfter: value } )
							}
							help={ __( 'eg) "', 'vk-filter-search' ) }
						/>
					</BaseControl>
					<BaseControl id={ 'vkfs_searchTitle_queryElementsAfter' }>
						<TextControl
							label={ __(
								'The separator string after the query element',
								'vk-filter-search'
							) }
							value={ queryElementsAfter }
							onChange={ ( value ) =>
								setAttributes( { queryElementsAfter: value } )
							}
							help={ __( 'eg) |', 'vk-filter-search' ) }
						/>
					</BaseControl>
					{ vkfsIsPro && (
						<>
							<BaseControl
								id={ 'vkfs_searchTitle_queryDateMinFormat' }
							>
								<TextControl
									label={ __(
										'Minimum format for a date query',
										'vk-filter-search'
									) }
									value={ queryDateMinFormat }
									onChange={ ( value ) =>
										setAttributes( {
											queryDateMinFormat: value,
										} )
									}
									help={ __(
										'eg) From %s',
										'vk-filter-search'
									) }
								/>
							</BaseControl>
							<BaseControl
								id={ 'vkfs_searchTitle_queryDateMaxFormat' }
							>
								<TextControl
									label={ __(
										'Maximum format for a date query',
										'vk-filter-search'
									) }
									value={ queryDateMaxFormat }
									onChange={ ( value ) =>
										setAttributes( {
											queryDateMaxFormat: value,
										} )
									}
									help={ __(
										'eg) To %s',
										'vk-filter-search'
									) }
								/>
							</BaseControl>
							<BaseControl
								id={ 'vkfs_searchTitle_queryDaterRangeFormat' }
							>
								<TextControl
									label={ __(
										'Format for a date range query',
										'vk-filter-search'
									) }
									value={ queryDaterRangeFormat }
									onChange={ ( value ) =>
										setAttributes( {
											queryDaterRangeFormat: value,
										} )
									}
									help={ __(
										'eg) From %s to %s',
										'vk-filter-search'
									) }
								/>
							</BaseControl>
						</>
					) }
				</PanelBody>
			</InspectorControls>
			{ editContent }
		</>
	);
}
