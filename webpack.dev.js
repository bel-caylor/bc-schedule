const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin')

module.exports = {
  mode: 'development',
  entry: {
    'admin': ['./js/index.js', './scss/stylesheet.scss'],
    'frontend': './js/frontend/index.js'
  },
  output: {
    filename: './dist/[name].js',
    path: path.resolve(__dirname)
  },
  module: {
    rules: [
      {
        test: /\.(js|jsx)$/,
        exclude: /node_modules/,
        loader: 'babel-loader'
      },
      {
        test: /\.(sass|scss)$/,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader',
          {
            loader: "postcss-loader",
            options: {
              postcssOptions: {
                plugins: [require("tailwindcss"), require("autoprefixer")],
              },
            },
          },
          {
            loader: 'sass-loader',
            options: {
              sourceMap: true
            }
          }
        ]
      }
    ]
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: './dist/stylesheet.css'
    }),
    new BrowserSyncPlugin(
      {
        proxy: 'https://hopeisreal.localdev/wp-admin/', // Point to your local WordPress site
        files: ["**/*.php", "**/*.css", "**/*.js"],
      },
      {
        reload: false
      }
    )
  ],
  devtool: 'inline-source-map',
  watch: true
};