const path = require('path');
const CopyPlugin = require('copy-webpack-plugin');

module.exports = {
	entry: './lib/dev/js/test.js',
	mode: 'development',
	output: {
		path: path.resolve(__dirname, 'lib'),
		filename: 'blizzardwatch.bundle.js'
	},
	plugins: [
		new CopyPlugin([{
				from: 'node_modules/bootstrap/dist/js/bootstrap.min.js',
				to: 'js/'
			},
			{
				from: 'node_modules/jquery/dist/jquery.min.js',
				to: 'js/'
			},
			{
				from: 'node_modules/popper.js/dist/popper.min.js',
				to: 'js/'
			},
			{
				from: 'node_modules/bootstrap/dist/css/bootstrap.min.css',
				to: 'css/'
			}
		]),
	],
};