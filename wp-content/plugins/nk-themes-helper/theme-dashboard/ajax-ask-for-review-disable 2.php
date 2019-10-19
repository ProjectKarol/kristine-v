<?php
/**
 * AJAX disable ask for review notice.
 *
 * @package nk-themes-helper
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'wp_ajax_nk_theme_ask_for_review_disable', 'nk_theme_ask_for_review_disable' );

/**
 * Disable ask for review notice action.
 */
function nk_theme_ask_for_review_disable() {
    nk_theme()->update_option( 'ask_for_review_status', 'disabled' );
    nk_theme()->update_option( 'ask_for_review_pending', false );

    die();
}
