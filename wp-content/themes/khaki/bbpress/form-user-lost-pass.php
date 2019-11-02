<?php

/**
 * User Lost Password Form
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<form method="post" action="<?php bbp_wp_login_action( array( 'action' => 'lostpassword', 'context' => 'login_post' ) ); ?>" class="bbp-login-form nk-form nk-form-style-1">
	<fieldset class="bbp-form">
		<legend><?php echo esc_html__( 'Lost Password', 'khaki' ); ?></legend>

				<input type="text" name="user_login" value="" size="20" id="user_login" tabindex="<?php bbp_tab_index(); ?>" class="form-control" placeholder="<?php echo esc_html__( 'Username or Email', 'khaki' ); ?>"/>
<div class="nk-gap"></div>
		<?php do_action( 'login_form', 'resetpass' ); ?>
			<button type="submit" tabindex="<?php bbp_tab_index(); ?>" name="user-submit" class="nk-btn nk-btn-color-dark-1 nk-btn-lg"><?php echo esc_html__( 'Reset My Password', 'khaki' ); ?></button>
			<?php bbp_user_lost_pass_fields(); ?>
	</fieldset>
</form>
