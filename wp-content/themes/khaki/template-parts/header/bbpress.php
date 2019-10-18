<!-- START: Header Title -->
<?php $breadcrumbs = khaki_breadcrumbs(esc_attr(khaki_get_theme_mod('bbpress_breadcrumbs_homepage_title')));
global $post;
$acf_header = false;
$background_type = khaki_get_theme_mod('bbpress_header_background_type');
?>
<?php if (khaki_get_theme_mod('bbpress_header_show', false)): ?>
    <?php
//defend additional classes
    $navbarAdditionalClasses = "";
    if (khaki_get_theme_mod('bbpress_header_size', false)) {
        $navbarAdditionalClasses .= " nk-header-title-" . khaki_get_theme_mod('bbpress_header_size', false);
    }
    if (khaki_get_theme_mod('bbpress_header_parallax', false)) {
        $navbarAdditionalClasses .= " nk-header-title-parallax";
    }
    if (khaki_get_theme_mod('bbpress_header_parallax_opacity', false)) {
        $navbarAdditionalClasses .= " nk-header-title-parallax-opacity";
    }
    if (khaki_get_theme_mod('bbpress_header_parallax_blur', false)) {
        $navbarAdditionalClasses .= " nk-header-title-parallax-blur";
    }
    ?>
    <div
        class="nk-header-title<?php if ($navbarAdditionalClasses) echo khaki_sanitize_class($navbarAdditionalClasses); ?>">
        <?php if ('image' == $background_type && khaki_get_theme_mod('bbpress_header_type_image', false)): ?>
            <?php
            $banner_url = '';
            if (khaki_get_theme_mod('bbpress_header_type_image', false) == 'custom') {
                $banner_url = khaki_get_theme_mod('bbpress_header_background_image', false);
            } elseif (khaki_get_theme_mod('bbpress_header_type_image', false) == 'featured') {
                $banner_url = get_post_thumbnail_id($post->ID);
            }
            ?>
            <?php if (isset($banner_url)): ?>
                <div class="bg-image <?php echo esc_attr( 'op-' . khaki_get_theme_mod('bbpress_header_background_image_opacity', true) ) ?>">
                    <?php
                    echo khaki_get_image( $banner_url, 'khaki_1920x1080', false, array(
                        'class' => 'jarallax-img',
                    ) );
                    ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ( 'video' == $background_type ):
            $header_background_video_link = khaki_get_theme_mod( 'bbpress_header_background_video_link' );
            ?>
            <?php if ( $header_background_video_link ): ?>
            <div class="bg-video" data-video="<?php echo esc_url( $header_background_video_link );?>">
                <?php
                $header_background_video_poster_path = khaki_get_theme_mod( 'bbpress_header_background_video_poster' );
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
                    <?php
                    $bbpress_header_back_title=khaki_get_theme_mod('bbpress_header_back_title', false);
                    $bbpress_header_sub_title=khaki_get_theme_mod('bbpress_header_sub_title', false);
                    $bbpress_header_content=khaki_get_theme_mod('bbpress_header_content', false);
                    $bbpress_header_video_link=khaki_get_theme_mod('bbpress_header_video_link', false);
                    ?>
                    <?php if (!empty($bbpress_header_back_title)): ?>
                        <?php
                        $header_back_title_opacity = 'op-' . khaki_get_theme_mod('bbpress_header_back_title_opacity', $acf_header);
                        $header_back_title_padding_bottom = khaki_get_theme_mod('bbpress_header_back_title_padding_bottom', $acf_header);
                        $back_title_class = 'nk-title-back';
                        $back_title_class .= ' text-' . khaki_get_theme_mod('bbpress_header_back_title_align', $acf_header);
                        $back_title_class .= ' ' . $header_back_title_opacity;
                        ?>
                        <h2 class="<?php echo khaki_sanitize_class($back_title_class);?>" style="padding-bottom: <?php echo esc_attr($header_back_title_padding_bottom);?>px;"><?php echo wp_kses_post($bbpress_header_back_title); ?></h2>
                    <?php endif; ?>
                    <?php if (get_the_title() && khaki_get_theme_mod('bbpress_header_show_title', false)): ?>
                        <?php
                        $header_title_padding_bottom = khaki_get_theme_mod('bbpress_header_title_padding_bottom', $acf_header);
                        $header_title_looks_like = khaki_get_theme_mod('bbpress_header_title_looks_like', $acf_header);
                        $header_title_looks_like .= ' nk-title';
                        $header_title_looks_like .= ' text-' . khaki_get_theme_mod('bbpress_header_title_align', $acf_header);
                        ?>
                        <h1 class="<?php echo khaki_sanitize_class(trim($header_title_looks_like));?>" style="padding-bottom: <?php echo esc_attr($header_title_padding_bottom);?>px;"><?php bbp_reply_topic_title();?></h1>
                    <?php endif; ?>
                    <?php if (!empty($bbpress_header_sub_title)): ?>
                        <?php
                        $header_sub_title_padding_bottom = khaki_get_theme_mod('bbpress_header_sub_title_padding_bottom', $acf_header);
                        $sub_title_class = 'nk-sub-title';
                        $sub_title_class .= ' text-' . khaki_get_theme_mod('bbpress_header_sub_title_align', $acf_header);
                        ?>
                        <h2 class="<?php echo khaki_sanitize_class($sub_title_class);?>" style="padding-bottom: <?php echo esc_attr($header_sub_title_padding_bottom);?>px;"><?php echo wp_kses_post(khaki_get_theme_mod('bbpress_header_sub_title', false)); ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($bbpress_header_content)): ?>
                        <?php
                        echo do_shortcode(khaki_get_theme_mod('bbpress_header_content', false));
                        ?>
                    <?php endif; ?>
                    <?php if (!empty($bbpress_header_video_link)): ?>
                        <?php
                        $style_video_icon = 'nk-video-icon';
                        $header_video_style = khaki_get_theme_mod('bbpress_header_video_style', $acf_header);
                        $style_video_icon .= !empty($header_video_style) ? '-'.$header_video_style : '';
                        ?>
                        <a class="nk-video-fullscreen-toggle"
                           href="<?php echo esc_url(khaki_get_theme_mod('bbpress_header_video_link', false)); ?>">
                            <span class="<?php echo khaki_sanitize_class($style_video_icon);?>"><span class="fa fa-play pl-5"></span></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if (khaki_get_theme_mod('bbpress_breadcrumbs_show', false) === 'header' && !empty($breadcrumbs)): ?>
            <?php
            $bbpress_breadcrumbs_background = khaki_get_theme_mod('bbpress_breadcrumbs_background', false);
            $breadcrumbAdditionalClasses = 'nk-header-text-bottom';
            if ($bbpress_breadcrumbs_background === 'white') {
                $breadcrumbAdditionalClasses .= " bg-white text-dark-1";
            }
            if (!$bbpress_breadcrumbs_background) {
                $breadcrumbAdditionalClasses .= " bg-black text-white";
            }
            ?>
            <div class="<?php echo khaki_sanitize_class($breadcrumbAdditionalClasses);?>">
                <?php
                $navbarAdditionalClasses = "";
                if (khaki_get_theme_mod('bbpress_breadcrumbs_side', false)) {
                    $navbarAdditionalClasses .= " text-" . khaki_get_theme_mod('bbpress_breadcrumbs_side', false);
                }else{
                    $navbarAdditionalClasses .= " text-left";
                }
                ?>
                <div class="nk-breadcrumbs<?php if ($navbarAdditionalClasses) echo khaki_sanitize_class($navbarAdditionalClasses); ?>">
                    <?php echo wp_kses( $breadcrumbs, khaki_allowed_html() ); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
<!-- END: Header Title -->

<?php if (khaki_get_theme_mod('bbpress_breadcrumbs_show', false) === 'out_header' && !empty($breadcrumbs)): ?>
    <?php
//defend additional classes
    $navbarAdditionalClasses = "";
    if (khaki_get_theme_mod('bbpress_breadcrumbs_side', false)) {
        $navbarAdditionalClasses .= " text-" . khaki_get_theme_mod('bbpress_breadcrumbs_side', false);
    }

    $bbpress_breadcrumbs_background = khaki_get_theme_mod('bbpress_breadcrumbs_background', false);

    if ($bbpress_breadcrumbs_background === 'white') {
        $navbarAdditionalClasses .= " bg-white text-dark-1";
    }
    if (!$bbpress_breadcrumbs_background) {
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
