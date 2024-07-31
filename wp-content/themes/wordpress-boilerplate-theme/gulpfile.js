const { watch, parallel, series, src, dest } = require('gulp'),
    gulp        = require('gulp'),
    browserSync = require('browser-sync'),
    mode        = require('gulp-mode')(),
    gulpClean   = require('gulp-clean'),
    sass        = require('gulp-sass')(require('sass')),
    autoprefixer = require('autoprefixer'),
    postcss     = require('gulp-postcss'),
    sourcemaps  = require('gulp-sourcemaps'),
    rename      = require('gulp-rename'),
    cleanCss    = require('gulp-clean-css'),
    plumber     = require("gulp-plumber"),
    uglify      = require('gulp-uglify'),
    webpack     = require('webpack-stream'),
    log = require('fancy-log'),
    path = require('path'),
    flatmap = require('gulp-flatmap'),
    changedInPlace = require('gulp-changed-in-place');

const prod = process.env.NODE_ENV === 'production';

const paths = {
    'dist': 'dist/**/*',
    'html': {
        'watch': '**/*.php'
    },
    'css': {
        'src': 'assets/scss/app.scss',
        'dest': 'dist/css/',
        'watch': 'assets/scss/**/*.scss',
    },
    'js': {
        'src': 'assets/js/**/*.js',
        'dest': 'dist/js/',
        'watch': 'assets/js/**/*.js',
    },
    'partCss': {
        'src': 'parts/**/style.scss',
        'watch': 'parts/**/*.scss',
    },
    'partJs': {
        'src': ['parts/**/script.js', '!parts/blocks/**'],
        'watch': ['parts/**/script.js', '!parts/blocks/**'],
    },
    'blockCss': {
        'src': ['parts/blocks/**/style.scss', '!parts/blocks/**'],
        'watch': ['parts/blocks/**/*.scss', '!parts/blocks/**'],
    },
    'blockJs': {
        'src': 'parts/blocks/**/script.js',
        'watch': 'parts/blocks/**/script.js',
    }
};

function css() {
    return styles(paths.css.src, paths.css.dest);
}

function js() {
    return scripts(paths.js.src, paths.js.dest, 'app.js');
}

function partCss() {
    return styles(paths.partCss.src, file => { return file.base });
}

function partJs() {
    return scripts(paths.partJs.src, 'part', 'script.js');
}

function blockCss() {
    return styles(paths.blockCss.src, file => { return file.base });
}

function blockJs() {
    return scripts(paths.blockJs.src, 'block', 'script.js');
}

function watchFiles() {
    watch(paths.html.watch, browserSyncReload);
    watch(paths.js.watch, series(js, browserSyncReload));
    watch(paths.css.watch, series(css, browserSyncReload));
    watch(paths.partCss.watch, series(partCss, browserSyncReload));
    watch(paths.partJs.watch, series(partJs, browserSyncReload));
    watch(paths.blockCss.watch, series(blockCss, browserSyncReload));
    watch(paths.blockJs.watch, series(blockJs, browserSyncReload));
}

function clean() {
    return src(paths.dist, { read: false }).pipe(gulpClean());
}

function serve() {
    browserSync.init({
        open: true,
        proxy: 'http://test.test', // Zmień na swoją lokalizację
        serveStatic: ['.', './dist'],
        notify: false,
        reloadDelay: 1000,
        browser: 'default',
        reloadDebounce: 2000,
        injectChanges: true
    });
}

function browserSyncReload(done) {
    browserSync.reload();
    done();
}

exports.css = css;
exports.js = js;
exports.clean = clean;
exports.partCss = partCss;
exports.partJs = partJs;
exports.blockCss = blockCss;
exports.blockJs = blockJs;
exports.build = series(clean, css, js, partCss, partJs, blockCss, blockJs);
exports.default = parallel(clean, css, js, partCss, partJs, blockCss, blockJs, watchFiles, serve);

function styles(source, destination){ 
    return src(source, {since: gulp.lastRun(styles)})
        .pipe(changedInPlace({ firstPass:true }))
        .pipe(mode.development(sourcemaps.init()))
        .pipe(sass({ outputStyle: 'expanded' }))
        .pipe(postcss([autoprefixer()]))
        .pipe(cleanCss())
        .pipe(mode.development(sourcemaps.write()))
        .pipe(rename({'suffix': '.min'}))
        .pipe(dest(destination));
}

function scripts(source, destination, output){
    return src(source)
        .pipe(plumber())
        .pipe(changedInPlace({ firstPass: true }))
        .pipe(flatmap(function(stream, file){
            if (destination === 'block' || destination === 'part') {
                destination = path.dirname(file.path);
            }
           return stream.pipe(webpack({
                mode: prod ? 'production' : 'development',
                devtool: prod ? false : 'eval',
                output: {
                    filename: output,
                },
                module: {
                    rules: [{
                        test: /\.js$/,
                        exclude: /node_modules/,
                        use: {
                            loader: 'babel-loader',
                            options: {
                                presets: ['@babel/preset-env']
                            }
                        }
                    }]
                }
            }))
            .pipe(uglify())
            .pipe(rename({
                'suffix': '.min',
            }))
            .pipe(dest(destination))
        }))
}