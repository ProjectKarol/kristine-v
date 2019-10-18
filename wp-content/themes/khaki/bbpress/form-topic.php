<?php

/**
 * New/Edit Topic
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php if (!bbp_is_single_forum()) : ?>

<div id="bbpress-forums">

    <?php //bbp_breadcrumb(); ?>

    <?php endif; ?>
    <?php if (bbp_current_user_can_access_create_topic_form()) : ?>
    <div class="nk-gap-2"></div>
    <h3 class="h4">
    <?php
    if (bbp_is_topic_edit())
        printf(esc_html__('Now Editing &ldquo;%s&rdquo;', 'khaki'), bbp_get_topic_title());
    else
        bbp_is_single_forum() ? printf(esc_html__('Create New Topic in &ldquo;%s&rdquo;', 'khaki'), bbp_get_forum_title()) : esc_html_e('Create New Topic', 'khaki');
    ?>
    </h3>
    <div class="nk-gap-1"></div>
    <?php endif;?>
    <?php if (bbp_is_topic_edit()) : ?>

        <?php bbp_topic_tag_list(bbp_get_topic_id()); ?>

        <?php bbp_single_topic_description(array('topic_id' => bbp_get_topic_id())); ?>

    <?php endif; ?>

    <?php if (bbp_current_user_can_access_create_topic_form()) : ?>

        <div id="new-topic-<?php bbp_topic_id(); ?>" class="bbp-topic-form nk-box-3 bg-gray-3">

        <form id="new-post" name="new-post" method="post" class="nk-form nk-form-style-1" action="<?php the_permalink(); ?>">

        <?php do_action('bbp_theme_before_topic_form'); ?>

        <fieldset class="bbp-form">

        <?php do_action('bbp_theme_before_topic_form_notices'); ?>

        <?php if (!bbp_is_topic_edit() && bbp_is_forum_closed()) : ?>

        <?php echo '<div class="nk-info-box bg-main-1"><div class="nk-info-box-icon"><span class="ion-ios-information-circle"></span></div>' . esc_html__('This forum is marked as closed to new topics, however your posting capabilities still allow you to do so.', 'khaki') . '</div>'; ?>

    <?php endif; ?>

        <?php if (current_user_can('unfiltered_html')) : ?>

        <?php echo '<div class="nk-info-box bg-main-1"><div class="nk-info-box-icon"><span class="ion-ios-information-circle"></span></div>' . esc_html__('Your account has the ability to post unrestricted HTML content.', 'khaki') . '</div>'; ?>

    <?php endif; ?>

        <?php do_action('khaki_bbp_template_notices'); ?>

        <div>

            <?php bbp_get_template_part('form', 'anonymous'); ?>

            <?php do_action('bbp_theme_before_topic_form_title'); ?>

            <input type="text"
                   id="bbp_topic_title"
                   class="form-control"
                   value="<?php bbp_form_topic_title(); ?>" tabindex="<?php bbp_tab_index(); ?>" size="40"
                   name="bbp_topic_title" maxlength="<?php bbp_title_max_length(); ?>"
                   placeholder="<?php printf(esc_html__('Topic Title (Maximum Length: %d):', 'khaki'), bbp_get_title_max_length()); ?>"/>
            <div class="nk-gap"></div>
            <?php do_action('bbp_theme_after_topic_form_title'); ?>

            <?php do_action('bbp_theme_before_topic_form_content'); ?>

            <?php bbp_the_content(array('context' => 'topic')); ?>

            <?php do_action('bbp_theme_after_topic_form_content'); ?>

            <?php if (!(bbp_use_wp_editor() || current_user_can('unfiltered_html'))) : ?>

                <label><?php esc_html_e('You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes:', 'khaki'); ?></label>
                <?php echo do_shortcode('[nk_info_box icon="fa fa-exclamation-circle" class="allow-tags-block" show_close_button="false"]<pre class="language-html"><code class="language-html">' . apply_filters('bbp_get_allowed_tags', allowed_tags()) . '</code></pre>' . '[/nk_info_box]'); ?>

            <?php endif; ?>

            <?php if (bbp_allow_topic_tags() && current_user_can('assign_topic_tags')) : ?>

                <?php do_action('bbp_theme_before_topic_form_tags'); ?>


                <input type="text" value="<?php bbp_form_topic_tags(); ?>"
                       tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_topic_tags"
                       id="bbp_topic_tags" <?php disabled(bbp_is_topic_spam()); ?>
                       class="form-control"
                       placeholder="<?php esc_html_e('Topic Tags:', 'khaki'); ?>"
                />
                <div class="nk-gap"></div>

                <?php do_action('bbp_theme_after_topic_form_tags'); ?>

            <?php endif; ?>

            <?php if (!bbp_is_single_forum()) : ?>

                <?php do_action('bbp_theme_before_topic_form_forum'); ?>


                <label for="bbp_forum_id"><?php esc_html_e('Forum:', 'khaki'); ?></label>
                <?php
                bbp_dropdown(array(
                    'show_none' => esc_html__('(No Forum)', 'khaki'),
                    'selected' => bbp_get_form_topic_forum()
                ));
                ?>

                <?php do_action('bbp_theme_after_topic_form_forum'); ?>

            <?php endif; ?>

            <?php if (current_user_can('moderate')) : ?>

                <?php do_action('bbp_theme_before_topic_form_type'); ?>

                <label for="bbp_stick_topic"><?php esc_html_e('Topic Type:', 'khaki'); ?></label>

                <?php bbp_form_topic_type_dropdown(); ?>


                <?php do_action('bbp_theme_after_topic_form_type'); ?>

                <?php do_action('bbp_theme_before_topic_form_status'); ?>


                <label for="bbp_topic_status"><?php esc_html_e('Topic Status:', 'khaki'); ?></label>

                <?php bbp_form_topic_status_dropdown(); ?>


                <?php do_action('bbp_theme_after_topic_form_status'); ?>

            <?php endif; ?>

            <?php if (bbp_is_subscriptions_active() && !bbp_is_anonymous() && (!bbp_is_topic_edit() || (bbp_is_topic_edit() && !bbp_is_topic_anonymous()))) : ?>

                <?php do_action('bbp_theme_before_topic_form_subscriptions'); ?>
                <div class="nk-bbpress-dropdown">
                    <input name="bbp_topic_subscription" id="bbp_topic_subscription" type="checkbox"
                           value="bbp_subscribe" <?php bbp_form_topic_subscribed(); ?>
                           tabindex="<?php bbp_tab_index(); ?>"/>

                    <?php if (bbp_is_topic_edit() && (bbp_get_topic_author_id() !== bbp_get_current_user_id())) : ?>

                        <label
                            for="bbp_topic_subscription"><?php esc_html_e('Notify the author of follow-up replies via email', 'khaki'); ?></label>

                    <?php else : ?>

                        <label
                            for="bbp_topic_subscription"><?php esc_html_e('Notify me of follow-up replies via email', 'khaki'); ?></label>

                    <?php endif; ?>
                </div>
                <?php do_action('bbp_theme_after_topic_form_subscriptions'); ?>

            <?php endif; ?>

            <?php if (bbp_allow_revisions() && bbp_is_topic_edit()) : ?>

                <?php do_action('bbp_theme_before_topic_form_revisions'); ?>

                <fieldset class="bbp-form">
                    <legend>
                        <div class="nk-bbpress-dropdown">
                            <input name="bbp_log_topic_edit" id="bbp_log_topic_edit" type="checkbox"
                                   value="1" <?php bbp_form_topic_log_edit(); ?>
                                   tabindex="<?php bbp_tab_index(); ?>"/>
                            <label
                                for="bbp_log_topic_edit"><?php esc_html_e('Keep a log of this edit:', 'khaki'); ?></label>
                        </div>
                    </legend>

                    <div>
                        <input type="text" value="<?php bbp_form_topic_edit_reason(); ?>"
                               tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_topic_edit_reason"
                               id="bbp_topic_edit_reason"
                               class="form-control"
                               placeholder=<?php printf(esc_html__('Optional reason for editing:', 'khaki'), bbp_get_current_user_name()); ?>""
                        />
                    </div>
                </fieldset>

                <?php do_action('bbp_theme_after_topic_form_revisions'); ?>

            <?php endif; ?>

            <?php do_action('bbp_theme_before_topic_form_submit_wrapper'); ?>
            <div class="nk-gap"></div>
            <div class="bbp-submit-wrapper">

                <?php do_action('bbp_theme_before_topic_form_submit_button'); ?>

                <button type="submit" tabindex="<?php bbp_tab_index(); ?>" id="bbp_topic_submit"
                        name="bbp_topic_submit"
                        class="nk-btn nk-btn-effect-2-right nk-btn-color-dark-1">
                    <span><?php esc_html_e('Submit', 'khaki'); ?></span>
                    <span class="icon"><span class="ion-ios-undo"></span></span>
                </button>

                <?php do_action('bbp_theme_after_topic_form_submit_button'); ?>

            </div>

            <?php do_action('bbp_theme_after_topic_form_submit_wrapper'); ?>

        </div>

        <?php bbp_topic_form_fields(); ?>

        </fieldset>

        <?php do_action('bbp_theme_after_topic_form'); ?>

        </form>
        </div>

        <?php elseif (bbp_is_forum_closed()) : ?>

        <div id="no-topic-<?php bbp_topic_id(); ?>" class="bbp-no-topic">
            <div class="bbp-template-notice">
                <p><?php printf(esc_html__('The forum &#8216;%s&#8217; is closed to new topics and replies.', 'khaki'), bbp_get_forum_title()); ?></p>
            </div>
        </div>

        <?php else : ?>

        <div id="no-topic-<?php bbp_topic_id(); ?>" class="bbp-no-topic">
            <div class="bbp-template-notice">
                <p><?php is_user_logged_in() ? esc_html_e('You cannot create new topics.', 'khaki') : esc_html_e('You must be logged in to create new topics.', 'khaki'); ?></p>
            </div>
        </div>

    <?php endif; ?>

    <?php if (!bbp_is_single_forum()) : ?>

</div>

<?php endif; ?>
