<?php
/**
 * Get changelog page content from url
 *
 * @package nk-themes-helper
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'wp_ajax_nk_theme_get_changelog', 'nk_theme_get_changelog' );

/**
 * Theme Activation Action
 */
function nk_theme_get_changelog() {
    $url = isset( $_GET['url'] ) ? sanitize_text_field( wp_unslash( $_GET['url'] ) ) : null;

    if ( null === $url ) {
        die();
    }

    $result = wp_remote_get( $url );
    $result = wp_remote_retrieve_body( $result );

    if ( $result ) {
        echo $result; // XSS OK.
    }

    die();
}
