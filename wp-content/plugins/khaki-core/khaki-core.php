<?php
/**
 * Plugin Name:  Khaki Core
 * Description:  Auxiliary plugin with shortcodes, widgets and migration script for khaki
 * Version:      1.0.0
 * Author:       nK
 * Author URI:   https://nkdev.info
 * License:      GPLv2 or later
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  khaki-core
 */

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

/**
 * Khaki_Core Class
 */
if (!class_exists( 'Khaki_Core' )) :
    class Khaki_Core {

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

                new Khaki_Core_Migration();

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
            load_plugin_textdomain( 'khaki-core', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
        }

        public function init_options() {
            $this->plugin_path = plugin_dir_path(__FILE__);
            $this->plugin_url = plugin_dir_url(__FILE__);
        }

        public function init_hooks() {
            add_action( 'admin_init', array( $this, 'admin_init' ) );
            add_action( 'admin_init', array( $this, 'deactivate_old_plugins' ), 20 );
            add_filter( 'site_option_active_sitewide_plugins', array( $this, 'deactivate_old_multisite_plugins' ) );
        }

        public function admin_init () {
            // get current plugin data
            $data = get_plugin_data(__FILE__);
            $this->plugin_name = $data['Name'];
            $this->plugin_version = $data['Version'];
            $this->plugin_slug = plugin_basename(__FILE__, '.php');
            $this->plugin_name_sanitized = basename(__FILE__, '.php');
        }

        public function deactivate_old_plugins () {
            if ( $active_plugins = get_option('active_plugins') ) {
                $deactivate_this = array(
                    'khaki-shortcodes/khaki-shortcodes.php',
                    'khaki-widgets/khaki-widgets.php',
                );
                $active_plugins = array_diff( $active_plugins, $deactivate_this );
                update_option( 'active_plugins', $active_plugins );
            }
        }

        public function deactivate_old_multisite_plugins ( $value ) {
            if ( isset($value['khaki-shortcodes/khaki-shortcodes.php']) ) {
                unset($value['khaki-shortcodes/khaki-shortcodes.php']);
            }
            if ( isset($value['khaki-widgets/khaki-widgets.php']) ) {
                unset($value['khaki-widgets/khaki-widgets.php']);
            }
            return $value;
        }

        public function is_plugin_active( $plugin ) {
            return in_array( $plugin, (array) get_option( 'active_plugins', array() ) );
        }

        // include
        private function include_dependencies () {

            $current_theme = wp_get_theme();

            require_once($this->plugin_path . 'migration.php');

            if ( ! $this->is_plugin_active( 'khaki-shortcodes/khaki-shortcodes.php' ) && ! $this->is_plugin_active( 'khaki-widgets/khaki-widgets.php' ) && ( 'Khaki' == $current_theme->name || 'Khaki Child' == $current_theme->name ) ) {
                require_once($this->plugin_path . '_all.php');

                /* include all shortcodes */
                require_once($this->plugin_path . "/shortcodes/nk-title.php");
                require_once($this->plugin_path . "/shortcodes/nk-text.php");
                require_once($this->plugin_path . "/shortcodes/nk-block-quote.php");
                require_once($this->plugin_path . "/shortcodes/nk-button.php");

                require_once($this->plugin_path . "/shortcodes/nk-icon-box.php");
                require_once($this->plugin_path . "/shortcodes/nk-info-box.php");
                require_once($this->plugin_path . "/shortcodes/nk-counter.php");
                require_once($this->plugin_path . "/shortcodes/nk-image-box.php");
                require_once($this->plugin_path . "/shortcodes/nk-gallery-images.php");
                require_once($this->plugin_path . "/shortcodes/nk-plain-video.php");
                require_once($this->plugin_path . "/shortcodes/nk-gif.php");
                require_once($this->plugin_path . "/shortcodes/nk-progress.php");

                require_once($this->plugin_path . "/shortcodes/nk-tabs.php");
                require_once($this->plugin_path . "/shortcodes/nk-accordion.php");
                require_once($this->plugin_path . "/shortcodes/nk-carousel.php");
                require_once($this->plugin_path . "/shortcodes/nk-images-carousel.php");
                require_once($this->plugin_path . "/shortcodes/nk-testimonial.php");
                require_once($this->plugin_path . "/shortcodes/nk-team-member.php");

                require_once($this->plugin_path . "/shortcodes/nk-text-typed.php");
                require_once($this->plugin_path . "/shortcodes/nk-countdown.php");
                require_once($this->plugin_path . "/shortcodes/nk-pricing-table.php");

                require_once($this->plugin_path . "/shortcodes/nk-instagram.php");
                require_once($this->plugin_path . "/shortcodes/nk-twitter.php");
                require_once($this->plugin_path . "/shortcodes/nk-posts-list.php");
                require_once($this->plugin_path . "/shortcodes/nk-separator.php");
                require_once($this->plugin_path . "/shortcodes/nk-fullpage.php");
                require_once($this->plugin_path . "/shortcodes/nk-playlist.php");
                require_once($this->plugin_path . "/shortcodes/nk-plain-audio.php");
                require_once($this->plugin_path . "/shortcodes/nk-portfolio-list.php");
                require_once($this->plugin_path . "/shortcodes/nk-portfolio-custom-list.php");
                require_once($this->plugin_path . "/shortcodes/nk-posts-carousel-list.php");
                require_once($this->plugin_path . "/shortcodes/nk-posts-fullscreen-list.php");
                require_once($this->plugin_path . "/shortcodes/nk-creative-posts-list.php");
                require_once($this->plugin_path . "/shortcodes/nk-events-list.php");
                require_once($this->plugin_path . "/shortcodes/nk-social.php");
                require_once($this->plugin_path . "/shortcodes/nk-contact.php");
                require_once($this->plugin_path . "/shortcodes/nk-video-icon.php");

                /* include all widgets */
                require_once($this->plugin_path . '/widgets/recent-posts.php');
                require_once($this->plugin_path . '/widgets/twitter.php');
                require_once($this->plugin_path . '/widgets/instagram.php');
                require_once($this->plugin_path . '/widgets/tags-cloud.php');
                require_once($this->plugin_path . '/widgets/social-links.php');
                require_once($this->plugin_path . '/widgets/custom-image.php');
                require_once($this->plugin_path . '/widgets/copyright.php');
                require_once($this->plugin_path . '/widgets/contact.php');
            }
        }

        /**
         * Options
         */
        private function get_options () {
            $options_slug = 'khaki_core_options';
            return unserialize( get_option($options_slug, 'a:0:{}') );
        }
        public function update_option ($name, $value) {
            $options_slug = 'khaki_core_options';
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

if (!function_exists( 'khaki_core' )) :
    function khaki_core () {
        return Khaki_Core::instance();
    }
endif;
add_action('plugins_loaded', 'khaki_core' );