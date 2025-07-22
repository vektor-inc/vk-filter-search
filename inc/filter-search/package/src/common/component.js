/**
 * Common Component
 */

/* eslint camelcase: 0 */
/* eslint no-shadow: 0 */

import { kebabCase } from 'lodash';
import { CheckboxControl } from '@wordpress/components';
import { useState } from '@wordpress/element';
import { select } from '@wordpress/data';
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
	const { schema, rawData, checkedData, setAttributes } = props;
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
		ALLOWED_TAGS: [ 'span', 'i' ],
		ALLOWED_ATTR: [ 'class', 'style' ],
	} );
};
