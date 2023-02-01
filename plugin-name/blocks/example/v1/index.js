import { registerBlockType } from '@wordpress/blocks';

import Save from './save';

export default {
	save: Save,
	attributes: {},
	migrate: attributes => {
		attributes.columns = 3;
		return attributes;
	}
};
