<?php
/**
 * AJAX disable ask for activation notice.
 *
 * @package nk-themes-helper
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'wp_ajax_nk_theme_ask_for_activation_disable', 'nk_theme_ask_for_activation_disable' );

/**
 * Disable ask for activation notice action.
 */
function nk_theme_ask_for_activation_disable() {
    nk_theme()->update_option( 'ask_for_activation_status', 'disabled' );

    die();
}
