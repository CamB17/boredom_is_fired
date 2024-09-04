module.exports = function (grunt) {
    //var target = grunt.option('target') || '*';
    const sass = require('node-sass');
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        clean: {
            contents: ['../../_exports/_css-source/', '../../_exports/css/'],
            options: {
                force: true
            },
        },
        concat: {
            // js: {
            //     src: '../../_engine/vendor/**/*.js',
            //     dest: '../../_exports/js/javascript.min.js'
            // },
            css: {
                src: [
                    '../../_exports/_css-source/vendor/**/*.css',
                    '../../_exports/_css-source/global/**/*.css',
                    '../../_exports/_css-source/archives/**/*.css',
                    '../../_exports/_css-source/pages/**/*.css',
                    '../../_exports/_css-source/singles/**/*.css',
                    '../../_exports/_css-source/pb/**/*.css',
                    '../../_exports/_css-source/func_mods/**/*.css',
                    '../../_exports/_css-source/alm/**/*.css',
                ],
                dest: '../../_exports/css/style.css'
            },
        },
        sass: {
            dist: {
                options: {
                    style: 'expanded',
                    sourceMap: true,
                    sourceComments: true,
                    implementation: sass,
                    quiet: false
                    //sourceMap: false
                },
                files: [
                    {
                        expand: true,
                        cwd: '../../global/',
                        src: ['**/*.scss'],
                        dest: '../../_exports/_css-source/global/',
                        ext: '.css'
                    }, {
                        expand: true,
                        cwd: '../../alm/',
                        src: ['**/*.scss'],
                        dest: '../../_exports/_css-source/alm/',
                        ext: '.css'
                    },
                    {
                        expand: true,
                        cwd: '../../archives/',
                        src: ['**/*.scss'],
                        dest: '../../_exports/_css-source/archives/',
                        ext: '.css'
                    },
                    {
                        expand: true,
                        cwd: '../../styles/',
                        src: ['**/*.scss'],
                        dest: '../../_exports/_css-source/styles/',
                        ext: '.css'
                    },
                    {
                        expand: true,
                        cwd: '../../fm_assorted/',
                        src: ['**/*.scss'],
                        dest: '../../_exports/_css-source/fm_assorted/',
                        ext: '.css'
                    },
                    {
                        expand: true,
                        cwd: '../../fm_page_builder/',
                        src: ['**/*.scss'],
                        dest: '../../_exports/_css-source/fm_page_builder/',
                        ext: '.css'
                    },
                    {
                        expand: true,
                        cwd: '../../cpt/',
                        src: ['*/**/*.scss'],
                        dest: '../../_exports/_css-source/cpt/',
                        ext: '.css'
                    },
                    {
                        expand: true,
                        cwd: '../../pages/',
                        src: ['**/*.scss'],
                        dest: '../../_exports/_css-source/pages/',
                        ext: '.css'
                    },
                    {
                        expand: true,
                        cwd: '../vendor/',
                        src: ['**/*.scss'],
                        dest: '../../_exports/_css-source/vendor/',
                        ext: '.css'
                    },
                    {
                        expand: true,
                        cwd: '../wp_admin/',
                        src: ['**/*.scss'],
                        dest: '../../_exports/_css-source/wp_admin/',
                        ext: '.css'
                    },


                ]
            }
        },
        postcss: {
            options: {
                map: false,
                processors: [
                    require('autoprefixer'), // add vendor prefixes
                    require('cssnano')() // minify the result
                ]
            },
            dist: {
                src: '../../_exports/css/*.css'
            }
        },
        uglify: {
            options: {
                banner: '',
                sourceMap: true
            },
            dist: {
                files: {
                    '../dist/js/javascript.min.js': '../dist/js/javascript.min.js'
                }
            }
        },
        watch: {
            // scripts: {
            //     files: ['../vendor/**/*.js'],
            //     tasks: ['concat']
            //     //tasks: ['concat', 'uglify']
            // },
            css: {
                files: ['../../**/*.scss'],
                // tasks: ['sass'],
                tasks: ['clean', 'sass', 'concat']
                //tasks: ['sass', 'postcss'],
            }
            /*
                 images: {
                   files: [
                     '<%= meta.assetPath_image %>/starstar/*.*'
                   ],
                   tasks: ['imagemin'],
                   options: {
                     spawn: true,
                   }
                 }*/
        },
    });
    // plugins
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-watch');
    //grunt.loadNpmTasks('grunt-contrib-imagemin');
    //grunt.loadNpmTasks('grunt-browser-sync');
    //grunt.loadNpmTasks('grunt-sftp-deploy');
    //grunt.loadNpmTasks('grunt-kss');
    grunt.registerTask('default', ['watch']);
    //grunt.registerTask('styleguide', ['clean', 'kss']);
    //grunt.registerTask('deploy', ['sftp-deploy:build']);
};
