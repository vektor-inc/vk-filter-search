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
	category: "vk-blocks-cat",
	attributes: schema,

    edit: ( props ) => {

		const { attributes, setAttributes } = props;

		const { showKeyword, isCheckedPostType, isCheckedTaxonomy } = attributes;

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
						title={__("Filtering Options", "vk-filter-search")}
						initialOpen={false}
					>
						<BaseControl label={__("Keyword", "vk-filter-search")}>
							<CheckboxControl
								label={__("Filter by Keyword", "vk-filter-search")}
								className={ "mb-1" }
								checked={ showKeyword }
								onChange={ (checked) => setAttributes({ showKeyword: checked }) }
							/>
						</BaseControl>

						<BaseControl label={__("PostTypes", "vk-filter-search")}>
							<AdvancedCheckboxControl
								schema={"isCheckedPostType"}
								rawData={postTypesProps}
								checkedData={JSON.parse(isCheckedPostType)}
								{...props}
							/>
						</BaseControl>

						<BaseControl label={__("Taxonomies", "vk-filter-search")}>
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
					attributes={ props.attributes }
				/>
			</Fragment>
		);
    },
} );