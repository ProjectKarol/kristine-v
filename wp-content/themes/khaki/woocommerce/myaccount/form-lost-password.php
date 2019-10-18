<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
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
 * @version 3.5.2
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="nk-gap-4"></div>
<?php do_action( 'woocommerce_before_lost_password_form' ); ?>
<form method="post" class="woocommerce-ResetPassword lost_reset_password nk-form-style-1">

	<p><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'khaki' ) ); ?></p>

	<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
		<input class="woocommerce-Input woocommerce-Input--text input-text form-control" type="text" name="user_login" id="user_login" autocomplete="username" placeholder="<?php esc_attr_e( 'Username or email', 'khaki' ); ?>"/>
	</p>


	<?php do_action( 'woocommerce_lostpassword_form' ); ?>

    <input type="hidden" name="wc_reset_password" value="true" />
    <input type="submit" class="nk-btn nk-btn-color-dark-1" value="<?php esc_attr_e( 'Reset Password', 'khaki' ); ?>" />

    <?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

</form>
<?php do_action( 'woocommerce_after_lost_password_form' ); ?>
<div class="nk-gap-4"></div>