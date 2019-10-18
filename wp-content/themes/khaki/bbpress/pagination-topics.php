<?php

/**
 * Pagination for pages of topics (when viewing a forum)
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action('bbp_template_before_pagination_loop'); ?>

<!-- START: Pagination -->

<div class="bbp-pagination">
    <div class="bbp-pagination-count">

        <?php bbp_forum_pagination_count(); ?>

    </div>
</div>
<?php if((bbp_current_user_can_access_create_topic_form() && !bbp_is_single_user_topics() && !bbp_is_favorites() && !bbp_is_subscriptions() && !bbp_is_topic_archive() && !bbp_is_forum_archive() && !bbp_is_topic_tag()) || bbp_get_forum_pagination_links()):?>
<div class="row">
    <?php if (bbp_current_user_can_access_create_topic_form() && !bbp_is_single_user_topics() && !bbp_is_favorites() && !bbp_is_subscriptions() && !bbp_is_topic_archive() && !bbp_is_forum_archive() && !bbp_is_topic_tag()) : ?>
        <div class="col-md-3 order-md-2 text-right">
            <a href="#new-post" class="nk-btn nk-btn-color-black nk-btn-color-hover-dark-4"><?php echo esc_html__('New Topic', 'khaki');?></a>
        </div>
    <?php endif;?>
    <div class="col-md-9">
        <?php khaki_bb_output_pagination(bbp_get_forum_pagination_links()); ?>
    </div>
</div>
<div class="nk-gap-2"></div>
<?php endif;?>
<!-- END: Pagination -->
<?php do_action('bbp_template_after_pagination_loop'); ?>
