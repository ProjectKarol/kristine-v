<?php

/**
 * Search Loop - Single Topic
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<li id="post-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); ?>>
	<div class="nk-forum-topic-header">
		<div class="bbp-meta">

			<span class="bbp-topic-post-date"><?php bbp_topic_post_date( bbp_get_topic_id() ); ?></span>

			<a href="<?php bbp_topic_permalink(); ?>" class="bbp-topic-permalink">#<?php bbp_topic_id(); ?></a>

		</div><!-- .bbp-meta -->

		<div class="nk-forum-title">

			<?php do_action( 'bbp_theme_before_topic_title' ); ?>

			<h3><?php esc_html_e( 'Topic: ', 'khaki' ); ?>
				<a href="<?php bbp_topic_permalink(); ?>"><?php bbp_topic_title(); ?></a>


				<?php if ( function_exists( 'bbp_is_forum_group_forum' ) && bbp_is_forum_group_forum( bbp_get_topic_forum_id() ) ) : ?>

					<?php esc_html_e( 'in group forum ', 'khaki' ); ?>

				<?php else : ?>

					<?php esc_html_e( 'in forum ', 'khaki' ); ?>

				<?php endif; ?>

				<a href="<?php bbp_forum_permalink( bbp_get_topic_forum_id() ); ?>"><?php bbp_forum_title( bbp_get_topic_forum_id() ); ?></a>

			<!-- .bbp-topic-title-meta -->
			</h3>
			<?php do_action( 'bbp_theme_after_topic_title' ); ?>

		</div><!-- .bbp-topic-title -->
	</div>
	<div class="nk-forum-topic-author">

		<?php do_action( 'bbp_theme_before_topic_author_details' ); ?>

		<?php echo khaki_bbp_get_reply_author_avatar();?>

		<div class="nk-forum-topic-author-name">
			<?php bbp_reply_author_link(array('sep' => '', 'show_role' => false, 'type' => 'name')); ?>
		</div>

		<div class="nk-forum-topic-author-role">
			<?php echo bbp_get_reply_author_role();?>
		</div>
		
		<?php if ( bbp_is_user_keymaster() ) : ?>

			<?php do_action( 'bbp_theme_before_topic_author_admin_details' ); ?>

			<div class="bbp-reply-ip nk-forum-topic-author-since"><?php bbp_author_ip( bbp_get_topic_id() ); ?></div>

			<?php do_action( 'bbp_theme_after_topic_author_admin_details' ); ?>

		<?php endif; ?>

		<?php do_action( 'bbp_theme_after_topic_author_details' ); ?>

	</div><!-- .bbp-topic-author -->
	<div class="nk-forum-topic-content">

		<?php do_action( 'bbp_theme_before_topic_content' ); ?>

		<?php bbp_topic_content(); ?>

		<?php do_action( 'bbp_theme_after_topic_content' ); ?>

	</div><!-- .bbp-topic-content -->
	<div class="clearfix"></div>
	<div class="nk-gap-2"></div>
</li><!-- #post-<?php bbp_topic_id(); ?> -->
<div class="nk-gap-2"></div>
