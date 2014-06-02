module.exports = function (grunt) {

    'use strict';

    grunt.config('jslint', {
        js: {
            directives: {
                browser: true,
                nomen: true,
                predef: [
                    '_',
                    'jQuery',
                    'module',
                    'require'
                ]
            },
            src: [
                'bower.js',
                'composer.json',
                'Gruntfile.js',
                'grunt/*.js',
                'js/**/*.js',
                'js/**/!*.min.js',
                'package.json'
            ]
        }
    });

};