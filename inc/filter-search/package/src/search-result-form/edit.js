import ServerSideRender from '@wordpress/server-side-render';
import { PanelBody, BaseControl, RadioControl } from '@wordpress/components';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

export default function SearchResultEdit( props ) {
	const { attributes, setAttributes } = props;
	const { forceDisplayResult } = attributes;
	const blockProps = useBlockProps( {
		className: `vkfs-search-result-form`,
	} );

	let editContent = '';
	const pathString = window.location.pathname;
	if (
		pathString.indexOf( 'site-editor.php' ) === -1 &&
		pathString.indexOf( 'widgets.php' ) === -1 &&
		pathString.indexOf( 'post-new.php' ) === -1 &&
		pathString.indexOf( 'post.php' ) === -1
	) {
		editContent = (
			<ServerSideRender block="vk-filter-search/search-result-form" />
		);
	} else {
		editContent = (
			<div className="vkfs__alert vkfs__alert--warning">
				<div className="vkfs__alert-title">
					{ __( 'Search Result Form', 'vk-filter-search' ) }
				</div>
				<p>
					{ __(
						'This block is used to display the original search form on the search results page.',
						'vk-filter-search'
					) }
					{ __(
						'It is designed for use with the Search Result Template in Block Themes and in the widget area on search result pages of classic themes.',
						'vk-filter-search'
					) }
					{ __(
						'Additionally, if you use the Post Type Archive Template of a Block Theme, or the widget area that displays the post type archive in a Classic theme, the corresponding search form will automatically appear on the post type archive page.',
						'vk-filter-search'
					) }
					{ __(
						'The form is not displayed in the theme editor; however, it appears on the actual search results page and post type archive page.',
						'vk-filter-search'
					) }
				</p>
			</div>
		);
	}

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __(
						'Search Result Form Option',
						'vk-filter-search'
					) }
					initialOpen={ true }
					className="components-panel__vkfs-panel-body"
				>
					<BaseControl>
						<RadioControl
							label={ __(
								'Display the form on the search results page',
								'vk-filter-search'
							) }
							options={ [
								{
									label: __(
										'Always display search source form',
										'vk-filter-search'
									),
									value: true,
								},
								{
									label: __(
										'Dependent on the source form',
										'vk-filter-search'
									),
									value: false,
								},
							] }
							selected={ forceDisplayResult }
							onChange={ ( value ) => {
								// value が文字列扱いされて入ってしまうため、selected が効かなくなるため、
								// value === true || value === 'true' で bool にしてから forceDisplayResult にセットする
								setAttributes( {
									forceDisplayResult:
										value === true || value === 'true',
								} );
							} }
						/>
						<dl>
							<dt>
								{ __(
									'For classic theme',
									'vk-filter-search'
								) }
							</dt>
							<dd>
								<p>
									{ __(
										'If you specify "Display form on search results page" in the search source VK Filter Search block, it will be automatically displayed at a specific hook position (generally above the list of posts in search results). There is no need to place this block.',
										'vk-filter-search'
									) }
								</p>
								<p>
									{ __(
										'However, place this block if you want to display the search source form in any widget area, such as the sidebar, instead of where it appears automatically.',
										'vk-filter-search'
									) }
								</p>
								<p>
									{ __(
										'In that case, disable "Display form on search results page" for the search source form, and enable "Always display search source form" in this block.',
										'vk-filter-search'
									) }
								</p>
							</dd>
							<dt>
								{ __( 'For block theme', 'vk-filter-search' ) }
							</dt>
							<dd>
								<p>
									{ __(
										'If you specify "Display form on search results page" in the search source VK Filter Search block, the form will be displayed where this block is placed. ',
										'vk-filter-search'
									) }
								</p>
								<p>
									{ __(
										'Alternatively, select "Always show search source form" in this block to display it regardless of the search source\'s display settings.',
										'vk-filter-search'
									) }
								</p>
							</dd>
						</dl>
					</BaseControl>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>{ editContent }</div>
		</>
	);
}
