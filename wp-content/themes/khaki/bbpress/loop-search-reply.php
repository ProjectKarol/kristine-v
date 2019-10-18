<?php

/**
 * Search Loop - Single Reply
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<li id="post-<?php bbp_reply_id(); ?>" <?php bbp_reply_class(); ?>>

	<div class="nk-forum-topic-header">

		<div class="bbp-meta">

			<span class="bbp-reply-post-date"><?php bbp_reply_post_date(); ?></span>

			<a href="<?php bbp_reply_url(); ?>" class="bbp-reply-permalink">#<?php bbp_reply_id(); ?></a>

		</div><!-- .bbp-meta -->

		<div class="nk-forum-title">

			<h3><?php esc_html_e( 'In reply to: ', 'khaki' ); ?>
				<a class="bbp-topic-permalink" href="<?php bbp_topic_permalink( bbp_get_reply_topic_id() ); ?>"><?php bbp_topic_title( bbp_get_reply_topic_id() ); ?></a></h3>

		</div><!-- .bbp-reply-title -->

	</div><!-- .bbp-reply-header -->

	<div class="nk-forum-topic-author">

		<?php do_action( 'bbp_theme_before_reply_author_details' ); ?>
		
		<?php echo khaki_bbp_get_reply_author_avatar();?>

		<div class="nk-forum-topic-author-name">
			<?php bbp_reply_author_link(array('sep' => '', 'show_role' => false, 'type' => 'name')); ?>
		</div>

		<div class="nk-forum-topic-author-role">
			<?php echo bbp_get_reply_author_role();?>
		</div>

		<?php if ( bbp_is_user_keymaster() ) : ?>

			<?php do_action( 'bbp_theme_before_reply_author_admin_details' ); ?>

			<div class="bbp-reply-ip nk-forum-topic-author-since"><?php bbp_author_ip( bbp_get_reply_id() ); ?></div>
			
			<?php do_action( 'bbp_theme_after_reply_author_admin_details' ); ?>

		<?php endif; ?>

		<?php do_action( 'bbp_theme_after_reply_author_details' ); ?>

	</div><!-- .bbp-reply-author -->

	<div class="nk-forum-topic-content">

		<?php do_action( 'bbp_theme_before_reply_content' ); ?>

		<?php bbp_reply_content(); ?>

		<?php do_action( 'bbp_theme_after_reply_content' ); ?>

	</div><!-- .bbp-reply-content -->
	<div class="nk-forum-topic-footer"></div>
	<div class="nk-gap-2"></div>
</li><!-- #post-<?php bbp_reply_id(); ?> -->
<div class="nk-gap-2"></div>