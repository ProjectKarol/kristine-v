<?php
/*
 * Plugin Name:  nK WooCommerce Swatches
 * Description:  Attributes swatches for WooCommerce
 * Version:      1.1.1
 * Author:       nK
 * Author URI:   https://nkdev.info
 * License:      GPLv2 or later
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  nkwcs
 */

define('NK_WCS_DOMAIN', 'nkwcs');

add_action('plugins_loaded', 'nkwcs_load_textdomain' );
function nkwcs_load_textdomain() {
    load_plugin_textdomain( 'nkwcs', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}


/**
 * NKWCS Class
 */
class NKWCS {
    /**
     * The single class instance.
     */
    private static $_instance = null;

    /**
     * Main Instance
     * Ensures only one instance of this class exists in memory at any one time.
     */
    public static function instance () {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
            self::$_instance->init_options();
        }
        return self::$_instance;
    }

    private $product_attribute_images;
    public $plugin_path;
    public $plugin_url;
    public $plugin_name;
    public $plugin_version;
    public $plugin_slug;
    public $plugin_name_sanitized;

    public function __construct() {
        /* We do nothing here! */
    }

    public function init_options() {
        $this->plugin_path = plugin_dir_path(__FILE__);
        $this->plugin_url = plugin_dir_url(__FILE__);

        // include helper files
        $this->include_dependencies();

        // clear caches
        $this->clear_expired_caches();

        // Hooks
        $this->init_hooks();
    }

    private function include_dependencies () {
        require 'nkwcs-templates.php';

        require 'classes/class-updater.php';
        require 'classes/class-wc-swatch-term.php';
        require 'classes/class-wc-swatches-product-attribute-images.php';
        require 'classes/class-wc-swatches-product-data-tab.php';
        require 'classes/class-wc-swatch-attribute-configuration.php';

        require 'classes/class-wc-swatches-ajax-handler.php';
    }

    public function init_hooks() {
        add_action( 'init', array(&$this, 'on_init') );

        add_action( 'wc_quick_view_enqueue_scripts', array($this, 'on_enqueue_scripts') );
        add_action( 'wp_enqueue_scripts', array(&$this, 'on_enqueue_scripts') );


        add_action( 'admin_head', array(&$this, 'on_enqueue_scripts') );

        add_action('admin_init', array(&$this, 'admin_init'));

        $this->product_attribute_images = new NKWCS_Product_Attribute_Images( 'swatches_id', 'swatches_image_size' );
        $this->product_data_tab = new NKWCS_Product_Data_Tab();

        //Swatch Image Size Settings
        add_filter( 'woocommerce_product_settings', array(&$this, 'swatches_image_size_setting') );
        add_filter( 'woocommerce_get_image_size_swatches', array($this, 'get_image_size_swatches') );
    }

    public function admin_init () {
        // get current plugin data
        $data = get_plugin_data(__FILE__);
        $this->plugin_name = $data['Name'];
        $this->plugin_version = $data['Version'];
        $this->plugin_slug = plugin_basename(__FILE__, '.php');
        $this->plugin_name_sanitized = basename(__FILE__, '.php');

        // init updater class to plugin updates check
        $this->updater();
    }

    public function on_init() {
        global $woocommerce;
        $image_size = get_option( 'swatches_image_size', array() );
        $size = array();

        $size['width'] = isset( $image_size['width'] ) && !empty( $image_size['width'] ) ? $image_size['width'] : '32';
        $size['height'] = isset( $image_size['height'] ) && !empty( $image_size['height'] ) ? $image_size['height'] : '32';
        $size['crop'] = isset( $image_size['crop'] ) ? $image_size['crop'] : 1;

        $image_size = apply_filters( 'woocommerce_get_image_size_swatches_image_size', $size );

        add_image_size( 'swatches_image_size', apply_filters( 'nkwcs_size_width_default', $image_size['width'] ), apply_filters( 'nkwcs_size_height_default', $image_size['height'] ), $image_size['crop'] );
    }

    public function on_enqueue_scripts() {
        global $pagenow, $wp_scripts;

        if ( !is_admin() ) {
            wp_enqueue_style( 'nkwcs', $this->plugin_url() . '/assets/css/nkwcs.css', array() );
            wp_enqueue_script( 'nkwcs', $this->plugin_url() . '/assets/js/nkwcs.js', array('jquery'), '', true );

            $data = array(
                'ajax_url' => admin_url( 'admin-ajax.php' )
            );

            wp_localize_script( 'nkwcs', 'nkwcs_params', $data );
        }

        if ( is_admin() && ( $pagenow == 'post-new.php' || $pagenow == 'post.php' || $pagenow == 'edit.php' || 'edit-tags.php') ) {
            wp_enqueue_media();
            wp_enqueue_style( 'nkwcs', $this->plugin_url() . '/assets/css/nkwcs.css' );
            wp_enqueue_script( 'nkwcs-admin', $this->plugin_url() . '/assets/js/nkwcs-admin.js', array('jquery'), '1.0', true );

            wp_enqueue_style( 'colourpicker', $this->plugin_url() . '/assets/css/colorpicker.css' );
            wp_enqueue_script( 'colourpicker', $this->plugin_url() . '/assets/js/colorpicker.js', array('jquery') );


            $data = array(
                'placeholder_img_src' => apply_filters( 'woocommerce_placeholder_img_src', WC()->plugin_url() . '/assets/images/placeholder.png' )
            );

            wp_localize_script( 'nkwcs-admin', 'nkwcs_params', $data );
        }
    }

    public function plugin_url() {
        return untrailingslashit( plugin_dir_url( __FILE__ ) );
    }

    public function plugin_dir() {
        return plugin_dir_path( __FILE__ );
    }

    public function swatches_image_size_setting( $settings ) {
        $setting = array(
            'name' => __( 'Swatches and Photos', 'nkwcs' ),
            'desc' => __( 'The default size for color swatches and images.', 'nkwcs' ),
            'id' => 'swatches_image_size',
            'css' => '',
            'type' => 'image_width',
            'std' => '32',
            'desc_tip' => true,
            'default' => array(
            'crop' => true,
            'width' => 32,
            'height' => 32
            )
        );

        $index = count( $settings ) - 1;

        $settings[$index + 1] = $settings[$index];
        $settings[$index] = $setting;
        return $settings;
    }

    public function get_image_size_swatches( $size ) {
        $image_size = get_option( 'swatches_image_size', array() );
        $size = array();

        $size['width'] = isset( $image_size['width'] ) && !empty( $image_size['width'] ) ? $image_size['width'] : '32';
        $size['height'] = isset( $image_size['height'] ) && !empty( $image_size['height'] ) ? $image_size['height'] : '32';
        $size['crop'] = isset( $image_size['crop'] ) ? 1 : 0;

        $image_size = apply_filters( 'woocommerce_get_image_size_swatches_image_size', $size );

        //Need to remove the filter because woocommerce will disable the input field.
        remove_filter( 'woocommerce_get_image_size_swatches', array($this, 'get_image_size_swatches') );

        return $image_size;
    }


    /**
     * Additional Classes
     */
    public function updater () {
        return NKWCS_Updater::instance();
    }


    /**
     * Options
     */
    private function get_options () {
        $options_slug = 'nkwcs_options';
        return unserialize( get_option($options_slug, 'a:0:{}') );
    }
    public function update_option ($name, $value) {
        $options_slug = 'nkwcs_options';
        $options = self::get_options();
        $options[self::sanitize_key($name)] = $value;
        update_option($options_slug, serialize($options));
    }
    public function get_option ($name, $default = null) {
        $options = self::get_options();
        $name = self::sanitize_key($name);
        return isset($options[$name]) ? $options[$name] : $default;
    }
    private function sanitize_key ($key) {
        return preg_replace( '/[^A-Za-z0-9\_]/i', '', str_replace( array( '-', ':' ), '_', $key ) );
    }


    /**
     * Cache
     * $time in seconds
     */
    private function get_caches () {
        $caches_slug = 'cache';
        return $this->get_option($caches_slug, array());
    }
    public function set_cache ($name, $value, $time = 3600) {
        if(!$time || $time <= 0) {
            return;
        }
        $caches_slug = 'cache';
        $caches = self::get_caches();

        $caches[self::sanitize_key($name)] = array(
            'value'   => $value,
            'expired' => time() + ((int) $time ? $time : 0)
        );
        $this->update_option($caches_slug, $caches);
    }
    public function get_cache ($name, $default = null) {
        $caches = self::get_caches();
        $name = self::sanitize_key($name);
        return isset($caches[$name]['value']) ? $caches[$name]['value'] : $default;
    }
    public function clear_cache ($name) {
        $caches_slug = 'cache';
        $caches = self::get_caches();
        $name = self::sanitize_key($name);
        if(isset($caches[$name])) {
            $caches[$name] = null;
            $this->update_option($caches_slug, $caches);
        }
    }
    public function clear_expired_caches () {
        $caches_slug = 'cache';
        $caches = self::get_caches();
        foreach($caches as $k => $cache) {
            if(isset($cache) && isset($cache['expired']) && $cache['expired'] < time()) {
                $caches[$k] = null;
            }
        }
        $this->update_option($caches_slug, $caches);
    }
}

function nkwcs() {
    return NKWCS::instance();
}

// check if WooCommerce plugin active
if (in_array('woocommerce/woocommerce.php', (array) apply_filters('active_plugins', get_option('active_plugins', array())))) {
    add_action('plugins_loaded', 'nkwcs' );
}
