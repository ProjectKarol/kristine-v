<?php
/**
 * Lost password reset form.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-reset-password.php.
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
 * @version 3.5.5
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_reset_password_form' );
?>
<div class="nk-gap-4"></div>
<form method="post" class="woocommerce-ResetPassword lost_reset_password nk-form-style-1">

	<p><?php echo esc_html( apply_filters( 'woocommerce_reset_password_message', esc_html__( 'Enter a new password below.', 'khaki') ) ); ?></p>

	<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
		<input type="password" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="password_1" id="password_1" autocomplete="new-password" placeholder="<?php esc_attr_e( 'New password *', 'khaki' ); ?>"/>
	</p>
	<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
		<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password_2" id="password_2" autocomplete="new-password" placeholder="<?php esc_attr_e( 'Re-enter new password *', 'khaki' ); ?>"/>
	</p>

	<input type="hidden" name="reset_key" value="<?php echo esc_attr( $args['key'] ); ?>" />
	<input type="hidden" name="reset_login" value="<?php echo esc_attr( $args['login'] ); ?>" />

	<div class="clear"></div>

	<?php do_action( 'woocommerce_resetpassword_form' ); ?>
	<div class="nk-gap-1"></div>
	<p class="woocommerce-form-row form-row">
		<input type="hidden" name="wc_reset_password" value="true" />
		<span class="nk-btn nk-btn-color-dark-1 khaki-relative">
			<?php esc_html_e( 'Save', 'khaki' ); ?>
			<input type="submit" class="khaki-wc-submit" value="<?php esc_attr_e( 'Save', 'khaki' ); ?>" />
		</span>
	</p>

    <?php wp_nonce_field( 'reset_password', 'woocommerce-reset-password-nonce' ); ?>

</form>
<div class="nk-gap-4"></div>
<?php
do_action( 'woocommerce_after_reset_password_form' );
