/* eslint camelcase: 0 */
import save0_6_5 from './0.6.5/save';
import save0_4_6 from './0.4.6/save';
import save0_3_2 from './0.3.2/save';
import save0_3_1 from './0.3.1/save';
import save0_2_3 from './0.2.3/save';
import save0_1_1 from './0.1.1/save';
import save0_1_0 from './0.1.0/save';

const blockAttributes = {
	TargetPostType: {
		type: 'string',
		default: '',
	},
};

const deprecated = [
	{
		attributes: {
			...blockAttributes,
			DisplayOnResult: {
				type: 'boolean',
				default: false,
			},
			DisplayOnPosttypeArchive: {
				type: 'string',
				default: '[]',
			},
			FormID: {
				type: 'string',
				default: null,
			},
			PostID: {
				type: 'number',
				default: null,
			},
		},
		save: save0_6_5,
	},
	{
		attributes: {
			...blockAttributes,
			DisplayOnResult: {
				type: 'boolean',
				default: false,
			},
			FormID: {
				type: 'string',
				default: null,
			},
		},
		save: save0_4_6,
	},
	{
		attributes: {
			...blockAttributes,
			DisplayOnResult: {
				type: 'boolean',
				default: false,
			},
			PostID: {
				type: 'number',
				default: null,
			},
		},
		save: save0_3_2,
	},
	{
		attributes: {
			...blockAttributes,
			DisplayOnResult: {
				type: 'boolean',
				default: false,
			},
		},
		save: save0_3_1,
	},
	{
		attributes: {
			...blockAttributes,
			DisplayOnResult: {
				type: 'boolean',
				default: false,
			},
		},
		save: save0_2_3,
	},
	{
		attributes: blockAttributes,
		save: save0_1_1,
	},
	{
		attributes: blockAttributes,
		save: save0_1_0,
	},
];
export default deprecated;
