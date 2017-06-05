var path = require('path');
var ExtractTextPlugin = require('extract-text-webpack-plugin');
var webpack = require('webpack');

module.exports = {
	entry: {
		'index.js': './assets/index.js',
		'index.css': './assets/index.scss',
	},
	output: {
		filename: '[name]',
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
						{loader: 'resolve-url-loader'},
						{loader: 'sass-loader', options: {sourceMap: true}}
					]
				})
			}, {
				test: /\.(woff|woff2|eot|ttf|otf|svg)$/,
				use: [
					'file-loader'
				]
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
