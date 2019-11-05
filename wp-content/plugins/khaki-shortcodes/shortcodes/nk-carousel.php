<?php
/**
 * nK Carousel
 *
 * Example:
 * [nk_carousel autoplay="0" show_arrows="false" show_dots="false" no_margin="false" all_visible="false" style="1" size="1"]
 *     [nk_carousel_item]Item Content[/nk_carousel_item]
 *     [nk_carousel_item]Item Content[/nk_carousel_item]
 * [/nk_carousel]
 */

add_shortcode('nk_carousel', 'nk_carousel');
if ( ! function_exists( 'nk_carousel' ) ) :
    function nk_carousel($atts, $content = null) {
        if( !khaki_nk_check($content) ) {
            return '';
        }

        extract(shortcode_atts(array(
            "autoplay" => "",
            "show_arrows" => "",
            "style_arrows" => "",
            "cell_align" => "center",
            "color_arrows"  => false,
            "show_dots" => "",
            "no_margin" => "",
            "all_visible" => "",
            "style" => false,
            "size" => "",
            "class" => "",
        ), $atts));

        if(khaki_nk_check($style)) {
            $class .= 'nk-carousel-' . $style;
        } else {
            $class .= 'nk-carousel';
        }

        if (khaki_nk_check($size)) {
            $class .= ' nk-carousel-x' . $size;
        }
        if (khaki_nk_check($no_margin)) {
            $class .= ' nk-carousel-no-margin';
        }
        if (khaki_nk_check($all_visible)) {
            $class .= ' nk-carousel-all-visible';
        }

        $attributes = $pagination ='';
        if (khaki_nk_check($autoplay)) {
            $attributes .= ' data-autoplay="' . esc_attr($autoplay) . '"';
        }
        if (khaki_nk_check($show_arrows)) {
            if(khaki_nk_check($style_arrows)){
                $color_class = '';
                if(khaki_nk_check($color_arrows)){
                    $color_class = ' text-'.$color_arrows;
                }
                switch ($style_arrows) {
                    case 'pagination_standard':
                        $pagination = '<div class="'.khaki_sanitize_class('nk-carousel-prev' . $color_class).'">
                                                    <div class="nk-carousel-arrow-name"></div>
                                                    '.esc_html__('Previous', 'khaki-shortcodes').'
                                                    <span class="nk-icon-arrow-left"></span>
                                                </div>
                                                <div class="'.khaki_sanitize_class('nk-carousel-next' . $color_class).'">
                                                    <div class="nk-carousel-arrow-name"></div>
                                                    '.esc_html__('Next', 'khaki-shortcodes').'
                                                    <span class="nk-icon-arrow-right"></span>
                                                </div>';
                        break;
                        /**
                        TODO: add case 'pagination_top':
                        break;
                        case 'pagination_bottom':
                        break;
                        */
                }
            } else{
                $attributes .= ' data-arrows="true"';
            }
        }
        if (khaki_nk_check($show_dots)) {
            $attributes .= ' data-dots="true"';
        }
        if(khaki_nk_check($cell_align)){
            $attributes .= ' data-cell-align="'.esc_attr($cell_align).'"';
        }

        $attributes .= ' data-size="1"';

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);

        return '<div class="' . khaki_sanitize_class($class) . '"' . $attributes . '>
                   <div class="nk-carousel-inner">'
                   . do_shortcode($content) .
                   '</div>
                   '.$pagination.'
                </div>';
    }
endif;

// image for carousel
add_shortcode('nk_carousel_item', 'nk_carousel_item');
if ( ! function_exists( 'nk_carousel_item' ) ) :
    function nk_carousel_item($atts, $content = null) {
        extract(shortcode_atts(array(
            "class" => "",
        ), $atts));

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);

        return '<div><div class="' . khaki_sanitize_class($class) . '">' . do_shortcode($content) . '</div></div>';
    }
endif;


/* Add VC Shortcode */
add_action( "after_setup_theme", "vc_nk_carousel" );
if ( ! function_exists( 'vc_nk_carousel' ) ) :
    function vc_nk_carousel() {
        if(function_exists("vc_map")) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                "name"     => esc_html__("nK Carousel", 'khaki-shortcodes'),
                "base"     => "nk_carousel",
                "controls" => "full",
                "category" => "nK",
                "icon"     => "icon-nk icon-nk-carousel",
                "as_parent" => array('only' => 'nk_carousel_item'),
                "content_element" => true,
                "show_settings_on_create" => false,
                "admin_enqueue_css"       => khaki_shortcodes()->plugin_url . "shortcodes/css/nk-carousel-vc-view.css",
                "js_view" => 'VcColumnView',
                "params"   => array_merge(array(
                    array(
                        "type"        => "textfield",
                        "heading"     => esc_html__("Autoplay", 'khaki-shortcodes'),
                        "param_name"  => "autoplay",
                        "value"       => "0",
                        "description" => esc_html__("Type integer value in ms", 'khaki-shortcodes')
                    ),
                    array(
                        "type"        => "checkbox",
                        "heading"     => esc_html__('Show Arrows', 'khaki-shortcodes'),
                        "param_name"  => "show_arrows",
                        "value"       => array( "" => true ),
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Style Arrows', 'khaki-shortcodes'),
                        'param_name' => 'style_arrows',
                        'std'        => false,
                        'value'      => array(
                            esc_html__('Default', 'khaki-shortcodes') => false,
                            esc_html__('Standard Pagination ', 'khaki-shortcodes') => 'pagination_standard',
                            /** TODO: add next styles
                            esc_html__('Pagination Top', 'khaki-shortcodes') => 'pagination_top',
                            esc_html__('Pagination Bottom', 'khaki-shortcodes') => 'pagination_bottom'
                            */
                        ),
                        'dependency' => array(
                            'element' => 'show_arrows',
                            'not_empty'  => true
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Color Arrows', 'khaki-shortcodes'),
                        'param_name' => 'color_arrows',
                        'std'        => false,
                        'value'      => khaki_get_colors(),
                        'description' => '',
                        'dependency' => array(
                            'element' => 'style_arrows',
                            'value' => 'pagination_standard'
                        ),
                    ),
                    array(
                        "type"        => "checkbox",
                        "heading"     => esc_html__('Show Dots', 'khaki-shortcodes'),
                        "param_name"  => "show_dots",
                        "value"       => array( "" => true ),
                    ),
                    array(
                        "type"        => "checkbox",
                        "heading"     => esc_html__('No Margin Between Slides', 'khaki-shortcodes'),
                        "param_name"  => "no_margin",
                        "value"       => array( "" => true ),
                    ),
                    array(
                        "type"        => "checkbox",
                        "heading"     => esc_html__('All Visible', 'khaki-shortcodes'),
                        "description" => esc_html__('By default non-active slides semi-transparent, this option removed transparency.', 'khaki-shortcodes'),
                        "param_name"  => "all_visible",
                        "value"       => array( "" => true ),
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Style', 'khaki-shortcodes'),
                        'param_name' => 'style',
                        'std'        => false,
                        'value'      => array(
                            esc_html__('Default', 'khaki-shortcodes') => false,
                            esc_html__('Style 1', 'khaki-shortcodes') => '1',
                            esc_html__('Style 2', 'khaki-shortcodes') => '2',
                            esc_html__('Style 3', 'khaki-shortcodes') => '3'
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Size', 'khaki-shortcodes'),
                        'param_name' => 'size',
                        'std'        => false,
                        'value'      => array(
                            esc_html__('Default', 'khaki-shortcodes') => false,
                            esc_html__('X1', 'khaki-shortcodes') => '1',
                            esc_html__('X2', 'khaki-shortcodes') => '2',
                            esc_html__('X3', 'khaki-shortcodes') => '3',
                            esc_html__('X4', 'khaki-shortcodes') => '4',
                        ),
                        'dependency' => array(
                            'element'    => 'style',
                            'value'      => array('2')
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Cell Align', 'khaki-shortcodes'),
                        'param_name' => 'cell_align',
                        'std'        => false,
                        'value'      => array(
                            esc_html__('Center', 'khaki-shortcodes') => 'center',
                            esc_html__('Left', 'khaki-shortcodes') => 'left',
                            esc_html__('Right', 'khaki-shortcodes') => 'right'
                        ),
                        'description' => ''
                    ),
                    array(
                        "type"        => "textfield",
                        "heading"     => esc_html__("Custom Classes", 'khaki-shortcodes'),
                        "param_name"  => "class",
                        "value"       => "",
                        "description" => "",
                    ),
                ), khaki_get_css_tab())
            ) );
        }
    }
endif;


add_action( "after_setup_theme", "vc_nk_carousel_item" );
if ( ! function_exists( 'vc_nk_carousel_item' ) ) :
    function vc_nk_carousel_item() {
        if(function_exists("vc_map")) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                "name"     => esc_html__("nK Carousel Item", 'khaki-shortcodes'),
                "base"     => "nk_carousel_item",
                "controls" => "full",
                "category" => "nK",
                "icon"     => "icon-nk icon-nk-single-image",
                "as_child" => array('only' => 'nk_carousel'),
                "content_element" => true,
                "is_container"  => true,
                "js_view"  => 'VcColumnView',
                "params"   => array_merge(array(
                    array(
                        "type"        => "textfield",
                        "heading"     => esc_html__("Custom Classes", 'khaki-shortcodes'),
                        "param_name"  => "class",
                        "value"       => "",
                        "description" => "",
                    ),
                ), khaki_get_css_tab())
            ) );
        }
    }
endif;


//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_nk_carousel extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_nk_carousel_item extends WPBakeryShortCodesContainer {
    }
}
