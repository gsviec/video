module.exports = function(grunt) {
 grunt.initConfig({
    concat: {

        css: {
           src: [
              'public/css/bootstrap.min.css',
              'public/css/font-awesome.min.css',
              'public/css/font-circle-video.css',
              'public/css/app.css',
           ],
           dest: 'public/css/all.css'
        },
        js: {
           src: [
              'public/js/jquery.js',
              'public/js/bootstrap.js',
              'public/js/notify.js',
              'public/js/app.function.js',
              'public/js/app.js',

           ],
           dest: 'public/js/all.js'
        },
     },
     cssmin: {
        css: {
           src: 'public/css/all.css',
           dest: 'public/css/all.min.css'
        }
     },
     uglify: {
        js: {
           src: 'public/js/all.js',
           dest: 'public/js/all.min.js',
        }
     },
    bump: {
        options: {
          files: ['package.json'],
          updateConfigs: [],
          commit: true,
          commitMessage: 'Release v%VERSION%',
          commitFiles: ['package.json'],
          createTag: true,
          tagName: 'v%VERSION%',
          tagMessage: 'Version %VERSION%',
          push: true,
          pushTo: 'upstream',
          gitDescribeOptions: '--tags --always --abbrev=1 --dirty=-d',
          globalReplace: false,
          prereleaseName: false,
          metadata: '',
          regExp: false
        }
    },




 });

    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-bump');
    grunt.registerTask('default', ['concat', 'cssmin', 'uglify']);
};

