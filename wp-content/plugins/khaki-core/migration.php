<?php
/**
 * khaki Core. Migration.
 */

if (!class_exists( 'Khaki_Core_Migration' )) :
    class Khaki_Core_Migration {

        private $migrate_version = '2.0.0';

        public $migrate_icons = array(
            'ion-social-twitter' => 'fab fa-twitter',
            'ion-social-facebook' => 'fab fa-facebook-f',
            'ion-social-pinterest' => 'fab fa-pinterest',
            'ion-social-instagram-outline' => 'fab fa-instagram',
            'ion-social-dribbble-outline' => 'fab fa-dribbble',
            'ion-social-octocat' => 'fab fa-github',
            'ion-bag' => 'ion-md-cart',
            'ion-ios-arrow-thin-right' => 'ion-ios-arrow-round-forward',
            'ion-ios-arrow-thin-left' => 'ion-ios-arrow-round-back',
            'ion-ios-arrow-right' => 'ion-ios-arrow-forward',
            'ion-ios-arrow-left' => 'ion-ios-arrow-back',
            'ion-android-favorite-outline' => 'ion-md-heart-empty',
            'ion-android-favorite' => 'ion-md-heart',
            'ion-grid' => 'ion-md-apps',
            'ion-ios-time-outline' => 'ion-md-time',
            'ion-android-time' => 'ion-md-time',
            'ion-clock' => 'ion-md-time',
            'ion-ios-color-wand-outline' => 'ion-ios-color-wand',
            'ion-wand' => 'ion-md-color-wand',
            'ion-ios-chatboxes-outline' => 'ion-ios-chatboxes',
            'ion-chatbubbles' => 'ion-ios-chatboxes',
            'ion-ios-email' => 'ion-ios-mail',
            'ion-navicon' => 'ion-ios-menu',
            'ion-iphone' => 'ion-ios-phone-portrait',
            'ion-paintbrush' => 'ion-ios-brush',
            'ion-social-buffer' => 'ion-logo-buffer',
            'ion-gear-a' => 'ion-ios-cog',
            'ion-ios-gear-outline' => 'ion-ios-cog',
            'ion-ios-gear' => 'ion-ios-cog',
            'ion-ios-cog-outline' => 'ion-ios-cog',
            'ion-speedometer' => 'ion-ios-speedometer',
            'ion-ios-speedometer-outline' => 'ion-md-speedometer',
            'ion-help-buoy' => 'ion-ios-help-buoy',
            'ion-ios-telephone' => 'ion-ios-call',
            'ion-android-close' => 'ion-md-close',
            'ion-search' => 'ion-ios-search',
            'ion-play' => 'ion-ios-play',
            'ion-pause' => 'ion-ios-pause',
            'ion-ios-book-outline' => 'ion-ios-book',
            'ion-ios-game-controller-a-outline' => 'ion-logo-game-controller-a',
            'ion-ios-navigate-outline' => 'ion-ios-navigate',
            'ion-ios-cloud-download-outline' => 'ion-ios-cloud-download',
            'ion-ios-help-outline' => 'ion-ios-help-circle-outline',
            'ion-paper-airplane' => 'ion-ios-paper-plane',
            'ion-ribbon-b' => 'ion-ios-ribbon',
            'ion-person-stalker' => 'ion-ios-people',
            'ion-reply-all' => 'ion-ios-undo',
            'ion-code' => 'ion-ios-code',
            'ion-android-happy' => 'ion-md-happy',
            'ion-ios-infinite-outline' => 'ion-ios-infinite',
            'ion-eye' => 'ion-ios-eye',
            'ion-information-circled' => 'ion-ios-information-circle',
            'ion-alert-circled' => 'ion-ios-alert',
            'ion-help-circled' => 'ion-ios-help-circle',
            'ion-fireball' => 'ion-md-flame',
            'ion-calendar' => 'ion-ios-calendar',
            'ion-location' => 'ion-ios-navigate',
            'ion-arrow-right-c' => 'ion-ios-arrow-round-forward',
            'ion-arrow-left-c' => 'ion-ios-arrow-round-back',
            'ion-arrow-up-c' => 'ion-ios-arrow-round-up',
            'ion-arrow-down-c' => 'ion-ios-arrow-round-down',
            'ion-locked' => 'ion-ios-lock',
            'ion-camera' => 'ion-ios-camera',
            'ion-speakerphone' => 'ion-md-mic',
            'ion-ios-search-strong' => 'ion-ios-search',
            'ion-home' => 'ion-ios-home',
            'ion-pricetags' => 'ion-md-pricetags',
            'ion-person' => 'ion-ios-person',
            'ion-earth' => 'ion-md-globe',
            'ion-reply' => 'ion-ios-undo',
            'ion-android-volume-off' => 'ion-md-volume-off',
            'ion-android-volume-mute' => 'ion-md-volume-mute',
            'ion-android-volume-down' => 'ion-md-volume-low',
            'ion-android-volume-up' => 'ion-md-volume-high',
            'ion-loop' => 'ion-md-infinite',
            'ion-shuffle' => 'ion-ios-shuffle',
            'ion-android-list' => 'ion-md-list-box',
            'ion-trash-b' => 'ion-ios-trash',
            'ion-refresh' => 'ion-md-refresh',
            'ion-checkmark' => 'ion-ios-checkmark',
            'ion-pin' => 'fas fa-thumbtack',
            'fa fa-link' => 'ion-md-link',
        );

        public $migrate_shortcode_classes = array(
            'hidden-md-up' => 'd-md-none',
            'hidden-sm-down' => 'd-none d-md-inline-block',
            'dib' => 'd-inline-block',
            'pull-right' => 'float-right',
            'pull-left' => 'float-left',
        );

        public function __construct() {
            add_option( 'khaki_migrate_theme_version', '' );
            add_action( 'wp_loaded', array( $this, 'migrate_to_new_version' ), 100 );
        }

        public function migrate_to_new_version() {
            $migrate_theme_version = get_option( 'khaki_migrate_theme_version' );
            if ( false === $migrate_theme_version || empty( $migrate_theme_version ) || $migrate_theme_version !== $this->migrate_version ) {
                global $wpdb;
                foreach ( $this->migrate_icons as $key => $icon ) {
                    $wpdb->query("UPDATE `" . $wpdb->prefix . "posts` SET `post_content` = REPLACE(`post_content`, '" . $key . "', '" . $icon . "')");
                    $wpdb->query("UPDATE `" . $wpdb->prefix . "options` SET `option_value` = REPLACE(`option_value`, '" . $key . "', '" . $icon . "')");
                }
                foreach ( $this->migrate_shortcode_classes as $key => $shortcode_class) {
                    $wpdb->query("UPDATE `" . $wpdb->prefix . "posts` SET `post_content` = REPLACE(`post_content`, '" . $key . "', '" . $shortcode_class . "')");
                }
                update_option( 'khaki_migrate_theme_version', $this->migrate_version );
            }
        }
    }
endif;