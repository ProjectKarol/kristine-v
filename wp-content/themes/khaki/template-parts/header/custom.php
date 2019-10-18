<!-- START: Header Title -->
<?php
global $post;
//use acf settings (return true or null)
$post_type = get_post_type();
if (is_archive()) {
    $acf_header = false;
    $acf_breadcrumbs = false;
    $acf_content = false;
    $acf_meta = false;
    $title = get_the_archive_title();
} elseif (is_single()) {
    $acf_header = khaki_get_theme_mod($post_type . '_header_custom', true);
    $acf_breadcrumbs = khaki_get_theme_mod($post_type . '_breadcrumbs_custom', true);
    $acf_content = khaki_get_theme_mod('content_' . $post_type . '_custom', true);
    $acf_meta = khaki_get_theme_mod($post_type . '_meta_custom', true);
    $title = get_the_title($post->ID);
}
$background_type = khaki_get_theme_mod($post_type . '_header_background_type', $acf_header);
?>
<?php $breadcrumbs = khaki_breadcrumbs(esc_attr(khaki_get_theme_mod($post_type . '_breadcrumbs_homepage_title', $acf_breadcrumbs))); ?>
<?php if (khaki_get_theme_mod($post_type . '_header_show', $acf_header)): ?>
    <?php
//defend additional classes
    $navbarAdditionalClasses = "";
    if (khaki_get_theme_mod($post_type . '_header_size', $acf_header)) {
        $navbarAdditionalClasses .= " nk-header-title-" . khaki_get_theme_mod($post_type . '_header_size', $acf_header);
    }
    if (khaki_get_theme_mod($post_type . '_header_parallax', $acf_header)) {
        $navbarAdditionalClasses .= " nk-header-title-parallax";
    }
    if (khaki_get_theme_mod($post_type . '_header_parallax_opacity', $acf_header)) {
        $navbarAdditionalClasses .= " nk-header-title-parallax-opacity";
    }
    if (khaki_get_theme_mod($post_type . '_header_parallax_blur', $acf_header)) {
        $navbarAdditionalClasses .= " nk-header-title-parallax-blur";
    }
    ?>
    <div
        class="nk-header-title<?php if ($navbarAdditionalClasses) echo khaki_sanitize_class($navbarAdditionalClasses); ?>">
        <?php if ( 'image' == $background_type && false != khaki_get_theme_mod($post_type . '_header_type_image', $acf_header)): ?>
            <?php
            $banner_url = '';
            if (is_archive()){
                $banner_url = khaki_get_theme_mod($post_type . '_header_archive_background_image');
            } elseif (khaki_get_theme_mod($post_type . '_header_type_image', $acf_header) == 'custom') {
                $banner_url = khaki_get_theme_mod($post_type . '_header_background_image', $acf_header);
            } elseif (khaki_get_theme_mod($post_type . '_header_type_image', $acf_header) == 'featured') {
                $banner_url = get_post_thumbnail_id($post->ID);
            }
            ?>
            <?php if (isset($banner_url)): ?>
                <div class="bg-image <?php echo esc_attr( 'op-' . khaki_get_theme_mod($post_type . '_header_background_image_opacity', $acf_header) ) ?>">
                    <?php
                    echo khaki_get_image( $banner_url, 'khaki_1920x1080', false, array(
                        'class' => 'jarallax-img',
                    ) );
                    ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ( 'video' == $background_type ):
            $header_background_video_link = khaki_get_theme_mod( $post_type . '_header_background_video_link', $acf_header );
            ?>
            <?php if ( $header_background_video_link ): ?>
            <div class="bg-video" data-video="<?php echo esc_url( $header_background_video_link );?>">
                <?php
                $header_background_video_poster_path = khaki_get_theme_mod( $post_type . '_header_background_video_poster', $acf_header );
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
                    $custom_header_back_title = khaki_get_theme_mod($post_type . '_header_back_title', $acf_header);
                    $custom_header_sub_title = khaki_get_theme_mod($post_type . '_header_sub_title', $acf_header);
                    $custom_header_content = khaki_get_theme_mod($post_type . '_header_content', $acf_header);
                    $custom_header_video_link = khaki_get_theme_mod($post_type . '_header_video_link', $acf_header);
                    ?>
                    <?php if (!empty($custom_header_back_title)): ?>
                        <?php
                        $header_back_title_opacity = 'op-' . khaki_get_theme_mod($post_type . '_header_back_title_opacity', $acf_header);
                        $header_back_title_padding_bottom = khaki_get_theme_mod($post_type . '_header_back_title_padding_bottom', $acf_header);
                        $back_title_class = 'nk-title-back';
                        $back_title_class .= ' text-' . khaki_get_theme_mod($post_type . '_header_back_title_align', $acf_header);
                        $back_title_class .= ' ' . $header_back_title_opacity;
                        ?>
                        <h2 class="<?php echo khaki_sanitize_class($back_title_class);?>" style="padding-bottom: <?php echo esc_attr($header_back_title_padding_bottom);?>px;"><?php echo wp_kses_post($custom_header_back_title); ?></h2>
                    <?php endif; ?>
                    <?php if (khaki_get_theme_mod($post_type . '_header_show_title', $acf_header)): ?>
                        <?php
                        $header_title_padding_bottom = khaki_get_theme_mod($post_type . '_header_title_padding_bottom', $acf_header);
                        $header_title_looks_like = khaki_get_theme_mod($post_type . '_header_title_looks_like', $acf_header);
                        $header_title_looks_like .= ' nk-title';
                        $header_title_looks_like .= ' text-' . khaki_get_theme_mod($post_type . '_header_title_align', $acf_header);
                        ?>
                        <h1 class="<?php echo khaki_sanitize_class(trim($header_title_looks_like));?>" style="padding-bottom: <?php echo esc_attr($header_title_padding_bottom);?>px;">
                            <?php
                            $custom_title = khaki_get_theme_mod($post_type . '_header_custom_title', $acf_header);
                            if (is_archive()){
                                $custom_title = khaki_get_theme_mod($post_type . '_header_archive_custom_title');
                            }
                            echo $custom_title ? wp_kses_post( $custom_title ) : esc_html( $title );
                            ?>
                        </h1>
                    <?php endif; ?>
                    <?php if (!empty($custom_header_sub_title)): ?>
                        <?php
                        $header_sub_title_padding_bottom = khaki_get_theme_mod($post_type . '_header_sub_title_padding_bottom', $acf_header);
                        $sub_title_class = 'nk-sub-title';
                        $sub_title_class .= ' text-' . khaki_get_theme_mod($post_type . '_header_sub_title_align', $acf_header);
                        ?>
                        <h2 class="<?php echo khaki_sanitize_class($sub_title_class);?>" style="padding-bottom: <?php echo esc_attr($header_sub_title_padding_bottom);?>px;"><?php echo wp_kses_post($custom_header_sub_title); ?></h2>
                    <?php endif; ?>
                    <?php if (is_single() && $post_type == 'event'): ?>
                        <?php
                        $status_sales = khaki_get_theme_mod('event_status_sales', true);
                        $product_type = khaki_get_theme_mod('event_product_type', true);
                        $container_buy_class = 'nk-event-button';
                        $container_buy = '';
                        switch ($status_sales) {
                            case 'sold_out':
                                $container_buy_class .= ' nk-event-button-sold';
                                $container_buy = esc_html__('Sold Out', 'khaki');
                                break;
                            case 'buy':
                                $purchase_link = khaki_get_theme_mod('event_link_to_purchase', true);
                                if (isset($purchase_link) && !empty($purchase_link)) {
                                    $container_buy = '<div class="nk-gap"></div>
                                <a href="' . esc_url($purchase_link) . '"
                                   class="nk-btn nk-btn-sm nk-btn-effect-2-right nk-btn-outline nk-btn-color-white nk-btn-circle">
                                    <span>' . esc_html__('Buy', 'khaki') . ' ' . esc_html($product_type) . '</span>
                                    <span class="icon"><span class="fa fa-ticket"></span></span>
                                </a>';
                                }
                                break;
                            case 'buy_on_date':
                                $current_time = current_time(esc_html__('j F Y', 'khaki'));
                                $date_purchase = khaki_get_theme_mod('event_date_purchase', true);
                                if (strtotime($current_time) >= strtotime($date_purchase)) {
                                    $purchase_link = khaki_get_theme_mod('event_link_to_purchase', true);
                                    if (isset($purchase_link) && !empty($purchase_link)) {
                                        $container_buy = '<div class="nk-gap"></div>
                                <a href="' . esc_url($purchase_link) . '"
                                   class="nk-btn nk-btn-sm nk-btn-effect-2-right nk-btn-outline nk-btn-color-white nk-btn-circle">
                                    <span>' . esc_html__('Buy', 'khaki') . ' ' . esc_html($product_type) . '</span>
                                    <span class="icon"><span class="fa fa-ticket"></span></span>
                                </a>';
                                    }
                                    break;
                                } else {
                                    $date_purchase = date('j F', strtotime($date_purchase));
                                    if (isset($date_purchase) && !empty($date_purchase)) {
                                        $container_buy = esc_html__('Buy on', 'khaki') . ' ' . esc_html($date_purchase);
                                    }
                                }
                                break;
                        }
                        ?>
                        <div class="nk-header-text">
                            <?php echo wp_kses( $container_buy, khaki_allowed_html() ); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($custom_header_content)): ?>
                        <?php if ((single_post_title(null, false) && khaki_get_theme_mod($post_type . '_show_title', $acf_content)) || !empty($custom_header_sub_title)): ?>
                            <div class="nk-gap-2"></div>
                        <?php endif; ?>
                        <?php
                        echo do_shortcode(khaki_get_theme_mod($post_type . '_header_content', $acf_header));
                        ?>
                    <?php endif; ?>
                    <?php if (!empty($custom_header_video_link)): ?>
                        <?php
                        $style_video_icon = 'nk-video-icon';
                        $header_video_style = khaki_get_theme_mod($post_type . '_header_video_style', $acf_header);
                        $style_video_icon .= !empty($header_video_style) ? '-'.$header_video_style : '';
                        ?>
                        <div class="nk-gap-2"></div>
                        <a class="nk-video-fullscreen-toggle"
                           href="<?php echo esc_url(khaki_get_theme_mod($post_type . '_header_video_link', $acf_header)); ?>">
                            <span class="<?php echo khaki_sanitize_class($style_video_icon);?>"><span class="fa fa-play pl-5"></span></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if (khaki_get_theme_mod($post_type . '_show_meta', $acf_meta) && is_single() && khaki_get_theme_mod($post_type . '_position_meta', $acf_meta) == 'header'): ?>
                <?php get_template_part('/template-parts/' . $post_type . '/' . $post_type . '-meta'); ?>
        <?php endif; ?>
        <?php if (khaki_get_theme_mod($post_type . '_breadcrumbs_show', $acf_breadcrumbs) === 'header' && !empty($breadcrumbs)): ?>
            <?php
            $breadcrumbs_background = khaki_get_theme_mod($post_type . '_breadcrumbs_background', $acf_breadcrumbs);
            $breadcrumbAdditionalClasses = 'nk-header-text-bottom';
            if ($breadcrumbs_background === 'white') {
                $breadcrumbAdditionalClasses .= " bg-white text-dark-1";
            }
            if (!$breadcrumbs_background) {
                $breadcrumbAdditionalClasses .= " bg-black text-white";
            }
            ?>
            <div class="<?php echo khaki_sanitize_class($breadcrumbAdditionalClasses);?>">
                <?php
                $navbarAdditionalClasses = "";
                if (khaki_get_theme_mod($post_type . '_breadcrumbs_side', $acf_breadcrumbs)) {
                    $navbarAdditionalClasses .= " text-" . khaki_get_theme_mod($post_type . '_breadcrumbs_side', $acf_breadcrumbs);
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

<?php if (khaki_get_theme_mod($post_type . '_breadcrumbs_show', $acf_breadcrumbs) === 'out_header' && !empty($breadcrumbs)): ?>
    <?php
//defend additional classes
    $navbarAdditionalClasses = "";
    if (khaki_get_theme_mod($post_type . '_breadcrumbs_side', $acf_breadcrumbs)) {
        $navbarAdditionalClasses .= " text-" . khaki_get_theme_mod($post_type . '_breadcrumbs_side', $acf_breadcrumbs);
    }

    $breadcrumbs_background = khaki_get_theme_mod($post_type . '_breadcrumbs_background', $acf_breadcrumbs);

    if ($breadcrumbs_background === 'white') {
        $navbarAdditionalClasses .= " bg-white text-dark-1";
    }
    if (!$breadcrumbs_background) {
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
