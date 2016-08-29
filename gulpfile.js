var gulp =         require( 'gulp' );
var sass =         require( 'gulp-sass' );
var rename =       require( 'gulp-rename' );
var autoprefixer = require( 'gulp-autoprefixer' );
var uglify =       require( 'gulp-uglify' );
var watch =        require( 'gulp-watch' );
var postcss =      require( 'gulp-postcss' );
var browserify =   require( 'gulp-browserify' );


gulp.task( 'global-sass', function() {
    return watch( 'sass/*.scss', { ignoreInitial: false } )
		.pipe(
			sass( { outputStyle: 'compressed' } )
				.on( 'error', sass.logError )
		).pipe(
			autoprefixer()
		).pipe(
			rename({
				suffix: '.min'
			})
		).pipe(
			gulp.dest( 'css' )
		);
});

gulp.task( 'template-sass', function() {
    return watch( [ '*/*.scss', '!sass/*', '!node_modules/*' ], { ignoreInitial: false } )
		.pipe(
			sass( { outputStyle: 'compressed' } )
				.on( 'error', sass.logError )
		).pipe(
			autoprefixer()
		).pipe(
			rename({
				suffix: '.min'
			})
		).pipe(
			gulp.dest( './' )
		);
});
 
gulp.task( 'template-js', function() {
    return watch( [ '*/*.js', '!*/*.min.js', '!node_modules/*' ], { ignoreInitial: false } )
		.pipe(
			rename({
				suffix: '.min'
			})
		).pipe(
			uglify()
		).pipe(
			gulp.dest( './' )
		);
});

gulp.task( 'component-sass', function() {
    return watch( 'components/**/*.scss', { ignoreInitial: false } )
		.pipe(
			sass( { outputStyle: 'compressed' } )
				.on( 'error', sass.logError )
		).pipe(
			autoprefixer()
		).pipe(
			postcss( [ require( 'postcss-modules' )])
		).pipe(
			rename({
				suffix: '.min'
			})
		).pipe(
			gulp.dest( 'components' )
		);
});

gulp.task( 'component-js', function( cb ) {
    return watch( [ 'components/**/*.js', '!components/**/*.min.js' ], { ignoreInitial: false } )
    	.pipe(
    		browserify()
    	).pipe(
			rename({
				suffix: '.min'
			})
		).pipe(
			uglify()
		).pipe(
			gulp.dest( 'components' )
		);
});

gulp.task( 'default',
	[
		'global-sass',
		'component-sass',
		'component-js',
		'template-sass',
		'template-js'
	]
);