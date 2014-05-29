module.exports = function (grunt) {

    'use strict';

    grunt.config('jslint', {
        js: {
            directives: {
                browser: true,
                predef: [
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
                'package.json'
            ]
        }
    });

};