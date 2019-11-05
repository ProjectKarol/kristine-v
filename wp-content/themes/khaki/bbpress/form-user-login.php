<?php

/**
 * User Login Form
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<form method="post" action="<?php bbp_wp_login_action( array( 'context' => 'login_post' ) ); ?>" class="bbp-login-form nk-form nk-form-style-1">
	<fieldset class="bbp-form">
		<legend><?php echo esc_html__( 'Log In', 'khaki' ); ?></legend>
		<div class="nk-gap"></div>
			<input type="text" name="log" value="<?php bbp_sanitize_val( 'user_login', 'text' ); ?>" size="20" id="user_login" tabindex="<?php bbp_tab_index(); ?>"
			placeholder="<?php echo esc_html__( 'Username', 'khaki' ); ?>" class="form-control"
			/>
		<div class="nk-gap"></div>
			<input type="password" name="pwd" value="<?php bbp_sanitize_val( 'user_pass', 'password' ); ?>" size="20" id="user_pass" tabindex="<?php bbp_tab_index(); ?>"
			placeholder="<?php echo esc_html__( 'Password', 'khaki' ); ?>" class="form-control"
			/>
		<div class="nk-gap"></div>
			<input type="checkbox" name="rememberme" value="forever" <?php checked( bbp_get_sanitize_val( 'rememberme', 'checkbox' ) ); ?> id="rememberme" tabindex="<?php bbp_tab_index(); ?>" />
			<label for="rememberme"><?php echo esc_html__( 'Keep me signed in', 'khaki' ); ?></label>

		<div class="nk-gap"></div>
		<?php do_action( 'login_form' ); ?>

			<button type="submit" tabindex="<?php bbp_tab_index(); ?>" name="user-submit" class="nk-btn nk-btn-color-dark-1 nk-btn-lg"><?php echo esc_html__( 'Log In', 'khaki' ); ?></button>

			<?php bbp_user_login_fields(); ?>

	</fieldset>
</form>
