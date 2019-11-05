<?php

/**
 * Create the section beneath the products tab
 */
add_filter( 'woocommerce_get_sections_products', 'hpy_woo_add_section' );
function hpy_woo_add_section( $sections ) {
	$sections['hpy_variants'] = __( 'Variants', 'hpy_wdv' );
	return $sections;	
}

/**
 * Add settings to the specific section we created before
 */
add_filter( 'woocommerce_get_settings_products', 'hpy_woo_all_settings', 10, 2 );
function hpy_woo_all_settings( $settings, $current_section ) {
	/**
	 * Check the current section is what we want
	 **/
	if ( $current_section == 'hpy_variants' ) {
		$settings_variant = array();

		$settings_variant[] = array( 'name' => __( 'Default Variant Settings', 'hpy_wdv' ), 'type' => 'title', 'id' => 'hpy_variants' );

		$settings_variant[] = array(
			'name'     => __( 'Sort by:', 'hpy_wdv' ),
			'desc_tip' => __( 'Change how you want the default variant to be sorted.', 'hpy_wdv' ),
			'id'       => 'hpy_variant_sort',
			'type'     => 'select',
			'options'  => array(
				'position'   => __( 'Position', 'hpy_wdv' ),
				'id'		 => __( 'ID', 'hpy_wdv' ),
				'price-low'  => __( 'Price Low -> High', 'hpy_wdv' ),
				'price-high' => __( 'Price High -> Low', 'hpy_wdv' ),
			),
			'css'      => 'min-width:300px;',
			'desc'     => __( '<p>How do you want to sort the variations</p>', 'hpy_wdv' ),
		);
		
		$settings_variant[] = array(
			'name'     => __( 'Stock Limit:', 'hpy_wdv' ),
			'desc_tip' => __( 'Check the stock limit of the variant before displaying. If this is not set the Plugin will still check for the overall stock status.', 'hpy_wdv' ),
			'id'       => 'hpy_variant_stockLimit',
			'type'     => 'text',
			'desc'     => __( '<p>Skip Variant if Stock level is below this limit</p>', 'hpy_wdv' ),
		);
		
		$settings_variant[] = array(
			'name'     => __( 'Keep manually set defaults:', 'hpy_wdv' ),
			'desc_tip' => __( 'If you have already set manual defaults for some products and want to keep those select this box. Otherwise Force Default Variant will overwrite that option.', 'hpy_wdv' ),
			'id'       => 'hpy_variant_respect',
			'std'     => 'no', // WooCommerce < 2.0
			'default' => 'no', // WooCommerce >= 2.0
			'type'     => 'checkbox',
			'desc'     => __( '<p>Respect the Product\'s Default if it is already set.</p>', 'hpy_wdv' ),
    );
    
    $settings_variant[] = array(
			'name'     => __( 'Disable auto-removal of \'Select Option\' text ', 'hpy_wdv' ),
			'desc_tip' => __( 'If you would like dropdowns to have the \'Select Option\' text by default when no product defaults are set, select this box. Force Default Variant options will still apply.', 'hpy_wdv' ),
			'id'       => 'hpy_disabled_auto_remove_dropdown',
			'std'     => 'no', // WooCommerce < 2.0
			'default' => 'no', // WooCommerce >= 2.0
			'type'     => 'checkbox',
			'desc'     => __( '<p>Re-enable \'Select Option\' text globally, manually set defaults will still apply.</p>', 'hpy_wdv' ),
		);
		
		$settings_variant[] = array( 'type' => 'sectionend', 'id' => 'hpy_variants' );
		return apply_filters( 'hpy_fdv_woocommerce_settings', $settings_variant );
	
	/**
	 * If not, return the standard settings
	 **/
	} else {
		return $settings;
	}
}

?>