module.exports = function (grunt) {

    'use strict';

    grunt.config('clean', {
        css: [
            'admin/css',
            'css'
        ],
        js: [
            'js/*.min.js'
        ],
        lib: [
            'composer.lock',
            'lib'
        ]
    });

};