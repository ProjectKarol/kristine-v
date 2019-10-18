<!-- START: Header Title -->
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
$acf_breadcrumbs = khaki_get_theme_mod('post_breadcrumbs_custom', true);

$meta_published_show = khaki_get_theme_mod('single_post_meta_published_show', $acf_meta);
$meta_categories_show = khaki_get_theme_mod('single_post_meta_categories_show', $acf_meta);
$meta_author_show = khaki_get_theme_mod('single_post_meta_author_show', $acf_meta);
$breadcrumbs = khaki_breadcrumbs(esc_attr(khaki_get_theme_mod('single_post_breadcrumbs_homepage_title', $acf_breadcrumbs)));
$custom_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_list', $acf_sidebar);
$show_custom_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_show', $acf_sidebar);
$custom_sidebar_side = khaki_get_theme_mod('sidebar_' . $post_type . '_side', $acf_sidebar);
$background_type = khaki_get_theme_mod('single_post_header_background_type', $acf_header);

if (khaki_get_theme_mod('single_post_header_show', $acf_header)): ?>
    <?php
//defend additional classes
    $navbarAdditionalClasses = "";
    if (khaki_get_theme_mod('single_post_header_size', $acf_header)) {
        $navbarAdditionalClasses .= " nk-header-title-" . khaki_get_theme_mod('single_post_header_size', $acf_header);
    }
    if (khaki_get_theme_mod('single_post_header_parallax', $acf_header)) {
        $navbarAdditionalClasses .= " nk-header-title-parallax";
    }
    if (khaki_get_theme_mod('single_post_header_parallax_opacity', $acf_header)) {
        $navbarAdditionalClasses .= " nk-header-title-parallax-opacity";
    }
    if (khaki_get_theme_mod('single_post_header_parallax_blur', $acf_header)) {
        $navbarAdditionalClasses .= " nk-header-title-parallax-blur";
    }
    ?>
    <div
        class="nk-header-title<?php if ($navbarAdditionalClasses) echo khaki_sanitize_class($navbarAdditionalClasses); ?>">
        <?php if ( 'image' == $background_type && khaki_get_theme_mod( 'single_post_header_type_image', $acf_header ) ): ?>
            <?php
            $banner_url = '';
            if (khaki_get_theme_mod('single_post_header_type_image', $acf_header) == 'custom') {
                $banner_url = khaki_get_theme_mod('single_post_header_background_image', $acf_header);
            } elseif (khaki_get_theme_mod('single_post_header_type_image', $acf_header) == 'featured') {
                $banner_url = get_post_thumbnail_id(get_the_ID());
            }
            ?>
            <?php if (isset($banner_url)): ?>
                <div class="bg-image <?php echo esc_attr( 'op-' . khaki_get_theme_mod('single_post_header_background_image_opacity', $acf_header) ) ?>">
                    <?php
                    echo khaki_get_image( $banner_url, 'khaki_1920x1080', false, array(
                        'class' => 'jarallax-img',
                    ) );
                    ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ( 'video' == $background_type ):
            $header_background_video_link = khaki_get_theme_mod( 'single_post_header_background_video_link', $acf_header );
            ?>
            <?php if ( $header_background_video_link ): ?>
            <div class="bg-video" data-video="<?php echo esc_url( $header_background_video_link );?>">
                <?php
                $header_background_video_poster_path = khaki_get_theme_mod( 'single_post_header_background_video_poster', $acf_header );
                if ( $header_background_video_poster_path ) {
                    echo khaki_get_image( $header_background_video_poster_path , 'khaki_1920x1080', false, array( 'class' => 'jarallax-img' ) );
                }
                ?>
            </div>
            <?php endif; ?>
        <?php endif; ?>
        <div class="nk-header-table">
            <div class="nk-header-table-cell">
                <div class="container">
                    <?php if (khaki_get_theme_mod('single_post_header_show_title', $acf_header)): ?>
                        <?php
                        $header_title_padding_bottom = khaki_get_theme_mod('single_post_header_title_padding_bottom', $acf_header);
                        $header_title_looks_like = khaki_get_theme_mod('single_post_header_title_looks_like', $acf_header);
                        $header_title_looks_like .= ' nk-title';
                        $header_title_looks_like .= ' text-' . khaki_get_theme_mod('single_post_header_title_align', $acf_header);
                        ?>
                    <h1 class="<?php echo khaki_sanitize_class(trim($header_title_looks_like));?>" style="padding-bottom: <?php echo esc_attr($header_title_padding_bottom);?>px;">
                        <?php
                        $custom_title = khaki_get_theme_mod('single_post_header_custom_title', $acf_header);
                        echo $custom_title ? wp_kses_post($custom_title) : get_the_title();
                        ?>
                    </h1>
                    <?php endif; ?>
                    <?php if (khaki_get_theme_mod('single_post_date_author_category_show', $acf_meta)): ?>
                        <?php if (khaki_get_theme_mod('single_post_date_author_category_area', $acf_meta) == 'header-middle'): ?>
                            <div class="nk-header-text">
                                <div class="nk-post-date">
                                    <?php
                                    if($meta_published_show):
                                        $time_string = get_the_time(esc_html__('F j, Y ', 'khaki'));
                                        echo esc_html( $time_string );
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
                            <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    <?php if (khaki_get_theme_mod('single_post_date_author_category_show', $acf_meta)): ?>
        <?php if (khaki_get_theme_mod('single_post_date_author_category_area', $acf_meta) == 'header-bottom'): ?>
        <div class="nk-header-text-bottom">
            <div class="nk-post-date">
                <?php
                if($meta_published_show):
                    $time_string = get_the_time(esc_html__('F j, Y ', 'khaki'));
                    echo esc_html( $time_string );
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
                    <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    <?php endif; ?>
        <?php if (khaki_get_theme_mod('single_post_breadcrumbs_show', $acf_breadcrumbs) === 'header' && !empty($breadcrumbs)): ?>
            <?php
            $single_post_breadcrumbs_background = khaki_get_theme_mod('single_post_breadcrumbs_background', $acf_breadcrumbs);
            $breadcrumbAdditionalClasses = 'nk-header-text-bottom';
            if ($single_post_breadcrumbs_background === 'white') {
                $breadcrumbAdditionalClasses .= " bg-white text-dark-1";
            }
            if (!$single_post_breadcrumbs_background) {
                $breadcrumbAdditionalClasses .= " bg-black text-white";
            }
            ?>
            <div class="<?php echo khaki_sanitize_class($breadcrumbAdditionalClasses);?>">
                <?php
                $navbarAdditionalClasses = "";
                if (khaki_get_theme_mod('single_post_breadcrumbs_side', $acf_breadcrumbs)) {
                    $navbarAdditionalClasses .= " text-" . khaki_get_theme_mod('single_post_breadcrumbs_side', $acf_breadcrumbs);
                } else {
                    $navbarAdditionalClasses .= " text-left";
                }
                ?>
                <div
                    class="nk-breadcrumbs<?php if ($navbarAdditionalClasses) echo khaki_sanitize_class($navbarAdditionalClasses); ?>">
                    <?php echo wp_kses( $breadcrumbs, khaki_allowed_html() ); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <!-- END: Header Title -->
<?php endif; ?>

<?php if (khaki_get_theme_mod('single_post_breadcrumbs_show', $acf_breadcrumbs) === 'out_header' && !empty($breadcrumbs)): ?>
    <?php
//defend additional classes
    $navbarAdditionalClasses = "";
    if (khaki_get_theme_mod('single_post_breadcrumbs_side', $acf_breadcrumbs)) {
        $navbarAdditionalClasses .= " text-" . khaki_get_theme_mod('single_post_breadcrumbs_side', $acf_breadcrumbs);
    }

    $single_post_breadcrumbs_background = khaki_get_theme_mod('single_post_breadcrumbs_background', $acf_breadcrumbs);

    if ($single_post_breadcrumbs_background === 'white') {
        $navbarAdditionalClasses .= " bg-white text-dark-1";
    }
    if (!$single_post_breadcrumbs_background) {
        $navbarAdditionalClasses .= " bg-black text-white";
    }
    ?>
    <div class="nk-breadcrumbs<?php if ($navbarAdditionalClasses) echo khaki_sanitize_class($navbarAdditionalClasses); ?>">
        <div class="container">
            <ul>
                <?php echo wp_kses( $breadcrumbs, khaki_allowed_html() ); ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
