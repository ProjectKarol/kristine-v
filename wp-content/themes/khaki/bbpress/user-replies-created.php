<?php

/**
 * User Replies Created
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
	<?php do_action( 'bbp_template_before_user_replies' ); ?>

	<div id="bbp-user-replies-created" class="bbp-user-replies-created">
		<div class="bbp-user-section">
			<h2 class="nk-title"><?php echo esc_html__('Forum Replies Created', 'khaki');?></h2>
			<div class="nk-gap-1"></div>
			<?php if ( bbp_get_user_replies_created() ) : ?>

				<?php bbp_get_template_part( 'pagination', 'replies' ); ?>

				<?php bbp_get_template_part( 'loop',       'replies' ); ?>

				<?php bbp_get_template_part( 'pagination', 'replies' ); ?>

			<?php else : ?>

				<p><?php bbp_is_user_home() ? esc_html_e( 'You have not replied to any topics.', 'khaki' ) : esc_html_e( 'This user has not replied to any topics.', 'khaki' ); ?></p>

			<?php endif; ?>

		</div>
	</div><!-- #bbp-user-replies-created -->

	<?php do_action( 'bbp_template_after_user_replies' ); ?>
