<?php /* Variant DropDown menu changes */
if ( hpy_fdv_wc_version_check( '3.0' ) ) {
	add_filter( 'woocommerce_product_get_default_attributes', 'hpy_fdv_default_attribute', 10, 1 );
	add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'hpy_fdv_remove_dropdown_option_html', 12, 2 );
} else {
	add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'hpy_fdv_attribute_args', 10, 1 );
}



/**
 * Re-order the variations depending on the chosen option. If nothing is set default to ID.
 *
 * @param array $args
 *
 * @return array
 */
function hpy_fdv_attribute_args( $args = array() ) {
	$sortby = get_option( 'hpy_variant_sort' );

	if ( empty( $sortby ) ) {
		$sortby = 'id';
	}

	$product   = $args['product'];
	$attribute = strtolower( $args['attribute'] );

	$product_class = new WC_Product_Variable( $product );
	$children = $product_class->get_visible_children();
	$i = 0;
	if ( !empty( $children ) ) {
		foreach ( $children as $child ) {
			$required      = 'attribute_' . $attribute;
			$meta          = get_post_meta( $child );
			$to_use        = $meta[ $required ][ 0 ];
			$product_child = new WC_Product_Variation( $child );
			$prices[ $i ]  = array( $product_child->get_price(), $to_use );
			$i ++;
		}

		if ( $sortby == 'price-low' || $sortby == 'price-high' ) {
			if ( isset( $prices ) ) {
				if ( $sortby == 'price-low' ) {
					sort( $prices );
				} else {
					rsort( $prices );
				}
			}
		}
		$args[ 'selected' ] = $prices[ 0 ][ 1 ];

		$args[ 'show_option_none' ] = '';
	}

	return $args;

}

/**
 * Remove the Choose an Option HTML.
 *
 * @param $html
 * @param $args
 *
 * @return mixed
 */
function hpy_fdv_remove_dropdown_option_html( $html, $args ) {
  //Return normal html markup if disabled_auto_remove_dropdown is enabled.
	if ( empty( $args['selected'] ) && get_option('hpy_disabled_auto_remove_dropdown') == 'yes' ) {
    return $html;
  }

	$show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __( 'Choose an option', 'woocommerce' );
  $show_option_none_html = '<option value="">' . esc_html( $show_option_none_text ) . '</option>';
	
  $html = str_replace($show_option_none_html, '', $html);
  $html = preg_replace('/(<option\b[^><]*)>/i', '$1 class="attached enabled">', $html, 1); // Adds missing JS classes  -- Fixes the field appearing blank.
  
  // If no option selected by default, set first option to selected
  if ( empty( $args['selected'] )  ) {
    $html = preg_replace('/(<option\b[^><]*)>/i', '$1 selected>', $html, 1);
  }

	return $html;
}

function hpy_fdv_default_attribute( $defaults ) {
	global $product;
	
	if ( !$product ) {
		return $defaults;
	}
	
	if ( $product->post_type !== 'product' ) {
		return $defaults;
	}
	
	$respect = get_option( 'hpy_variant_respect' );
	$sortby = apply_filters( 'hpy_fdv_custom_sortby', get_option( 'hpy_variant_sort' ) );
	
	if ( $respect == 'yes' && !empty( $defaults ) ) {
		return $defaults;
	}
	
	if ( empty( $sortby ) ) {
		$sortby = 'id';
	}
	
	if ( !$product->is_type( 'variable' ) ) {
		return $defaults;
	}
	
	$children = $product->get_children();
	$attributes = array();
	
	foreach( $children as $key => $child ) {
		$_child = wc_get_product( $child );
		$position = array_search( $key, array_keys( $children ) );

		if ( $_child->get_status() == 'publish' ) {
			$attributes[] = array( 'price' => !empty($_child->get_price()) ? $_child->get_price() : '0' , 'id' => $_child->get_id(), 'position' => $position );
		}
	}
	
	switch( $sortby ) {
		
		case 'price-low':
			$attributes = hpy_fdv_multidimensional_sort( $attributes, 'price-low' );
			break;
			
		case 'price-high':
			$attributes = hpy_fdv_multidimensional_sort( $attributes, 'price-high' );
			break;
			
		case 'position':
			$attributes = hpy_fdv_multidimensional_sort( $attributes, 'position' );
			break;
			
		case 'id' :
			$attributes = hpy_fdv_multidimensional_sort( $attributes, 'id' );
			break;
			
		default:
			$attributes = apply_filters( 'hpy_fdv_trigger_sort', $attributes );
			break;
		
	}
	
	if ( empty( $attributes ) ) {
		return $defaults;
	}
	
	$count = count( $attributes );
	for( $i = 0; $i < $count; $i++ ) {
		$_prod = wc_get_product( $attributes[$i]['id'] );
		
		$stock_limit = get_option( 'hpy_variant_stockLimit' );
		
		if ( !empty( $stock_limit ) ) {
			$stock_qty = $_prod->get_stock_quantity();
			if ( $stock_qty < $stock_limit && !is_null( $stock_qty ) ) {
				$stock = 'outofstock';
			} else {
				$stock = $_prod->get_stock_status();
			}
		} else {
			$stock = $_prod->get_stock_status();
		}
		
		if ( $stock == 'outofstock' ) {
			unset( $attributes[$i] );
		}
	}
	
	$attributes = array_values($attributes);
	
	$_prod = ! empty( $attributes[0]['id'] ) ? wc_get_product( $attributes[0]['id'] ) : null;
	
	if ( empty( $_prod ) ) {
		return $defaults;
	}
	
	$attr = $_prod->get_attributes();
	
	$defaults = array();
	
	foreach( $attr as $key => $value ) {
		$defaults[$key] = $value;
	}
	
	return apply_filters( 'hpy_fdv_attributes_return', $defaults );
}

function hpy_fdv_multidimensional_sort( $array, $check ) {

	if ( $check == 'price-low' ) {
		usort( $array, 'hpy_fdv_sortByPrice' );
	} else if ( $check == 'price-high' ) {
		usort( $array, 'hpy_fdv_sortByPriceHigh' );
	} else if ( $check == 'position' ) {
		usort( $array, 'hpy_fdv_sortByPosition' );
	} else {
		usort( $array, 'hpy_fdv_sortByID' );
	}
	
	return apply_filters( 'hpy_fdv_sort_filter', $array );
	
}

function hpy_fdv_sortByPrice($a, $b) {
	return $a['price'] - $b['price'];
}

function hpy_fdv_sortByPriceHigh($a, $b) {
	return $b['price'] - $a['price'];
}

function hpy_fdv_sortByPosition($a, $b) {
	return $a['position'] - $b['position'];
}

function hpy_fdv_sortByID($a, $b) {
	return $a['id'] - $b['id'];
}

//add_filter( 'woocommerce_hide_invisible_variations', 'hpy_fdv_hide_invisible_variants' );
function hpy_fdv_hide_invisible_variants() {
	return apply_filters( 'hpy_fdv_hide_unavailable_variants', true );
}