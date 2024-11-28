const { watch, src, dest, series, parallel } = require('gulp')
const browserSync = require('browser-sync').create()
const scss = require('gulp-sass')(require('sass'))
const cleanCSS = require('gulp-clean-css')
const concat = require('gulp-concat')
const uglify = require('gulp-minify')
const del = require('del')

const config = {
	app: {
		js: './app/js/*.js',
		scss: './app/scss/**/*.scss',
		css: './app/css/*.css',
	},
	dist: {
		base: './assets/',
		css: './assets/css',
		js: './assets/js',
	},
}

function liveReload(done) {
	browserSync.init({
		// server: {
		//     baseDir: config.dist.base
		// },
		proxy: 'http://wlc.local',
	})
	done()
}

function reload(done) {
	browserSync.reload()
	done()
}

function scssTask(done) {
	src(config.app.scss).pipe(scss().on('error', scss.logError)).pipe(dest(config.dist.css))
	done()
}

function jsTask(done) {
	src(config.app.js).pipe(dest(config.dist.js))
	done()
}

function watchFiles(done) {
	watch(config.app.scss, series(scssTask, reload))
	watch(config.app.js, series(jsPathTask, reload))
	watch(config.app.css, series(cssPathTask, reload))
	watch('./**/*.php', reload)
	done()
}

function cleanUp() {
	return del([config.dist.base])
}

function cssPathTask(done) {
	src(config.app.css).pipe(concat('main.min.css')).pipe(cleanCSS()).pipe(dest(config.dist.css))
	done()
}

function jsPathTask(done) {
	src(config.app.js).pipe(concat('script.js')).pipe(uglify()).pipe(dest(config.dist.js))
	done()
}

exports.default = parallel(scssTask, cssPathTask, jsPathTask, watchFiles, liveReload)
exports.prod = series(parallel(cleanUp, jsTask, scssTask), cssPathTask, jsPathTask)
