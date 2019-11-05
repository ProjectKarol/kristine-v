<?php
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="woocommerce-shipping-fields">
	<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>
		<label class="custom-control custom-checkbox" id="ship-to-different-address">
			<input id="ship-to-different-address-checkbox" class="input-checkbox custom-control-input" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" />
			<span class="custom-control-indicator"></span>
			<?php esc_html_e( 'Ship to a different address?', 'khaki' ); ?>
		</label>

		<div class="shipping_address">
			<div class="nk-gap mt-5"></div>
			<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>
            <div class="woocommerce-shipping-fields__field-wrapper">
				<?php
                $fields = $checkout->get_checkout_fields( 'shipping' );

                foreach ( $fields as $key => $field ) {

                    //shipping style argument fields. start
                    $key_gap_list = array('shipping_last_name', 'shipping_company', 'shipping_country', 'shipping_email', 'shipping_address_1', 'shipping_address_2', 'shipping_city', 'shipping_state');

                    if (!isset($field['placeholder']) && isset($field['label'])) {
                        $field['placeholder'] = $field['label'];
                    }
                    if (isset($field['required']) && $field['required']) {
                        $field['placeholder'] .= ' *';
                    }
                    if (isset($field['class'])) {
                        $findClass = array_search('form-control', $field['class']);
                        if ($findClass) {
                            unset($field['class'][$findClass]);
                        }
                    }
                    if ($key !== 'shipping_country') {
                        $field['input_class'] = array('form-control');
                    }
                    unset($field['label']);

                    woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );

                    if ($key == 'shipping_last_name') {
                        echo '<div class="clear"></div>';
                    }
                }
				?>
            </div>
			<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

	<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>

		<?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>

			<h3 class="nk-title h4 text-center"><?php esc_html_e( 'Additional Information', 'khaki' ); ?></h3>

		<?php endif; ?>
        <div class="woocommerce-additional-fields__field-wrapper">
            <?php foreach ( $checkout->checkout_fields['order'] as $key => $field ) : ?>
                <?php
                //order style argument fields. start
                if($key=='order_comments'){
                    $field['custom_attributes']['rows'] = '6';
                }
                if(!isset($field['placeholder']) && isset($field['label'])){
                    $field['placeholder'] = $field['label'];
                    if(isset($field['required']) && $field['required']){
                        $field['placeholder'].=' *';
                    }
                }
                if(isset($field['class'])){
                    $findClass = array_search('form-control',$field['class']);
                    if($findClass){
                        unset($field['class'][$findClass]);
                    }
                }
                $field['input_class']=array('form-control');
                unset($field['label']);
                //order style argument fields. end
                ?>
                <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

            <?php endforeach; ?>
        </div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
</div>