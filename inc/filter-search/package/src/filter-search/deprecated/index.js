/* eslint camelcase: 0 */
import save2_14_1 from './2.14.1/save';
import save1_11_0 from './1.11.0/save';
import save1_6_1 from './1.6.1/save';
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

const blockAttributes2 = {
	...blockAttributes,
	DisplayOnResult: {
		type: 'boolean',
		default: false,
	},
};

const blockAttributes3 = {
	...blockAttributes2,
	PostID: {
		type: 'number',
		default: null,
	},
};

const blockAttributes4 = {
	...blockAttributes3,
	DisplayOnPosttypeArchive: {
		type: 'string',
		default: '[]',
	},
	FormID: {
		type: 'string',
		default: null,
	},
};

const deprecated = [
	{
		attributes: blockAttributes4,
		save: save2_14_1,
	},
	{
		attributes: blockAttributes4,
		save: save1_11_0,
	},
	{
		attributes: blockAttributes4,
		save: save1_6_1,
	},
	{
		attributes: blockAttributes4,
		save: save0_6_5,
	},
	{
		attributes: blockAttributes3,
		save: save0_4_6,
	},
	{
		attributes: blockAttributes3,
		save: save0_3_2,
	},
	{
		attributes: blockAttributes2,
		save: save0_3_1,
	},
	{
		attributes: blockAttributes2,
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
