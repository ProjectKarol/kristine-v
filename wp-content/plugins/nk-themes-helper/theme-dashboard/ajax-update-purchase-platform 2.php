<?php
/**
 * Update Purchase Platform
 *
 * @package nk-themes-helper
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'wp_ajax_nk_theme_update_purchase_platform', 'nk_theme_update_purchase_platform' );

/**
 * Theme Activation Action
 */
function nk_theme_update_purchase_platform() {
    $platform = isset( $_GET['platform'] ) ? sanitize_text_field( wp_unslash( $_GET['platform'] ) ) : null;

    if ( null !== $platform ) {
        nk_theme()->theme_dashboard()->update_option( 'purchase_platform', $platform );
        echo 'ok';
    }

    die();
}
