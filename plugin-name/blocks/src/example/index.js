import { registerBlockType } from '@wordpress/blocks';
import Edit from './edit.js';
import Save from './save.js';
import metadata from './block.json';
import v1 from './deprecated/v1';

registerBlockType(metadata, {
	edit: Edit,
	save: Save,
	deprecated: [v1],
	getEditWrapperProps() {
		return {
			'data-align': 'wide',
		};
	},
});
