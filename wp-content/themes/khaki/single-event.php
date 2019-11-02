<?php
global $post;
get_header();
get_template_part('/template-parts/header/custom');
$post_type = get_post_type();
$acf_header = khaki_get_theme_mod($post_type . '_header_custom', true);
$acf_content = khaki_get_theme_mod('content_' . $post_type . '_custom', true);
$acf_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_custom', true);
$acf_meta = khaki_get_theme_mod($post_type . '_meta_custom', true);
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
<?php while (have_posts()) : the_post(); ?>
    <?php if (khaki_get_theme_mod($post_type . '_show_meta', $acf_meta) && khaki_get_theme_mod($post_type . '_position_meta', $acf_meta) == 'out header'): ?>
        <?php get_template_part('/template-parts/' . $post_type . '/' . $post_type . '-meta'); ?>
    <?php endif; ?>
    <div
    class="<?php echo khaki_sanitize_class(khaki_get_theme_mod('event_inner_boxed', $acf_content) ? 'container' : 'container-fluid'); ?>">
        <div class="row">
            <div class="<?php echo khaki_sanitize_class($col_class); ?>">
        <div class="nk-events-item-single">
            <?php if (!khaki_get_theme_mod($post_type . '_header_show', $acf_header)): ?>
                <?php get_template_part('/template-parts/' . $post_type . '/' . $post_type . '-status'); ?>
            <?php endif; ?>
            <?php
            $resolution = 'khaki_600x600';
            $attachment = khaki_get_attachment(get_post_thumbnail_id(get_the_ID()), $resolution);
            ?>
    <?php if(khaki_get_theme_mod($post_type . '_style', true) == 'half' && isset($attachment) && !empty($attachment) && is_array($attachment)): ?>
        <div class="nk-gap-4"></div>
                <div class="row vertical-gap">
                    <div class="col-md-6">
                        <img src="<?php echo esc_url($attachment['src']); ?>" alt="<?php echo esc_attr($attachment['alt']); ?>" class="nk-img-fit nk-events-item-single-image">
                    </div>
                    <div class="col-md-6">
                        <?php if (khaki_get_theme_mod($post_type . '_show_meta', $acf_meta) && khaki_get_theme_mod($post_type . '_position_meta', $acf_meta) == 'before content'): ?>
                            <?php get_template_part('/template-parts/' . $post_type . '/' . $post_type . '-meta'); ?>
                        <?php endif; ?>
                        <div class="nk-events-item-description">
                            <?php the_content(); ?>
                        </div>
                        <?php if (khaki_get_theme_mod($post_type . '_show_meta', $acf_meta) && khaki_get_theme_mod($post_type . '_position_meta', $acf_meta) == 'after content'): ?>
                            <?php get_template_part('/template-parts/' . $post_type . '/' . $post_type . '-meta'); ?>
                        <?php endif; ?>
                    </div>
                </div>

        <?php else:?>
            <?php if (khaki_get_theme_mod($post_type . '_show_meta', $acf_meta) && khaki_get_theme_mod($post_type . '_position_meta', $acf_meta) == 'before content'): ?>
                <?php get_template_part('/template-parts/' . $post_type . '/' . $post_type . '-meta'); ?>
            <?php endif; ?>
            <div class="nk-events-item-description">
                <div class="nk-gap-2"></div>
                <div class="container">
                    <?php the_content(); ?>
                </div>
            </div>
            <div class="nk-gap-4"></div>
            <?php if (khaki_get_theme_mod($post_type . '_show_meta', $acf_meta) && khaki_get_theme_mod($post_type . '_position_meta', $acf_meta) == 'after content'): ?>
                <?php get_template_part('/template-parts/' . $post_type . '/' . $post_type . '-meta'); ?>
                <div class="nk-gap-4"></div>
            <?php endif; ?>
    <?php endif; ?>
            <div class="nk-gap-4"></div>
        </div>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
        <?php endwhile; // End of the loop.?>
        <?php get_footer();
