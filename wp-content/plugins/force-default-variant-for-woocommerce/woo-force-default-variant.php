<?php
/*
Plugin Name: WooCommerce Force Default Variant
Plugin URI: http://www.happykite.co.uk
Description: Removes the standard WooCommerce 'Select an Option' from variant Drop Downs and the option to Clear Selection.
Author: HappyKite
Author URI: http://www.happykite.co.uk/
Version: 1.4.3
*/

/*
 This file is part of wooCommerce-force-default.
 wooCommerce-force-default is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.
 wooCommerce-force-default is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.
 You should have received a copy of the GNU General Public License
 along with wooCommerce-force-default.  If not, see <http://www.gnu.org/licenses/>.
 */

/***************************
* includes
***************************/
include( dirname(__FILE__).'/functions.php' ); //Load Additional Functions
include( dirname(__FILE__).'/includes/variations.php' ); //Variant code
include( dirname(__FILE__).'/includes/settings.php' ); //Settings Area
include( dirname(__FILE__).'/includes/clear-removal.php' ); //Remove Clear Selection Text


/***************************
* Get Current WC Version.
***************************/

function hpy_check_wc_version() {
  //Checking if get_plugins is available.
  if( !function_exists( 'get_plugins' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
  }

  //Adding required variables
  $woo_folder = get_plugins( '/' . 'woocommerce' );
  $woo_file = 'woocommerce.php';

  //Checking if Version number is set.
  if( isset( $woo_folder[$woo_file]['Version'] ) ) {
    return $woo_folder[$woo_file]['Version'];
  } else {
    return NULL;
  }

}


/***************************
* Activation Notice
***************************/
$woo_version = hpy_check_wc_version();

if ( $woo_version < 2.4 ) {
  register_activation_hook(__FILE__, 'hpy_plugin_activation');
  function hpy_plugin_activation() {
    $url = admin_url('tools.php?page=uuc-options');
    $notices= get_option('hpy_plugin_deferred_admin_notices', array());
    $notices[]= "Attention: WooCommerce Force Default Variant requires at least WooCommerce Version 2.5, you currently have " . hpy_check_wc_version() . ". Please update WooCommerce before activating this plugin.";
    update_option('hpy_plugin_deferred_admin_notices', $notices);
  }

  add_action('admin_notices', 'hpy_plugin_admin_notices');
  function hpy_plugin_admin_notices() {
    if ($notices= get_option('hpy_plugin_deferred_admin_notices')) {
      foreach ($notices as $notice) {
        echo "<div id='message' class='error'><p>$notice</p></div>";
      }
      delete_option('hpy_plugin_deferred_admin_notices');
    }
    deactivate_plugins( plugin_basename( __FILE__ ) );
  }

}

register_deactivation_hook(__FILE__, 'hpy_plugin_deactivation');
function hpy_plugin_deactivation() { 
  delete_option('hpy_plugin_deferred_admin_notices');
}


/***************************
* Adding Plugin Settings Link
***************************/

function hpy_fdv_settings_link($links) {
  $settings_link = '<a href="admin.php?page=wc-settings&tab=products&section=hpy_variants">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'hpy_fdv_settings_link' );

