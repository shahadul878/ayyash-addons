// webpack.config.js
const path = require("path")
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const fs = require("fs");

const projectPaths = {
    projectDir: __dirname, // Current project directory absolute path.
    projectJsPath: path.resolve(__dirname, 'assets/src/js'),
    projectScssPath: path.resolve(__dirname, 'assets/src/scss'),
    projectImagesPath: path.resolve(__dirname, 'assets/src/images'),
    projectFontsPath: path.resolve(__dirname, 'assets/src/fonts'),
    projectOutput: path.resolve(__dirname, 'assets/dist'),
    projectWebpack: path.resolve(__dirname, 'webpack'),
};

function getScssEntries(dir, files_) {
    files_ = files_ || {};
    const files = fs.readdirSync(dir);
    for (const i in files) {
        const basename = files[i];
        const name = dir + '/' + basename;
        if (fs.statSync(name).isDirectory()) {
            getScssEntries(name, files_);
        } else if (0 !== basename.indexOf('_') && -1 === scssExcludes.indexOf(name) && 'scss' === name.slice(-4)) {
            files_[basename.slice(0, -5)] = name; // webpack needs k=>v no .ext
        }
    }
    return files_;
}


let scssExcludes = [
    // 'plugins/wpcf7.scss' // eg.
    'admin/admin.scss', 'admin/mega-menu.scss', // imported via admin.js
    'customizer.scss', // imported via customizer.js
];
// Files to bundle
const projectFiles = {
    // BrowserSync settings
    browserSync: {
        enable: false, // enable or disable browserSync
        host: 'localhost',
        port: 3000,
        mode: 'proxy', // proxy | server
        server: {baseDir: ['public']}, // can be ignored if using proxy
        proxy: 'https://themeoo.test',
        // BrowserSync will automatically watch for changes to any files connected to our entry,
        // including both JS and Sass files. We can use this property to tell BrowserSync to watch
        // for other types of files, in this case PHP files, in our project.
        files: '**/**/**.php',
        reload: true, // Set false to prevent BrowserSync from reloading and let Webpack Dev Server take care of this
        // browse to http://localhost:3000/ during development,
    },
    // JS configurations for development and production
    projectJs: {
        eslint: true, // enable or disable eslint  | this is only enabled in development env.
        filename: 'js/[name].js',
        entry: {

            // we had to export some scss separately.
            ...getScssEntries(projectPaths.projectScssPath)
        },
        rules: {
            test: /\.m?js$/,
        }
    },
    // CSS configurations for development and production
    projectCss: {
        postCss: projectPaths.projectWebpack + '/postcss.config.js',
        stylelint: false, // enable or disable stylelint | this is only enabled in development env.
        filename: 'css/[name].css',
        use: 'sass', // sass (not scss sett test rules below.) || postcss
        // ^ If you want to change from Sass to PostCSS or PostCSS to Sass then you need to change the
        // styling files which are being imported in "assets/src/js/frontend.js" and "assets/src/js/backend.js".
        // So change "import '../sass/backend.scss'" to "import '../postcss/backend.pcss'" for example
        rules: {
            sass: {
                test: /\.s[ac]ss$/i
            },
            postcss: {
                test: /\.pcss$/i
            }
        },
        purgeCss: { // PurgeCSS is only being activated in production environment
            paths: [ // Specify content that should be analyzed by PurgeCSS
                __dirname + '/assets/src/js/**/*',
                __dirname + '/templates/**/**/*',
                __dirname + '/template-parts/**/**/*',
                __dirname + '/blocks/**/**/*',
                __dirname + '/*.php',
                __dirname + '/**/*.php',
            ]
        }
    },
    // Source Maps configurations
    projectSourceMaps: {
        // Sourcemaps are nice for debugging but takes lots of time to compile,
        // so we disable this by default and can be enabled when necessary
        enable: false,
        env: 'dev', // dev | dev-prod | prod
        // ^ Enabled only for development on default, use "prod" to enable only for production
        // or "dev-prod" to enable it for both production and development
        devtool: 'source-map' // type of sourcemap, see more info here: https://webpack.js.org/configuration/devtool/
        // ^ If "source-map" is too slow, then use "cheap-source-map" which struck a good balance between build performance and debuggability.
    },
    // Images configurations for development and production
    projectImages: {
        rules: {
            test: /\.(jpe?g|png|gif|svg)$/i,
        },
        // Optimization settings
        minimizerOptions: {
            // Lossless optimization with custom option
            // Feel free to experiment with options for better result for you
            // More info here: https://webpack.js.org/plugins/image-minimizer-webpack-plugin/
            plugins: [
                ['gifsicle', {interlaced: true}],
                ['jpegtran', {progressive: true}],
                ['optipng', {optimizationLevel: 5}],
                ['svgo', {
                    plugins: [
                        {removeViewBox: false,},
                    ],
                },],
            ],
        }
    },
    // Images configurations for development and production
    projectFonts: {
        rules: {
            test: /\.(woff|woff2|eot|ttf|otf|svg)$/i,
        }
    }
}

// Merging the projectFiles & projectPaths objects
const projectOptions = {
    ...projectPaths, ...projectFiles,
    projectConfig: {
        // add extra options here
    }
}

module.exports = env => {
    if (env.NODE_ENV === 'production') {
        return require('./webpack/config.production')(projectOptions);
    } else {
        return require('./webpack/config.development')(projectOptions);
    }
};

