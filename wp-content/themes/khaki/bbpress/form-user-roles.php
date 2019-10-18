<?php

/**
 * User Roles Profile Edit Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div>
	<label for="role"><?php esc_html_e( 'Blog Role', 'khaki' ) ?></label>

	<?php bbp_edit_user_blog_role(); ?>

</div>

<div>
	<label for="forum-role"><?php esc_html_e( 'Forum Role', 'khaki' ) ?></label>

	<?php bbp_edit_user_forums_role(); ?>

</div>
