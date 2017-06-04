var path = require('path');
var ExtractTextPlugin = require('extract-text-webpack-plugin');
var webpack = require('webpack');

module.exports = {
	entry: './assets/index.js',
	output: {
		filename: 'index.js',
		path: path.resolve(__dirname, 'www/assets')
	},
	module: {
		rules: [
			{
				test: /.(scss)$/,
				use: ExtractTextPlugin.extract({
					use: [
						{loader: 'css-loader'},
						{
							loader: 'postcss-loader',
							options: {
								plugins: function () {
									return [require('precss'), require('autoprefixer')];
								}
							}
						},
						{loader: 'sass-loader'}
					]
				})
			}
		]
	},
	plugins: [
		new ExtractTextPlugin('index.css'),
		new webpack.ProvidePlugin({
			$: 'jquery',
			jQuery: 'jquery',
			'window.jQuery': 'jquery',
			Popper: ['popper.js', 'default'],
			Tether: 'tether',
		})
	]
};
