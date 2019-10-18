<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="nk-store nk-store-checkout">
<?php if ( $order ) : ?>

	<?php if ( $order->has_status( 'failed' ) ) : ?>

		<div class="nk-info-box bg-main-5"><div class="nk-info-box-icon"><span class="ion-ios-alert"></span></div><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'khaki' ); ?></div>
		<p class="woocommerce-thankyou-order-failed-actions">
			<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="nk-btn nk-btn-md nk-btn-rounded float-left"><?php esc_html_e( 'Pay', 'khaki' ) ?></a>
			<?php if ( is_user_logged_in() ) : ?>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="nk-btn nk-btn-md nk-btn-rounded float-right"><?php esc_html_e( 'My Account', 'khaki' ); ?></a>
			<?php endif; ?>
		</p>

	<?php else : ?>
		<div class="nk-info-box bg-main-2"><div class="nk-info-box-icon"><span class="ion-android-checkbox-outline"></span></div><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'khaki' ), $order ); ?></div>
		<div class="nk-gap-1"></div>
	<div class="nk-info-box bg-dark-4">
		<div class="nk-info-box-icon"><span class="ion-clipboard"></span></div>
		<ul class="woocommerce-thankyou-order-details order_details">
			<li class="order">
				<?php esc_html_e( 'Order Number:', 'khaki' ); ?>
				<strong><?php echo $order->get_order_number(); ?></strong>
			</li>
			<li class="date">
				<?php esc_html_e( 'Date:', 'khaki' ); ?>
				<strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
			</li>
            <?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
                <li class="woocommerce-order-overview__total total">
                    <?php esc_html_e( 'Email:', 'khaki' ); ?>
                    <strong><?php echo $order->get_billing_email(); ?></strong>
                </li>
            <?php endif; ?>
			<li class="total">
				<?php esc_html_e( 'Total:', 'khaki' ); ?>
				<strong><?php echo $order->get_formatted_order_total(); ?></strong>
			</li>
			<?php if ( $order->get_payment_method_title() ) : ?>
			<li class="method">
				<?php esc_html_e( 'Payment Method:', 'khaki' ); ?>
				<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
			</li>
			<?php endif; ?>
		</ul>
		</div>
		<div class="clear"></div>

	<?php endif; ?>
	<?php if($order->get_payment_method() && $order->get_id()):?>
	<div class="nk-gap-1"></div>
		<?php
		if ( $available_gateways = WC()->payment_gateways->get_available_payment_gateways() ) {
			foreach ( $available_gateways as $gateway ) {
				if ( $gateway->title == $order->get_payment_method_title()) {
					$payment_out = $gateway->payment_fields();
					if(isset($payment_out) && !empty($payment_out)){
						echo $payment_out;

					}
				}
			}
		}
		?>
	<?php endif; ?>
	<div class="nk-gap-2"></div>
	<div class="nk-box-3 bg-gray-2">
	<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
</div>
<?php else : ?>

	<div class="nk-info-box bg-main-2"><div class="nk-info-box-icon"><span class="ion-android-checkbox-outline"></span></div><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'khaki' ), null ); ?></div>

<?php endif; ?>
</div>
