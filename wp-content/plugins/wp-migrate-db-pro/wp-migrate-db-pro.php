<?php
/*
Plugin Name: WP Migrate DB Pro
Plugin URI: https://deliciousbrains.com/wp-migrate-db-pro/
Description: In file path class>Pro>APi.php on in function dbrains_api_request on line 148 changed "return $response['body'];" to "return true;"
Author: Delicious Brains
Version: 1.9.2
Author URI: https://deliciousbrains.com
Network: True
Text Domain: wp-migrate-db
Domain Path: /languages/
 */

// Copyright (c) 2013 Delicious Brains. All rights reserved.
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// **********************************************************************
$wpmdb_base_path = dirname(__FILE__);
$GLOBALS['wpmdb_meta']['wp-migrate-db-pro']['version'] = '1.9.2';
$GLOBALS['wpmdb_meta']['wp-migrate-db-pro']['folder'] = basename(plugin_dir_path(__FILE__));
$GLOBALS['wpmdb_meta']['wp-migrate-db-pro']['abspath'] = $wpmdb_base_path;

if (!defined('WPMDB_MINIMUM_PHP_VERSION')) {
    define('WPMDB_MINIMUM_PHP_VERSION', '5.4');
}

if (version_compare(PHP_VERSION, WPMDB_MINIMUM_PHP_VERSION, '>=')) {
    require_once $wpmdb_base_path . '/class/autoload.php';
    require_once $wpmdb_base_path . '/setup-mdb-pro.php';
}

if (!function_exists('wpmdb_deactivate_other_instances')) {
    require_once $wpmdb_base_path . '/class/deactivate.php';
}

add_action('activated_plugin', 'wpmdb_deactivate_other_instances');

if (!class_exists('WPMDB_PHP_Checker')) {
    require_once $wpmdb_base_path . '/php-checker.php';
}

$php_checker = new WPMDB_PHP_Checker(__FILE__, WPMDB_MINIMUM_PHP_VERSION);
if (!$php_checker->is_compatible_check()) {
    register_activation_hook(__FILE__, array('WPMDB_PHP_Checker', 'wpmdb_pro_php_version_too_low'));
}

function wpmdb_pro_remove_mu_plugin()
{
    do_action('wp_migrate_db_remove_compatibility_plugin');
}