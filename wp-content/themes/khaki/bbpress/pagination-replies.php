<?php

/**
 * Pagination for pages of replies (when viewing a topic)
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action('bbp_template_before_pagination_loop'); ?>

	<!-- START: Pagination -->

	<div class="bbp-pagination">
		<div class="bbp-pagination-count">

			<?php bbp_topic_pagination_count(); ?>

		</div>
	</div>

	<div class="row">
		<?php if (bbp_current_user_can_access_create_reply_form() && !bbp_is_single_user_replies()) : ?>
			<div class="col-md-3 order-md-2 text-right">
				<a href="#new-post" class="nk-btn nk-btn-color-black nk-btn-color-hover-dark-4"><?php echo esc_html__('Reply', 'khaki');?></a>
			</div>
		<?php endif;?>
		<div class="col-md-9">
			<?php khaki_bb_output_pagination(bbp_get_topic_pagination_links()); ?>
		</div>
	</div>
	<div class="nk-gap-2"></div>
	<!-- END: Pagination -->
<?php do_action('bbp_template_after_pagination_loop'); ?>
