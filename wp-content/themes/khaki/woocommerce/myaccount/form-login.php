<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
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

do_action( 'woocommerce_before_customer_login_form' );
?>
<div class="nk-store nk-store-checkout">
<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<div class="row vertical-gap lg-gap" id="customer_login">

	<div class="col-md-6">

<?php endif; ?>
		<div class="nk-box-3">
			<h3 class="nk-title h4 text-center"><?php esc_html_e( 'Login', 'khaki' ); ?></h3>
			<div class="nk-gap"></div>
		<form method="post" class="nk-form-style-1">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="username" id="username" autocomplete="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" placeholder="<?php esc_attr_e( 'Username or email address *', 'khaki' ); ?>"/>
			</p>
			
			<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
				<input class="woocommerce-Input woocommerce-Input--text input-text form-control" type="password" name="password" id="password" autocomplete="current-password" placeholder="<?php esc_attr_e( 'Password *', 'khaki' ); ?>"/>
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>
			
			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<span class="nk-btn nk-btn-color-dark-1 khaki-relative">
					<?php esc_html_e( 'Login', 'khaki' ); ?>
					<input type="submit" class="khaki-wc-submit woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Log In', 'khaki' ); ?>" />
				</span>
				<label for="rememberme" class="custom-control custom-checkbox woocommerce-form-login__rememberme">
					<input class="custom-control-input" name="rememberme" type="checkbox" id="rememberme" value="forever" />
					<span class="custom-control-indicator"></span>
					<?php esc_html_e( 'Remember me', 'khaki' ); ?>
				</label>
			</p>
			<p class="woocommerce-LostPassword lost_password">
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'khaki' ); ?></a>
			</p>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>
</div>
<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

	</div>

	<div class="col-md-6">
		<div class="nk-box-3">
			<h3 class="nk-title h4 text-center"><?php esc_html_e( 'Register', 'khaki' ); ?></h3>
			<div class="nk-gap"></div>
		<form method="post" class="nk-form-style-1" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="username" id="reg_username" autocomplete="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" placeholder="<?php esc_attr_e( 'Username *', 'khaki' ); ?>"/>
				</p>
				
			<?php endif; ?>

			<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
				<input type="email" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="email" id="reg_email" autocomplete="email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" placeholder="<?php esc_attr_e( 'Email address *', 'khaki' ); ?>"/>
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
				
				<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="password" id="reg_password" autocomplete="new-password" placeholder="<?php esc_attr_e( 'Password *', 'khaki' ); ?>"/>
				</p>
            <?php else : ?>

                <p><?php esc_html_e( 'A password will be sent to your email address.', 'khaki' ); ?></p>

			<?php endif; ?>

			<?php do_action( 'woocommerce_register_form' ); ?>
			<?php do_action( 'register_form' ); ?>
			
			<p class="woocomerce-FormRow form-row">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
				<span class="nk-btn nk-btn-color-dark-1 khaki-relative">
				<?php esc_html_e( 'Register', 'khaki' ); ?>
				<input type="submit" class="khaki-wc-submit" name="register" value="<?php esc_attr_e( 'Register', 'khaki' ); ?>" />
				</span>
			</p>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>
		</div>
	</div>

</div>
<?php endif; ?>
</div>
<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
