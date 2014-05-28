module.exports = function (grunt) {

    'use strict';

    grunt.config('watch', {
        css: {
            files: [
                'admin/sass/**/*.scss',
                'sass/**/*.scss'
            ],
            tasks: [
                'css'
            ]
        },
        js: {
            files: [
                'bower.json',
                'composer.json',
                'grunt/*.js',
                'Gruntfile.js',
                'package.json'
            ],
            tasks: [
                'js'
            ]
        }
    });

};