<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
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
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( is_user_logged_in() ) {
    return;
}

?>
<form class="woocomerce-form woocommerce-form-login login nk-form-style-1" method="post" <?php echo ( $hidden ) ? 'style="display:none;"' : ''; ?>>

    <?php do_action( 'woocommerce_login_form_start' ); ?>

    <?php echo ( $message ) ? wpautop( wptexturize( $message ) ) : ''; ?>
    <div class="nk-box-2 bg-gray-2">
        <p class="form-row form-row-first">
            <input type="text" class="input-text form-control" name="username" id="username" placeholder="<?php esc_html_e( 'Username or email *', 'khaki' ); ?>"/>
        </p>
        <p class="form-row form-row-last">
            <input class="input-text form-control" type="password" name="password" id="password" placeholder="<?php esc_html_e( 'Password *', 'khaki' ); ?>"/>
        </p>
        <div class="clear"></div>

        <?php do_action( 'woocommerce_login_form' ); ?>
        <div class="nk-gap"></div>
        <p class="form-row">
            <?php wp_nonce_field( 'woocommerce-login' ); ?>
            <span class="nk-btn nk-btn-color-dark-1 khaki-relative">
					<?php esc_html_e( 'Login', 'khaki' ); ?>
                <input type="submit" class="khaki-wc-submit" name="login" value="<?php esc_attr_e( 'Login', 'khaki' ); ?>" />
			</span>
            <input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ); ?>" />
            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline" id="khaki_woocommerce_rememberme_label">
                <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php _e( 'Remember me', 'khaki' ); ?></span>
            </label>
        </p>
        <p class="lost_password">
            <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'khaki' ); ?></a>
        </p>
    </div>
    <div class="clear"></div>

    <?php do_action( 'woocommerce_login_form_end' ); ?>

</form>
