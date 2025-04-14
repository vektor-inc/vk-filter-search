import { __ } from '@wordpress/i18n';
import { PanelBody, BaseControl, SelectControl } from '@wordpress/components';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';
import { useEffect } from '@wordpress/element';

export default function CallFilterSearchEdit( props ) {
	const { attributes, setAttributes } = props;
	const { TargetPost } = attributes;

	// eslint-disable-next-line no-undef
	const adminURL = callFilterSearch.adminURL;
	// eslint-disable-next-line no-undef
	const hasFilterSearchPosts = callFilterSearch.hasFilterSearchPosts;
	// eslint-disable-next-line no-undef
	const filterSearchPostIDs = callFilterSearch.filterSearchPostIDs;
	// eslint-disable-next-line no-undef
	const pagesSelect = callFilterSearch.targetPosts;

	useEffect( () => {
		const iframe = document.querySelector(
			'.block-editor__container iframe'
		);
		const iframeDoc = iframe?.contentWindow?.document;
		const targetDoc = iframeDoc || document;

		// eslint-disable-next-line no-undef
		const observer = new MutationObserver( () => {
			const editorRoot = targetDoc.querySelector(
				'.block-editor-block-list__layout'
			);
			if ( ! editorRoot ) {
				return;
			}

			const filterSearchSubmit = editorRoot.querySelectorAll(
				'.vk-filter-search .vkfs_submit'
			);
			if ( filterSearchSubmit.length === 0 ) {
				return;
			}

			filterSearchSubmit.forEach( ( link ) => {
				if ( link.dataset.prevented ) {
					return;
				} // 二重適用防止

				link.dataset.prevented = 'true';
				link.addEventListener( 'click', function ( event ) {
					event.preventDefault();
					link.style.cursor = 'default';
					link.style.boxShadow = 'unset';
					link.style.pointerEvents = 'none';
				} );
				link.addEventListener( 'mouseover', function ( event ) {
					event.preventDefault();
					link.style.cursor = 'default';
					link.style.boxShadow = 'unset';
					link.style.pointerEvents = 'none';
				} );
			} );
		} );
		const observeTarget =
			targetDoc.querySelector( '.block-editor-block-list__layout' ) ||
			targetDoc.body;
		if ( observeTarget ) {
			observer.observe( observeTarget, {
				childList: true,
				subtree: true,
			} );
		}

		// クリーンアップ
		return () => {
			observer.disconnect();
		};
	}, [] );

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
				<button
					onClick={ () =>
						window.open(
							adminURL + 'edit.php?post_type=filter-search',
							'_blank',
							'noopener,noreferrer'
						)
					}
					className="components-button is-primary"
				>
					{ __( 'Register Filter Search Form', 'vk-filter-search' ) }
				</button>
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
	} else if ( ! filterSearchPostIDs.includes( TargetPost ) ) {
		editContent = (
			<div className="vkfs__alert alert text-center">
				{ __(
					'The selected form is deleted. Please select another form.',
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
