const UglifyPlugin = require('uglifyjs-webpack-plugin');
const webpack = require("webpack");
const path = require('path');

module.exports = {
    entry: {
        bootstrap: './resources/assets/js/bootstrap.js',
        browser: './resources/assets/js/browser.js',
    },
    output: {
        path: path.resolve(__dirname, 'public')
    },
    resolve: {
        extensions: ['.js', '.vue']
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader',
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'babel-loader',
                options: {
                    babelrc: false,
                    presets: [['es2015', {modules: false}]]
                }
            }
        ]
    },
    plugins: [
        new UglifyPlugin(),
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery',
            Popper: ['popper.js', 'default'],
            Centrifuge: 'centrifuge'
        })
    ]
};
