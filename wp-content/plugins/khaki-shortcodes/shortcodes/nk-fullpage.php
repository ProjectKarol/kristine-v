<?php

add_shortcode('nk_fullpage', 'nk_fullpage');
if ( ! function_exists( 'nk_fullpage' ) ) :
    function nk_fullpage($atts, $content = null) {
        if( !khaki_nk_check($content) ) {
            return '';
        }

        $result = '<div class="nk-fullpage">';
        $result .= do_shortcode($content);
        $result .= '</div>';
        return $result;
    }
endif;

add_shortcode('nk_fullpage_item', 'nk_fullpage_item');
if ( ! function_exists( 'nk_fullpage_item' ) ) :
    function nk_fullpage_item($atts, $content = null) {
        extract(shortcode_atts(array(
            "image"=>"",
        ), $atts));
        $image_attr = '';
        if(khaki_nk_check($image)){
            $ar_image = khaki_get_attachment($image, 'khaki_1920x1080');
            if(!empty($ar_image) && is_array($ar_image)){
                $image_attr = ' style="background-image: url('."'".$ar_image['src']."'".');"';
            }
        }
        return '<div class="nk-fullpage-item"'.$image_attr.'><div>' . khaki_remove_wpautop($content, true) . '</div></div>';
    }
endif;

/* Add VC Shortcode */
add_action( "after_setup_theme", "vc_nk_fullpage" );
if ( ! function_exists( 'vc_nk_fullpage' ) ) :
    function vc_nk_fullpage() {
        if(function_exists("vc_map")) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                "name"     => esc_html__("nK Fullpage", 'khaki-shortcodes'),
                "base"     => "nk_fullpage",
                "controls" => "full",
                "category" => "nK",
                "icon"     => "icon-nk",
                "as_parent" => array('only' => 'nk_fullpage_item'),
                "content_element" => true,
                "show_settings_on_create" => false,
                "admin_enqueue_css"       => khaki_shortcodes()->plugin_url . "shortcodes/css/nk-carousel-vc-view.css",
                "js_view" => 'VcColumnView',
            ) );
        }
    }
endif;

add_action( "after_setup_theme", "vc_nk_fullpage_item" );
if ( ! function_exists( 'vc_nk_fullpage_item' ) ) :
    function vc_nk_fullpage_item() {
        if(function_exists("vc_map")) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                "name"     => esc_html__("nK Fullpage Item", 'khaki-shortcodes'),
                "base"     => "nk_fullpage_item",
                "controls" => "full",
                "category" => "nK",
                "icon"     => "icon-nk icon-nk-single-image",
                "as_child" => array('only' => 'nk_fullpage'),
                "content_element" => true,
                "is_container"  => true,
                "js_view"  => 'VcColumnView',
                "params"   => array_merge(array(
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__("Select Image", 'khaki-shortcodes'),
                        'param_name' => 'image',
                    ),
                ))
            ) );
        }
    }
endif;

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_nk_fullpage extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_nk_fullpage_item extends WPBakeryShortCodesContainer {
    }
}