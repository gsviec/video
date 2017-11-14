var webpack = require('webpack');
module.exports = {
  entry: {
    app: './public/css/bootstrap.min.css',
    list: './public/css/font-awesome.min.css',
  },
  output: {
    path: __dirname + '/public/css/',
    filename: 'all.css'
  },
  plugins: [
    new CommonsChunkPlugin({
      // The order of this array matters
      names: ["all"],
      minChunks: 2
    })
]
}
