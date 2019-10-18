<?php
/**
 * The template for displaying all custom(playlist) posts list.
 *
 * @link https://codex.wordpress.org/Post_Types
 *
 * @package khaki
 */
get_header();
get_template_part('/template-parts/header/custom');
$post_type = get_post_type();
$acf_header = khaki_get_theme_mod($post_type . '_header_custom', true);
$acf_content = khaki_get_theme_mod('content_' . $post_type . '_custom', true);

$acf_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_custom', true);
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
    <!-- START: Latest Albums -->
    <div class="nk-box bg-custom-playlist-archive-color text-custom-playlist-archive-color">
        <div
            class="<?php echo khaki_sanitize_class(khaki_get_theme_mod('playlist_inner_boxed', $acf_content) ? 'container' : 'container-fluid'); ?>">
            <div class="row">
                <div class="<?php echo khaki_sanitize_class($col_class); ?>">
                    <div class="nk-gap-5"></div>
            <?php if (khaki_get_theme_mod('playlist_show_title', $acf_content)): ?>
                <h2 class="nk-title h1 text-center"><?php echo get_the_archive_title();?></h2>
                <div class="nk-gap-2"></div>
            <?php endif; ?>
            <?php
            $pagination = khaki_get_theme_mod('playlist_pagination');
            $class = '';
            if (isset($pagination) && $pagination === 'infinite') {
                $class .= 'nk-infinite-scroll-container';
            }
            if (isset($pagination) && $pagination === 'load_more') {
                $class .= 'nk-load-more-container';
            }
            $class .= ' row vertical-gap';
            ?>
            <div class="<?php echo khaki_sanitize_class($class); ?>">
                <?php
                if (have_posts()) :
                    /* Start the Loop */
                    $playlist_no_image = khaki_get_theme_mod('playlist_no_image');
                    $resolution = 'khaki_800x600';
                    while (have_posts()) : the_post();
                        $attachment = (khaki_get_attachment(get_post_thumbnail_id(get_the_ID()), $resolution));
                        $img_str = '';
                        if (isset($attachment) && !empty($attachment) && is_array($attachment)) {
                            $img_str = '<img src="' . esc_url($attachment['src']) . '" alt="' . esc_attr($attachment['alt']) . '">';
                        } else {
                            $img_str = '<img src="' . esc_url($playlist_no_image) . '" alt="' . esc_attr_( 'No Image', 'khaki' ) . '">';
                        }
                        ?>
                        <div id="post-<?php the_ID(); ?>" class="col-md-4 news-one">
                            <div class="nk-image-box-4">
                                <a href="<?php echo esc_url(get_permalink()) ?>" class="nk-image-box-link"></a>
                                <?php echo wp_kses( $img_str, khaki_allowed_html() ); ?>
                                <div class="nk-image-box-overlay nk-image-box-center">
                                    <div>
                                        <h3 class="nk-image-box-title mb-20"><?php echo get_the_title(); ?></h3>
                                        <div
                                            class="nk-btn nk-btn-sm nk-btn-color-white nk-btn-outline"><?php esc_html_e('See More', 'khaki'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                else :
                    get_template_part('template-parts/content', 'none');
                endif; ?>
            </div>
            <div class="nk-gap-1"></div>
            <?php if ($pagination) {
                khaki_posts_navigation();
                if ($pagination == 'infinite' || $pagination == 'load_more') {
                    nk_infinite_scroll_init();
                }
            } ?>
            <div class="nk-gap-5"></div>
        </div>
        <?php get_sidebar(); ?>
    </div>
        </div>
    </div>
    <!-- END: Latest Albums -->
<?php get_footer();
