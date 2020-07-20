import { schema } from "./schema";
import { AdvancedCheckboxControl, usePostTypes, useTaxonomies } from "./component";
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { PanelBody, BaseControl, CheckboxControl } = wp.components;
const { Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;
const ServerSideRender = wp.serverSideRender;

registerBlockType( 'vk-filter-search/filter-search', {
    title: 'VK Filter Search',
    icon: 'search',
	category: 'widgets',
	attributes: schema,

    edit: ( props ) => {

		const { attributes, setAttributes, name } = props;

		const { showKeyword, isCheckedPostType, isCheckedTaxonomy } = attributes;
		attributes.name = name;

		const postTypes = usePostTypes();
		const postTypesProps = postTypes.map(postType => {
			return {
				label: postType.name,
				slug: postType.slug
			};
		});

		const taxonomies = useTaxonomies();
		const taxonomiesProps =taxonomies.map(taxonomy => {
			return {
				label: taxonomy.name,
				slug: taxonomy.slug
			};
		});

        return (
			<Fragment>
				<InspectorControls>
					<PanelBody
						title={__("Display conditions", "vk-blocks")}
						initialOpen={false}
					>
						<BaseControl label={__("Filter by Keyword", "vk-blocks")}>
							<CheckboxControl
								className={ "mb-1" }
								checked={ showKeyword }
								onChange={ (checked) => setAttributes({ showKeyword: checked }) }
							/>
						</BaseControl>

						<BaseControl label={__("Filter by PostTypes", "vk-blocks")}>
							<AdvancedCheckboxControl
								schema={"isCheckedPostType"}
								rawData={postTypesProps}
								checkedData={JSON.parse(isCheckedPostType)}
								{...props}
							/>
						</BaseControl>

						<BaseControl label={__("Filter by Taxonomies", "vk-blocks")}>
							<AdvancedCheckboxControl
								schema={"isCheckedTaxonomy"}
								rawData={taxonomiesProps}
								checkedData={JSON.parse(isCheckedTaxonomy)}
								{...props}
							/>
						</BaseControl>
					</PanelBody>
				</InspectorControls>
				<ServerSideRender
					block="vk-filter-search/filter-search"
					attributes={ attributes }
				/>
			</Fragment>
		);
    },
} );