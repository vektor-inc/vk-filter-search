/**
 * Common Component
 */

/* eslint camelcase: 0 */
/* eslint no-shadow: 0 */

import { CheckboxControl } from '@wordpress/components';
import { useState } from '@wordpress/element';

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
