<?php
/**
 * Color and Image variations
 */
echo '<div id="picker_' . esc_attr( $id ) . '" class="nkwcs-color-image">';

$options_array = nkwcs_get_variations_array($options, $product, $attribute, $name, $id, $selected, $config);
foreach ($options_array as $opt) {
    $style = '';

    if ($opt['swatch_type'] == 'image' ) {
        $style = 'background-image: url(' . esc_url($opt['swatch_image_src']) . ');';
    } elseif ( $opt['swatch_type'] == 'color' ) {
        $style = 'background-color:' . esc_attr($opt['swatch_color']) . ';color:' . esc_attr($opt['swatch_color']) . ';';
    }

    echo '<div class="nkwcs-color-image-item' . ($opt['selected'] ? ' selected' : '') . '" data-attribute="' . esc_attr($opt['attribute']) . '" data-value="' . esc_attr($opt['slug']) . '" title="' . esc_attr($opt['title']) . '" style="' . $style . '"></div>';
}

echo '</div>';