const path = require( 'path' );

var urlToPreview = 'https://kristine-v.loc';

module.exports = {
	mode: 'development',
	entry: {
		App: './assets/js/index.js'
	},
	output: {
		path: path.resolve( __dirname, './disc/js/' ),
		filename: 'scripts-bundled.[contenthash].js'
	},
	module: {
		rules: [ { test: /\.js$/, exclude: /node_modules/, loader: 'babel-loader' } ]
	}
};
