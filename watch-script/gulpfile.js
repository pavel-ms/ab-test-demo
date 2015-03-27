var gulp = require("gulp")
	, concat = require('gulp-concat')
	, uglify = require('gulp-uglify');

var jsFiles = [
	'main.js'
	, 'lib/q-adopted.js'
	, 'lib/cookie-adopted.js'
];




gulp.task('default', function() {
	gulp.src(jsFiles)
		.pipe(concat({path: 'watch.js'}))
		.pipe(uglify())
		.pipe(gulp.dest('../backend/web/static/'));
});