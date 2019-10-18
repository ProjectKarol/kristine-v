<?php

/**
 * Password Protected
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div id="bbpress-forums">
	
	<fieldset class="bbp-form" id="bbp-protected">
		<Legend><?php esc_html__( 'Protected', 'khaki' ); ?></legend>

		<?php echo khaki_get_the_password_form(); ?>

	</fieldset>
</div>