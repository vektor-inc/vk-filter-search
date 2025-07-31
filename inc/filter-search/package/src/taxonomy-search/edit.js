import { __ } from '@wordpress/i18n';
import { PanelBody, BaseControl, SelectControl } from '@wordpress/components';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';

export default function TaxonomySearchEdit( props ) {
	const { attributes, setAttributes } = props;

	const { isSelectedTaxonomy } = attributes;

	let editContent;
	//eslint-disable-next-line camelcase,no-undef
	const taxonomyOption = vk_filter_search_params.taxonomy_option;
	//eslint-disable-next-line camelcase,no-undef
	const taxonomyList = vk_filter_search_params.taxonomy_list;
	const condition = ( taxonomy ) => taxonomy.value === isSelectedTaxonomy;

	const selectedTaxonomy = taxonomyList.find( condition );

	if (
		taxonomyOption.some( condition ) &&
		isSelectedTaxonomy !== '' &&
		isSelectedTaxonomy !== null &&
		isSelectedTaxonomy !== undefined
	) {
		editContent = (
			<ServerSideRender
				block="vk-filter-search/taxonomy-search"
				attributes={ props.attributes }
			/>
		);
	} else if (
		isSelectedTaxonomy === '' ||
		isSelectedTaxonomy === null ||
		isSelectedTaxonomy === undefined
	) {
		editContent = (
			<div>
				<div className="vkfs__warning">
					<div className="vkfs__label-name">
						<div className="vkfs__label-name-inner">
							{ __( 'Taxonomy', 'vk-filter-search' ) }
						</div>
					</div>
					<div className="vkfs__warning-text">
						{ __(
							'This block will not be displayed because no taxonomy is selected.',
							'vk-filter-search'
						) }
					</div>
				</div>
			</div>
		);
	} else if (
		selectedTaxonomy !== undefined &&
		selectedTaxonomy.label !== undefined
	) {
		editContent = (
			<div className="vkfs__warning">
				<div className="vkfs__label-name">
					<div className="vkfs__label-name-inner">
						{ selectedTaxonomy.label }
					</div>
				</div>
				<div className="vkfs__warning-text">
					{ __(
						'This block will not be displayed because this taxonomy has no term.',
						'vk-filter-search'
					) }
				</div>
			</div>
		);
	} else {
		editContent = (
			<div className="vkfs__warning">
				<div className="vkfs__label-name">
					<div className="vkfs__label-name-inner">
						{ __(
							'Specified taxonomy does not exist',
							'vk-filter-search'
						) }
					</div>
				</div>
				<div className="vkfs__warning-text">
					{ __(
						'This block will not be displayed because the specified taxonomy does not exist.',
						'vk-filter-search'
					) }
					{ __(
						'Please reselect the taxonomy or remove this block..',
						'vk-filter-search'
					) }
				</div>
			</div>
		);
	}

	const blockProps = useBlockProps( {
		className: `vkfs__taxonomy`,
	} );

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __( 'Taxonomy Option', 'vk-filter-search' ) }
					initialOpen={ true }
				>
					<BaseControl id={ 'vsfs03' }>
						<SelectControl
							label={ __( 'Taxonomy', 'vk-filter-search' ) }
							value={ isSelectedTaxonomy }
							options={ taxonomyOption }
							onChange={ ( value ) =>
								setAttributes( { isSelectedTaxonomy: value } )
							}
						/>
					</BaseControl>
				</PanelBody>
				<PanelBody
					title={ __( 'VK Taxonomy Search', 'vk-filter-search' ) }
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
									'Checkbox / Radio button',
									'vk-filter-search'
								) }
							</li>
							<li>
								{ __(
									'Editable text for labels',
									'vk-filter-search'
								) }
							</li>
							<li>
								{ __(
									'Display Post Counts',
									'vk-filter-search'
								) }
							</li>
							<li>
								{ __( 'Hide Empty Terms', 'vk-filter-search' ) }
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
			<div { ...blockProps }>{ editContent }</div>
		</>
	);
}
