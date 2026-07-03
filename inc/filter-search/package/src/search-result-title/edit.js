import { __, sprintf } from '@wordpress/i18n';
import {
	PanelBody,
	BaseControl,
	TextControl,
	SelectControl,
	__experimentalToggleGroupControl as ToggleGroupControl,
	__experimentalToggleGroupControlOption as ToggleGroupControlOption,
} from '@wordpress/components';
import {
	InspectorControls,
	useBlockProps,
	BlockControls,
	AlignmentControl,
} from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';

/**
 * Allowed HTML tag names for the `outerTagName` attribute.
 * Must be kept in sync with the PHP allow list in
 * `vkfs_search_result_title_get_allowed_outer_tag_names()`
 * (inc/filter-search/package/src/search-result-title/index.php).
 * The value is used directly as a JSX element type below, so an
 * unrestricted value would allow Stored XSS in the editor context
 * (issue #526). Any value outside this list falls back to `div`.
 *
 * `outerTagName` 属性で許可する HTML タグ名。
 * PHP 側の許可リスト `vkfs_search_result_title_get_allowed_outer_tag_names()`
 * （inc/filter-search/package/src/search-result-title/index.php）と必ず揃えること。
 * 下記でこの値を JSX 要素タイプとしてそのまま使うため、制限しないと
 * エディタ文脈での Stored XSS を許してしまう（issue #526）。
 * リスト外の値は `div` にフォールバックする。
 */
const ALLOWED_OUTER_TAG_NAMES = [
	'div',
	'h1',
	'h2',
	'h3',
	'h4',
	'h5',
	'h6',
	'p',
	'span',
];

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
			queryTitleDisplay === 'display'
				? __( 'Post Type', 'vk-filter-search' ) + queryTitleAfter
				: '';

		// ジャンルのクエリタイトル
		const genreQueryTitle =
			queryTitleDisplay === 'display'
				? __( 'Genre', 'vk-filter-search' ) + queryTitleAfter
				: '';

		// エリアのクエリタイトル
		const areaQueryTitle =
			queryTitleDisplay === 'display'
				? __( 'Area', 'vk-filter-search' ) + queryTitleAfter
				: '';

		// 投稿日のクエリタイトル
		const postDateQueryTitle =
			queryTitleDisplay === 'display'
				? __( 'Post Date', 'vk-filter-search' ) + queryTitleAfter
				: '';

		// 更新日のクエリタイトル
		const postModifiedaQueryTitle =
			queryTitleDisplay === 'display'
				? __( 'Post Modified', 'vk-filter-search' ) + queryTitleAfter
				: '';

		// キーワードのクエリタイトル
		const keywordQueryTitle =
			queryTitleDisplay === 'display'
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
		// Restrict outerTagName to the allow list to prevent Stored XSS via attribute/tag injection in the editor (issue #526).
		// outerTagName を許可リストに制限し、エディタ文脈での属性・タグインジェクションによる Stored XSS を防ぐ（issue #526）.
		const Tag = ALLOWED_OUTER_TAG_NAMES.includes( outerTagName )
			? outerTagName
			: 'div';
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
							help={
								// translators: %s is replaced with the search result
								__(
									'eg) Search Result for %s',
									'vk-filter-search'
								)
							}
						/>
					</BaseControl>
					<BaseControl
						id={ 'vkfs_searchTitle_queryTitleDisplay' }
						label={ __(
							'Queries titile display',
							'vk-filter-search'
						) }
					>
						<ToggleGroupControl
							label={ __(
								'Query Title Display',
								'vk-filter-search'
							) }
							value={ queryTitleDisplay }
							onChange={ ( value ) => {
								setAttributes( { queryTitleDisplay: value } );
							} }
							isBlock
						>
							<ToggleGroupControlOption
								value="display"
								label={ __( 'Display', 'vk-filter-search' ) }
							/>
							<ToggleGroupControlOption
								value="hide"
								label={ __( 'Hide', 'vk-filter-search' ) }
							/>
						</ToggleGroupControl>
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
									help={
										// translators: %s is replaced with the date
										__( 'eg) From %s', 'vk-filter-search' )
									}
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
									help={
										// translators: %s is replaced with the date
										__( 'eg) To %s', 'vk-filter-search' )
									}
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
									help={
										// translators: %1$s is replaced with the date, %2$s is replaced with the date
										__(
											'eg) From %1$s to %2$s',
											'vk-filter-search'
										)
									}
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
