<?php
/**
 * nK Gallery Images
 *
 * Example:
 * [nk_gallery_images images="123,523" columns="2"]
 */

add_shortcode('nk_gallery_images', 'nk_gallery_images');
if (!function_exists('nk_gallery_images')) :
    function nk_gallery_images($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "style" => "default",
            "effect" => "1",
            "content_vertical_align" => "center",
            "icon" => "ion-ios-search",
            "images" => "",
            "columns" => 2,
            "class" => "",
        ), $atts));

        $before = $after = $overlay_class = '';
            $class .= ' nk-popup-gallery';


        if (khaki_nk_check($columns)) {
            $class .= ' nk-isotope-' . esc_attr($columns) . '-cols';

            if ($columns > 1) {
                $class .= ' nk-isotope';
            }
            if($style == 'boxed_gap'){
                $class .= ' nk-isotope-gap';
            }
        }

        $result = '';

        $ar_images = explode(",", $images);
        $class_effect = khaki_nk_check($effect) ? 'nk-image-box-'.$effect : 'nk-image-box-1';
        foreach ($ar_images as $image) {
            $image_big_size = khaki_get_attachment($image, 'khaki_1920x1080');
            $image_small_size = khaki_get_attachment($image, 'khaki_800x600');
                if (isset($image_big_size) && isset($image_small_size)) {
                    if ($columns > 1) {
                        $result .= '<div class="nk-isotope-item">';
                    }
                    $result .= '<div class="'.esc_attr($class_effect).'">';
                    $result .= '<a href="' . esc_url($image_big_size['src']) . '" class="nk-gallery-item" data-size="' . esc_attr($image_big_size['width']) . 'x' . esc_attr($image_big_size['height']) . '">';
                    $result .= ' <img src="' . esc_url($image_small_size['src']) . '" alt="' . esc_attr($image_small_size['alt']) . '">';
                    if(khaki_nk_check($icon)) {
                        $overlay_class = 'nk-image-box-overlay ';
                    }
                    $result .= '<span class="' . khaki_sanitize_class($overlay_class.'nk-image-box-' . $content_vertical_align) . '">';
                        if(khaki_nk_check($icon)){
                            $icon .= ' fs-30';
                            $result .= '<span>';
                            $result .= '<span class="'.khaki_sanitize_class($icon).'"></span>';
                            $result .= '</span>';
                        }
                    $result .= '</span>';
                    $result .= '</a>';
                    $result .= '</div>';
                    if ($columns > 1) {
                        $result .= '</div>';
                    }
                }

        }

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);
        if($style == 'boxed' || $style == 'boxed_gap'){
            $before = '<div class="container">';
            $after = '</div>';
        }
        return $before.'<div class="' . khaki_sanitize_class($class) . '">' . $result . '</div>'.$after;
    }
endif;

add_action( 'after_setup_theme', 'vc_nk_gallery_images' );
if ( ! function_exists( 'vc_nk_gallery_images' ) ) :
    function vc_nk_gallery_images() {
        if(function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name' => esc_html__('nK Gallery Images', 'khaki-core'),
                'base' => 'nk_gallery_images',
                'controls' => 'full',
                'category' => 'nK',
                'icon'     => 'icon-nk icon-nk-gallery-images',
                'params' => array_merge(array(
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Style", 'khaki-core'),
                        "param_name" => "style",
                        "value" => array(
                            esc_html__("Default", 'khaki-core') => "default",
                            esc_html__("Boxed", 'khaki-core') => 'boxed',
                            esc_html__("Boxed + Gap", 'khaki-core') => 'boxed_gap',
                        ),
                        "description" => ""
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Effect', 'khaki-core'),
                        'param_name' => 'effect',
                        'std'        => '1',
                        'value'      => array(
                            esc_html__('Style 1', 'khaki-core')  => '1',
                            esc_html__('Style 1a', 'khaki-core')  => '1-a',
                            esc_html__('Style 2', 'khaki-core')  => '2',
                            esc_html__('Style 3', 'khaki-core')  => '3',
                            esc_html__('Style 4', 'khaki-core')  => '4',
                            esc_html__('Style 5', 'khaki-core')  => '5',
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'        => 'iconpicker',
                        'heading'     => esc_html__('Icon', 'khaki-core'),
                        'param_name'  => 'icon',
                        'value'       => 'ion-ios-search',
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Content Vertical Align', 'khaki-core'),
                        'param_name' => 'content_vertical_align',
                        'std'        => 'center',
                        'value'      => array(
                            esc_html__('Top', 'khaki-core')  => 'top',
                            esc_html__('Center', 'khaki-core')  => 'center',
                            esc_html__('Bottom', 'khaki-core')  => 'bottom',
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'attach_images',
                        'heading'    => esc_html__('Select Images', 'khaki-core'),
                        'param_name' => 'images',
                        'description' => '',
                        'admin_label' => true
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Columns', 'khaki-core'),
                        'param_name' => 'columns',
                        'std'        => 2,
                        'value'      => array(
                            2, 3, 4
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Custom Classes', 'khaki-core'),
                        'param_name'  => 'class',
                        'value'       => '',
                        'description' => '',
                    )
                ), khaki_get_css_tab())
            ) );
        }
    }
endif;
