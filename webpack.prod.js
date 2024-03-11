const webpack = require('webpack');
const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

module.exports = [
    {
    mode: 'production',
    entry: {
      'main': ['./js/index.js', './scss/stylesheet.scss']
    },
    output: {
      filename: './dist/[name].min.js',
      path: path.resolve(__dirname)
    },
    module: {
      rules: [
        // Babelize JavaScript
        {
          test: /\.(js|jsx)$/,
          exclude: /node_modules/,
          loader: 'babel-loader'
        },
        // Compile SCSS
        {
          test: /\.(sass|scss)$/,
          use: [
            MiniCssExtractPlugin.loader,
            "css-loader",
            {
              loader: "postcss-loader",
              options: {
                postcssOptions: {
                  plugins: [require("tailwindcss"), require("autoprefixer")],
                },
              },
            },
            "sass-loader",  
          ]
        }
      ]
    },
    plugins: [
      // Clean build directories on each build
      new CleanWebpackPlugin({
        cleanOnceBeforeBuildPatterns: ['./dist/*']
      }),
      // Extract CSS into a dedicated file
      new MiniCssExtractPlugin({
        filename: './dist/stylesheet.min.[fullhash].css'
      }),
      new webpack.ProvidePlugin({
        $: 'jquery',
        jQuery: 'jquery'
      })
    ],
    optimization: {
      // Minification (only in production mode)
      minimizer: [
        // JavaScript minification (using webpack 5 default terser-webpack-plugin)
        '...',
        // CSS minification
        new CssMinimizerPlugin()
      ]
    }
  }
];
