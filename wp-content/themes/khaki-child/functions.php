<?php
/**
 * Khaki Child functions and definitions
 *
 * @package Khaki Child
 */
add_filter('widget_text', 'do_shortcode');
add_filter('acf/format_value/type=textarea', 'do_shortcode');
include_once get_stylesheet_directory() . '/lib/search.php';
include_once get_stylesheet_directory() . '/lib/scripts.php';
include_once get_stylesheet_directory() . '/lib/woocomerce.php';
/*
hash  files

 */
function wp_enqueue_style_hash()
{
	foreach (
		new DirectoryIterator(get_stylesheet_directory() . '/disc/css')
		as $file
	) {
		if (pathinfo($file, PATHINFO_EXTENSION) === 'css') {
			$fullName = basename($file); // main.3hZ9.js
			//   ddd( $fullName);
			$name = substr(
				basename($fullName),
				0,
				strpos(basename($fullName), '.')
			); // main

			switch ($name) {
				case 'style':
					$deps = array('vendor');
					break;

				default:
					$deps = null;
					break;
			}
			// ddd($deps);
		}
	}

	wp_register_style(
		$name,
		get_stylesheet_directory_uri() . '/disc/css/' . $fullName
	);
	//    ddd($fullName);
	wp_enqueue_style(
		$name,
		get_stylesheet_directory_uri() . '/disc/css/' . $fullName,
		$deps,
		null,
		true
	);
}

add_action("wp_enqueue_scripts", "wp_enqueue_style_hash", 9999999);

function wp_enqueue_script_hash()
{
	foreach (
		new DirectoryIterator(get_stylesheet_directory() . '/disc/js')
		as $file
	) {
		if (pathinfo($file, PATHINFO_EXTENSION) === 'js') {
			$fullName = basename($file); // main.3hZ9.js
			//  ddd( $fullName);
			$name = substr(
				basename($fullName),
				0,
				strpos(basename($fullName), '.')
			); // main

			switch ($name) {
				case 'style':
					$deps = array('vendor');
					break;

				default:
					$deps = null;
					break;
			}
			// ddd($deps);
		}
	}

	wp_register_script(
		$name,
		get_stylesheet_directory_uri() . '/disc/js/' . $fullName
	);
	//  ddd($fullName);
	wp_enqueue_script(
		$name,
		get_stylesheet_directory_uri() . '/disc/js/' . $fullName,
		$deps,
		null,
		true
	);
	wp_localize_script('scripts-bundled', 'kristine', array(
		'root_url' => get_site_url()
	));
}

add_action("wp_enqueue_scripts", "wp_enqueue_script_hash", 999);

// Enqueue Scripts & Styles.
add_action('wp_enqueue_scripts', 'kreativ_scripts_styles');
function kreativ_scripts_styles()
{
	wp_enqueue_script(
		'paralax',
		'//unpkg.com/jarallax@1.10/dist/jarallax-element.min.js',
		array(),
		'1.1'
	);
}

add_action('wp_enqueue_scripts', 'khaki_child_enqueue_styles', 15);
function khaki_child_enqueue_styles()
{
	wp_enqueue_style(
		'khaki-child',
		get_stylesheet_directory_uri() . '/style.css'
	);

	// wp_enqueue_script(
	// 	'khaki-child',
	// 	get_stylesheet_directory_uri() . '/script.js',
	// 	array('jquery')
	// );
}

// requeried files
require_once "lib/home-slider.php";
require_once 'lib/scripts.php';
require_once 'lib/footer-menu.php';

add_filter('stylesheet_uri', 'rv_load_alternate_stylesheet', 10, 2);
function rv_load_alternate_stylesheet($stylesheet_uri, $stylesheet_dir_uri)
{
	// Make sure this URI path is correct for your file
	return trailingslashit($stylesheet_dir_uri) . 'style-main.css';
}

function add_sockeraretea()
{
	echo '<h1>test</h1>';
}

add_action(' dynamic_sidebar_after', 'add_sockeraretea');

// custom link in menu
// add a link to the WP Toolbar
function custom_toolbar_link($wp_admin_bar)
{
	$args = array(
		'id' => 'pocza-kristien',
		'title' => 'Poczta',
		'href' => 'https://s67.linuxpl.com/roundcube/',
		'meta' => array(
			'class' => 'pocza-kristien',
			'target' => '_blank',
			'title' => 'Link do skrzynki pocztowej'
		)
	);
	$wp_admin_bar->add_node($args);
}
add_action('admin_bar_menu', 'custom_toolbar_link', 1);

//remove admin wordpess logo
function annointed_admin_bar_remove()
{
	global $wp_admin_bar;

	/* Remove their stuff */
	$wp_admin_bar->remove_menu('wp-logo');
}
add_action('wp_before_admin_bar_render', 'annointed_admin_bar_remove', 0);

// cutosm gatewaysy
add_filter(
	'woocommerce_available_payment_gateways',
	'payment_gateway_disable_based_on_language'
);
function payment_gateway_disable_based_on_language($available_gateways)
{
	if (ICL_LANGUAGE_CODE == "en") {
		unset($available_gateways['dotpay']);
	}

	if (ICL_LANGUAGE_CODE == "pl") {
	}

	return $available_gateways;
}

// remove specyfic category from shp page

/**
 * Show products only of selected category.
 */
function get_subcategory_terms($terms, $taxonomies, $args)
{
	$new_terms = array();
	$hide_category = array(424); // Ids of the category you don't want to display on the shop page

	// if a product category and on the shop page
	if (in_array('product_cat', $taxonomies) && !is_admin() && is_shop()) {
		foreach ($terms as $key => $term) {
			if (!in_array($term->term_id, $hide_category)) {
				$new_terms[] = $term;
			}
		}
		$terms = $new_terms;
	}
	return $terms;
}
add_filter('get_terms', 'get_subcategory_terms', 10, 3);

// separate category
// separte category

/**
 * Move WooCommerce subcategory list items into
 * their own <ul> separate from the product <ul>.
 */
add_action('init', 'move_subcat_lis');
function move_subcat_lis()
{
	// Remove the subcat <li>s from the old location.
	remove_filter(
		'woocommerce_product_loop_start',
		'woocommerce_maybe_show_product_subcategories'
	);
	add_action('woocommerce_before_shop_loop', 'msc_product_loop_start', 40);
	add_action(
		'woocommerce_before_shop_loop',
		'msc_maybe_show_product_subcategories',
		50
	);
	add_action('woocommerce_before_shop_loop', 'msc_product_loop_end', 60);
}
/**
 * Conditonally start the product loop with a <ul> contaner if subcats exist.
 */
function msc_product_loop_start()
{
	$subcategories = woocommerce_maybe_show_product_subcategories();
	if ($subcategories) {
		woocommerce_product_loop_start();
	}
}
/**
 * Print the subcat <li>s in our new location.
 */
function msc_maybe_show_product_subcategories()
{
	echo woocommerce_maybe_show_product_subcategories();
}
/**
 * Conditonally end the product loop with a </ul> if subcats exist.
 */
function msc_product_loop_end()
{
	$subcategories = woocommerce_maybe_show_product_subcategories();
	if ($subcategories) {
		woocommerce_product_loop_end();
	}
}
