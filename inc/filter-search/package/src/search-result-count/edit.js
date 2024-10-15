import ServerSideRender from '@wordpress/server-side-render';
import {
	PanelBody,
	BaseControl,
	TextControl,
	FontSizePicker,
	SelectControl,
} from '@wordpress/components';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { select } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

import {
	AdvancedColorPalette,
	isHexColor,
} from '@vk-filter-search/common/component';

export default function SearchResultEdit( props ) {
	const { attributes, setAttributes } = props;
	const {
		beforeText,
		afterText,
		numberColor,
		numberFontSize,
		numberFontStyle,
		numberFontWeight,
	} = attributes;
	const blockProps = useBlockProps( {
		className: `vkfs-search-result-count`,
	} );

	const fontSizes = select( 'core/block-editor' )?.getSettings()?.fontSizes;

	/*
	 Github の Gutenberg の下記から取得
	 packages/block-editor/src/utils/format-font-style.js
	 packages/block-editor/src/utils/get-font-styles-and-weights.js
	*/
	const FONT_STYLES = [
		{
			label: __( 'Regular', 'vk-filter-search' ),
			value: 'normal',
		},
		{
			label: __( 'Italic', 'vk-filter-search' ),
			value: 'italic',
		},
		{
			label: __( 'Oblique', 'vk-filter-search' ),
			value: 'oblique',
		},
	];
	/*
	 Github の Gutenberg の下記から取得
	 packages/block-editor/src/utils/format-font-weight.js
	 packages/block-editor/src/utils/get-font-styles-and-weights.js
	*/
	const FONT_WEIGHTS = [
		{
			label: __( 'Thin (100)', 'vk-filter-search' ),
			value: '100',
		},
		{
			label: __( 'Extra Light (200)', 'vk-filter-search' ),
			value: '200',
		},
		{
			label: __( 'Light (300)', 'vk-filter-search' ),
			value: '300',
		},
		{
			label: __( 'Regular (400)', 'vk-filter-search' ),
			value: '400',
		},
		{
			label: __( 'Medium (500)', 'vk-filter-search' ),
			value: '500',
		},
		{
			label: __( 'Semi Bold (600)', 'vk-filter-search' ),
			value: '600',
		},
		{
			label: __( 'Bold (700)', 'vk-filter-search' ),
			value: '700',
		},
		{
			label: __( 'Extra Bold (800)', 'vk-filter-search' ),
			value: '800',
		},
		{
			label: __( 'Black (900)', 'vk-filter-search' ),
			value: '900',
		},
		{
			label: __( 'Extra Black (1000)', 'vk-filter-search' ),
			value: '1000',
		},
	];

	const numberAttributes = {};
	if ( ! numberAttributes.style ) {
		numberAttributes.style = {};
	}

	if ( numberFontSize ) {
		numberAttributes.style.fontSize = numberFontSize;
	}

	if ( numberColor ) {
		if ( isHexColor( numberColor ) ) {
			numberAttributes.style.color = numberColor;
		} else {
			numberAttributes.className = `has-text-color has-${ numberColor }-color`;
		}
	}

	if ( numberFontStyle ) {
		numberAttributes.style.fontStyle = numberFontStyle;
	}

	if ( numberFontWeight ) {
		numberAttributes.style.fontWeight = numberFontWeight;
	}

	let editContent = '';
	const pathString = window.location.pathname;
	if (
		pathString.indexOf( 'site-editor.php' ) === -1 &&
		pathString.indexOf( 'widgets.php' ) === -1 &&
		pathString.indexOf( 'post-new.php' ) === -1 &&
		pathString.indexOf( 'post.php' ) === -1
	) {
		editContent = (
			<ServerSideRender block="vk-filter-search/search-result-count" />
		);
	} else {
		editContent = (
			<div { ...blockProps }>
				{ beforeText + ' ' }
				<span { ...numberAttributes }>2</span>
				{ ' ' + afterText }
			</div>
		);
	}

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __(
						'Search Result Count Setting',
						'vk-filter-search'
					) }
					initialOpen={ true }
					className="components-panel__vkfs-panel-body"
				>
					<BaseControl>
						<TextControl
							label={ __(
								'Before text of count number',
								'vk-filter-search'
							) }
							value={ beforeText }
							onChange={ ( value ) =>
								setAttributes( { beforeText: value } )
							}
						/>
					</BaseControl>
					<BaseControl>
						<TextControl
							label={ __(
								'After text of count number',
								'vk-filter-search'
							) }
							value={ afterText }
							onChange={ ( value ) =>
								setAttributes( { afterText: value } )
							}
						/>
					</BaseControl>
				</PanelBody>
				<PanelBody
					title={ __(
						'Search Result Count Number Setting',
						'vk-filter-search'
					) }
					initialOpen={ true }
					className="components-panel__vkfs-panel-body-number"
				>
					<BaseControl
						id={ 'vkfs-pro-numberFontSize' }
						label={ __( 'Font Size', 'vk-filter-search' ) }
					>
						<FontSizePicker
							fontSizes={ fontSizes }
							value={ numberFontSize }
							onChange={ ( value ) =>
								setAttributes( { numberFontSize: value } )
							}
						/>
					</BaseControl>
					<BaseControl id={ 'vkfs-pro-numberFontStyle' }>
						<SelectControl
							label={ __( 'Font Style', 'vk-filter-search' ) }
							value={ numberFontStyle }
							options={ FONT_STYLES }
							onChange={ ( value ) => {
								setAttributes( {
									numberFontStyle: value,
								} );
							} }
						/>
					</BaseControl>
					<BaseControl id={ 'vkfs-pro-numberFontWeight' }>
						<SelectControl
							label={ __( 'Font Weight', 'vk-filter-search' ) }
							value={ numberFontWeight }
							options={ FONT_WEIGHTS }
							onChange={ ( value ) => {
								setAttributes( {
									numberFontWeight: value,
								} );
							} }
						/>
					</BaseControl>
					<BaseControl
						id={ 'vkfs-pro-numberColor' }
						label={ __( 'Text Color', 'vk-filter-search' ) }
					>
						<AdvancedColorPalette
							schema={ 'numberColor' }
							{ ...props }
						/>
					</BaseControl>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>{ editContent }</div>
		</>
	);
}
