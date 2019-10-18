<?php

/**
 * Replies Loop - Single Reply
 *
 * @package bbPress
 * @subpackage Theme
 */
?>
<?php
$tag = 'li';
if ( bbp_thread_replies() ){
    $tag = 'div';
}
?>
<<?php echo $tag;?> id="post-<?php bbp_reply_id(); ?>" class="bbp-reply-header">


    <div <?php bbp_reply_class(); ?>>

        <div class="nk-forum-topic-author">

            <?php do_action('bbp_theme_before_reply_author_details'); ?>

            <?php echo khaki_bbp_get_reply_author_avatar();?>

            <div class="nk-forum-topic-author-name">
                <?php bbp_reply_author_link(array('sep' => '', 'show_role' => false, 'type' => 'name')); ?>
            </div>

            <div class="nk-forum-topic-author-role">
                <?php echo bbp_get_reply_author_role();?>
            </div>

            <?php if (bbp_is_user_keymaster()) : ?>

                <?php do_action('bbp_theme_before_reply_author_admin_details'); ?>

                <div class="bbp-reply-ip nk-forum-topic-author-since"><?php bbp_author_ip(bbp_get_reply_id()); ?></div>

                <?php do_action('bbp_theme_after_reply_author_admin_details'); ?>

            <?php endif; ?>

            <?php do_action('bbp_theme_after_reply_author_details'); ?>

        </div><!-- .bbp-reply-author -->

        <div class="nk-forum-topic-content">

            <?php do_action('bbp_theme_before_reply_content'); ?>

            <?php bbp_reply_content(); ?>

            <?php do_action('bbp_theme_after_reply_content'); ?>

        </div><!-- .bbp-reply-content -->

    </div><!-- .reply -->


    <div class="nk-forum-topic-footer">

        <span class="nk-forum-topic-date"><?php bbp_reply_post_date(); ?></span>

        <a href="<?php bbp_reply_url(); ?>" class="bbp-reply-permalink">#<?php bbp_reply_id(); ?></a>
        


        <?php if (bbp_is_single_user_replies()) : ?>

            <span class="bbp-header">
				<?php esc_html_e('in reply to: ', 'khaki'); ?>
                <a class="bbp-topic-permalink"
                   href="<?php bbp_topic_permalink(bbp_get_reply_topic_id()); ?>"><?php bbp_topic_title(bbp_get_reply_topic_id()); ?></a>
			</span>

        <?php endif; ?>


        <?php do_action('bbp_theme_before_reply_admin_links'); ?>

        <?php bbp_reply_admin_links(); ?>

        <?php do_action('bbp_theme_after_reply_admin_links'); ?>

    </div><!-- .bbp-meta -->

</<?php echo $tag;?>><!-- #post-<?php bbp_reply_id(); ?> -->

