var gulp = require('gulp');
var gutil = require('gulp-util');
var webpackStream = require('webpack2-stream-watch');
var webpack2 = require('webpack');
var sftp = require('gulp-sftp');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
const imagemin = require('gulp-imagemin');
var autoprefixer = require('gulp-autoprefixer');
var fs = require('fs');
const postcss = require('gulp-postcss');
const notify = require('gulp-notify');
var monitorCtrlC = require('monitorctrlc');
let config = JSON.parse(fs.readFileSync('./project.config.json'));

const getFilesToProcess = () => {
    const walk = function(dir) {
        var results = [];
        var list = fs.readdirSync(dir);
        list.forEach(function(file) {
            file = dir + '/' + file;
            var stat = fs.statSync(file);
            if (stat && stat.isDirectory())
                results = results.concat(walk(file));
            else results.push(file);
        });
        return results;
    };

    const server = walk('../assets').map(a => a.replace('../assets/', ''));
    const local = walk('.').map(a =>
        a.replace('./', '').replace('.scss', '.css')
    );

    const intersect = (a, b) => {
        let ai = 0;
        let bi = 0;
        let result = [];

        while (ai < a.length && bi < b.length) {
            if (a[ai] < b[bi]) {
                ai++;
            } else if (a[ai] > b[bi]) {
                bi++;
            } else {
                result.push(a[ai]);
                ai++;
                bi++;
            }
        }

        return result;
    };

    return intersect(server, local).map(a => './' + a.replace('.css', '.scss'));
};

gulp.task('config', () => {
    config.files = getFilesToProcess();
});
gulp.task('build', ['config', 'scripts', 'styles'], () => process.exit());

gulp.task('watch', ['watch:scripts', 'watch:styles'], function() {
    return gulp.src('./*').pipe(notify('Ready'));
});

gulp.task('watch:styles', ['config', 'styles'], function() {
    gulp.watch(['*.css', '**/*.css', '*.scss', '**/*.scss'], ['styles']);
});

gulp.task('watch:scripts', ['config', 'scripts'], function() {
    gulp.watch(['*.js', '**/*.js'], ['scripts']);
});

gulp.task('ready', function() {});

/************
 *
 *  Javascript
 *
 * */
gulp.task('scripts', function() {
    const { files = [] } = config;
    const jsFiles = files.filter(file => ~file.indexOf('.js'));
    const named = require('vinyl-named-with-path');

    return gulp
        .src(jsFiles, { base: './' })
        .pipe(named())
        .pipe(
            webpackStream(
                {
                    devtool: 'source-map',
                    watch: true,
                    module: {
                        loaders: [
                            {
                                test: /\.js$/,
                                exclude: /node_modules/,
                                loader: 'babel-loader',
                                query: {
                                    presets: ['es2015', 'react', 'stage-0']
                                }
                            },
                            {
                                test: /\.scss$/,
                                loaders: [
                                    'style-loader',
                                    'css-loader?sourceMap&minimize',
                                    'sass-loader?sourceMap'
                                ]
                            }
                        ]
                    },
                    resolve: {
                        extensions: ['.js', '.jsx']
                    },
                    plugins: [
                        new webpack2.DefinePlugin({
                            'process.env': {
                                NODE_ENV: JSON.stringify('production')
                            }
                        }),
                        new webpack2.optimize.UglifyJsPlugin({
                            compress: {
                                warnings: false
                            },
                            sourceMap: true
                        })
                    ]
                },
                webpack2
            )
        )
        .on('error', notify.onError(error => error.message))
        .pipe(gulp.dest('../assets')) // write the minified output file
        .pipe(sftp(config.sftp)); // uploade the file and map
});

/************
 *
 *  Styles
 *
 * */
gulp.task('styles', function() {
    const { files = [] } = config;
    const scssFiles = files.filter(file => ~file.indexOf('.scss'));

    // plugins for postcss
    const _autoprefixer = require('autoprefixer');
    const cssnano = require('cssnano')({
        zindex: false
    });
    const plugins = [_autoprefixer, cssnano];

    return gulp
        .src(scssFiles, { base: './' })
        .pipe(sourcemaps.init())
        .pipe(
            sass({ outputStyle: 'compressed' }).on(
                'error',
                notify.onError(error => error.message)
            )
        )
        .pipe(postcss(plugins))
        .pipe(sourcemaps.write('../assets'))
        .pipe(gulp.dest('../assets'))
        .pipe(sftp(config.sftp)); // uploade the file and map
});

gulp.task('minify:images', () => {
    const sftpConfig = Object.assign({}, config.sftp, {
        remotePath: config.sftp.remotePath + '/assets/images/'
    });

    return gulp
        .src('./images/**/*')
        .pipe(
            imagemin([
                imagemin.gifsicle({ interlaced: true }),
                imagemin.jpegtran({ progressive: true }),
                imagemin.optipng({ optimizationLevel: 5 }),
                imagemin.svgo({ plugins: [{ removeViewBox: true }] })
            ])
        )
        .pipe(gulp.dest('../assets/images'))
        .pipe(sftp(sftpConfig));
});
