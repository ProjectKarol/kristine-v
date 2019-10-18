<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
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
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;


do_action( 'woocommerce_before_edit_account_form' ); ?>

<form class="woocommerce-EditAccountForm edit-account nk-form-style-1" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>
	<legend><?php esc_html_e( 'Details', 'khaki' ); ?></legend>
	
	<p class="woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first">
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" placeholder="<?php esc_attr_e( 'First name *', 'khaki' ); ?>" />
	</p>
	<p class="woocommerce-FormRow woocommerce-FormRow--last form-row form-row-last">
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" placeholder="<?php esc_attr_e( 'Last name *', 'khaki' ); ?>"/>
	</p>
	<div class="clear"></div>
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" placeholder="<?php esc_attr_e( 'Display name *', 'khaki' ); ?>" />
    </p>
    <div class="clear"></div>
	<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
		<input type="email" class="woocommerce-Input woocommerce-Input--email input-text form-control" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" placeholder="<?php esc_attr_e( 'Email address *', 'khaki' ); ?>"/>
	</p>
	
	<fieldset>
		<legend><?php esc_html_e( 'Password Change', 'khaki' ); ?></legend>
		
		<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control" name="password_current" id="password_current" autocomplete="off" placeholder="<?php esc_attr_e( 'Current Password (leave blank to leave unchanged)', 'khaki' ); ?>"/>
		</p>
		
		<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control" name="password_1" id="password_1" autocomplete="off" placeholder="<?php esc_attr_e( 'New Password (leave blank to leave unchanged)', 'khaki' ); ?>"/>
		</p>
		
		<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text form-control" name="password_2" id="password_2" autocomplete="off" placeholder="<?php esc_attr_e( 'Confirm New Password', 'khaki' ); ?>"/>
		</p>
	</fieldset>
	<div class="clear"></div>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>
	
	<p>
        <?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
		<span class="nk-btn nk-btn-color-dark-1 khaki-relative">
			<?php esc_html_e( 'Save changes', 'khaki' ); ?>
			<input type="submit" class="khaki-wc-submit" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'khaki' ); ?>" />
		</span>
		<input type="hidden" name="action" value="save_account_details" />
	</p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
