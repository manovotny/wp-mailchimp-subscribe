module.exports = function (grunt) {

    'use strict';

    grunt.registerTask('default', [
        'build',
        'watch'
    ]);

    grunt.registerTask('build', [
        'lib',
        'js',
        'bump'
    ]);

    grunt.registerTask('bump', [
        'replace'
    ]);

    grunt.registerTask('css', [
        'clean:css',
        'sass',
        'cssmin'
    ]);

    grunt.registerTask('lib', [
        'clean:lib',
        'copy'
    ]);

    grunt.registerTask('js', [
        'clean:js',
        'jslint',
        'uglify'
    ]);

};
