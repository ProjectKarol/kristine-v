<?php
/**
 * Add and initialization custom post types
 * Work if you activate nk Themes Helper plugin
 * @package khaki
 */
if(function_exists('nk_theme') && class_exists('NK_Helper_Custom_Post_Type')){
    $portfolios = nk_theme()->custom_post_type('portfolio',array(
        'supports' => array('title', 'editor', 'thumbnail', 'comments')
    ));
    // create a portfolio category taxonomy
    $portfolios->register_taxonomy('portfolio-category');
    // use "portfolio" icon for post type
    $portfolios->menu_icon("dashicons-portfolio");

    $events = nk_theme()->custom_post_type('event',array(
        'supports' => array('title', 'editor', 'thumbnail')
    ));
    $events->menu_icon("dashicons-calendar-alt");

    $playlist = nk_theme()->custom_post_type('playlist',array(
        'supports' => array('title', 'editor', 'thumbnail')
    ));
    $playlist->menu_icon('dashicons-playlist-audio');

    if(!function_exists('khaki_portfolio_list_element')){
        function khaki_portfolio_list_element($style, $preview_description_type = 'false', $preview_description_trim_cnt = 15, $show_date = true){
            $result = '';
            $attachment = (khaki_get_attachment(get_post_thumbnail_id(get_the_ID())));
            $image_path = $attachment['src'] ? $attachment['src'] : khaki_get_theme_mod('portfolio_no_image');
            $title = get_the_title();
            $post_detail_url = get_permalink();
            $date = get_the_time(esc_html__('F j, Y ', 'khaki'));
            $description = '';
            if ($preview_description_type == 'excerpt' && $preview_description_trim_cnt > 0) {
                $description = khaki_excerpt_max_charlength($preview_description_trim_cnt, true);
            } elseif ($preview_description_type == 'more') {
                $description = get_the_content();
            }
            $button_title = esc_html__('More Info', 'khaki');
            if($style == 'list'){
                $result = '
                <div class="row no-gutters">
                    <div class="col-md-6 col-lg-8">
                        <div class="nk-image-box-1">
                            <a href="'.esc_url($post_detail_url).'" class="nk-image-box-link"></a>
                            <img class="nk-portfolio-image" src="'.esc_url($image_path).'"
                                 alt="'.esc_attr($title).'">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="nk-box-2">
                            <h2 class="h3"><a href="'.esc_url($post_detail_url).'" class="nk-portfolio-title">'.esc_html($title).'</a>
                            </h2>';
                if($show_date){
                    $result .= '<div class="nk-portfolio-links">'.esc_html($date).'</div>';
                }
                $result .= '<div class="nk-gap"></div>
                            <p>'.esc_html($description).'</p>
                            <div class="nk-gap"></div>
                            <a href="'.esc_url($post_detail_url).'"
                               class="nk-btn nk-btn-sm nk-btn-effect-2-right nk-btn-circle nk-btn-outline nk-btn-color-dark-4">
                                <span>'.$button_title.'</span>
                                <span class="icon"><span class="ion-ios-arrow-forward"></span></span>
                            </a>
                        </div>
                    </div>
                </div>';
            } elseif($style == 'list_2'){
                $result = '
                    <div class="nk-image-box-1 nk-portfolio-image-box">
                        <a href="'.esc_url($post_detail_url).'" class="nk-image-box-link"></a>
                        <div class="nk-portfolio-image d-none d-md-block" style="background-image: url('."'".esc_url($image_path)."'".');"></div>
                        <img src="'.esc_url($image_path).'" alt="Foggy Forest" class="nk-portfolio-image d-lg-none">
                    </div>
                    <div class="nk-portfolio-text-box">
                        <div>
                            <h2 class="h3"><a href="'.esc_url($post_detail_url).'" class="nk-portfolio-title">'.esc_html($title).'</a></h2>';
                if($show_date) {
                    $result .= '<div class="nk-portfolio-links"><a href="#">' . esc_html($date) . '</a></div>';
                }
                $result .= '<div class="nk-gap"></div>
                            <p>'.esc_html($description).'</p>
                            <div class="nk-gap"></div>
                            <a href="'.esc_url($post_detail_url).'" class="nk-btn nk-btn-sm nk-btn-effect-2-right nk-btn-circle nk-btn-outline nk-btn-color-dark-4">
                                <span>'.$button_title.'</span>
                                <span class="icon"><span class="ion-ios-arrow-forward"></span></span>
                            </a>
                        </div>
                    </div>';
            }
            return $result;
        }
    }
}
