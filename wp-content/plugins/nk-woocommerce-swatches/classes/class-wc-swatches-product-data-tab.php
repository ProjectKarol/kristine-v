<?php

class NKWCS_Product_Data_Tab {

    public $tab_class = '';
    public $tab_additional_class = '';
    public $tab_id = '';
    public $tab_title = '';
    public $tab_script_src = '';

    public function __construct( $script = false ) {
        $tab_class = array('nk-swatches', 'show_if_variable');
        $tab_id = 'nk-swatches';
        $tab_title = 'nK Swatches';

        if ( is_array( $tab_class ) ) {
            $this->tab_class = $tab_class[0];
            for ( $x = 1; $x < count( $tab_class ); $x++ ) {
                $this->tab_additional_class .= ' ' . $tab_class[$x];
            }
        } else {
            $this->tab_class = $tab_class;
        }
        $this->tab_id = $tab_id;
        $this->tab_title = $tab_title;

        $this->tab_script_src;

        add_action( 'woocommerce_product_write_panel_tabs', array(&$this, 'product_write_panel_tabs'), 99 );

        // WC 3.0
        if (version_compare(WC()->version, '3.0', ">=")) {
            add_action( 'woocommerce_product_data_panels', array(&$this, 'product_data_panel_wrap'), 99 );
        } else {
            add_action( 'woocommerce_product_write_panels', array(&$this, 'product_data_panel_wrap'), 99 );
        }
        add_action( 'woocommerce_process_product_meta', array(&$this, 'process_meta_box'), 1, 2 );
    }


    public function product_write_panel_tabs() {
        ?>
        <li class="<?php echo $this->tab_class; ?><?php echo $this->tab_additional_class; ?>"><a href="#<?php echo $this->tab_id; ?>"><span><?php echo $this->tab_title; ?></span></a></li>
        <?php
    }

    public function product_data_panel_wrap() {
        ?>
        <div id="<?php echo $this->tab_id; ?>" class="panel <?php echo $this->tab_class; ?> woocommerce_options_panel wc-metaboxes-wrapper">
            <?php $this->render_product_tab_content(); ?>
        </div>
        <?php
    }

    public function render_product_tab_content() {
        global $woocommerce, $post;
        global $_wp_additional_image_sizes;

        add_filter( 'woocommerce_variation_is_visible', array($this, 'return_true') );

        $post_id = $post->ID;

        if ( function_exists( 'wc_get_product' ) ) {
            $product = wc_get_product( $post->ID );
        } else {
            $product = new WC_Product( $post->ID );
        }

        $product_type_array = array('variable', 'variable-subscription');

        $type = version_compare(WC()->version, '3.0', ">=") ? $product->get_type() : $product->product_type;
        if ( !in_array( $type, $product_type_array ) ) {
            return;
        }

        $swatch_type_options = get_post_meta( $post_id, '_swatch_type_options', true );
        $swatch_type = get_post_meta( $post_id, '_swatch_type', true );
        $swatch_size = get_post_meta( $post_id, '_swatch_size', true );


        if ( !$swatch_type_options ) {
            $swatch_type_options = array();
        }

        if ( !$swatch_type ) {
            $swatch_type = 'standard';
        }

        if ( !$swatch_size ) {
            $swatch_size = 'swatches_image_size';
        }

        echo '<div class="options_group">';
        ?>

        <div class="fields_header">
            <table class="wcsap widefat">
                <thead>
                <th class="attribute_swatch_label">
                    <?php _e( 'Product Attribute Name', 'nkwcs' ); ?>
                </th>
                <th class="attribute_swatch_type">
                    <?php _e( 'Attribute Control Type', 'nkwcs' ); ?>
                </th>
                </thead>
            </table>
        </div>
        <div class="fields">

            <?php
            $woocommerce_taxonomies = wc_get_attribute_taxonomies();
            $woocommerce_taxonomy_infos = array();
            foreach ( $woocommerce_taxonomies as $tax ) {
                $woocommerce_taxonomy_infos[wc_attribute_taxonomy_name( $tax->attribute_name )] = $tax;
            }
            $tax = null;

            $attributes = $product->get_variation_attributes(); //Attributes configured on this product already.

            if ( $attributes && count( $attributes ) ) :
                $attribute_names = array_keys( $attributes );
                foreach ( $attribute_names as $name ) :
                    $key = md5( sanitize_title( $name ) );
                    $old_key = sanitize_title( $name );

                    $key_attr = md5( str_replace( '-', '_', sanitize_title( $name ) ) );

                    $current_is_taxonomy = taxonomy_exists( $name );
                    $current_type = 'default';
                    $current_type_description = 'None';
                    $current_size = 'swatches_image_size';
                    $current_size_height = '32';
                    $current_size_width = '32';

                    $current_label = 'Unknown';
                    $current_options = false;

                    if ( isset( $swatch_type_options[$key] ) ) {
                        $current_options = ($swatch_type_options[$key]);
                    } elseif ( isset( $swatch_type_options[$old_key] ) ) {
                        $current_options = ($swatch_type_options[$old_key]);
                    }


                    if ( $current_options ) {

                        $current_size = $current_options['size'];
                        $current_type = $current_options['type'];

                        if ( $current_type == 'radio' ) {
                            $current_type_description = __( 'Radio Buttons', 'nkwcs' );
                        } else if ( $current_type == 'radio_toggler' ) {
                            $current_type_description = __( 'Radio Toggler Buttons', 'nkwcs' );
                        } else if ( $current_type != 'default' ) {
                            $current_type_description = ($current_type == 'term_options' ? __( 'Taxonomy Colors and Images', 'nkwcs' ) : __( 'Custom Product Colors and Images', 'nkwcs' ));
                        }
                    }

                    $the_size = isset( $_wp_additional_image_sizes[$current_size] ) ? $_wp_additional_image_sizes[$current_size] : $_wp_additional_image_sizes['swatches_image_size'];
                    if ( isset( $the_size['width'] ) && isset( $the_size['height'] ) ) {
                        $current_size_width = $the_size['width'];
                        $current_size_height = $the_size['height'];
                    } else {
                        $current_size_width = 32;
                        $current_size_height = 32;
                    }

                    $attribute_terms = array();
                    if ( taxonomy_exists( $name ) ) :
                        $tax = get_taxonomy( $name );
                        $woocommerce_taxonomy = $woocommerce_taxonomy_infos[$name];
                        $current_label = isset( $woocommerce_taxonomy->attribute_label ) && !empty( $woocommerce_taxonomy->attribute_label ) ? $woocommerce_taxonomy->attribute_label : $woocommerce_taxonomy->attribute_name;

                        $terms = get_terms( $name, array('hide_empty' => false) );
                        $selected_terms = isset( $attributes[$name] ) ? $attributes[$name] : array();
                        foreach ( $terms as $term ) {
                            if ( in_array( $term->slug, $selected_terms ) ) {
                                $attribute_terms[] = array('id' => md5( $term->slug ), 'label' => $term->name, 'old_id' => $term->slug);
                            }
                        }
                    else :
                        $current_label = esc_html( $name );
                        foreach ( $attributes[$name] as $term ) {
                            $attribute_terms[] = array('id' => ( md5( sanitize_title( strtolower( $term ) ) ) ), 'label' => esc_html( $term ), 'old_id' => esc_attr( sanitize_title( $term ) ));
                        }
                    endif;
                    ?>
                    <div class="field">
                        <div class="wcsap_field_meta">
                            <table class="wcsap widefat">
                                <tbody>
                                    <tr>
                                        <td class="attribute_swatch_label">
                                            <strong><a class="wcsap_edit_field row-title" href="javascript:;"><?php echo $current_label; ?></a></strong>
                                        </td>
                                        <td class="attribute_swatch_type">
                                            <?php echo $current_type_description; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="field_form_mask">
                            <div class="field_form">
                                <table class="wcsap_input widefat wcsap_field_form_table">
                                    <tbody>
                                        <tr class="attribute_swatch_type">
                                            <td class="label">
                                                <label for="_swatch_type_options_<?php echo $key_attr; ?>_type">Type</label>
                                            </td>
                                            <td>
                                                <select class="_swatch_type_options_type" id="_swatch_type_options_<?php echo $key_attr; ?>_type" name="_swatch_type_options[<?php echo $key; ?>][type]">
                                                    <option <?php selected( $current_type, 'default' ); ?> value="default">None</option>
                                                    <?php if ( $current_is_taxonomy ) : ?>
                                                        <option <?php selected( $current_type, 'term_options' ); ?> value="term_options"><?php _e( 'Taxonomy Colors and Images', 'nkwcs' ); ?></option>
                                                    <?php endif; ?>
                                                    <option <?php selected( $current_type, 'product_custom' ); ?> value="product_custom"><?php _e( 'Custom Colors and Images', 'nkwcs' ); ?></option>
                                                    <option <?php selected( $current_type, 'radio' ); ?> value="radio"><?php _e( 'Radio Buttons', 'nkwcs' ); ?></option>
                                                    <option <?php selected( $current_type, 'radio_toggler' ); ?> value="radio_toggler"><?php _e( 'Radio Toggler Buttons', 'nkwcs' ); ?></option>

                                                </select>
                                            </td>
                                        </tr>

                                        <tr class="field_option field_option_product_custom" style="<?php echo $current_type != 'product_custom' ? 'display:none;' : ''; ?>">
                                            <td class="label">
                                                <label for="_swatch_type_options_<?php echo $key_attr; ?>_size">Size</label>
                                            </td>
                                            <td>
                                                <?php $image_sizes = get_intermediate_image_sizes(); ?>
                                                <select id="_swatch_type_options_pa_color_size" name="_swatch_type_options[<?php echo $key; ?>][size]">
                                                    <?php foreach ( $image_sizes as $size ) : ?>
                                                        <option <?php selected( $current_size, $size ); ?> value="<?php echo $size; ?>"><?php echo $size; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr class="field_option field_option_term_default" style="<?php echo $current_type != 'default' ? 'display:none;' : ''; ?>">
                                            <td class="label">

                                            </td>
                                            <td>
                                                <p>
                                                    <?php _e( 'WooCommerce default select boxes will be used for this product attribute', 'nkwcs' ); ?>
                                                </p>
                                            </td>
                                        </tr>

                                        <tr class="field_option field_option_term_options" style="<?php echo $current_type != 'term_options' ? 'display:none;' : ''; ?>">
                                            <td class="label">

                                            </td>
                                            <td>
                                                <p>
                                                    <?php printf( __( 'The color swatch and image configuration will be used from the %s taxonomy.  Navigate to Products -> Attributes to edit the shared swatches and images for this product attribute.', 'nkwcs' ), $current_label ); ?>
                                                </p>
                                            </td>
                                        </tr>

                                        <tr class="field_option field_option_product_custom" style="<?php echo $current_type != 'product_custom' ? 'display:none;' : ''; ?>">

                                            <td class="label">
                                                <label>Attribute Configuration</label>
                                            </td>
                                            <td>
                                                <div class="product_custom">

                                                    <div class="fields_header">
                                                        <table class="wcsap widefat">
                                                            <thead>
                                                            <th class="attribute_swatch_preview">
                                                                <?php _e( 'Preview', 'nkwcs' ); ?>
                                                            </th>
                                                            <th class="attribute_swatch_label">
                                                                <?php _e( 'Attribute', 'nkwcs' ); ?>
                                                            </th>
                                                            <th class="attribute_swatch_type">
                                                                <?php _e( 'Type', 'nkwcs' ); ?>
                                                            </th>
                                                            </thead>
                                                        </table>
                                                    </div>

                                                    <div class="fields">
                                                        <?php foreach ( $attribute_terms as $attribute_term ) : ?>
                                                            <?php
                                                            $attribute_term['id'] = ( $attribute_term['id'] );

                                                            $current_attribute_type = 'color';
                                                            $current_attribute_color = '#FFFFFF';
                                                            $current_attribute_image_src = wc_placeholder_img_src();
                                                            $current_attribute_image_id = 0;
                                                            $current_attribute_options = false;
                                                            if ( isset( $current_options['attributes'][$attribute_term['id']] ) ) {
                                                                $current_attribute_options = isset( $current_options['attributes'][$attribute_term['id']] ) ? $current_options['attributes'][$attribute_term['id']] : false;
                                                            } elseif ( isset( $current_options['attributes'][$attribute_term['old_id']] ) ) {
                                                                $current_attribute_options = isset( $current_options['attributes'][$attribute_term['old_id']] ) ? $current_options['attributes'][$attribute_term['old_id']] : false;
                                                            }

                                                            if ( $current_attribute_options ) :
                                                                $current_attribute_type = $current_attribute_options['type'];
                                                                $current_attribute_color = $current_attribute_options['color'];
                                                                $current_attribute_image_id = $current_attribute_options['image'];
                                                                if ( $current_attribute_image_id ) :
                                                                    $current_attribute_image_src = wp_get_attachment_image_src( $current_attribute_image_id, $current_size );
                                                                    $current_attribute_image_src = $current_attribute_image_src[0];
                                                                endif;
                                                            elseif ( $current_is_taxonomy ) :

                                                            endif;
                                                            ?>

                                                            <div class="sub_field field">

                                                                <div class="wcsap_field_meta">

                                                                    <table class="wcsap widefat">

                                                                        <tbody>
                                                                        <td class="attribute_swatch_preview">
                                                                            <div class="nkwcs-color-image-item">
                                                                                <a id="_swatch_type_options_<?php echo $key_attr; ?>_<?php echo $attribute_term['id']; ?>_color_preview_image" href="javascript:;"
                                                                                   class="image"
                                                                                   style="<?php echo $current_attribute_type == 'image' ? '' : 'display:none;'; ?>">
                                                                                    <img src="<?php echo $current_attribute_image_src; ?>" class="wp-post-image" />
                                                                                </a>
                                                                                <a id="_swatch_type_options_<?php echo $key_attr; ?>_<?php echo $attribute_term['id']; ?>_color_preview_swatch" href="javascript:;"
                                                                                   class="swatch"
                                                                                   style="background-color:<?php echo $current_attribute_color; ?>;<?php echo $current_attribute_type == 'color' ? '' : 'display:none;'; ?>"><?php echo $attribute_term['label']; ?>
                                                                                </a>
                                                                            </div>
                                                                        </td>
                                                                        <td class="attribute_swatch_label">
                                                                            <strong><a class="wcsap_edit_field row-title" href="javascript:;"><?php echo $attribute_term['label']; ?></a></strong>
                                                                        </td>
                                                                        <td class="attribute_swatch_type">
                                                                            <?php echo ($current_attribute_type  == 'image' ? __('Image', 'nkwcs') : __( 'Color Swatch', 'nkwcs' )); ?>
                                                                        </td>
                                                                        <tbody>

                                                                    </table>

                                                                </div>

                                                                <div class="field_form_mask">
                                                                    <div class="field_form">
                                                                        <table class="wcsap_input widefat">
                                                                            <tbody>
                                                                                <tr class="attribute_swatch_type">
                                                                                    <td class="label">
                                                                                        <label for="_swatch_type_options_<?php echo $key_attr; ?>_<?php echo esc_attr( $attribute_term['id'] ); ?>">
                                                                                            <?php _e( 'Attribute Color or Image', 'nkwcs' ); ?>
                                                                                        </label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <select class="_swatch_type_options_attribute_type" id="_swatch_type_options_<?php echo $key_attr; ?>_<?php echo esc_attr( $attribute_term['id'] ); ?>_type" name="_swatch_type_options[<?php echo $key; ?>][attributes][<?php echo esc_attr( $attribute_term['id'] ); ?>][type]">
                                                                                            <option <?php selected( $current_attribute_type, 'color' ); ?> value="color">Color</option>
                                                                                            <option <?php selected( $current_attribute_type, 'image' ); ?> value="image">Image</option>
                                                                                        </select>
                                                                                    </td>
                                                                                </tr>

                                                                                <tr class="field_option field_option_color" style="<?php echo $current_attribute_type == 'color' ? '' : 'display:none;'; ?>">
                                                                                    <td class="label">
                                                                                        <label><?php _e( 'Color', 'nkwcs' ); ?></label>
                                                                                    </td>
                                                                                    <td class="section-color-swatch">
                                                                                        <div id="_swatch_type_options_<?php echo $key_attr; ?>_<?php echo $attribute_term['id']; ?>_color_picker" class="colorSelector"><div></div></div>
                                                                                        <input class="woo-color" id="_swatch_type_options_<?php echo $key_attr; ?>_<?php echo $attribute_term['id']; ?>_color" type="text" class="text" name="_swatch_type_options[<?php echo $key; ?>][attributes][<?php echo esc_attr( $attribute_term['id'] ); ?>][color]" value="<?php echo $current_attribute_color; ?>" />
                                                                                    </td>
                                                                                </tr>

                                                                                <tr class="field_option field_option_image" style="<?php echo $current_attribute_type == 'image' ? '' : 'display:none;' ?>">
                                                                                    <td class="label">
                                                                                        <label><?php _e( 'Image', 'nkwcs' ); ?></label>
                                                                                    </td>
                                                                                    <td>

                                                                                        <div style="line-height:60px;">
                                                                                            <div id="_swatch_type_options_<?php echo $key_attr; ?>_<?php echo $attribute_term['id']; ?>_image_thumbnail" style="float:left;margin-right:10px;">
                                                                                                <img src="<?php echo $current_attribute_image_src; ?>" alt="<?php _e( 'Thumbnail Preview', 'nkwcs' ); ?>" class="wp-post-image swatch-imagepa_colour_swatches_id">
                                                                                            </div>
                                                                                            <input class="upload_image_id" type="hidden" id="_swatch_type_options_<?php echo $key_attr; ?>_<?php echo $attribute_term['id']; ?>_image" name="_swatch_type_options[<?php echo $key; ?>][attributes][<?php echo esc_attr( $attribute_term['id'] ); ?>][image]" value="<?php echo $current_attribute_image_id; ?>" />
                                                                                            <button type="submit" class="upload_swatch_image_button button" rel="<?php echo $post_id; ?>"><?php _e( 'Upload/Add image', 'nkwcs' ); ?></button>
                                                                                            <button type="submit" class="remove_swatch_image_button button" rel="<?php echo $post_id; ?>"><?php _e( 'Remove image', 'nkwcs' ); ?></button>
                                                                                        </div>

                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>

                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php
                endforeach;
            else :
                echo '<p>' . __( 'Add a at least one attribute / variation combination to this product that has been configured with color swatches or images. After you add the attributes from the "Attributes" tab and create a variation, save the product and you will see the option to configure the swatch or image picker here.', 'nkwcs' ) . '</p>';
            endif;
            ?>


        </div>

        <?php
        echo '</div>';

        remove_filter( 'woocommerce_variation_is_visible', array($this, 'return_true') );
    }

    public function render_attribute_images( $product_id, $name, $is_taxonomy ) {
        ?>
        <div class="product_swatches_configuration">
            <table>
                <?php if ( $is_taxonomy ) : ?>
                    <?php $terms = get_terms( $name, array('hide_empty' => false) ); ?>
                    <?php foreach ( $terms as $term ) : ?>
                        <?php $this->edit_attributre_thumbnail_field( $product_id, $term, $name ); ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
        </div>
        <?php
    }

    public function process_meta_box( $post_id, $post ) {
        $swatch_type_options = isset( $_POST['_swatch_type_options'] ) ? $_POST['_swatch_type_options'] : false;
        $swatch_type = 'default';

        if ( $swatch_type_options && is_array( $swatch_type_options ) ) {
            foreach ( $swatch_type_options as $options ) {
                if ( isset( $options['type'] ) && $options['type'] != 'default' && $options['type'] != 'radio' && $options['type'] != 'radio_toggler' ) {
                    $swatch_type = 'pickers';
                    break;
                }
            }

            update_post_meta( $post_id, '_swatch_type_options', $swatch_type_options );
        }

        update_post_meta( $post_id, '_swatch_type', $swatch_type );
    }

    public function return_true() {
        return true;
    }

}
