module.exports = function(grunt) {

  grunt.initConfig({

    // Watches for changes and runs tasks
    // Livereload is setup for the 35729 port by default
    watch: {
      css: {
        files: ['*.css'],
        options: {
          livereload: 35729
        }
      },
      php: {
        files: ['*.php', '**/*.php'],
        options: {
          livereload: 35729
        }
      }
    }

  });

  // Default task
  grunt.registerTask('default', ['watch']);

  // Load up tasks
  grunt.loadNpmTasks('grunt-contrib-watch');

};