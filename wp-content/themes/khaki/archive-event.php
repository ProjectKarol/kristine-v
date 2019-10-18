<?php
/**
 * The template for displaying all custom(event) posts list.
 *
 * @link https://codex.wordpress.org/Post_Types
 *
 * @package khaki
 */
get_header();
get_template_part('/template-parts/header/custom');
?>
<?php

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'posts_per_page' => 5,
    'category_name' => get_post_meta(get_queried_object_id(), 'WP_Catid', 'true'),
    'paged' => $paged,
    'post_type' => 'event',
    'meta_key' => 'event_date',
    'orderby' => 'meta_value_num',
    'order' => 'DESC'
);
$posts = new WP_Query($args);
$post_type = get_post_type();
$acf_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_custom', true);
$acf_header = khaki_get_theme_mod($post_type . '_header_custom', true);
$acf_content = khaki_get_theme_mod('content_' . $post_type . '_custom', true);
$custom_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_list', $acf_sidebar);
$show_custom_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_show', $acf_sidebar);
$custom_sidebar_side = khaki_get_theme_mod('sidebar_' . $post_type . '_side', $acf_sidebar);

$col_class = 'col-12';

if ($show_custom_sidebar && $custom_sidebar && is_active_sidebar($custom_sidebar)) {
    if (isset($custom_sidebar_side) && $custom_sidebar_side === 'both') {
        $col_class = 'col-lg-6';
    } else {
        $col_class = 'col-lg-8';
    }
}
?>
<?php if ($posts->have_posts()) :?>
    <div
        class="<?php echo khaki_sanitize_class(khaki_get_theme_mod('event_inner_boxed', $acf_content) ? 'container' : 'container-fluid'); ?>">
        <div class="row">
            <div class="<?php echo khaki_sanitize_class($col_class); ?>">
                <!-- START: Events List -->
                <div class="nk-gap-4"></div>
                        <?php if (khaki_get_theme_mod('event_show_title', $acf_content)): ?>
                            <h2 class="nk-title h1 text-center"><?php echo get_the_archive_title();?></h2>
                            <div class="nk-gap-2"></div>
                        <?php endif; ?>
                <?php
                $pagination = khaki_get_theme_mod('event_pagination');
                $class = 'nk-events-list';
                if (isset($pagination) && $pagination === 'infinite') {
                    $class .= ' nk-infinite-scroll-container';
                }
                if (isset($pagination) && $pagination === 'load_more') {
                    $class .= ' nk-load-more-container';
                }

                ?>
                <ul class="<?php echo khaki_sanitize_class($class); ?>">
                    <?php /* Start the Loop */
                    while ($posts->have_posts()) : $posts->the_post();
                        ?>
                        <?php
                        $event_date = explode('|', khaki_get_theme_mod('event_date', true));
                        $detail_url = get_permalink();
                        $title = get_the_title();
                        $location = khaki_get_theme_mod('event_location', true);
                        $price = khaki_get_theme_mod('event_price', true);
                        $product_type = khaki_get_theme_mod('event_product_type', true);
                        ?>
                        <li>
                            <?php if (isset($event_date) && !empty($event_date) && is_array($event_date)): ?>
                                <a href="<?php echo esc_url($detail_url); ?>" class="nk-event-date">
                                    <?php echo esc_html(array_shift($event_date)); ?>
                                    <span><?php echo esc_html(array_pop($event_date)); ?></span>
                                </a>
                            <?php endif; ?>
                            <?php if ((isset($title) && !empty($title)) || (isset($location) && !empty($location))): ?>
                                <a href="<?php echo esc_url($detail_url); ?>" class="nk-event-name">
                                    <?php if (isset($title) && !empty($title)): ?>
                                        <strong><?php echo esc_html($title); ?></strong>
                                    <?php endif; ?>
                                    <?php if (isset($location) && !empty($location)): ?>
                                        <span><?php echo esc_html($location); ?></span>
                                    <?php endif; ?>
                                </a>
                            <?php endif; ?>
                            <?php if ((isset($price) && !empty($price)) || (isset($product_type) && !empty($product_type))): ?>
                                <a href="<?php echo esc_url($detail_url); ?>" class="nk-event-price">
                                    <?php if (isset($price) && !empty($price)): ?>
                                        <?php echo esc_html($price); ?>
                                    <?php endif; ?>
                                    <?php if (isset($product_type) && !empty($product_type)): ?>
                                        <span><?php echo esc_html($product_type); ?></span>
                                    <?php endif; ?>
                                </a>
                            <?php endif; ?>
                            <?php get_template_part('/template-parts/' . $post_type . '/' . $post_type . '-status'); ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <!-- END: Events List -->
                <?php if ($pagination) {
                    khaki_posts_navigation();
                    if ($pagination == 'infinite' || $pagination == 'load_more') {
                        nk_infinite_scroll_init();
                    }
                } ?>
                <?php wp_reset_postdata();     // Restore global post data stomped by posts().
                ?>
                <div class="nk-gap-4"></div>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
<?php else :
    get_template_part('template-parts/content', 'none');
endif; ?>

<?php get_footer();
