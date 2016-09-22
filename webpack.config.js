var path = require('path');

module.exports = {
    entry: './resources/assets/js/app.js',
    output: {
        filename: './public/app.js'
    },
    devtool: 'source-map',
    resolve: {
        extensions: ['.js', '.vue'],
    },
    module: {
        loaders: [
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'babel',
                query: {
                    babelrc: false,
                    presets: [['es2015', {modules: false}]]
                }
            },

        ]
    }
};
