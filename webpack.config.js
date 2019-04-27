const Encore = require('@symfony/webpack-encore');
const EnhavoEncore = require('./assets/node_modules/@enhavo/core/EnhavoEncore');
const nodeExternals = require('webpack-node-externals');

Encore
  .setOutputPath('public/build/')
  .setPublicPath('/build')
  .enableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild()
  .enableSourceMaps(!Encore.isProduction())
  .splitEntryChunks()
  .autoProvidejQuery()
  .enableVueLoader()
  .enableSassLoader()
  .enableTypeScriptLoader()
  .enableBuildNotifications()
  .configureRuntimeEnvironment()

  .addEntry('enhavo/main', './assets/enhavo/main')
  .addEntry('enhavo/index', './assets/enhavo/index')
  .addEntry('enhavo/view', './assets/enhavo/view')
  .addEntry('enhavo/form', './assets/enhavo/form')
  .addEntry('enhavo/editor', './assets/enhavo/editor')
  .addEntry('enhavo/image-cropper', './assets/enhavo/image-cropper')
  .addEntry('enhavo/media-library', './assets/enhavo/media-library')
  .addEntry('enhavo/dashboard', './assets/enhavo/dashboard')
  .addEntry('enhavo/preview', './assets/enhavo/preview')
  .addEntry('enhavo/delete', './assets/enhavo/delete')
  .addEntry('enhavo/list', './assets/enhavo/list')
  .addEntry('enhavo/login', './assets/enhavo/login')
;

let config = EnhavoEncore.getWebpackConfig(Encore.getWebpackConfig());
//config.externals.push(nodeExternals());
//config.devtool = 'inline-cheap-module-source-map';
//config.output.devtoolModuleFilenameTemplate = '[absolute-resource-path]',
//config.devtoolFallbackModuleFilenameTemplate = '[absolute-resource-path]?[hash]';

config.target = 'node', // webpack should emit node.js compatible code
config.externals = [nodeExternals()], // in order to ignore all modules in node_modules folder from bundling


module.exports = config;