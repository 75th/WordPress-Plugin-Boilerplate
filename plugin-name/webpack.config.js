const path = require('path');
const { merge } = require('webpack-merge');
/**
 * WordPress Dependencies
 */
const defaultConfig = require( '@wordpress/scripts/config/webpack.config.js' );

module.exports = merge(
  {
    ...defaultConfig,
    output: {
      path: path.resolve(__dirname, 'blocks/build'),
    },
  },
  {}
);
