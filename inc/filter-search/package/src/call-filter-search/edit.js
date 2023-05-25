import { __ } from '@wordpress/i18n';
import { PanelBody, BaseControl, SelectControl } from '@wordpress/components';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';

export default function CallFilterSearchEdit( { attributes, setAttributes } ) {
	const { TargetPost } = attributes;

	// eslint-disable-next-line no-undef
	const adminURL = callFilterSearch.adminURL;
	// eslint-disable-next-line no-undef
	const hasFilterSearchPosts = callFilterSearch.hasFilterSearchPosts;
	// eslint-disable-next-line no-undef
	const pagesSelect = callFilterSearch.targetPosts;

	let editContent;
	if ( ! hasFilterSearchPosts ) {
		editContent = (
			<div className="vkfs__alert alert text-center">
				<h4>
					{ __( 'Search Form not registered', 'vk-filter-search' ) }
				</h4>
				<ol className="text-left">
					<li>
						{ __(
							'Place the VK Filter Search block in the dedicated post type and register the search form.',
							'vk-filter-search'
						) }
					</li>
					<li>
						{ __( 'Please reload this page.', 'vk-filter-search' ) }
					</li>
					<li>
						{ __(
							'Select this block and specify from the settings sidebar which search form to display.',
							'vk-filter-search'
						) }
					</li>
				</ol>
				<a
					href={ adminURL + 'edit.php?post_type=filter-search' }
					target="_blank"
					rel="noopener noreferrer"
					className="components-button is-primary"
				>
					{ __( 'Register Filter Search Form', 'vk-filter-search' ) }
				</a>
			</div>
		);
	} else if ( TargetPost === -1 ) {
		editContent = (
			<div className="vkfs__alert alert text-center">
				{ __(
					'Select this block and specify from the settings sidebar which search form to display.',
					'vk-filter-search'
				) }
			</div>
		);
	} else {
		editContent = (
			<ServerSideRender
				block="vk-filter-search/call-filter-search"
				attributes={ attributes }
			/>
		);
	}

	const blockProps = useBlockProps();

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __(
						'Call Filter Search Form Setting',
						'vk-filter-search'
					) }
					initialOpen={ true }
				>
					<BaseControl id={ 'vkfs__call-filter-search__form-select' }>
						<SelectControl
							label={ __(
								'Select Filter Search Form',
								'vk-filter-search'
							) }
							value={ TargetPost }
							options={ pagesSelect }
							onChange={ ( value ) =>
								setAttributes( {
									TargetPost: parseInt( value, 10 ),
								} )
							}
						/>
					</BaseControl>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>{ editContent }</div>
		</>
	);
}
