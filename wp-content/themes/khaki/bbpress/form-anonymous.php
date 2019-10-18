<?php

/**
 * Anonymous User
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php if (bbp_current_user_can_access_anonymous_user_form()) : ?>

    <?php do_action('bbp_theme_before_anonymous_form'); ?>

    <fieldset class="bbp-form">
        <legend><?php (bbp_is_topic_edit() || bbp_is_reply_edit()) ? esc_html_e('Author Information', 'khaki') : esc_html_e('Your information:', 'khaki'); ?></legend>

        <?php do_action('bbp_theme_anonymous_form_extras_top'); ?>

        <input type="text" class="form-control" id="bbp_anonymous_author"
               placeholder="<?php esc_html_e('Name (required):', 'khaki'); ?>" value="<?php bbp_author_display_name(); ?>"
               tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_anonymous_name"/>
        <div class="nk-gap"></div>

        <input type="text" class="form-control" id="bbp_anonymous_email"
               placeholder="<?php esc_html_e('Mail (will not be published) (required):', 'khaki'); ?>"
               value="<?php bbp_author_email(); ?>" tabindex="<?php bbp_tab_index(); ?>" size="40"
               name="bbp_anonymous_email"/>

        <div class="nk-gap"></div>
        <input type="text" class="form-control" id="bbp_anonymous_website"
               placeholder="<?php esc_html_e('Website:', 'khaki'); ?>"
               value="<?php bbp_author_url(); ?>" tabindex="<?php bbp_tab_index(); ?>" size="40"
               name="bbp_anonymous_website"/>
        <div class="nk-gap"></div>

        <?php do_action('bbp_theme_anonymous_form_extras_bottom'); ?>

    </fieldset>

    <?php do_action('bbp_theme_after_anonymous_form'); ?>

<?php endif; ?>
