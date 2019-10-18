<?php

/**
 * No Access Feedback Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div id="forum-private" class="bbp-forum-content">
	<h1 class="entry-title"><?php esc_html_e( 'Private', 'khaki' ); ?></h1>
	<div class="entry-content">
		<?php echo '<div class="nk-info-box bg-danger"><div class="nk-info-box-icon"><span class="ion-ios-alert"></span></div>' . esc_html__('You do not have permission to view this forum.', 'khaki'). '</div>' ;?>
	</div>
</div><!-- #forum-private -->
