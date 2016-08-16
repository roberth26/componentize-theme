var gulp =         require( 'gulp' );
var sourcemaps =   require( 'gulp-sourcemaps' );
var sass =         require( 'gulp-sass' );
var rename =       require( 'gulp-rename' );
var autoprefixer = require( 'gulp-autoprefixer' );
var uglify =       require( 'gulp-uglify' );
var pump =         require( 'pump' );

gulp.task( 'global-sass', function() {
	return gulp.src( [ 'sass/*.scss' ] )
		//.pipe( sourcemaps.init() )
			.pipe( sass({outputStyle: 'compressed'}).on( 'error', sass.logError ) )
			.pipe( autoprefixer() )
			.pipe (rename({
				suffix: '.min'
			}))
		//.pipe( sourcemaps.write() )
		.pipe( gulp.dest( 'css' ) );
});

gulp.task( 'template-sass', function() {
	return gulp.src( [ '*/*.scss' ] )
		//.pipe( sourcemaps.init() )
			.pipe( sass({outputStyle: 'compressed'}).on( 'error', sass.logError ) )
			.pipe( autoprefixer() )
			.pipe (rename({
				suffix: '.min'
			}))
		//.pipe( sourcemaps.write() )
		.pipe( gulp.dest( './' ) );
});
 
gulp.task( 'template-js', function( cb ) {
	pump([
			gulp.src( [ '*/*.js', '!*/*.min.js' ] )
				.pipe( rename({
					suffix: '.min'
				})),
			uglify(),
			gulp.dest( './' )
		],
		cb
	);
});

gulp.task( 'component-sass', function() {
	return gulp.src( [ 'components/**/*.scss' ] )
		//.pipe( sourcemaps.init() )
			.pipe( sass({outputStyle: 'compressed'}).on( 'error', sass.logError ) )
			.pipe( autoprefixer() )
			.pipe (rename({
				suffix: '.min'
			}))
		//.pipe( sourcemaps.write() )
		.pipe( gulp.dest( 'components' ) );
});

gulp.task( 'component-js', function( cb ) {
	pump([
			gulp.src( [ 'components/**/*.js', '!components/**/*.min.js' ] )
				.pipe( rename({
					suffix: '.min'
				})),
			uglify(),
			gulp.dest( 'components' )
		],
		cb
	);
});

gulp.task( 'watch-sass', function() {
	gulp.watch(
		[
			'*/*.scss',
			'components/**/*.scss',
			'sass/*.scss'
		],
		[
			'global-sass', 
			'template-sass', 
			'component-sass' 
		]
	);
});

gulp.task( 'watch-js', function() {
	gulp.watch(
		[
			'*/*.js',
			'!*/*.min.js', 
			'components/**/*.js', 
			'!components/**/*.min.js'
		],
		[
			'template-js',
			'component-js'
		]
	);
});

gulp.task( 'default',
	[
		'global-sass',
		'component-sass',
		'component-js',
		'template-sass',
		'template-js',
		'watch-sass',
		'watch-js'
	]
);