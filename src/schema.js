export const schema = {
	name: {
		type: "string",
		default: '',
	},
	showKeyword: {
		type: "boolean",
		default: true,
  	},
	isCheckedPostType: {
	  type: "string",
	  default: '["post","page"]',
	},
	isCheckedTaxonomy: {
		type: "string",
		default: '["category","post_tag"]',
	},
};