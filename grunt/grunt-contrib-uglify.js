module.exports = function (grunt) {

    'use strict';

    grunt.config('uglify', {
        options: {
//            beautify: true,
//            mangle: false
        },
        theme: {
            files: {
                'js/subscribe.min.js': [
                    'js/*.js',
                    'js/!*.min.js'
                ]
            }
        }
    });

};