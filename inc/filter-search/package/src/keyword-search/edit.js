import ServerSideRender from '@wordpress/server-side-render';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, BaseControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

export default function KeywordSearchEdit() {
	const blockProps = useBlockProps( {
		className: `vkfs-keyword-search`,
	} );

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __( 'VK Keyword Search', 'vk-filter-search' ) }
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
								{ __(
									'Editable text for labels (item names)/ Placeholder',
									'vk-filter-search'
								) }
							</li>
							<li>
								{ __(
									'Block width settings for each screen size',
									'vk-filter-search'
								) }
							</li>
						</ul>
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

			<div { ...blockProps }>
				<ServerSideRender block="vk-filter-search/keyword-search" />
			</div>
		</>
	);
}
