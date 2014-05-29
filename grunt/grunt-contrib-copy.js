module.exports = function (grunt) {

    'use strict';

    grunt.config('copy', {
        bower: {
            files: [
                {
                    expand: true,
                    cwd: 'bower_components/sass-placeholders',
                    src: [
                        '**/*.scss'
                    ],
                    dest: 'lib/sass-placeholdeers'
                }
            ]
        },
        composer: {
            files: [
                {
                    expand: true,
                    cwd: 'vendor/manovotny',
                    src: [
                        '**/*'
                    ],
                    dest: 'lib'
                }
            ]
        }
    });

};