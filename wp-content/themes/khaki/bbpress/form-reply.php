<?php

/**
 * New/Edit Reply
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php if (bbp_is_reply_edit()) : ?>

<div id="bbpress-forums">

    <?php //bbp_breadcrumb(); ?>

    <?php endif; ?>

    <?php if (bbp_current_user_can_access_create_reply_form()) : ?>
        <div class="nk-gap-2"></div>
        <h3 class="h4"><?php printf(esc_html__('Reply To: %s', 'khaki'), bbp_get_topic_title()); ?></h3>
        <div class="nk-gap-1"></div>
        <div id="new-reply-<?php bbp_topic_id(); ?>" class="bbp-reply-form nk-box-3 bg-gray-3">

            <form id="new-post" name="new-post" method="post" class="nk-form nk-form-style-1" action="<?php the_permalink(); ?>">

                <?php do_action('bbp_theme_before_reply_form'); ?>

                <fieldset class="bbp-form">

                    <?php do_action('bbp_theme_before_reply_form_notices'); ?>

                    <?php if (!bbp_is_topic_open() && !bbp_is_reply_edit()) : ?>

                        <?php echo '<div class="nk-info-box bg-main-1"><div class="nk-info-box-icon"><span class="ion-ios-information-circle"></span></div>' . esc_html__('This topic is marked as closed to new replies, however your posting capabilities still allow you to do so.', 'khaki') . '</div>'; ?>

                    <?php endif; ?>

                    <?php if (current_user_can('unfiltered_html')) : ?>

                        <?php echo '<div class="nk-info-box bg-main-1"><div class="nk-info-box-icon"><span class="ion-ios-information-circle"></span></div>' . esc_html__('Your account has the ability to post unrestricted HTML content.', 'khaki') . '</div>'; ?>

                    <?php endif; ?>

                    <?php do_action('khaki_bbp_template_notices'); ?>
                    <div>

                        <?php bbp_get_template_part('form', 'anonymous'); ?>

                        <?php do_action('bbp_theme_before_reply_form_content'); ?>

                        <?php bbp_the_content(array('context' => 'reply')); ?>

                        <?php do_action('bbp_theme_after_reply_form_content'); ?>

                        <?php if (!(bbp_use_wp_editor() || current_user_can('unfiltered_html'))) : ?>

                            <label><?php esc_html_e('You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes:', 'khaki'); ?></label>
                            <?php echo do_shortcode('[nk_info_box icon="fa fa-exclamation-circle" class="allow-tags-block" show_close_button="false"]<pre class="language-html"><code class="language-html">' . apply_filters('bbp_get_allowed_tags', allowed_tags()) . '</code></pre>' . '[/nk_info_box]'); ?>

                        <?php endif; ?>

                        <?php if (bbp_allow_topic_tags() && current_user_can('assign_topic_tags')) : ?>

                        <?php do_action('bbp_theme_before_reply_form_tags'); ?>


                        <input type="text" value="<?php bbp_form_topic_tags(); ?>"
                               tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_topic_tags"
                               id="bbp_topic_tags" <?php disabled(bbp_is_topic_spam()); ?>
                               class="form-control"
                               placeholder="<?php esc_html_e('Tags:', 'khaki'); ?>"
                        />
                        <div class="nk-gap"></div>


                        <?php do_action('bbp_theme_after_reply_form_tags'); ?>

                        <?php endif; ?>

                        <?php if (bbp_is_subscriptions_active() && !bbp_is_anonymous() && (!bbp_is_reply_edit() || (bbp_is_reply_edit() && !bbp_is_reply_anonymous()))) : ?>

                            <?php do_action('bbp_theme_before_reply_form_subscription'); ?>

                        <div class="nk-bbpress-dropdown">

                                <input name="bbp_topic_subscription" id="bbp_topic_subscription" type="checkbox"
                                       value="bbp_subscribe"<?php bbp_form_topic_subscribed(); ?>
                                       tabindex="<?php bbp_tab_index(); ?>"/>

                                <?php if (bbp_is_reply_edit() && (bbp_get_reply_author_id() !== bbp_get_current_user_id())) : ?>

                                    <label
                                        for="bbp_topic_subscription"><?php esc_html_e('Notify the author of follow-up replies via email', 'khaki'); ?></label>

                                <?php else : ?>

                                    <label
                                        for="bbp_topic_subscription"><?php esc_html_e('Notify me of follow-up replies via email', 'khaki'); ?></label>

                                <?php endif; ?>

                            </div>

                            <?php do_action('bbp_theme_after_reply_form_subscription'); ?>

                        <?php endif; ?>

                        <?php if (bbp_allow_revisions() && bbp_is_reply_edit()) : ?>

                            <?php do_action('bbp_theme_before_reply_form_revisions'); ?>

                            <fieldset class="bbp-form">
                                <legend>
                                    <div class="nk-bbpress-dropdown">
                                    <input name="bbp_log_reply_edit" id="bbp_log_reply_edit" type="checkbox"
                                           value="1" <?php bbp_form_reply_log_edit(); ?>
                                           tabindex="<?php bbp_tab_index(); ?>"/>
                                    <label
                                        for="bbp_log_reply_edit"><?php esc_html_e('Keep a log of this edit:', 'khaki'); ?></label>
                                        </div>
                                </legend>

                                <div>
                                    <input type="text" value="<?php bbp_form_reply_edit_reason(); ?>"
                                           tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_reply_edit_reason"
                                           id="bbp_reply_edit_reason"
                                           class="form-control"
                                           placeholder="<?php printf(esc_html__('Optional reason for editing:', 'khaki'), bbp_get_current_user_name()); ?>"
                                    />
                                </div>
                            </fieldset>

                            <?php do_action('bbp_theme_after_reply_form_revisions'); ?>

                        <?php endif; ?>

                        <?php do_action('bbp_theme_before_reply_form_submit_wrapper'); ?>
                        <div class="nk-gap"></div>
                        <div class="bbp-submit-wrapper">

                            <?php do_action('bbp_theme_before_reply_form_submit_button'); ?>

                            <?php bbp_cancel_reply_to_link(); ?>

                            <button type="submit" tabindex="<?php bbp_tab_index(); ?>" id="bbp_reply_submit"
                                    name="bbp_reply_submit"
                                    class="nk-btn nk-btn-effect-2-right nk-btn-color-dark-1">
                                <span><?php esc_html_e('Reply', 'khaki'); ?></span>
                                <span class="icon"><span class="ion-ios-undo"></span></span>
                            </button>
                            <?php do_action('bbp_theme_after_reply_form_submit_button'); ?>

                        </div>

                        <?php do_action('bbp_theme_after_reply_form_submit_wrapper'); ?>

                    </div>

                    <?php bbp_reply_form_fields(); ?>

                </fieldset>

                <?php do_action('bbp_theme_after_reply_form'); ?>

            </form>
        </div>

    <?php elseif
    (bbp_is_topic_closed()) : ?>

        <div id="no-reply-<?php bbp_topic_id(); ?>" class="bbp-no-reply">
            <div class="bbp-template-notice">
                <p><?php printf(esc_html__('The topic &#8216;%s&#8217; is closed to new replies.', 'khaki'), bbp_get_topic_title()); ?></p>
            </div>
        </div>

    <?php elseif (bbp_is_forum_closed(bbp_get_topic_forum_id())) : ?>

        <div id="no-reply-<?php bbp_topic_id(); ?>" class="bbp-no-reply">
            <div class="bbp-template-notice">
                <p><?php printf(esc_html__('The forum &#8216;%s&#8217; is closed to new topics and replies.', 'khaki'), bbp_get_forum_title(bbp_get_topic_forum_id())); ?></p>
            </div>
        </div>

    <?php else : ?>

        <div id="no-reply-<?php bbp_topic_id(); ?>" class="bbp-no-reply">
            <div class="bbp-template-notice">
                <p><?php is_user_logged_in() ? esc_html_e('You cannot reply to this topic.', 'khaki') : esc_html_e('You must be logged in to reply to this topic.', 'khaki'); ?></p>
            </div>
        </div>

    <?php endif; ?>

    <?php if (bbp_is_reply_edit()) : ?>

</div>

<?php endif; ?>
