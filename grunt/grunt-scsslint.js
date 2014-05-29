module.exports = function (grunt) {

    'use strict';

    grunt.config('scsslint', {
        sass: {
            options: {
                excludeLinter: [
                    'Indentation',
                    'PropertySortOrder'
                ]
            },
            src: [
                'admin/sass/**/*.scss',
                'sass/**/*.scss'
            ]
        }
    });

};