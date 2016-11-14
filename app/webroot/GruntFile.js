/**
 * Created by musta on 11/13/2016.
 */

module.exports = function(grunt){

    grunt.initConfig({

        uglify: {
            mediaview: {
                files: {
                    'js/mediaview.min.js': ['js/mediaview.js']
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');


    grunt.registerTask();

};
