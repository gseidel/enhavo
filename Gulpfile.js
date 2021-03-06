'use strict';

const gulp = require('gulp');
const exec = require('child_process').exec;
const elasticInstaller = require('./assets/node_modules/@enhavo/search/Installer')('./build/elasticsearch', '6.0.0');

gulp.task('docs', function (cb) {
  exec('sphinx-build -b html docs/source build/docs', function (err, stdout, stderr) {
    console.log(stdout);
    console.log(stderr);
    cb(err);
  });
});

gulp.task('test:karma', function (cb) {
    exec('TESTBUILD=true encore dev --config webpack.test.config.js && karma start --single-run --browsers ChromeHeadless karma.conf.js && rm -rf public/build/test/*', function (err, stdout, stderr) {
        console.log(stdout);
        console.log(stderr);
        cb(err);
    });
});

gulp.task('test:phpunit', function (cb) {
    exec('bin/phpunit', function (err, stdout, stderr) {
        console.log(stdout);
        console.log(stderr);
        cb(err);
    });
});

gulp.task('test:coverage', function (cb) {
    exec('bin/phpunit --coverage-html build/coverage-html', function (err, stdout, stderr) {
        console.log(stdout);
        console.log(stderr);
        cb(err);
    });
});

gulp.task('docs:watch', function () {
    exec('sphinx-autobuild docs/source build/docs', function (err, stdout, stderr) {
        console.log(stdout);
        console.log(stderr);
        cb(err);
    });
});

gulp.task("elastic:download", function(next) {
    elasticInstaller.download().then(next);
});

gulp.task("elastic:cleanup", function(next) {
    elasticInstaller.cleanup().then(next);
});

gulp.task("elastic:install", function(next) {
    elasticInstaller.install('./elasticsearch').then(next);
});

gulp.task("elastic", gulp.series("elastic:download", "elastic:install", "elastic:cleanup"));

gulp.task('routes:dump', function (cb) {
    exec('bin/console fos:js-routing:dump --format=json --target=public/js/fos_js_routes.json', function (err, stdout, stderr) {
        console.log(stdout);
        console.log(stderr);
        cb(err);
    });
});