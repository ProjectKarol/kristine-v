<?php

class NKWCS_Swatch_Term {

    public $attribute_meta_key;
    public $term_id;
    public $term;
    public $term_label;
    public $term_slug;
    public $taxonomy_slug;
    public $selected;
    public $type;
    public $color;
    public $thumbnail_src;
    public $thumbnail_id;
    public $size;
    public $width = 32;
    public $height = 32;

    public function __construct( $config, $term_id, $taxonomy, $selected = false, $size = 'swatches_image_size' ) {

        if (is_object($config) && $config->get_type() == 'product_custom') {
            global $_wp_additional_image_sizes;

            $this->attribute_options = $attribute_options = $config->get_options();

            $this->taxonomy_slug = $taxonomy;
            if (taxonomy_exists($taxonomy)) {
                $this->term = get_term($term_id, $taxonomy);
                $this->term_label = $this->term->name;
                $this->term_slug = $this->term->slug;
                $this->term_name = $this->term->name;
            } else {
                $this->term = false;
                $this->term_label = $term_id;
                $this->term_slug = $term_id;
            }

            $this->selected = $selected;

            $this->size = $attribute_options['size'];
            $the_size = isset($_wp_additional_image_sizes[$this->size]) ? $_wp_additional_image_sizes[$this->size] : $_wp_additional_image_sizes['shop_thumbnail'];
            if (isset($the_size['width']) && isset($the_size['height'])) {
                $this->width = $the_size['width'];
                $this->height = $the_size['height'];
            } else {
                $this->width = 32;
                $this->height = 32;
            }

            $key = md5( sanitize_title($this->term_slug) );
            $old_key = sanitize_title($this->term_slug);

            $lookup_key = '';
            if (isset($attribute_options['attributes'][$key])) {
                $lookup_key = $key;
            } elseif (isset($attribute_options['attributes'][$old_key])) {
                $lookup_key = $old_key;
            }

            $this->type = $attribute_options['attributes'][$lookup_key]['type'];

            if (isset($attribute_options['attributes'][$lookup_key]['image']) && $attribute_options['attributes'][$lookup_key]['image']) {
                $this->thumbnail_id = $attribute_options['attributes'][$lookup_key]['image'];
                $this->thumbnail_src = current(wp_get_attachment_image_src($this->thumbnail_id, $this->size));
            } else {
                $this->thumbnail_src = apply_filters( 'woocommerce_placeholder_img_src', WC()->plugin_url() . '/assets/images/placeholder.png' );
            }

            $this->color = isset($attribute_options['attributes'][$lookup_key]['color']) ? $attribute_options['attributes'][$lookup_key]['color'] : '#FFFFFF;';
        } else {
            $this->attribute_meta_key = 'swatches_id';
            $this->term_id = $term_id;
            $this->term = get_term( $term_id, $taxonomy );
            $this->term_label = $this->term->name;
            $this->term_slug = $this->term->slug;

            $this->taxonomy_slug = $taxonomy;
            $this->selected = $selected;
            $this->size = $size;

            $this->on_init();
        }
    }

    public function on_init() {
        $this->init_size( $this->size );

        $type = get_woocommerce_term_meta( $this->term_id, $this->meta_key() . '_type', true );
        $color = get_woocommerce_term_meta( $this->term_id, $this->meta_key() . '_color', true );
        $this->thumbnail_id = get_woocommerce_term_meta( $this->term_id, $this->meta_key() . '_image', true );

        $this->type = $type;
        $this->thumbnail_src = apply_filters( 'woocommerce_placeholder_img_src', WC()->plugin_url() . '/assets/images/placeholder.png' );
        $this->color = '#FFFFFF';

        if ( $type == 'image' ) {
            if ( $this->thumbnail_id ) {
                $imgsrc = wp_get_attachment_image_src( $this->thumbnail_id, $this->size );
                if ( $imgsrc && is_array( $imgsrc ) ) {
                    $this->thumbnail_src = current( $imgsrc );
                } else {
                    $this->thumbnail_src = apply_filters( 'woocommerce_placeholder_img_src', WC()->plugin_url() . '/assets/images/placeholder.png' );
                }
            } else {
                $this->thumbnail_src = apply_filters( 'woocommerce_placeholder_img_src', WC()->plugin_url() . '/assets/images/placeholder.png' );
            }
        } elseif ( $type == 'color' ) {
            $this->color = $color;
        }
    }

    public function init_size( $size ) {
        global $_wp_additional_image_sizes;
        $this->size = $size;
        $the_size = isset( $_wp_additional_image_sizes[$size] ) ? $_wp_additional_image_sizes[$size] : $_wp_additional_image_sizes['shop_thumbnail'];
        if ( isset( $the_size['width'] ) && isset( $the_size['height'] ) ) {
            $this->width = $the_size['width'];
            $this->height = $the_size['height'];
        } else {
            $this->width = 32;
            $this->height = 32;
        }
    }

    public function get_output() {

        $picker = '';

        if ( $this->type == 'image' ) {
            $picker .= '<a href="#" title="' . esc_attr( $this->term_label ) . '" class="image">';
            $picker .= '<img src="' . esc_url($this->thumbnail_src) . '" alt="thumbnail" class="wp-post-image swatch-image' . $this->meta_key() . ' swatch-img" width="' . $this->width . '" height="' . $this->height . '"/>';
            $picker .= '</a>';
        } elseif ( $this->type == 'color' ) {
            $picker .= '<a href="#" style="background-color:' . esc_attr($this->color) . ';color:' . esc_attr($this->color) . ';" title="' . $this->term_label . '" class="color">' . $this->term_label . '</a>';
        }

        $out = '<div class="nkwcs-color-image-item' . ($this->selected ? ' selected' : '') . '" data-attribute="' . esc_attr($this->taxonomy_slug) . '" data-value="' . esc_attr( $this->term_slug ) . '">';
        $out .= apply_filters( 'nkwcs_picker_html', $picker, $this );
        $out .= '</div>';

        return $out;
    }

    public function get_type() {
        return $this->type;
    }

    public function get_color() {
        return $this->color;
    }

    public function get_image_src() {
        return $this->thumbnail_src;
    }

    public function get_image_id() {
        return $this->thumbnail_id;
    }

    public function get_width() {
        return $this->width;
    }

    public function get_height() {
        return $this->height;
    }

    public function meta_key() {
        return $this->taxonomy_slug . '_' . $this->attribute_meta_key;
    }

}
