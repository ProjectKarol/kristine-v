<?php
/**
 * Scripts
 *
 * @package      Bootstrap for Genesis
 * @since        1.0
 * @link         http://webdevsuperfast.github.io
 * @author       Rotsen Mark Acob <webdevsuperfast.github.io>
 * @copyright    Copyright (c) 2015, Rotsen Mark Acob
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

// Theme Scripts & Stylesheet
add_action('wp_enqueue_scripts', 'bfg_theme_scripts');
function bfg_theme_scripts()
{
    $version = wp_get_theme()->Version;
    if (!is_admin()) {

// Register theme JS and enqueue it
        wp_register_script('custom', get_stylesheet_directory_uri() . '/assets/js/custom.js', array('jquery'), $version, true);
        wp_enqueue_script('custom');
        wp_localize_script('custom', 'charmedelamode', array(
            'root_url' => get_site_url(),
        ));

    }
}