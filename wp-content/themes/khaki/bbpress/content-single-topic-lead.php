<?php

/**
 * Single Topic Lead Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action('bbp_template_before_lead_topic'); ?>

<?php bbp_topic_favorite_link(); ?>
<?php bbp_topic_subscription_link(); ?>
<div class="nk-gap"></div>
<ul id="bbp-topic-<?php bbp_topic_id(); ?>-lead" class="bbp-lead-topic nk-forum nk-forum-topic">
    <li id="post-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); ?>>

        <div class="nk-forum-topic-author">

            <?php do_action('bbp_theme_before_topic_author_details'); ?>

            <?php echo khaki_bbp_get_reply_author_avatar();?>

            <div class="nk-forum-topic-author-name">
                <?php bbp_reply_author_link(array('sep' => '', 'show_role' => false, 'type' => 'name')); ?>
            </div>

            <div class="nk-forum-topic-author-role">
                <?php echo bbp_get_reply_author_role();?>
            </div>

            <?php if (bbp_is_user_keymaster()) : ?>

                <?php do_action('bbp_theme_before_topic_author_admin_details'); ?>

                <div class="bbp-topic-ip nk-forum-topic-author-since"><?php bbp_author_ip(bbp_get_topic_id()); ?></div>

                <?php do_action('bbp_theme_after_topic_author_admin_details'); ?>

            <?php endif; ?>

            <?php do_action('bbp_theme_after_topic_author_details'); ?>

        </div><!-- .bbp-topic-author -->

        <div class="nk-forum-topic-content">

            <?php do_action('bbp_theme_before_topic_content'); ?>

            <?php bbp_topic_content(); ?>

            <?php do_action('bbp_theme_after_topic_content'); ?>

        </div><!-- .bbp-topic-content -->

        <div class="nk-forum-topic-footer">

            <div class="bbp-meta">

                <span class="nk-forum-topic-date"><?php bbp_topic_post_date(); ?></span>

                <a href="<?php bbp_topic_permalink(); ?>" class="bbp-topic-permalink">#<?php bbp_topic_id(); ?></a>
                
                <?php do_action('bbp_theme_before_topic_admin_links'); ?>

                <?php bbp_topic_admin_links(); ?>

                <?php do_action('bbp_theme_after_topic_admin_links'); ?>

            </div><!-- .bbp-meta -->

        </div><!-- .bbp-topic-header -->


    </li>
</ul><!-- #bbp-topic-<?php bbp_topic_id(); ?>-lead -->

<?php do_action('bbp_template_after_lead_topic'); ?>
