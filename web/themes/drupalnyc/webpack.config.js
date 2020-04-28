var Encore = require('@symfony/webpack-encore');

Encore
// the project directory where compiled assets will be stored
    .setOutputPath('build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/themes/drupalnyc/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    //.enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
    .addEntry('js/main', './assets/js/main.js')
    .addEntry('js/infoscreen', './assets/js/infoscreen.js')
    .addStyleEntry('css/main', './assets/css/main.scss')
    .addStyleEntry('css/infoscreen', './assets/css/infoscreen.scss')

    // uncomment if you use Sass/SCSS files
    .enableSassLoader(function(sassOptions) {}, {
        resolveUrlLoader: true
    });

const config = Encore.getWebpackConfig();

if (config && config.module && config.module.rules && Array.isArray(config.module.rules)) {
    config.module.rules
        .filter(rule => rule.test.toString() === /\.(png|jpg|jpeg|gif|ico|svg|webp)$/.toString())
        .map(rule => {
                rule.test = /\.(png|jpg|jpeg|gif|ico|webp)$/;
            return rule;
        });

    let svgRule = Object.assign({}, config.module.rules.filter(rule => rule.test.toString() === /\.(png|jpg|jpeg|gif|ico|webp)$/.toString())[0]);
    svgRule.test = /\.(svg)$/;
    svgRule.use = [
        {
            loader: svgRule.loader,
            options: svgRule.options,
        },
        'image-webpack-loader'
    ];
    delete svgRule.loader;
    delete svgRule.options;

    config.module.rules.push(svgRule);
}

module.exports = config;
