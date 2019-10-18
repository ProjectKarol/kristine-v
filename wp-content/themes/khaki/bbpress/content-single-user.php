<?php

/**
 * Single User Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php /*Enable if disabled header*/?>

<div id="bbpress-forums">
        <?php do_action('khaki_bbp_template_notices'); ?>
    <div id="bbp-user-wrapper">
        <div class="row vertical-gap">
            <div class="col-lg-4 nk-sidebar-sticky-parent">
                <?php bbp_get_template_part('user', 'details'); ?>
            </div>
            <div class="col-lg-8">
                <div class="nk-gap-4"></div>
                    <div id="bbp-user-body">
                        <?php if (bbp_is_favorites()) bbp_get_template_part('user', 'favorites'); ?>
                        <?php if (bbp_is_subscriptions()) bbp_get_template_part('user', 'subscriptions'); ?>
                        <?php if (bbp_is_single_user_topics()) bbp_get_template_part('user', 'topics-created'); ?>
                        <?php if (bbp_is_single_user_replies()) bbp_get_template_part('user', 'replies-created'); ?>
                        <?php if (bbp_is_single_user_edit()) bbp_get_template_part('form', 'user-edit'); ?>
                        <?php if (bbp_is_single_user_profile()) bbp_get_template_part('user', 'profile'); ?>
                    </div>
                <div class="nk-gap-4"></div>
            </div>
        </div>
    </div>
</div>
