<?php

/**
 * Search Loop - Single Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<li id="post-<?php bbp_forum_id(); ?>" <?php bbp_forum_class(); ?>>

	<div class="nk-forum-topic-header">

		<div class="bbp-meta">

			<span class="bbp-forum-post-date"><?php printf( esc_html__( 'Last updated %s', 'khaki' ), bbp_get_forum_last_active_time() ); ?></span>

			<a href="<?php bbp_forum_permalink(); ?>" class="bbp-forum-permalink">#<?php bbp_forum_id(); ?></a>

		</div><!-- .bbp-meta -->

		<div class="nk-forum-title">

			<?php do_action( 'bbp_theme_before_forum_title' ); ?>

			<h3><?php esc_html_e( 'Forum: ', 'khaki' ); ?><a href="<?php bbp_forum_permalink(); ?>"><?php bbp_forum_title(); ?></a></h3>

			<?php do_action( 'bbp_theme_after_forum_title' ); ?>

		</div><!-- .bbp-forum-title -->

	</div><!-- .bbp-forum-header -->
	<div class="nk-forum-topic-author forum-find">
	<div class="nk-forum-icon">
		<span class="<?php echo khaki_sanitize_class(strripos(bbp_get_forum_class(), 'bbp-forum-status-closed') ? 'ion-ios-lock' :khaki_get_theme_mod('forum_icon_class', true)); ?>"></span>
	</div>
	</div>
	<div class="nk-forum-topic-content">

		<?php do_action( 'bbp_theme_before_forum_content' ); ?>

		<?php bbp_forum_content(); ?>

		<?php do_action( 'bbp_theme_after_forum_content' ); ?>

	</div><!-- .bbp-forum-content -->

</li><!-- #post-<?php bbp_forum_id(); ?> -->
<div class="nk-gap-2"></div>
