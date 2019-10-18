<?php

/**
 * User Registration Form
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<form method="post" action="<?php bbp_wp_login_action( array( 'context' => 'login_post' ) ); ?>" class="bbp-login-form nk-form nk-form-style-1">
	<fieldset class="bbp-form">
		<legend><?php echo esc_html__( 'Create an Account', 'khaki' ); ?></legend>

		<div class="bbp-template-notice">
			<?php echo '<div class="nk-info-box bg-main-1"><div class="nk-info-box-icon"><span class="ion-ios-information-circle"></span></div>' . esc_html__('Your username must be unique, and cannot be changed later.', 'khaki') . '</div>';?>
			<?php echo '<div class="nk-info-box bg-main-1"><div class="nk-info-box-icon"><span class="ion-ios-information-circle"></span></div>' . esc_html__('We use your email address to email you a secure password and verify your account.', 'khaki') . '</div>';?>
		</div>
		<div class="nk-gap"></div>
			<input type="text" name="user_login" value="<?php bbp_sanitize_val( 'user_login' ); ?>" size="20" id="user_login" tabindex="<?php bbp_tab_index(); ?>"
			placeholder="<?php echo esc_html( 'Username', 'khaki' ); ?>" class="form-control"/>
		<div class="nk-gap"></div>
			<input type="text" name="user_email" value="<?php bbp_sanitize_val( 'user_email' ); ?>" size="20" id="user_email" tabindex="<?php bbp_tab_index(); ?>"
				   placeholder="<?php echo esc_html__( 'Email', 'khaki' ); ?>" class="form-control"/>
		<?php do_action( 'register_form' ); ?>
		<div class="nk-gap"></div>
			<button type="submit" tabindex="<?php bbp_tab_index(); ?>" name="user-submit" class="nk-btn nk-btn-lg nk-btn-color-dark-1"><?php echo esc_html__( 'Register', 'khaki' ); ?></button>

			<?php bbp_user_register_fields(); ?>

	</fieldset>
</form>
