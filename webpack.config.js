const path = require("path");

module.exports = {
	mode: process.env.NODE_ENV || 'production',
	entry: ['./resources/js/index.js', './resources/scss/main.scss'],
	output: {
		filename: "bundle.js",
		path: path.resolve(__dirname, 'public/compiled'),
	},
	module: {
		rules: [
			{
				test: /.scss$/,
				use: [
					{
						loader: 'file-loader',
						options: {
							name: '[name].css'
						}
					},
					{
						loader: 'extract-loader'
					},
					{
						loader: 'css-loader'
					},
					{
						loader: 'postcss-loader'
					},
					{
						loader: 'sass-loader'
					}
				]
			}
		],
	},
	watchOptions: {
		aggregateTimeout: 300,
		poll: 1000
	},
};