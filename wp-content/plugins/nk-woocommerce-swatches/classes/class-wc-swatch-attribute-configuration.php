<?php

class NKWCS_Attribute_Configuration_Object {

    private $_attribute_name;
    private $_swatch_options;
    private $_product;

    /**
     *
     * @param NKWCS_Product $product
     * @param string $attribute The name of the attribute.
     */
    public function __construct( $product, $attribute ) {

        $swatch_options = maybe_unserialize( get_post_meta( version_compare(WC()->version, '3.0', ">=") ? $product->get_id() : $product->id, '_swatch_type_options', true ) );

        if ( !empty( $swatch_options ) ) {

            $st_name = sanitize_title( $attribute );
            $hashed_name = md5( $st_name );
            $lookup_name = '';

            //Normalize the key we use, this is for backwards compatibility.
            if ( isset( $swatch_options[$hashed_name] ) ) {
                $lookup_name = $hashed_name;
            } elseif ( isset( $swatch_options[$st_name] ) ) {
                $lookup_name = $st_name;
            }


            $size = 'swatches_image_size';
            //If the post has a default size configured for it.
            //This was done for CSV import suite, there is no UI for selecting this on the post directly.
            $product_configured_size = get_post_meta( version_compare(WC()->version, '3.0', ">=") ? $product->get_id() : $product->id, '_swatch_size', true );
            if ( $product_configured_size ) {
                $size = 'swatches_image_size';
            }

            $this->_attribute_name = $attribute;
            $this->_product = $product;
            $this->_swatch_options = isset($swatch_options[$lookup_name]) ? $swatch_options[$lookup_name] : false;
        }
    }

    public function get_attribute_name() {
        return $this->_attribute_name;
    }

    /**
     * Returns the type of input to display.
     */
    public function get_type() {
        return $this->sg( 'type', 'default' );
    }

    public function get_size() {
        $size = apply_filters( 'nkwcs_size_for_product', $this->sg( 'size' ), version_compare(WC()->version, '3.0', ">=") ? $this->_product->get_id() : $this->_product->id, $this->_attribute_name );
        return $size;
    }

    public function get_options() {
        return $this->_swatch_options;
    }

    /**
     * Safely get a configuration value from the swatch options.
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    private function sg( $key, $default = null ) {
        return isset( $this->_swatch_options[$key] ) ? $this->_swatch_options[$key] : $default;
    }

}
