<?php
/**
 * @package khaki
 */
?>
<?php
global $post;
$post_type = get_post_type();
if (!$post_type) {
    $post_type = 'page';
}
//use acf settings (return true or null)
$acf_header = khaki_get_theme_mod('post_header_custom', true);
$acf_meta = khaki_get_theme_mod('post_meta_custom', true);
$acf_sidebar = khaki_get_theme_mod('sidebar_post_custom', true);
$acf_content = khaki_get_theme_mod('content_post_custom', true);

$meta_published_show = khaki_get_theme_mod('single_post_meta_published_show', $acf_meta);
$meta_categories_show = khaki_get_theme_mod('single_post_meta_categories_show', $acf_meta);
$meta_author_show = khaki_get_theme_mod('single_post_meta_author_show', $acf_meta);

$custom_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_list', $acf_sidebar);
$show_custom_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_show', $acf_sidebar);
$custom_sidebar_side = khaki_get_theme_mod('sidebar_' . $post_type . '_side', $acf_sidebar);
$single_post_boxed = khaki_get_theme_mod('single_post_boxed', $acf_content);

$row_class = 'row';
$col_class = 'col-12';

if ($show_custom_sidebar && $custom_sidebar && is_active_sidebar($custom_sidebar)) {
    if (isset($custom_sidebar_side) && $custom_sidebar_side === 'both') {
        $col_class = 'col-lg-6';
    } else {
        $col_class = 'col-lg-8';
    }
} else if (isset($single_post_boxed) && $single_post_boxed == 'narrow') {
    $row_class .= 'justify-content-center';
}
?>
<div
    id="post-<?php the_ID(); ?>" <?php post_class(khaki_sanitize_class($single_post_boxed ? 'container' : 'container-fluid')); ?>>
    <div class="<?php echo khaki_sanitize_class($row_class); ?>">
        <div class="<?php echo khaki_sanitize_class($col_class); ?>">
            <?php if (khaki_get_theme_mod('single_post_header_show', $acf_header)): ?>
            <div class="nk-blog-container nk-blog-container-offset">
                <div class="nk-gap-4"></div>
                <?php else: ?>
                    <div class="nk-gap-3"></div>
                <?php endif; ?>
                <!-- START: Post -->
                <div class="nk-blog-post nk-blog-post-single">
                    <?php if (khaki_get_theme_mod('single_post_content_show_title', $acf_content)): ?>
                    <h1 class="h2">
                        <?php
                        $custom_title = khaki_get_theme_mod('single_post_content_custom_title', $acf_content);
                        echo $custom_title ? esc_html($custom_title) : get_the_title();
                        ?>
                    </h1>
                    <?php endif; ?>
                    <!-- START: Post Text -->
                    <?php if (khaki_get_theme_mod('single_post_date_author_category_show', $acf_meta)): ?>
                        <?php if (khaki_get_theme_mod('single_post_date_author_category_area', $acf_meta) == 'content-top'): ?>
                            <div class="nk-post-meta nk-post-meta-top">
                                <div class="nk-post-date">
                                    <?php
                                    if($meta_published_show):
                                        echo get_the_time(esc_html__('F j, Y ', 'khaki'));
                                    endif;
                                    ?>
                                    <?php if($meta_author_show):?>
                                        <span class="nk-post-by"><?php esc_html_e('by', 'khaki'); ?>
                                            <?php $author_id = $post->post_author; ?>
                                            <a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo get_the_author_meta('display_name', $author_id); ?></a>
                                        </span>
                                    <?php endif;?>
                            <?php if($meta_categories_show):?>
                                <span class="nk-post-category">
                                    <?php esc_html_e('In ', 'khaki'); ?>
                                    <?php $category = get_the_category(); ?>
                                    <?php foreach ($category as $key => $cat_item): ?>
                                        <a href="<?php echo get_category_link($cat_item->cat_ID); ?>"><?php echo esc_html( $cat_item->name ); ?></a>
                                        <?php if ($key != count($category) - 1) echo ', '; ?>
                                    <?php endforeach; ?>
                                </span>
                            <?php endif;?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php get_template_part('template-parts/content', 'post-list-preview'); ?>
                    <div class="nk-gap"></div>
                    <?php if (khaki_get_theme_mod('single_post_date_author_category_show', $acf_meta)): ?>
                        <?php if (khaki_get_theme_mod('single_post_date_author_category_area', $acf_meta) == 'content-after-format'): ?>
                            <div class="nk-post-meta nk-post-meta-top">
                                <div class="nk-post-date">
                                    <?php
                                     if($meta_published_show):
                                        echo get_the_time(esc_html__('F j, Y ', 'khaki'));
                                     endif;
                                    ?>
                                <?php if($meta_author_show):?>
                                    <span class="nk-post-by"><?php esc_html_e('by', 'khaki'); ?>
                                            <?php $author_id = $post->post_author; ?>
                                            <a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo get_the_author_meta('display_name', $author_id); ?></a>
                                    </span>
                                <?php endif; ?>
                            <?php if($meta_categories_show):?>
                                <span class="nk-post-category">
                                    <?php esc_html_e('In ', 'khaki'); ?>
                                    <?php $category = get_the_category(); ?>
                                    <?php foreach ($category as $key => $cat_item): ?>
                                        <a href="<?php echo get_category_link($cat_item->cat_ID); ?>"><?php echo esc_html( $cat_item->name ); ?></a>
                                        <?php if ($key != count($category) - 1) echo ', '; ?>
                                    <?php endforeach; ?>
                                </span>
                            <?php endif;?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="nk-post-text mt-0">
                        <?php the_content(); ?>
                        <div class="clearfix"></div>
                        <?php
                        $defaults = array(
                            'before'           => '<p>' . esc_html__( 'Pages:', 'khaki' ),
                            'after'            => '</p>',
                            'link_before'      => '',
                            'link_after'       => '',
                            'next_or_number'   => 'number',
                            'separator'        => ' ',
                            'nextpagelink'     => esc_html__( 'Next page', 'khaki' ),
                            'previouspagelink' => esc_html__( 'Previous page', 'khaki' ),
                            'pagelink'         => '%',
                            'echo'             => 1
                        );

                        wp_link_pages( $defaults );

                        ?>
                        <!-- START: Post Meta -->
                        <?php khaki_post_tags(khaki_get_theme_mod('single_post_meta_comments_show', $acf_meta), khaki_get_theme_mod('single_post_meta_like_show', $acf_meta), khaki_get_theme_mod('single_post_meta_views_show', $acf_meta)); ?>
                        <!-- END: Post Meta -->
                    </div>
                    <!-- END: Post Text -->

                    <?php
                    // print author bio block using Sociality plugin
                    do_action('sociality-author-bio');
                    ?>

                    <?php
                    if (is_single() && khaki_get_theme_mod('single_' . $post_type . '_adjacent_pagination', $acf_content) && khaki_get_theme_mod('single_' . $post_type . '_adjacent_pagination_style') == 'static'):
                    //output post type pagination
                    get_template_part('/template-parts/pagination', 'static');
                    endif;
                    ?>
                    <!-- START: Comments -->
                    <?php
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>
                </div>
                <!-- END: Post -->

                <div class="nk-gap-4"></div>
                <?php if (khaki_get_theme_mod('single_post_header_show', $acf_header)): ?>
            </div>
        <?php endif; ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
</div>
