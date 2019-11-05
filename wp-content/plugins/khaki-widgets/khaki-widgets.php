<?php
/**
 * Plugin Name:  Khaki Widgets
 * Description:  Widgets for Khaki
 * Version:      1.0.0
 * Author:       nK
 * Author URI:   https://nkdev.info
 * License:      GPLv2 or later
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  khaki-widgets
 */
define('NK_WIDGETS_DOMAIN', 'khaki-widgets');

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

/**
 * Khaki_Widgets Class
 */
if (!class_exists( 'Khaki_Widgets' )) :
    class Khaki_Widgets {

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
                self::$_instance->init_text_domain();
                self::$_instance->init_options();
                self::$_instance->init_hooks();

                // include helper files
                self::$_instance->include_dependencies();

                // clear caches
                self::$_instance->clear_expired_caches();

            }
            return self::$_instance;
        }

        public $plugin_path;
        public $plugin_url;
        public $plugin_name;
        public $plugin_version;
        public $plugin_slug;
        public $plugin_name_sanitized;

        public function __construct() {
            /* We do nothing here! */
        }

        public function init_text_domain () {
            load_plugin_textdomain( 'khaki-widgets', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
        }

        public function init_options() {
            $this->plugin_path = plugin_dir_path(__FILE__);
            $this->plugin_url = plugin_dir_url(__FILE__);
        }

        public function init_hooks() {
            add_action('admin_init', array($this, 'admin_init'));
        }

        public function admin_init () {
            // get current plugin data
            $data = get_plugin_data(__FILE__);
            $this->plugin_name = $data['Name'];
            $this->plugin_version = $data['Version'];
            $this->plugin_slug = plugin_basename(__FILE__, '.php');
            $this->plugin_name_sanitized = basename(__FILE__, '.php');
        }

        // include
        private function include_dependencies () {
            /* include all widgets */
            require_once( $this->plugin_path . '/widgets/recent-posts.php' );
            require_once( $this->plugin_path . '/widgets/twitter.php' );
            require_once( $this->plugin_path . '/widgets/instagram.php' );
            require_once( $this->plugin_path . '/widgets/tags-cloud.php' );
            require_once( $this->plugin_path . '/widgets/social-links.php' );
            require_once( $this->plugin_path . '/widgets/custom-image.php' );
            require_once( $this->plugin_path . '/widgets/copyright.php' );
            require_once( $this->plugin_path . '/widgets/contact.php' );
        }

        /**
         * Options
         */
        private function get_options () {
            $options_slug = 'khaki_widgets_options';
            return unserialize( get_option($options_slug, 'a:0:{}') );
        }
        public function update_option ($name, $value) {
            $options_slug = 'khaki_widgets_options';
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
endif;

if (!function_exists( 'khaki_widgets' )) :
    function khaki_widgets () {
        return Khaki_Widgets::instance();
    }
endif;
add_action('plugins_loaded', 'khaki_widgets' );