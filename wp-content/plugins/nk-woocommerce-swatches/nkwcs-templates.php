<?php

// print template file (first check for theme /nkwcs-templates/...php)
function nkwcs_include_template ($template_name, $args = array()) {
    if ( !empty( $args ) && is_array( $args ) ) {
        extract( $args );
    }

    // template in theme folder
    $template = locate_template(array('woocommerce/single-product/nkwcs-templates/' . $template_name, $template_name));

    // default template
    if (!$template) {
        $template = plugin_dir_path( __FILE__ ) . 'templates/' . $template_name;
    }

    // Allow 3rd party plugin filter template file from their plugin.
    $template = apply_filters( 'nkwcs_include_template', $template, $template_name, $args );

    include $template;
}

// create array of variation for templates
function nkwcs_get_variations_array($options, $product, $attribute, $name = false, $id = false, $selected = false, $config = false) {
    $result = array();
    if ( !empty( $options ) ) {
        $name = $name ? $name : 'attribute_' . sanitize_title( $attribute );
        $id = $id ? $id : sanitize_title( $attribute );

        if ( $product && taxonomy_exists( $attribute ) ) {
            // Get terms if this is a taxonomy - ordered. We need the names too.
            $terms = wc_get_product_terms( (version_compare(WC()->version, '3.0', ">=") ? $product->get_id() : $product->id), $attribute, array('fields' => 'all') );

            foreach ( $terms as $term ) {
                if ( in_array( $term->slug, $options ) ) {
                    $result[] = array(
                        'name' => $name,
                        'id' => $id,
                        'term_id' => $term->term_id,
                        'slug' => $term->slug,
                        'title' => $term->name,
                        'selected' => $selected == $term->slug,
                        'config' => $config,
                        'attribute' => $attribute
                    );
                }
            }
        } else {
            foreach ( $options as $option ) {
                $result[] = array(
                    'name' => $name,
                    'id' => $id,
                    'term_id' => $option,
                    'slug' => $option,
                    'title' => $option,
                    // This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
                    'selected' => sanitize_title( $selected ) === $selected ? $selected === sanitize_title( $option ) : $selected === $option,
                    'config' => $config,
                    'attribute' => $attribute
                );
            }
        }

        // prepare swatches params
        if (is_object($config) && ($config->get_type() == 'product_custom' || $config->get_type() == 'term_options')) {
            foreach ( $result as $k => $opt ) {
                $swatch_term = new NKWCS_Swatch_Term( $config, $opt['term_id'], $attribute, $opt['selected'] );

                $result[$k]['swatch_meta_key'] = $swatch_term->meta_key();
                $result[$k]['swatch_type'] = $swatch_term->get_type();
                if ($result[$k]['swatch_type'] == 'image') {
                    $result[$k]['swatch_image_src'] = $swatch_term->get_image_src();
                    $result[$k]['swatch_image_id'] = $swatch_term->get_image_id();
                    $result[$k]['swatch_image_width'] = $swatch_term->get_width();
                    $result[$k]['swatch_image_height'] = $swatch_term->get_height();
                } else {
                    $result[$k]['swatch_color'] = $swatch_term->get_color();
                }
            }
        }
    }

    return $result;
}

// Override for default WooCommerce function to make custom variations possible
// This script should be loaded before WooCommerce core
function wc_dropdown_variation_attribute_options( $args = array() ) {
    $args = wp_parse_args( apply_filters( 'woocommerce_dropdown_variation_attribute_options_args', $args ), array(
        'options' => false,
        'attribute' => false,
        'product' => false,
        'selected' => false,
        'name' => '',
        'id' => '',
        'class' => '',
        'show_option_none' => __( 'Choose an option', 'nkwcs' )
    ) );

    $product = $args['product'];
    $attribute = $args['attribute'];
    $id = $args['id'] ? $args['id'] : sanitize_title( $attribute );

    $config = new NKWCS_Attribute_Configuration_Object( $product, $attribute );
    $args['config'] = $config;
    $type = $config->get_type();

    if ( $type != 'default' ) :
        do_action( 'nkwcs_before_picker', $config );
        echo '<div id="picker_' . esc_attr( $id ) . '" class="select nkwcs-swatch-container">';
        $args['hide'] = true;
        nkwcs_wc_default_dropdown_variation_template( $args );

        if ($type == 'radio') {
            nkwcs_radio_variation_template( $args );
        } else if ($type == 'radio_toggler') {
            nkwcs_radio_toggler_variation_template( $args );
        } else {
            nkwcs_color_image_variation_template( $args );
        }
        echo '</div>';

    else :
        $args['hide'] = false;
        $args['class'] = $args['class'] .= (!empty( $args['class'] ) ? ' ' : '') . 'wc-default-select';
        nkwcs_wc_default_dropdown_variation_template( $args );
    endif;
}


/**
 * Get default variation args
 */
function nkwcs_get_default_variation_args () {

}

/**
 * Exact Duplicate of wc_dropdown_variation_attribute_options
 */
function nkwcs_wc_default_dropdown_variation_template( $args = array() ) {
    $args = wp_parse_args( apply_filters( 'woocommerce_dropdown_variation_attribute_options_args', $args ), array(
        'options'          => false,
        'attribute'        => false,
        'product'          => false,
        'selected' 	       => false,
        'name'             => '',
        'id'               => '',
        'class'            => '',
        'show_option_none' => __( 'Choose an option', 'nkwcs' )
    ) );

    $args['name'] = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $args['attribute'] );
    $args['id'] = $args['id'] ? $args['id'] : sanitize_title( $args['attribute'] );

    if ( empty( $args['options'] ) && !empty( $args['product'] ) && !empty( $args['attribute'] ) ) {
        $attributes = $args['product']->get_variation_attributes();
        $args['options'] = $attributes[$args['attribute']];
    }

    // We'll do our best to hide the placeholder, but we'll need to show something when resetting options.
    $args['show_option_none_text'] = $args['show_option_none'] ? $args['show_option_none'] : __( 'Choose an option', 'nkwcs' );

    ob_start();
    nkwcs_include_template('variation-dropdown.php', $args);
    $output = ob_get_contents();
    ob_end_clean();

    echo apply_filters( 'woocommerce_dropdown_variation_attribute_options_html', $output, $args );
}

function nkwcs_radio_variation_template( $args = array() ) {
    $args = wp_parse_args( apply_filters( 'woocommerce_radio_variation_attribute_options_args', $args ), array(
        'options' => false,
        'attribute' => false,
        'product' => false,
        'selected' => false,
        'name' => '',
        'id' => '',
        'class' => '',
    ) );

    $args['name'] = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $args['attribute'] );
    $args['id'] = $args['id'] ? $args['id'] : sanitize_title( $args['attribute'] );

    if ( empty( $args['options'] ) && !empty( $args['product'] ) && !empty( $args['attribute'] ) ) {
        $attributes = $args['product']->get_variation_attributes();
        $args['options'] = $attributes[$args['attribute']];
    }

    nkwcs_include_template('variation-radio.php', $args);
}

function nkwcs_radio_toggler_variation_template( $args = array() ) {
    $args = wp_parse_args( apply_filters( 'woocommerce_radio_toggler_variation_attribute_options_args', $args ), array(
        'options' => false,
        'attribute' => false,
        'product' => false,
        'selected' => false,
        'name' => '',
        'id' => '',
        'class' => '',
    ) );

    $args['name'] = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $args['attribute'] );
    $args['id'] = $args['id'] ? $args['id'] : sanitize_title( $args['attribute'] );

    if ( empty( $args['options'] ) && !empty( $args['product'] ) && !empty( $args['attribute'] ) ) {
        $attributes = $args['product']->get_variation_attributes();
        $args['options'] = $attributes[$args['attribute']];
    }

    nkwcs_include_template('variation-radio-toggler.php', $args);
}

function nkwcs_color_image_variation_template( $args = array() ) {
    $args = wp_parse_args( apply_filters( 'woocommerce_color_image_variation_attribute_options_args', $args ), array(
        'options' => false,
        'attribute' => false,
        'product' => false,
        'selected' => false,
        'name' => '',
        'id' => '',
        'class' => '',
    ) );

    $args['name'] = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $args['attribute'] );
    $args['id'] = $args['id'] ? $args['id'] : sanitize_title( $args['attribute'] );

    if ( empty( $args['options'] ) && !empty( $args['product'] ) && !empty( $args['attribute'] ) ) {
        $attributes = $args['product']->get_variation_attributes();
        $args['options'] = $attributes[$args['attribute']];
    }

    nkwcs_include_template('variation-color-image.php', $args);
}