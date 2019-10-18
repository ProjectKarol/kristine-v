<?

//Don't paste in the above php tag

// Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'hello_bar_scripts_styles' );

function hello_bar_scripts_styles() {
	wp_enqueue_script( 'hello-bar', esc_url( get_stylesheet_directory_uri() ) . '/js/hello-bar.js', array( 'jquery' ), '1.0.0' );
}

//Add in new Widget areas
add_action( 'widgets_init', 'hello_bar_extra_widgets' );

function hello_bar_extra_widgets() {
	genesis_register_sidebar( array(
	'id'          => 'preheaderleft',
	'name'        => __( 'Pre-Header Left', 'themename' ),
	'description' => __( 'This is the preheader Left area', 'themename' ),
	'before_widget' => '<div class="first one-half preheaderleft">',
    	'after_widget' => '</div>',
	) );
	genesis_register_sidebar( array(
	'id'          => 'preheaderright',
	'name'        => __( 'Pre-Header Right', 'themename' ),
	'description' => __( 'This is the preheader Left area', 'themename' ),
	'before_widget' => '<div class="one-half preheaderright">',
    	'after_widget' => '</div>',
	) );
}

//Position the preHeader Area
add_action('genesis_before','hello_bar_preheader_widget');

function hello_bar_preheader_widget() {
	echo '<div class="preheadercontainer hello-bar "><div class="wrap">';
    	genesis_widget_area ('preheaderleft', array(
        'before' => '<div class="preheaderleftcontainer">',
        'after' => '</div>',));
    	genesis_widget_area ('preheaderright', array(
        'before' => '<div class="preheaderrightcontainer">',
        'after' => '</div>',));
    	echo '</div></div>';
}