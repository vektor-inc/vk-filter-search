import {
	AdvancedCheckboxControl,
	UseTaxonomies,
	useTermsGroupbyTaxnomy
} from '../common/component';
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { PanelBody, BaseControl, SelectControl } = wp.components;
const { Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;
const ServerSideRender = wp.serverSideRender;

registerBlockType( 'vk-filter-search/taxonomy-search', {
	title: __('VK Taxonomy Search','vk-filter-search' ),
	icon: (
		<svg
			height="25"
			viewBox="0 0 24 25"
			width="24"
			xmlns="http://www.w3.org/2000/svg"
		>
			<path
				d="m19.1111 4h-14.22221c-.23575 0-.46184.08872-.62854.24665s-.26035.37212-.26035.59546v2.18107c0 .44043.18933.87327.51822 1.18485l4.81511 4.56177v6.3882c.00018.1435.039.2845.1128.4098s.18013.2307.30893.3061c.1288.0755.27584.1186.42704.1252.1513.0066.3019-.0235.4375-.0874l3.5555-1.6842c.3013-.1432.4916-.4346.4916-.7537v-4.704l4.8151-4.56177c.3289-.31158.5182-.74442.5182-1.18485v-2.18107c0-.22334-.0936-.43753-.2603-.59546s-.3928-.24665-.6286-.24665zm-5.6417 7.8257c-.0827.0781-.1483.1709-.193.2731s-.0676.2117-.0675.3223l-.0252 4.7608-2.3816 1.1038v-5.8646c.0002-.1106-.0227-.2201-.0674-.3223s-.1103-.195-.193-.2731l-5.07231-4.80252v-1.65175h13.06121v1.65175z"
				fill="#000"
			/>
			<path
				clipRule="evenodd"
				d="m9.89952 14.1163c1.40888 0 2.12808 1.6941 1.15858 2.7082l-2.17843 2.2937.96374 3.1033c.30179.965-.38112 2.0784-1.5252 2.0784h-2.98915c-.83824 0-1.35729-.6071-1.52122-1.1162l-.01259-.0391-.35973-1.3702c-.08381-.3015-.07758-.6203.01869-.9193l.00537-.0167.24244-.6967h-1.05309l2.70165-2.9083c-.23616-.3972-.30158-.8869-.18118-1.3024l.0106-.0366.23709-.6858c.22155-.6529.83443-1.0839 1.50981-1.0854h.00349zm-2.96913 1.5069c-.01896 0-.03792.0062-.05404.0172-.00789.0053-.0151.0118-.0213.0192-.00789.0095-.01414.0205-.01807.0327l-.22686.6562c-.02001.0691.02669.1382.09341.1382h1.1543c.08673 0 .13344.1105.07339.1726l-1.84153 1.9824h.00667l.94746 3.0876c.02001.069-.02669.1312-.09342.1312h-.92743c-.04671 0-.08007-.0276-.09341-.0691l-.47373-1.5817c-.00987-.0358-.03341-.0583-.06086-.068-.02076-.0073-.04375-.0072-.06474 0-.02633.0091-.04952.0296-.06122.0611l-.38699 1.112c-.00667.0208-.00667.0415 0 .0622l.35363 1.3469c.01334.0415.05337.076.09341.076h2.98915c.06672 0 .11343-.0691.09341-.1312l-1.20767-3.8888c-.01335-.0346 0-.076.02669-.1036l2.74228-2.8873c.06008-.0621.01334-.1727-.0734-.1727zm-.09712.0141-.00211.0023z"
				fill="#fff"
				fillRule="evenodd"
			/>
			<path
				d="m9.89952 15.6163-2.96913.0069c-.04004 0-.08007.0277-.09341.0691l-.22686.6562c-.02002.0691.02669.1381.09341.1381h1.1543c.08673 0 .13344.1106.07339.1727l-1.84153 1.9824h.00667l.94746 3.0876c.02001.069-.02669.1312-.09342.1312h-.92743c-.04671 0-.08007-.0276-.09341-.0691l-.47373-1.5817c-.02669-.0967-.15346-.0967-.18682-.0069l-.38699 1.112c-.00667.0208-.00667.0415 0 .0622l.35363 1.3469c.01334.0415.05337.076.09341.076h2.98915c.06672 0 .11343-.0691.09341-.1312l-1.20767-3.8888c-.01335-.0346 0-.076.02669-.1036l2.74228-2.8873c.06008-.0622.01334-.1727-.0734-.1727z"
				fill="#000"
			/>
			<path
				d="m6.38331 14-1.80817.0069c-.04003 0-.08007.0276-.09341.0691l-.23353.6562c-.02669.069.02669.1381.09341.1381h.76063c.06673 0 .11343.0691.09342.1382l-2.15513 6.106c-.03336.0898-.15346.0898-.18682 0l-1.54795-4.4069c-.02669-.069.02669-.1381.09341-.1381h.78065c.04003 0 .08006.0276.09341.0691l.56046 1.5886c.03336.0898.15346.0898.18682 0l.86739-2.4728c.02669-.069-.02669-.1381-.09341-.1381h-3.6964038c-.0667221 0-.1134276.0691-.09341092.1381l2.84236472 8.1783c.03336.0897.15346.0897.18682 0l3.44286-9.7946c.02002-.069-.02669-.1381-.09341-.1381z"
				fill="#d8141c"
			/>
		</svg>
	),
	category: 'vk-blocks-cat',
	parent: ["vk-filter-search/filter-search"],
	attributes: {
		isSelectedTaxonomy: {
			type: 'string',
			default: 'category',
		},
	},

	edit: ( props ) => {
		const { attributes } = props;

		const {
			isSelectedTaxonomy,
		} = attributes;

		const taxonomies = UseTaxonomies();
		const terms = useTermsGroupbyTaxnomy(taxonomies);
		let taxonomiesProps = taxonomies.map( ( taxonomy ) => {
			return {
				label: taxonomy.name,
				value: taxonomy.slug,
			};
		} );


		// If No terms in Taxonomy, Remove checkbox from sidebar.
		let taxonomiesIncludeTerms = [];
		Object.keys(terms).forEach(term => {

			if(Array.isArray(terms[term]) && terms[term].length){
				let taxonomiesIncludeTermsTemp;
				if(term === "tags"){
					taxonomiesIncludeTermsTemp = taxonomiesProps.filter( taxonomiesProp => taxonomiesProp.slug === "post_tag" );
				}else if(term === "categories"){
					taxonomiesIncludeTermsTemp = taxonomiesProps.filter( taxonomiesProp => taxonomiesProp.slug === "category" );
				}else{
					taxonomiesIncludeTermsTemp = taxonomiesProps.filter( taxonomiesProp => taxonomiesProp.slug === term );
				}
				taxonomiesIncludeTerms = taxonomiesIncludeTerms.concat(taxonomiesIncludeTermsTemp)
			}

		});
		console.log(taxonomiesIncludeTerms);

		return (
			<Fragment>
				<InspectorControls>
					<PanelBody
						title={ __( 'Taxonomy Option', 'vk-filter-search' ) }
						initialOpen={ false }
					>
						<BaseControl
							id={ 'vsfs03' }
							label={ __( 'Taxonomy', 'vk-filter-search' ) }
						>
							<SelectControl
								label={ __( 'Taxonomy', 'vk-filter-search' ) }
								value={ isSelectedTaxonomy }
								options={ taxonomiesIncludeTerms }
								onChange={ ( isSelectedTaxonomy ) => { setState( { isSelectedTaxonomy } ) } }
							/>
						</BaseControl>
					</PanelBody>
				</InspectorControls>
				<ServerSideRender
					block="vk-filter-search/taxonomy-search"
					attributes={ props.attributes }
				/>
			</Fragment>
		);
	},
} );