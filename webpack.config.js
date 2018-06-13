const path = require("path");

module.exports = {
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
};