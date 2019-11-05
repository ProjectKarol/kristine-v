<?php
/**
 * nK Image Box
 *
 * Example:
 * [nk_image_box image="12" image_size="full" link="https://google.com" content_vertical_align="center" style="1" no_effect="false" hovered="false"]My Content[/nk_image_box]
 */

add_shortcode('nk_image_box', 'nk_image_box');
if (!function_exists('nk_image_box')) :
    function nk_image_box($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "image" => "",
            "image_size" => "",
            "link" => "",
            "content_vertical_align" => "center",
            "style" => "1",
            "no_effect" => "",
            "hovered" => "",
            "box_line" => "",
            "class" => "",
        ), $atts));

        // image
        $image_str = $class_str = $overlay_str = '';
        if (khaki_nk_check($image)) {
            $image = khaki_get_attachment($image, $image_size);
            $image_atts = '';
            if($style == 2) {
                $image_atts = 'data-from="1.1"';
            }
            if (khaki_nk_check($image)) {
                $image_str = '<img src="' . esc_url($image['src']) . '" alt="' . $image['alt'] . '" ' . $image_atts . '>';
            }
        }

        // link
        $link_atts = '';
        $tag = '';
        $link_str='';
        if (khaki_nk_check($link) && function_exists('vc_build_link')) {
            $link = vc_build_link($link);

            if(isset($link['url']) && $link['url']) {
                $tag = 'a';
                $link_atts = ' href="' . esc_attr($link['url']) . '"';

                if(isset($link['title']) && $link['title']) {
                    $link_atts .= ' title="' . esc_attr($link['title']) . '"';
                }
                if(isset($link['target']) && $link['target']) {
                    $link_atts .= ' target="' . esc_attr($link['target']) . '"';
                }
                if(isset($link['rel']) && $link['rel']) {
                    $link_atts .= ' rel="' . esc_attr($link['rel']) . '"';
                }
                $link_str = '<' . $tag . ' ' . $link_atts . ' class="nk-image-box-link"></' . $tag . '>';
            }

        } else if (khaki_nk_check($link)) {
            $tag = 'a';
            $link_atts = ' href="' . esc_attr($link) . '"';
            $link_str = '<' . $tag . ' ' . $link_atts . ' class="nk-image-box-link"></' . $tag . '>';
        }
        // no effect
        if (khaki_nk_check($no_effect)) {
            $class .= ' nk-no-effect';
        }

        // hovered
        if (khaki_nk_check($hovered)) {
            $class .= ' hover';
        }

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);

        if(khaki_nk_check($style)){
            $class .= ' nk-image-box-' . $style;
            if(isset($content) && !empty($content)){
                $overlay_str = '<div class="' . khaki_sanitize_class('nk-image-box-overlay nk-image-box-' . $content_vertical_align) . '">
                                <div>
                                    ' . do_shortcode($content) . '
                                </div>
                            </div>';
            }
        } else {
            $class .= ' nk-image-box';
        }
        if(khaki_nk_check($box_line)){
            $class .= ' nk-box-line';
        }
        if(khaki_nk_check(trim($class))){
            $class_str = ' class="' . khaki_sanitize_class(trim($class)) . '"';
        }
            
        return '<div' . $class_str . '>
                    ' . $link_str . '
                    ' . $image_str . '
                    ' . $overlay_str . '                  
                </div>';
    }
endif;

add_action( 'after_setup_theme', 'vc_nk_image_box' );
if ( ! function_exists( 'vc_nk_image_box' ) ) :
    function vc_nk_image_box() {
        if(function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name' => esc_html__('nK Image Box', 'khaki-shortcodes'),
                'base' => 'nk_image_box',
                'controls' => 'full',
                'category' => 'nK',
                'icon'     => 'icon-nk icon-nk-image-box',
                "as_parent" => array('only' => array('nk_title', 'nk_text', 'nk_button')),
                "content_element" => true,
                "js_view"  => 'VcColumnView',
                'params' => array_merge(array(
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__("Select Image", 'khaki-shortcodes'),
                        'param_name' => 'image',
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Image Size', 'khaki-shortcodes'),
                        'param_name' => 'image_size',
                        'std'        => 'full',
                        'value'      => khaki_get_image_sizes(),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Effect', 'khaki-shortcodes'),
                        'param_name' => 'style',
                        'std'        => '1',
                        'value'      => array(
                            esc_html__('Disable', 'khaki-shortcodes')  => false,
                            esc_html__('Style 1', 'khaki-shortcodes')  => '1',
                            esc_html__('Style 1a', 'khaki-shortcodes')  => '1-a',
                            esc_html__('Style 2', 'khaki-shortcodes')  => '2',
                            esc_html__('Style 3', 'khaki-shortcodes')  => '3',
                            esc_html__('Style 4', 'khaki-shortcodes')  => '4',
                            esc_html__('Style 5', 'khaki-shortcodes')  => '5',
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'vc_link',
                        'heading'    => esc_html__('Link', 'khaki-shortcodes'),
                        'param_name' => 'link',
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Content Vertical Align', 'khaki-shortcodes'),
                        'param_name' => 'content_vertical_align',
                        'std'        => 'center',
                        'value'      => array(
                            esc_html__('Top', 'khaki-shortcodes')  => 'top',
                            esc_html__('Center', 'khaki-shortcodes')  => 'center',
                            esc_html__('Bottom', 'khaki-shortcodes')  => 'bottom',
                        ),
                        'description' => ''
                    ),
                    array(
                        'param_name'  => 'no_effect',
                        'heading'     => esc_html__('No Hover Effect', 'khaki-shortcodes'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        'param_name'  => 'hovered',
                        'heading'     => esc_html__('Hovered', 'khaki-shortcodes'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        'param_name'  => 'box_line',
                        'heading'     => esc_html__('Box Line', 'khaki-shortcodes'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Custom Classes', 'khaki-shortcodes'),
                        'param_name'  => 'class',
                        'value'       => '',
                        'description' => '',
                    )
                ), khaki_get_css_tab())
            ) );
        }
    }
endif;


//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_nk_image_box extends WPBakeryShortCodesContainer {
    }
}