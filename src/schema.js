export const schema = {
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