import ServerSideRender from '@wordpress/server-side-render';
import {
	PanelBody,
	BaseControl,
	TextControl,
	FontSizePicker,
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
	const { beforeText, afterText, numberColor, numberFontSize } = attributes;
	const blockProps = useBlockProps( {
		className: `vkfs-search-result-count`,
	} );

	const fontSizes = select( 'core/editor' ).getEditorSettings().fontSizes;

	const numberAttributes = {};

	if ( numberFontSize ) {
		numberAttributes.style = { fontSize: numberFontSize };
	}

	if ( numberColor ) {
		if ( ! numberAttributes.style ) {
			numberAttributes.style = {};
		}

		if ( isHexColor( numberColor ) ) {
			numberAttributes.style.color = numberColor;
		} else {
			numberAttributes.className = `has-text-color has-${ numberColor }-color`;
		}
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
					<BaseControl
						id={ 'vkfs-pro-numberFontSize' }
						label={ __( 'Number Font Size', 'vk-filter-search' ) }
					>
						<FontSizePicker
							fontSizes={ fontSizes }
							value={ numberFontSize }
							onChange={ ( value ) =>
								setAttributes( { numberFontSize: value } )
							}
						/>
					</BaseControl>
					<BaseControl
						id={ 'vkfs-pro-numberColor' }
						label={ __( 'Number Color', 'vk-filter-search' ) }
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
