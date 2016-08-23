var path = require('path');

module.exports = {
    entry: './resources/assets/js/app.js',
    output: {
        filename: './public/app.js'
    },
    devtool: 'source-map',
    module: {
        loaders: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'babel',
                query: {
                    babelrc: false,
                    presets: ['es2015']
                }
            }
        ]
    }
};