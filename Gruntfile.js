module.exports = function (grunt) {
  grunt.initConfig({
    autoprefixer: {
      options: {
        browsers: ['last 8 versions', 'ie 8', 'ie 7', 'ie 9']
      },
      multiple_files: {
        expand: true,
        flatten: true,
        src: 'public/prebuild/css/*.css',
        dest: 'public/assets/css/'
      }
    },
    watch: {
      src: {
        files: ['public/prebuild/css/*.css'],
        tasks: ['autoprefixer', 'cssmin'],
        options: {
          spawn: false
        }
      }
    },
    cssmin: {
      target: {
        files: [{
          expand: true,
          cwd: 'public/assets/css',
          src: ['*.css', '!*.min.css'],
          dest: 'public/assets/css/min',
          ext: '.css'
        }]
      }
    }
  });
  grunt.loadNpmTasks('grunt-autoprefixer');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
};
