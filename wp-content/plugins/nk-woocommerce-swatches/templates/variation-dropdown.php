<?php
/**
 * Default dropdown variation control
 * Will be added also in all swatches, but hidden
 */
$html = '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '" name="' . esc_attr( $name ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '"' . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
$html .= '<option value="">' . esc_html( $show_option_none_text ) . '</option>';

$options_array = nkwcs_get_variations_array($options, $product, $attribute, $name, $id, $selected);

foreach ($options_array as $opt) {
    $html .= '<option value="' . esc_attr( $opt['slug'] ) . '" ' . selected( $opt['selected'], true, false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $opt['title'] ) ) . '</option>';
}

$html .= '</select>';

echo $html;