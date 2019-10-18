<!-- START: Header Title -->
<?php
//use acf settings (return true or null)
$acf_header = khaki_get_theme_mod('woocommerce_header_custom', true);
$acf_breadcrumbs = khaki_get_theme_mod('woocommerce_breadcrumbs_custom', true);
$acf_content = khaki_get_theme_mod('content_woocommerce_custom', true);
$background_type = khaki_get_theme_mod('woocommerce_header_background_type', $acf_header);
global $post;
?>
<?php $breadcrumbs = khaki_breadcrumbs(esc_attr(khaki_get_theme_mod('woocommerce_breadcrumbs_homepage_title', $acf_breadcrumbs))); ?>
<?php if (khaki_get_theme_mod('woocommerce_header_show', $acf_header)): ?>
    <?php
//defend additional classes
    $navbarAdditionalClasses = "";
    if (khaki_get_theme_mod('woocommerce_header_size', $acf_header)) {
        $navbarAdditionalClasses .= " nk-header-title-" . khaki_get_theme_mod('woocommerce_header_size', $acf_header);
    }
    if (khaki_get_theme_mod('woocommerce_header_parallax', $acf_header)) {
        $navbarAdditionalClasses .= " nk-header-title-parallax";
    }
    if (khaki_get_theme_mod('woocommerce_header_parallax_opacity', $acf_header)) {
        $navbarAdditionalClasses .= " nk-header-title-parallax-opacity";
    }
    if (khaki_get_theme_mod('woocommerce_header_boxed', $acf_header)) {
        $navbarAdditionalClasses .= " nk-header-title-boxed";
    }
    if (khaki_get_theme_mod('woocommerce_header_parallax_blur', $acf_header)) {
        $navbarAdditionalClasses .= " nk-header-title-parallax-blur";
    }
    ?>
    <div
        class="nk-header-title<?php if ($navbarAdditionalClasses) echo khaki_sanitize_class($navbarAdditionalClasses); ?>">
        <?php if ('image' == $background_type && khaki_get_theme_mod('woocommerce_header_type_image', $acf_header)): ?>
            <?php
            $banner_url = '';
            if (khaki_get_theme_mod('woocommerce_header_type_image', $acf_header) == 'custom') {
                $banner_url = khaki_get_theme_mod('woocommerce_header_background_image', $acf_header);
            } elseif (khaki_get_theme_mod('woocommerce_header_type_image', $acf_header) == 'featured' && !is_shop() && !is_product_category()) {
                $banner_url = get_post_thumbnail_id($post->ID);
            } elseif(is_shop() || is_product_category()){
                $banner_url = khaki_get_theme_mod('woocommerce_header_archive_background_image', $acf_header);
            }
            ?>
            <?php if (isset($banner_url)): ?>
                <div class="bg-image <?php echo esc_attr( 'op-' . khaki_get_theme_mod('woocommerce_header_background_image_opacity', $acf_header) ) ?>">
                    <?php
                    echo khaki_get_image( $banner_url, 'khaki_1920x1080', false, array(
                        'class' => 'jarallax-img',
                    ) );
                    ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ( 'video' == $background_type ):
            $header_background_video_link = khaki_get_theme_mod( 'woocommerce_header_background_video_link', $acf_header );
            ?>
            <?php if ( $header_background_video_link ): ?>
            <div class="bg-video" data-video="<?php echo esc_url( $header_background_video_link );?>">
                <?php
                $header_background_video_poster_path = khaki_get_theme_mod( 'woocommerce_header_background_video_poster', $acf_header );
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
                    $woocommerce_header_back_title = khaki_get_theme_mod('woocommerce_header_back_title', $acf_header);
                    $woocommerce_header_sub_title = khaki_get_theme_mod('woocommerce_header_sub_title', $acf_header);
                    $woocommerce_header_content = khaki_get_theme_mod('woocommerce_header_content', $acf_header);
                    $woocommerce_header_video_link = khaki_get_theme_mod('woocommerce_header_video_link', $acf_header);
                    ?>
                    <?php if (!empty($woocommerce_header_back_title)): ?>
                        <?php
                        $header_back_title_opacity = 'op-' . khaki_get_theme_mod('woocommerce_header_back_title_opacity', $acf_header);
                        $header_back_title_padding_bottom = khaki_get_theme_mod('woocommerce_header_back_title_padding_bottom', $acf_header);
                        $back_title_class = 'nk-title-back';
                        $back_title_class .= ' text-' . khaki_get_theme_mod('woocommerce_header_back_title_align', $acf_header);
                        $back_title_class .= ' ' . $header_back_title_opacity;
                        ?>
                        <h2 class="<?php echo khaki_sanitize_class($back_title_class);?>" style="padding-bottom: <?php echo esc_attr($header_back_title_padding_bottom);?>px;"><?php echo wp_kses_post($woocommerce_header_back_title); ?></h2>
                    <?php endif; ?>
                    <?php if (khaki_get_theme_mod('woocommerce_header_show_title', $acf_content)): ?>
                        <?php
                        $header_title_padding_bottom = khaki_get_theme_mod('woocommerce_header_title_padding_bottom', $acf_header);
                        $header_title_looks_like = khaki_get_theme_mod('woocommerce_header_title_looks_like', $acf_header);
                        $header_title_looks_like .= ' nk-title';
                        $header_title_looks_like .= ' text-' . khaki_get_theme_mod('woocommerce_header_title_align', $acf_header);
                        ?>
                        <h1 class="<?php echo khaki_sanitize_class(trim($header_title_looks_like));?>" style="padding-bottom: <?php echo esc_attr($header_title_padding_bottom);?>px;">
                            <?php
                            $custom_title = khaki_get_theme_mod('woocommerce_header_custom_title', $acf_header);
                            if(is_post_type_archive() || is_search() || is_tax()){
                                woocommerce_page_title();
                            }elseif($custom_title){
                                echo wp_kses_post($custom_title);
                            }else{
                                echo get_the_title();
                            } ?>
                        </h1>
                    <?php endif; ?>
                    <?php if (!empty($woocommerce_header_sub_title)): ?>
                        <?php
                        $header_sub_title_padding_bottom = khaki_get_theme_mod('woocommerce_header_sub_title_padding_bottom', $acf_header);
                        $sub_title_class = 'nk-sub-title';
                        $sub_title_class .= ' text-' . khaki_get_theme_mod('woocommerce_header_sub_title_align', $acf_header);
                        ?>
                        <h2 class="<?php echo khaki_sanitize_class($sub_title_class);?>" style="padding-bottom: <?php echo esc_attr($header_sub_title_padding_bottom);?>px;"><?php echo wp_kses_post(khaki_get_theme_mod('woocommerce_header_sub_title', $acf_header)); ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($woocommerce_header_content)): ?>
                        <?php
                        echo do_shortcode(khaki_get_theme_mod('woocommerce_header_content', $acf_header));
                        ?>
                    <?php endif; ?>
                    <?php if (!empty($woocommerce_header_video_link)): ?>
                        <?php
                        $style_video_icon = 'nk-video-icon';
                        $header_video_style = khaki_get_theme_mod('woocommerce_header_video_style', $acf_header);
                        $style_video_icon .= !empty($header_video_style) ? '-'.$header_video_style : '';
                        ?>
                        <div class="nk-gap-2"></div>
                        <a class="nk-video-fullscreen-toggle"
                           href="<?php echo esc_url(khaki_get_theme_mod('woocommerce_header_video_link', $acf_header)); ?>">
                            <span class="<?php echo khaki_sanitize_class($style_video_icon);?>"><span class="fa fa-play pl-5"></span></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if (khaki_get_theme_mod('woocommerce_breadcrumbs_show', $acf_breadcrumbs) === 'header' && !empty($breadcrumbs)): ?>
            <?php
            $woocommerce_breadcrumbs_background = khaki_get_theme_mod('woocommerce_breadcrumbs_background', $acf_breadcrumbs);
            $breadcrumbAdditionalClasses = 'nk-header-text-bottom';
            if ($woocommerce_breadcrumbs_background === 'white') {
                $breadcrumbAdditionalClasses .= " bg-white text-dark-1";
            }
            if (!$woocommerce_breadcrumbs_background) {
                $breadcrumbAdditionalClasses .= " bg-black text-white";
            }
            ?>
            <div class="<?php echo khaki_sanitize_class($breadcrumbAdditionalClasses);?>">
                <?php
                $navbarAdditionalClasses = "";
                if (khaki_get_theme_mod('woocommerce_breadcrumbs_side', $acf_breadcrumbs)) {
                    $navbarAdditionalClasses .= " text-" . khaki_get_theme_mod('woocommerce_breadcrumbs_side', $acf_breadcrumbs);
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
<?php endif; ?>
<!-- END: Header Title -->

<?php if (khaki_get_theme_mod('woocommerce_breadcrumbs_show', $acf_breadcrumbs) === 'out_header' && !empty($breadcrumbs)): ?>
    <?php
//defend additional classes
    $navbarAdditionalClasses = "";
    if (khaki_get_theme_mod('woocommerce_breadcrumbs_side', $acf_breadcrumbs)) {
        $navbarAdditionalClasses .= " text-" . khaki_get_theme_mod('woocommerce_breadcrumbs_side', $acf_breadcrumbs);
    }
    $woocommerce_breadcrumbs_background = khaki_get_theme_mod('woocommerce_breadcrumbs_background', $acf_breadcrumbs);
    if ($woocommerce_breadcrumbs_background === 'white') {
        $navbarAdditionalClasses .= " bg-white text-dark-1";
    }
    if (!$woocommerce_breadcrumbs_background) {
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
