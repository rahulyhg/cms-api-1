const sass = require('node-sass');

module.exports = function ( grunt ) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        concat: {
            options: {
                stripBanners: true,
                banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - <%= grunt.template.today("yyyy-mm-dd") %> */',
            },
            js: {
                src: [
                    'assets/js/global/jquery-3.1.0.min.js',
                    'assets/js/global/bootstrap.min.js',
                    'assets/js/src/**/*.js'
                ],
                dest: 'public/js/built.js'
            },
            css: {
                src: [
                    'assets/styles/global/**/*.css',
                    'assets/styles/style.css'
                ],
                dest: 'public/css/built.css'
            }
        },
        sass: {
            options: {
                implementation: sass,
                sourceMap: true
            },
            dist: {
                files: {
                    'assets/styles/style.css' : 'assets/styles/sass/style.scss'
                }
            }
        },
        uglify: {
            build: {
                files: [ {
                    src: '<%= concat.js.dest %>',
                    dest: '<%= concat.js.dest %>'
                } ]
            }
        },
        cssmin: {
            options: {
                mergeIntoShorthands: false,
                roundingPrecision: -1,
                keepSpecialComments: 0
            },
            build: {
                files: {
                    '<%= concat.css.dest %>': '<%= concat.css.dest %>',
                }
            }
        },
        csslint: {
            check: {
                src: ['assets/styles/**/*.css', '!assets/styles/**/*.min.css']
            }
        },
        typescript: {
            base: {
                src: ['assets/js/typescript/**/*.ts'],
                dest: 'assets/js/src/',
                options: {
                    module: 'amd', //or commonjs
                    target: 'es5', //or es3
                    sourceMap: true,
                    declaration: true
                }
            }
        },
        copy: {
            main: {
                expand: true,
                cwd: 'assets/fonts/',
                src: ['**'],
                dest: 'public/fonts/'
            }
        },
        postcss: {
            options: {
                map: true,
                processors: [
                    require('autoprefixer')({browsers: 'last 2 versions'})
                ]
            },
            dist: {
                src: 'assets/styles/style.css'
            }
        }
    });

    // Load NPM
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-csslint');
    grunt.loadNpmTasks('grunt-typescript');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-postcss');

    // User define task
    grunt.registerTask('default', [
        'concat:js',
        'sass',
        'postcss',
        'concat:css',
        'uglify:build',
        'cssmin:build',
        'copy'
    ]);

    grunt.registerTask('dev', [
        'concat:js',
        'sass',
        'concat:css'
    ]);
};
