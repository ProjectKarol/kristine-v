<?php

/**
 * Topics Loop - Single
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<li id="bbp-topic-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); ?>>

    <div class="nk-forum-icon">
        <span class="<?php echo strripos(bbp_get_topic_class(), 'status-publish') ? khaki_sanitize_class(khaki_get_theme_mod('topic_icon_class', true)) :khaki_sanitize_class('ion-ios-lock'); ?>"></span>
    </div>

    <div class="nk-forum-title">

        <?php do_action('bbp_theme_before_topic_title'); ?>

        <h3><a href="<?php bbp_topic_permalink(); ?>"><?php bbp_topic_title(); ?></a></h3>

        <?php do_action('bbp_theme_after_topic_title'); ?>

        <?php //bbp_topic_pagination(); ?>

        <?php do_action('bbp_theme_before_topic_meta'); ?>

        <div class="nk-forum-title-sub">

            <?php do_action('bbp_theme_before_topic_started_by'); ?>

            <span
                class="bbp-topic-started-by"><?php printf(esc_html__('Started by %1$s on %2$s', 'khaki'), bbp_get_topic_author_link(array('type' => 'name')), bbp_get_reply_post_date()); ?></span>

            <?php do_action('bbp_theme_after_topic_started_by'); ?>

            <?php if (!bbp_is_single_forum() || (bbp_get_topic_forum_id() !== bbp_get_forum_id())) : ?>

                <?php do_action('bbp_theme_before_topic_started_in'); ?>

                <span
                    class="bbp-topic-started-in"><?php printf(__('in: <a href="%1$s">%2$s</a>', 'khaki'), bbp_get_forum_permalink(bbp_get_topic_forum_id()), bbp_get_forum_title(bbp_get_topic_forum_id())); ?></span>

                <?php do_action('bbp_theme_after_topic_started_in'); ?>

            <?php endif; ?>

        </div>

        <?php if (bbp_is_user_home()) : ?>

            <?php if (bbp_is_favorites()) : ?>


					<?php do_action('bbp_theme_before_topic_favorites_action'); ?>

                    <?php bbp_topic_favorite_link(array('before' => '', 'favorite' => '+', 'favorited' => '&times;')); ?>

                    <?php do_action('bbp_theme_after_topic_favorites_action'); ?>


            <?php elseif (bbp_is_subscriptions()) : ?>


					<?php do_action('bbp_theme_before_topic_subscription_action'); ?>

                    <?php bbp_topic_subscription_link(array('before' => '', 'subscribe' => '+', 'unsubscribe' => '&times;')); ?>

                    <?php do_action('bbp_theme_after_topic_subscription_action'); ?>
				</span>

            <?php endif; ?>

        <?php endif; ?>

        <?php do_action('bbp_theme_after_topic_meta'); ?>

        <?php bbp_topic_row_actions(); ?>

    </div>

    <div
        class="nk-forum-count"><?php printf(esc_html__('%1$s voice%2$s', 'khaki'), bbp_get_topic_voice_count(), bbp_get_topic_voice_count() > 1 ? esc_html__('s', 'khaki') : '') ?>
    </div>

    <?php $posts_count = bbp_show_lead_topic() ? bbp_get_topic_reply_count() : bbp_get_topic_post_count(); ?>

    <div class="nk-forum-count">
        <?php printf(esc_html__('%1$s post%2$s', 'khaki'), $posts_count, $posts_count > 1 ? esc_html__('s', 'khaki') : '') ?>
    </div>

    <div class="nk-forum-activity-avatar">
        <?php do_action('bbp_theme_before_topic_freshness_author'); ?>
        <?php bbp_author_link(array('post_id' => bbp_get_topic_last_active_id(), 'size' => 34, 'type' => 'avatar')); ?>
        <?php do_action('bbp_theme_after_topic_freshness_author'); ?>
    </div>

    <div class="nk-forum-activity">
        <?php
        $link_url = bbp_get_topic_last_reply_url();
        $title = bbp_get_topic_last_reply_title();
        ?>
        <div class="nk-forum-activity-title" title="<?php echo esc_attr($title); ?>">
            <a href="<?php echo esc_url($link_url); ?>"><?php echo esc_html($title); ?></a>
        </div>
        <div class="nk-forum-activity-date">
            <?php do_action('bbp_theme_before_topic_freshness_link'); ?>
            <?php $time_since = bbp_get_topic_last_active_time();
            if (!empty($time_since)) {
                echo esc_html($time_since);
            } else {
                echo esc_html__('No Replies', 'khaki');
            }
            ?>
            <?php do_action('bbp_theme_after_topic_freshness_link'); ?>
        </div>
    </div>

</li><!-- #bbp-topic-<?php bbp_topic_id(); ?> -->
