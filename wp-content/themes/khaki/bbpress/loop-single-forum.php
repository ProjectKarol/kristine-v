<?php

/**
 * Forums Loop - Single Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<li id="bbp-forum-<?php bbp_forum_id(); ?>" <?php bbp_forum_class(); ?>>

    <div class="nk-forum-icon">
        <span
            class="<?php echo strripos(bbp_get_forum_class(), 'bbp-forum-status-closed') ? khaki_sanitize_class('ion-ios-lock') :khaki_sanitize_class(khaki_get_theme_mod('forum_icon_class', true)); ?>"></span>
    </div>

    <div class="nk-forum-title">

        <?php if (bbp_is_user_home() && bbp_is_subscriptions()) : ?>

            <span class="bbp-row-actions">

				<?php do_action('bbp_theme_before_forum_subscription_action'); ?>

                <?php bbp_forum_subscription_link(array('before' => '', 'subscribe' => '+', 'unsubscribe' => '&times;')); ?>

                <?php do_action('bbp_theme_after_forum_subscription_action'); ?>

			</span>

        <?php endif; ?>

        <?php do_action('bbp_theme_before_forum_title'); ?>

        <h3><a href="<?php bbp_forum_permalink(); ?>"><?php bbp_forum_title(); ?></a></h3>

        <?php do_action('bbp_theme_after_forum_title'); ?>

        <?php do_action('bbp_theme_before_forum_description'); ?>

        <div class="nk-forum-title-sub"><?php bbp_forum_content(); ?></div>

        <?php do_action('bbp_theme_after_forum_description'); ?>

        <?php do_action('bbp_theme_before_forum_sub_forums'); ?>

        <?php bbp_list_forums(); ?>

        <?php do_action('bbp_theme_after_forum_sub_forums'); ?>

        <?php bbp_forum_row_actions(); ?>

    </div>

    <div
        class="nk-forum-count"><?php printf(esc_html('%1$s topic%2$s'), bbp_get_forum_topic_count(), bbp_get_forum_topic_count() > 1 ? 's' : '') ?></div>
    <?php bbp_show_lead_topic() ? $posts_count = bbp_get_forum_reply_count() : $posts_count = bbp_get_forum_post_count(); ?>
    <div class="nk-forum-count">
        <?php
        if (bbp_show_lead_topic()) {
            printf(esc_html__('%1$s post%2$s', 'khaki'), $posts_count, $posts_count > 1 ? esc_html__('s', 'khaki') : '');
        } else {
            printf(esc_html__('%1$s repl%2$s', 'khaki'), $posts_count, $posts_count > 1 ? esc_html__('ies', 'khaki') : esc_html__('y', 'khaki'));
        }
        ?>
    </div>
    <div class="nk-forum-activity-avatar">
        <?php do_action('bbp_theme_before_topic_author'); ?>
        <?php bbp_author_link(array('post_id' => bbp_get_forum_last_active_id(), 'size' => 34, 'type' => 'avatar')); ?>
        <?php do_action('bbp_theme_after_topic_author'); ?>
    </div>
    <div class="nk-forum-activity">

        <?php do_action('bbp_theme_before_forum_freshness_link'); ?>

        <?php bbp_forum_freshness_link(); ?>

        <?php do_action('bbp_theme_after_forum_freshness_link'); ?>

    </div>

</li><!-- #bbp-forum-<?php bbp_forum_id(); ?> -->
