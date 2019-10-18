<?php
/**
 * Radio buttons variation
 */
echo '<ul id="radio_select_' . esc_attr( $id ) . '" class="nkwcs-radio ' . esc_attr( $class ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '">';

$options_array = nkwcs_get_variations_array($options, $product, $attribute, $name, $id, $selected);

foreach ($options_array as $opt) {
    echo '<li>';
    echo '<input class="nkwcs-radio-input" name="' . esc_attr( $opt['name'] ) . '" id="radio_' . esc_attr( $opt['id'] ) . '_' . esc_attr( $opt['slug'] ) . '" type="radio" data-value="' . esc_attr( $opt['slug'] ) . '" value="' . esc_attr( $opt['slug'] ) . '" ' . checked( $opt['selected'], true, false ) . ' /><label for="radio_' . esc_attr( $opt['id'] ) . '_' . esc_attr( $opt['slug'] ) . '">' . esc_html( apply_filters( 'woocommerce_variation_option_name', $opt['title'] ) ) . '</label>';
    echo '</li>';
}

echo '</ul>';