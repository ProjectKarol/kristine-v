<?php
/**
 * khaki Plugins Activation
 *
 * @package khaki
 */
require nk_admin()->admin_path . '/lib/class-tgm-plugin-activation.php';


/**
 * Register Required Plugins
 */
add_action( 'tgmpa_register', 'khaki_register_required_plugins' );
if ( ! function_exists( 'khaki_register_required_plugins' ) ) :
function khaki_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        // nK Themes Helper
        array(
            'name'       => 'nK Themes Helper',
            'slug'       => 'nk-themes-helper',
            'source'     => 'https://a.nkdev.info/wp-plugins/nk-themes-helper.zip',
            'version'   => '1.5.0',
            'required'   => true,
        ),

        // Khaki Core
        array(
            'name'       => 'Khaki Core',
            'slug'       => 'khaki-core',
            'source'     => nk_admin()->admin_path . '/plugins/khaki-core.zip',
            'version'   => '1.0.0',
            'required'   => true,
        ),

        // Visual Composer
        array(
            'name'       => 'WPBakery Visual Composer',
            'slug'       => 'js_composer',
            'source'     => 'https://a.nkdev.info/wp-plugins/js_composer.zip',
            'required'   => true,
        ),

        // ACF PRO
        array(
            'name'       => 'Advanced Custom Fields PRO',
            'slug'       => 'advanced-custom-fields-pro',
            'required'   => true,
            'source'    => 'https://a.nkdev.info/wp-plugins/advanced-custom-fields-pro.zip',
        ),

        // Kirki
        array(
            'name'       => 'Kirki',
            'slug'       => 'kirki',
            'required'   => true,
            'version'    => '2.3.6',
        ),

        // AWB
        array(
            'name'       => 'Advanced WordPress Backgrounds',
            'slug'       => 'advanced-backgrounds',
            'required'   => false,
        ),

        // Sociality
        array(
            'name'       => 'Sociality',
            'slug'       => 'sociality',
            'required'   => false,
        ),

        // Rev Slider
        array(
            'name'       => 'Slider Revolution',
            'slug'       => 'revslider',
            'source'     => 'https://a.nkdev.info/wp-plugins/revslider.zip',
            'required'   => false,
        ),

        // bbPress
        array(
            'name'       => 'bbPress',
            'slug'       => 'bbpress',
            'required'   => false,
            'version'    => '2.5.9',
        ),

        // Facebook Widget
        array(
            'name'       => 'Facebook Widget',
            'slug'       => 'facebook-pagelike-widget',
            'required'   => false,
            'version'    => '4.1',
        ),
		
		// Contact Form 7
        array(
            'name'       => 'Contact Form 7',
            'slug'       => 'contact-form-7',
            'required'   => false,
            'version'    => '4.5',
        ),

        // MailChimp
        array(
            'name'       => 'MailChimp for WordPress',
            'slug'       => 'mailchimp-for-wp',
            'required'   => false,
            'version'    => '4.0.4',
        ),

        // Post Views Counter
        array(
            'name'       => 'Post Views Counter',
            'slug'       => 'post-views-counter',
            'required'   => false,
            'version'    => '1.2.3',
        ),

        // Menu Icons
        array(
            'name'       => 'Menu Icons',
            'slug'       => 'menu-icons',
            'required'   => false,
            'version'    => '0.10.2',
        ),

        //WooCommerce
        array(
            'name'       => 'WooCommerce',
            'slug'       => 'woocommerce',
            'required'   => false,
            'version'    => '2.6.9',
        ),

        // nK WooCommerce Swatches
        array(
            'name'       => 'nK WooCommerce Swatches',
            'slug'       => 'nk-woocommerce-swatches',
            'source'     => 'https://a.nkdev.info/wp-plugins/nk-woocommerce-swatches.zip',
            'required'   => false,
            'version'    => '1.0.0',
        ),

        // Login With Ajax
        array(
            'name'       => 'Login With Ajax',
            'slug'       => 'login-with-ajax',
            'required'   => false,
            'version'    => '3.1.7',
        ),
    );

    $config = array(
        'domain'           => 'khaki',
        'default_path'     => '',
        'has_notices'      => true,
        'is_automatic'     => true,
        'message'          => ''
    );

    tgmpa( $plugins, $config );
}
endif;


// Visual Composer as theme
add_action( 'vc_before_init', 'khaki_vc_setastheme' );
function khaki_vc_setastheme() {
    vc_set_as_theme();
}

// Revolution Slider as theme
if(function_exists( 'set_revslider_as_theme' )) {
    add_action( 'init', 'khaki_rev_setastheme' );
    function khaki_rev_setastheme() {
        set_revslider_as_theme();
    }
}
