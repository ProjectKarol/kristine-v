<!-- START: Header Title -->
<?php $breadcrumbs = khaki_breadcrumbs(esc_attr(khaki_get_theme_mod('search_breadcrumbs_homepage_title', true)));?>
<?php if (khaki_get_theme_mod('search_header_show', true)): ?>
    <?php
//defend additional classes
    $navbarAdditionalClasses = "";
    if (khaki_get_theme_mod('search_header_size', true)) {
        $navbarAdditionalClasses .= " nk-header-title-" . khaki_get_theme_mod('search_header_size', true);
    }
    if (khaki_get_theme_mod('search_header_parallax', true)) {
        $navbarAdditionalClasses .= " nk-header-title-parallax";
    }
    if (khaki_get_theme_mod('search_header_parallax_opacity', true)) {
        $navbarAdditionalClasses .= " nk-header-title-parallax-opacity";
    }
    if (khaki_get_theme_mod('search_header_parallax_blur', false)) {
        $navbarAdditionalClasses .= " nk-header-title-parallax-blur";
    }
    ?>
    <div
        class="nk-header-title<?php if ($navbarAdditionalClasses) echo khaki_sanitize_class($navbarAdditionalClasses); ?>">
        <?php
        $banner_url = khaki_get_theme_mod('search_header_background_image', true);
        $background_type = khaki_get_theme_mod('search_header_background_type');
        ?>
        <?php if ('image' == $background_type && isset( $banner_url )): ?>
            <?php
            ?>
            <div class="bg-image <?php echo esc_attr( 'op-' . khaki_get_theme_mod('search_header_background_image_opacity', $acf_header) ) ?>">
                <?php
                echo khaki_get_image( $banner_url, 'khaki_1920x1080', false, array(
                    'class' => 'jarallax-img',
                ) );
                ?>
            </div>
        <?php endif; ?>
        <?php if ( 'video' == $background_type ):
            $header_background_video_link = khaki_get_theme_mod( 'search_header_background_video_link' );
            ?>
            <?php if ( $header_background_video_link ): ?>
            <div class="bg-video" data-video="<?php echo esc_url( $header_background_video_link );?>">
                <?php
                $header_background_video_poster_path = khaki_get_theme_mod( 'search_header_background_video_poster' );
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
                    $search_header_back_title=khaki_get_theme_mod('search_header_back_title', true);
                    $search_header_sub_title=khaki_get_theme_mod('search_header_sub_title', true);
                    $search_header_content=khaki_get_theme_mod('search_header_content', true);
                    $search_header_video_link=khaki_get_theme_mod('search_header_video_link', true);
                    ?>
                    <?php if (!empty($search_header_back_title)): ?>
                        <?php
                        $header_back_title_opacity = 'op-' . khaki_get_theme_mod('search_header_back_title_opacity');
                        $header_back_title_padding_bottom = khaki_get_theme_mod('search_header_back_title_padding_bottom');
                        $back_title_class = 'nk-title-back';
                        $back_title_class .= ' text-' . khaki_get_theme_mod('search_header_back_title_align');
                        $back_title_class .= ' ' . $header_back_title_opacity;
                        ?>
                        <h2 class="<?php echo khaki_sanitize_class($back_title_class);?>" style="padding-bottom: <?php echo esc_attr($header_back_title_padding_bottom);?>px;"><?php echo wp_kses_post($search_header_back_title); ?></h2>
                    <?php endif; ?>

                    <?php if (khaki_get_theme_mod('search_header_show_title', true)): ?>
                        <?php
                        $header_title_padding_bottom = khaki_get_theme_mod('search_header_title_padding_bottom');
                        $header_title_looks_like = khaki_get_theme_mod('search_header_title_looks_like');
                        $header_title_looks_like .= ' nk-title';
                        $header_title_looks_like .= ' text-' . khaki_get_theme_mod('search_header_title_align');
                        ?>
                        <?php echo '<h1 class="'.khaki_sanitize_class(trim($header_title_looks_like)).'" style="padding-bottom:'.esc_attr($header_title_padding_bottom).' px;">'; printf(esc_html__('Search Results for: "%s" Query', 'khaki'), get_search_query()); echo '</h1>';?>
                    <?php endif; ?>

                    <?php if (!empty($search_header_sub_title)): ?>
                        <?php
                        $header_sub_title_padding_bottom = khaki_get_theme_mod('search_header_sub_title_padding_bottom');
                        $sub_title_class = 'nk-sub-title';
                        $sub_title_class .= ' text-' . khaki_get_theme_mod('search_header_sub_title_align');
                        ?>
                        <h2 class="<?php echo khaki_sanitize_class($sub_title_class);?>" style="padding-bottom: <?php echo esc_attr($header_sub_title_padding_bottom);?>px;"><?php echo wp_kses_post($search_header_sub_title); ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($search_header_content)): ?>
                        <?php
                        echo do_shortcode(khaki_get_theme_mod('search_header_content', true));
                        ?>
                    <?php endif; ?>
                    <?php if (!empty($search_header_video_link)): ?>
                        <?php
                        $style_video_icon = 'nk-video-icon';
                        $header_video_style = khaki_get_theme_mod('search_header_video_style');
                        $style_video_icon .= !empty($header_video_style) ? '-'.$header_video_style : '';
                        ?>
                        <a class="nk-video-fullscreen-toggle"
                           href="<?php echo esc_url(khaki_get_theme_mod('search_header_video_link', true)); ?>">
                            <span class="<?php echo khaki_sanitize_class($style_video_icon);?>"><span class="fa fa-play pl-5"></span></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if (khaki_get_theme_mod('search_breadcrumbs_show', true) === 'header' && !empty($breadcrumbs)): ?>
            <?php
            $search_breadcrumbs_background = khaki_get_theme_mod('search_breadcrumbs_background', true);
            $breadcrumbAdditionalClasses = 'nk-header-text-bottom';
            if ($search_breadcrumbs_background === 'white') {
                $breadcrumbAdditionalClasses .= " bg-white text-dark-1";
            }
            if (!$search_breadcrumbs_background) {
                $breadcrumbAdditionalClasses .= " bg-black text-white";
            }
            ?>
            <div class="<?php echo khaki_sanitize_class($breadcrumbAdditionalClasses);?>">
                <?php
                $navbarAdditionalClasses = "";
                if (khaki_get_theme_mod('search_breadcrumbs_side', true)) {
                    $navbarAdditionalClasses .= " text-" . khaki_get_theme_mod('search_breadcrumbs_side', true);
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
<?php if (khaki_get_theme_mod('search_breadcrumbs_show', true) === 'out_header' && !empty($breadcrumbs)): ?>
    <?php
//defend additional classes
    $navbarAdditionalClasses = "";
    if (khaki_get_theme_mod('search_breadcrumbs_side', true)) {
        $navbarAdditionalClasses .= " text-" . khaki_get_theme_mod('search_breadcrumbs_side', true);
    }

    $search_breadcrumbs_background = khaki_get_theme_mod('search_breadcrumbs_background', true);

    if ($search_breadcrumbs_background === 'white') {
        $navbarAdditionalClasses .= " bg-white text-dark-1";
    }
    if (!$search_breadcrumbs_background) {
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
