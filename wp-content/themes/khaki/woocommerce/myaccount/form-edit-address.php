<?php
/**
 * Edit address form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-address.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$page_title = ( $load_address === 'billing' ) ? esc_html__( 'Billing Address', 'khaki' ) : esc_html__( 'Shipping Address', 'khaki' );

do_action( 'woocommerce_before_edit_account_address_form' ); ?>

<?php if ( ! $load_address ) : ?>
	<?php wc_get_template( 'myaccount/my-address.php' ); ?>
<?php else : ?>

	<form method="post" class="nk-form-style-1">

		<h3><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title ); ?></h3>
		<div class="nk-gap-1"></div>
		<?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>
        <div class="woocommerce-address-fields__field-wrapper">
			<?php
            foreach ( $address as $key => $field ) {
                $key_gap_list = array('billing_company', 'billing_country', 'billing_address_1', 'billing_address_2', 'billing_city', 'billing_state', 'shipping_country', 'shipping_address_1', 'shipping_address_2', 'shipping_city', 'shipping_state', 'billing_phone', 'shipping_phone');
                if (!isset($field['placeholder']) && isset($field['label'])) {
                    $field['placeholder'] = $field['label'];
                    if (isset($field['required']) && $field['required']) {
                        $field['placeholder'] .= ' *';
                    }
                }
                if ($key !== 'billing_country' && $key !== 'shipping_country') {
                    $field['input_class'] = array('form-control');
                }
                unset($field['label']);

                woocommerce_form_field( $key, $field, wc_get_post_data_by_key( $key, $field['value'] ) );
                if ($key == 'billing_last_name' || $key == 'shipping_last_name') {
                    echo '<div class="clear"></div>';
                }
            }
			?>
        </div>
		<?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>
		<div class="clear"></div>
		<div class="nk-gap-1"></div>
		<p>
			<span class="nk-btn nk-btn-color-dark-1 khaki-relative">
				<?php esc_html_e( 'Save Address', 'khaki' ); ?>
			<input type="submit" class="khaki-wc-submit" name="save_address" value="<?php esc_attr_e( 'Save Address', 'khaki' ); ?>" />
			</span>
            <?php wp_nonce_field( 'woocommerce-edit_address', 'woocommerce-edit-address-nonce' ); ?>
			<input type="hidden" name="action" value="edit_address" />
		</p>

	</form>

<?php endif; ?>

<?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>
