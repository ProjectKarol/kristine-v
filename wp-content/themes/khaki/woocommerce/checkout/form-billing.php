<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

/** @global WC_Checkout $checkout */

?>
<div class="woocommerce-billing-fields">
	<?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

		<h3 class="nk-title h4"><?php esc_html_e( 'Billing &amp; Shipping', 'khaki' ); ?></h3>

	<?php else : ?>

		<h3 class="nk-title h4"><?php esc_html_e( 'Billing Details', 'khaki' ); ?></h3>

	<?php endif; ?>
	<div class="nk-gap"></div>
	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>
    <div class="woocommerce-billing-fields__field-wrapper">
		<?php
        $fields = $checkout->get_checkout_fields( 'billing' );

        foreach ( $fields as $key => $field ) {

            //billing style argument fields. start
            $key_gap_list = array('billing_last_name', 'billing_company', 'billing_country', 'billing_address_1', 'billing_address_2', 'billing_city', 'billing_state', 'billing_phone');

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
            if ($key !== 'billing_country') {
                $field['input_class'] = array('form-control');
            }
            unset($field['label']);

            woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );

            if ($key == 'billing_last_name') {
                echo '<div class="clear"></div>';
            }
        }
		?>
    </div>
	<?php do_action('woocommerce_after_checkout_billing_form', $checkout ); ?>

	<?php if ( ! is_user_logged_in() && $checkout->enable_signup ) : ?>

		<?php if ( $checkout->enable_guest_checkout ) : ?>

			<label class="create-account custom-control custom-checkbox">
				<input class="input-checkbox custom-control-input" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true); ?> type="checkbox" name="createaccount" value="1" />
				<span class="custom-control-indicator"></span><span><?php esc_html_e( 'Create an account?', 'khaki' ); ?></span>
			</label>

		<?php endif; ?>

		<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

		<?php if ( ! empty( $checkout->checkout_fields['account'] ) ) : ?>

			<div class="create-account">

				<p><?php esc_html_e( 'Create an account by entering the information below. If you are a returning customer please login at the top of the page.', 'khaki' ); ?></p>

				<?php foreach ( $checkout->checkout_fields['account'] as $key => $field ) : ?>
					<?php
					if(!isset($field['placeholder']) && isset($field['label'])){
						$field['placeholder'] = $field['label'];
						if(isset($field['required']) && $field['required']){
							$field['placeholder'].=' *';
						}
					}
					$field['input_class']=array('form-control');
					unset($field['label']);
					?>
					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

				<?php endforeach; ?>

				<div class="clear"></div>

			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>

	<?php endif; ?>
</div>