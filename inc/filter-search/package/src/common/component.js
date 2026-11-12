/**
 * Common Component
 */

/* eslint camelcase: 0 */
/* eslint no-shadow: 0 */

import { kebabCase } from 'lodash';
import {
	CheckboxControl,
	PanelBody,
	SelectControl,
} from '@wordpress/components';
import { useCallback, useState } from '@wordpress/element';
import { select } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import DOMPurify from 'dompurify';

// @wordpress/block-editor から必要なものをインポート
import {
	ColorPalette,
	getColorObjectByColorValue,
	getColorObjectByAttributeValues,
} from '@wordpress/block-editor';

export const destructiveDeleteFromArray = ( array, value ) => {
	const index = array.indexOf( value );
	if ( index !== -1 ) {
		array = array.splice( index, 1 );
	}
	return array;
};

export const AdvancedCheckboxControl = ( props ) => {
	// ariaDescribedBy: 各チェックボックスから参照させる説明の id（無ければ付けない）
	const { schema, rawData, checkedData, setAttributes, ariaDescribedBy } =
		props;
	const [ checkedState, setCheckedState ] = useState( checkedData );

	if ( ! rawData || ! checkedData ) {
		return false;
	}

	const advancedSetAttributes = ( schema2, saveData ) => {
		setAttributes( { [ schema2 ]: JSON.stringify( saveData ) } );
	};

	const checkBoxComponents = rawData.map( ( data ) => {
		return (
			<CheckboxControl
				key={ data.slug }
				label={ data.label }
				aria-describedby={ ariaDescribedBy }
				checked={ checkedState.some( ( item ) => item === data.slug ) }
				onChange={ ( value ) => {
					if ( value ) {
						checkedState.push( data.slug );
					} else {
						destructiveDeleteFromArray( checkedState, data.slug );
					}
					setCheckedState( checkedState );
					advancedSetAttributes.bind( null, schema, checkedState )();
				} }
			/>
		);
	} );
	return checkBoxComponents;
};

export const isParentReusableBlock = ( clientId ) => {
	const parentReusableBlock = select(
		'core/block-editor'
	).getBlockParentsByBlockName( clientId, [ 'core/block' ] );
	return parentReusableBlock.length ? true : false;
};

export const isHexColor = ( color ) => {
	let isHex = false;
	if (
		color &&
		color.match( /^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/ ) !== null
	) {
		isHex = true;
	}
	return isHex;
};

export const colorSlugToColorCode = ( color ) => {
	let colorCode;
	if ( color ) {
		// カラーパレットの色名・スラッグ・カラーコードを取得
		const colorSet = select( 'core/block-editor' ).getSettings().colors;

		// titleColor の色コードを colorSet から探して色データを取得
		const ColorValue = getColorObjectByAttributeValues( colorSet, color );

		if ( ColorValue.color !== undefined ) {
			colorCode = ColorValue.color;
		} else {
			colorCode = color;
		}
	}
	return colorCode;
};

export const AdvancedColorPalette = ( props ) => {
	const { schema, setAttributes, attributes } = props;
	const hexColor = colorSlugToColorCode( attributes[ schema ] );

	return (
		<ColorPalette
			value={ hexColor }
			onChange={ ( value ) => {
				// カラーパレットの色名・スラッグ・カラーコードを取得
				const colorSet =
					select( 'core/block-editor' ).getSettings().colors;

				// 色コードを colorSet から探して色データを取得
				// カスタムカラーの場合 undefined が返る
				// パレットのあるカラーの場合 オブジェクトで color / name / slug が返る（ console.dir(ColorValue) ）
				const ColorValue = getColorObjectByColorValue(
					colorSet,
					value
				);

				if ( ColorValue !== undefined ) {
					setAttributes( { [ schema ]: ColorValue.slug } );
				} else {
					setAttributes( { [ schema ]: value } );
				}
			} }
		/>
	);
};

export const isBlockDuplicate = ( blockName, clientId ) => {
	const blockids = select( 'core/block-editor' ).getBlocksByName( blockName );
	return blockids[ 0 ] !== clientId;
};

export const sanitizeSlug = ( slug ) => {
	return kebabCase( slug );
};

export const sanitizeIconHTML = ( html ) => {
	// Remove all tags except <i> and </i>
	return DOMPurify.sanitize( html, {
		ALLOWED_TAGS: [ 'span', 'i', 'br' ],
		ALLOWED_ATTR: [ 'class', 'style' ],
	} );
};

export const SearchResultPageSettingPanel = ( props ) => {
	const { currentPostType, SearchResultPageID, setAttributes, pageList } =
		props;

	if ( currentPostType !== 'filter-search' ) {
		return null;
	}

	const options =
		pageList ||
		( typeof vk_filter_search_params !== 'undefined'
			? vk_filter_search_params.page_list // eslint-disable-line camelcase,no-undef
			: [] );

	return (
		<PanelBody
			title={ __( 'Search Result Page Setting', 'vk-filter-search' ) }
			initialOpen={ true }
		>
			<p>
				{ __(
					"By default, search results are displayed on the site's search results page, but they can also be shown on a specific page.",
					'vk-filter-search'
				) }
			</p>
			<ol>
				<li>
					{ __(
						'Please create a new page to use as the search results page.',
						'vk-filter-search'
					) }
				</li>
				<li>
					{ __(
						'Put the Search Result Form block and the Query Loop block on a page.',
						'vk-filter-search'
					) }
				</li>
				<li>
					{ __(
						'Please set the Query Type of the Query Loop Block to "Custom."',
						'vk-filter-search'
					) }
					<br />
					{ __(
						'Most of the other settings will be overridden by the search parameters.',
						'vk-filter-search'
					) }
					<br />
					{ __(
						'Note that if you set the Query Type of the Query Loop Block to "Default," the search results will not be reflected.',
						'vk-filter-search'
					) }
				</li>
				<li>{ __( 'Reload this page.', 'vk-filter-search' ) }</li>
				<li>
					{ __(
						'Select the page from the list below.',
						'vk-filter-search'
					) }
				</li>
			</ol>
			<SelectControl
				label={ __( 'Page for Search Results', 'vk-filter-search' ) }
				value={ SearchResultPageID }
				onChange={ ( value ) =>
					setAttributes( { SearchResultPageID: value } )
				}
				options={ options }
			/>
		</PanelBody>
	);
};

/**
 * 旧版のフォームの「検索結果ページ・投稿タイプアーカイブに表示」の設定の下に、説明を出すか
 *
 * 権限が足りない人が、VK Filter Search 以外の投稿に置いたフォームを編集しているときだけ出す。
 * 権限の判定は PHP から受け取る。
 *
 * @param {string} currentPostType 編集中の投稿の投稿タイプ.
 * @return {boolean} 出す場合は true.
 */
export const isFormDisplaySettingNoteShown = ( currentPostType ) => {
	// 投稿タイプ VK Filter Search と、再利用ブロック・テンプレートなどの wp_ で始まる投稿タイプには出さない
	if (
		! currentPostType ||
		currentPostType === 'filter-search' ||
		currentPostType.startsWith( 'wp_' )
	) {
		return false;
	}
	const canApprove =
		// eslint-disable-next-line camelcase
		typeof vk_filter_search_params !== 'undefined' &&
		// eslint-disable-next-line no-undef
		vk_filter_search_params.canApproveFormDisplay;
	return ! canApprove;
};

/**
 * 入力要素に aria-describedby を付ける ref を返す
 *
 * WordPress 6.6〜6.9 の ToggleControl は、渡した aria-describedby を入力要素へ渡さない。
 * ref は入力要素まで届くため、ref で直接付ける（prop で渡す形に戻すと、古い WordPress で読み上げの関連付けが消える）。
 *
 * @param {string|undefined} describedBy 説明の要素の id。付けない場合は undefined.
 * @return {Function} ToggleControl などの ref に渡す関数.
 */
export const useAriaDescribedByRef = ( describedBy ) =>
	useCallback(
		( node ) => {
			if ( ! node ) {
				return;
			}
			if ( describedBy ) {
				node.setAttribute( 'aria-describedby', describedBy );
			} else {
				node.removeAttribute( 'aria-describedby' );
			}
		},
		[ describedBy ]
	);

/**
 * 旧版のフォームの「検索結果ページ・投稿タイプアーカイブに表示」の設定の下に出す説明
 *
 * 2つの設定から aria-describedby で参照させるため、id を受け取る。
 *
 * @param {Object} props                 プロパティ.
 * @param {string} props.currentPostType 編集中の投稿の投稿タイプ.
 * @param {string} props.id              説明の要素の id.
 * @return {Element|null} 説明。出さない場合は null.
 */
export const FormDisplaySettingNote = ( { currentPostType, id } ) => {
	if ( ! isFormDisplaySettingNoteShown( currentPostType ) ) {
		return null;
	}
	return (
		<p id={ id } className="vkfs-form-display-setting-note">
			{ __(
				'Display on the search result page and post type archives takes effect when saved by a user with the Editor role or higher.',
				'vk-filter-search'
			) }
		</p>
	);
};
