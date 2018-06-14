const Encore = require('@symfony/webpack-encore');
const CopyWebpackPlugin = require('copy-webpack-plugin');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())
    .cleanupOutputBeforeBuild()

    // uncomment to define the assets of the project
    .addEntry('js/app', './assets/js/app.js')
    .addStyleEntry('css/app', './assets/css/app.scss')

    // uncomment if you use Sass/SCSS files
    .enableSassLoader()

    .addPlugin(new CopyWebpackPlugin([
	    {
	    	from: './assets/static', to: 'static'
	    }
    ]))

    // uncomment for legacy applications that require $/jQuery as a global variable
    .autoProvidejQuery()
;

let config = Encore.getWebpackConfig();

if(process.env.DOCKER) {
	config.watchOptions = {
		aggregateTimeout: 300,
		poll: 1000
	};
}

module.exports = config;
