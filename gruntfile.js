'use strict';

// Gruntfile.js
module.exports = function (grunt) {
    
    var dest = 'app/build/';
    // load all grunt tasks matching the ['grunt-*', '@*/grunt-*'] patterns
    require('load-grunt-tasks')(grunt);

    grunt.initConfig({
        
        //bower_concat 
        bower_concat: {
            all: {
                dest: dest + 'main.js',
                cssDest: dest + 'main.css',
                dependencies: {
                    'angular': 'jquery',
                    'angular-route': 'angular',                    
                }
            }
        },
        
        //minify javascript
        uglify: {
           bower: {
            options: {
              mangle: true,
              compress: true
            },
            files: {
                'app/build/main.min.js': dest + 'main.js'
            }
          }
        },
        
        //minify css
        cssmin: {
			combine: {
				files: {
					'app/build/main.min.css': dest + 'main.css'
				}
			}
		},
    });
    
    grunt.registerTask("prepareModules", "Finds and prepares modules for concatenation.", function() {

        // get all module directories
        grunt.file.expand("app/modules/*").forEach(function (dir) {

            // get the module name from the directory name
            var dirName = dir.substr(dir.lastIndexOf('/')+1);

            // get the current concat object from initConfig
            var concat = grunt.config.get('concat') || {};

            // create a subtask for each module, find all src files
            // and combine into a single js file per module
            concat[dirName] = {
                src: [dir + '/**/*.js'],
                dest: 'app/build/' + dirName + '.min.js'
            };

            // add module subtasks to the concat task in initConfig
            grunt.config.set('concat', concat);
        });
    });
    
    grunt.registerTask('build', ['bower_concat', 'prepareModules', 'concat', 'uglify', 'cssmin']);
    
    grunt.registerTask('default', ['build']);
}