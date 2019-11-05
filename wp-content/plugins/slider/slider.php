<?php
/**
 * Plugin Name: Flicker Slider
 * Plugin URI:  https://themehybrid.com/plugins/members
 * Description: A user and role management plugin that puts you in full control of your site's permissions. This plugin allows you to edit your roles and their capabilities, clone existing roles, assign multiple roles per user, block post content, or even make your site completely private.
 * Version:     0.1
 * Author:      Karol Szczesny
 * Author URI:  https://themehybrid.com
 * Text Domain: members
 * Domain Path: /lang
 **/
if (!defined('ABSPATH')) {
	exit(); // exit if accessed this file directly.
}

// Define plugin constants.
define('flicker_slider_version', '0.1');
define('flicker_slider_css', plugins_url('css/', __FILE__));
define('flicker_slider_js', plugins_url('scripts/', __FILE__));

require_once plugin_dir_path(__FILE__) . 'inc/main.php';
require_once plugin_dir_path(__FILE__) . 'inc/cpt-slider.php';

add_image_size('main-slider', 1600, 800, true);
add_image_size('mobile-slider', 720, 1280, true);

// enqu4e styles
function my_isotope_style()
{
	wp_register_style(
		'flickity.min',
		plugins_url('./slider/css/flickity.min.css')
	);
	wp_register_style('slider-flicker', plugins_url('./slider/style.min.css'));

	wp_enqueue_style('flickity.min');
	wp_enqueue_style('slider-flicker');
}
add_action('wp_enqueue_scripts', 'my_isotope_style');

add_action('wp_enqueue_scripts', 'my_plugin_assets');
function my_plugin_assets()
{
	wp_register_script(
		'flickity.pkgd.min',
		plugins_url('./slider/js/flickity.pkgd.min.js')
	);
	wp_register_script('fullscreen', plugins_url('./slider/js/fullscreen.js'));
	wp_register_script('flickity', plugins_url('./slider/js/custom.js'));
	wp_enqueue_script('flickity.pkgd.min');
	wp_enqueue_script('flickity.pkgd.min');
	wp_enqueue_script('fullscreen');
}