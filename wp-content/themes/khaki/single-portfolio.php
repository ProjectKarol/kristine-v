<?php
/**
 * The template for displaying all custom(portfolio) posts.
 *
 * @link https://codex.wordpress.org/Post_Types
 *
 * @package khaki
 */
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
    <div
    class="<?php echo khaki_sanitize_class(khaki_get_theme_mod('portfolio_inner_boxed', $acf_content) ? 'container' : 'container-fluid'); ?>">
    <div class="row">
    <div class="<?php echo khaki_sanitize_class($col_class); ?>">
    <?php
    if (is_single() && khaki_get_theme_mod('single_' . $post_type . '_adjacent_pagination', $acf_content) && khaki_get_theme_mod('single_' . $post_type . '_adjacent_pagination_style', $acf_content) == 'static' && khaki_get_theme_mod('single_' . $post_type . '_adjacent_pagination_position', $acf_content) == 'before'):?>
        <div class="nk-gap-3"></div>
        <?php //output post type pagination
        get_template_part('/template-parts/pagination', 'static'); ?>
    <?php endif; ?>
    <div class="nk-portfolio-item-single">
        <?php if (khaki_get_theme_mod($post_type . '_show_meta', $acf_meta) && khaki_get_theme_mod($post_type . '_position_meta', $acf_meta) == 'before content' && khaki_get_theme_mod($post_type . '_style', true) == 'standard'): ?>
            <?php get_template_part('/template-parts/' . $post_type . '/' . $post_type . '-meta'); ?>
        <?php endif; ?>
        <div class="nk-portfolio-item-description">
            <div class="nk-gap-2"></div>
            <div class="container">
            <?php if(khaki_get_theme_mod($post_type . '_detail_show_title', $acf_content)):?>
                <h1 class="nk-title h2 text-center">
                    <?php
                    $custom_title = khaki_get_theme_mod('portfolio_content_custom_title', $acf_content);
                    echo $custom_title ? esc_html($custom_title) : get_the_title($post->ID);
                    ?>
                </h1>
            <?php endif; ?>
            <?php $detail_subtitle = khaki_get_theme_mod($post_type . '_detail_subtitle', $acf_content);?>
            <?php if(isset($detail_subtitle) && !empty($detail_subtitle)):?>
                <h2 class="nk-sub-title text-center"><?php echo esc_html($detail_subtitle);?></h2>
            <?php endif; ?>
            <?php if(isset($detail_subtitle) && !empty($detail_subtitle)):?>
                <div class="nk-gap-2"></div>
            <?php endif; ?>
                <?php if (khaki_get_theme_mod($post_type . '_style', true) == 'half'): ?>
                    <?php
                    $resolution = 'khaki_600x600';
                    $attachment = khaki_get_attachment(get_post_thumbnail_id(get_the_ID()), $resolution);
                    $gallery = khaki_get_theme_mod($post_type . '_gallery', true);
                    ?>
                    <div class="nk-popup-gallery">
                        <div class="row vertical-gap">
                            <?php if ((isset($gallery) && is_array($gallery) && !empty($gallery)) || (isset($attachment) && !empty($attachment) && is_array($attachment))): ?>
                                <div class="col-md-6">
                                    <?php if (isset($attachment) && !empty($attachment) && is_array($attachment)) {
                                        $full_image = khaki_get_attachment(get_post_thumbnail_id(get_the_ID()));
                                        $small_image = $attachment;
                                    } elseif (isset($gallery) && is_array($gallery) && !empty($gallery)) {
                                        $first_gallery = array_shift($gallery);
                                        $full_image = khaki_get_attachment($first_gallery['id']);
                                        $small_image = khaki_get_attachment($first_gallery['id'], $resolution);
                                    }
                                    ?>
                                    <a href="<?php echo esc_url($full_image['src']); ?>" class="nk-gallery-item"
                                       data-size="<?php echo esc_attr($full_image['width'] . 'x' . $full_image['height']); ?>"><img
                                            src="<?php echo esc_url($small_image['src']); ?>"
                                            alt="<?php echo esc_attr($small_image['alt']); ?>"
                                            class="nk-img-fit nk-portfolio-item-single-image"></a>
                                </div>
                            <?php endif; ?>
                            <div class="col-md-6">
                                <?php if (khaki_get_theme_mod($post_type . '_show_meta', $acf_meta) && khaki_get_theme_mod($post_type . '_position_meta', $acf_meta) == 'before content'): ?>
                                    <?php get_template_part('/template-parts/' . $post_type . '/' . $post_type . '-meta'); ?>
                                <?php endif; ?>
                                <div class="nk-portfolio-item-description">
                                    <div class="nk-portfolio-item-excerpt">
                                        <?php the_content(); ?>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <?php if (khaki_get_theme_mod($post_type . '_show_meta', $acf_meta) && khaki_get_theme_mod($post_type . '_position_meta', $acf_meta) == 'after content'): ?>
                                    <?php get_template_part('/template-parts/' . $post_type . '/' . $post_type . '-meta'); ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="nk-gap-1"></div>
                        <?php if (isset($gallery) && is_array($gallery) && !empty($gallery)): ?>
                            <div class="row vertical-gap">
                                <?php foreach ($gallery as $image): ?>
                                    <div class="col-md-6">
                                        <a href="<?php echo esc_url($image['url']); ?>" class="nk-gallery-item"
                                           data-size="<?php echo esc_attr($image['width'] . 'x' . $image['height']); ?>"><img
                                                src="<?php echo esc_url($image['sizes'][$resolution]); ?>"
                                                alt="<?php echo esc_attr($image['alt']); ?>"
                                                class="nk-img-fit"></a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php elseif
                (khaki_get_theme_mod($post_type . '_style', true) == 'standard'
                ): ?>
                    <?php the_content(); ?>
                    <div class="clearfix"></div>
                <?php endif; ?>
            </div>
        </div>
        <?php if (khaki_get_theme_mod($post_type . '_show_meta', $acf_meta) && khaki_get_theme_mod($post_type . '_position_meta', $acf_meta) == 'after content' && khaki_get_theme_mod($post_type . '_style', true) == 'standard'): ?>
            <?php get_template_part('/template-parts/' . $post_type . '/' . $post_type . '-meta'); ?>
        <?php endif; ?>
    </div>
    <?php
    if (is_single() && khaki_get_theme_mod('single_' . $post_type . '_adjacent_pagination', $acf_content) && khaki_get_theme_mod('single_' . $post_type . '_adjacent_pagination_style', $acf_content) == 'static' && khaki_get_theme_mod('single_' . $post_type . '_adjacent_pagination_position', $acf_content) == 'after'):?>
        <div class="nk-gap-3"></div>
        <?php //output post type pagination
        get_template_part('/template-parts/pagination', 'static'); ?>
    <?php endif; ?>
    <div class="container">
        <?php
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        ?>
    </div>
    <div class="nk-gap-4"></div>
    </div>
        <?php get_sidebar(); ?>
    </div>
    </div>
<?php endwhile; // End of the loop.?>
<?php get_footer();
