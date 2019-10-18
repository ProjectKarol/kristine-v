<?php
/**
 * nK Icon Box
 *
 * Example:
 * [nk_icon_box icon="fa fa-search" title="Title"]My Content[/nk_icon_box]
 */

add_shortcode('nk_icon_box', 'nk_icon_box');
if (!function_exists('nk_icon_box')) :
    function nk_icon_box($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "title" => "",
            "link" => "",
            "style" => 1,
            "hover" => false,
            "circle" => false,
            "inverted" => false,
            "color" => "",
            "background_color" => "",
            "hover_color" => "",
            "hover_color_background" => "",
            "icon" => "fa fa-search",
            "class" => ""
        ), $atts));
        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);
        $result = '';
        if (khaki_nk_check($style)) {
            $class .= ' nk-ibox-' . $style;
        }
        if (khaki_nk_check($hover)) {
            $class .= ' nk-ibox-hover';
        }
        if (khaki_nk_check($inverted)) {
            $class .= ' nk-ibox-inverted';
        }
        if (khaki_nk_check($class)) {
            $result .= '<div class="' . khaki_sanitize_class($class) . '">';
            if (khaki_nk_check($icon)) {
                $icon_class = 'nk-ibox-icon';
                if (khaki_nk_check($circle)) {
                    $icon_class .= ' nk-ibox-icon-circle';
                }
                if (khaki_nk_check($hover)) {
                    if (khaki_nk_check($hover_color)) {
                        $icon_class .= ' nk-ibox-icon-hover-color-' . $hover_color;
                    }
                    if (khaki_nk_check($hover_color_background)) {
                        $icon_class .= ' nk-ibox-icon-hover-bg-color-' . $hover_color_background;
                    }
                }
                if (khaki_nk_check($color)) {
                    $icon_class .= ' nk-ibox-icon-color-' . $color;
                }
                if (khaki_nk_check($background_color)) {
                    $icon_class .= ' nk-ibox-icon-bg-color-' . $background_color;
                }
                $result .= '<div class="' . khaki_sanitize_class($icon_class) . '">';
                $result .= '<span class="' . khaki_sanitize_class($icon) . '"></span>';
                $result .= '</div>';
            }
            if (khaki_nk_check($title) || khaki_nk_check($content)) {
                $result .='<div class="nk-ibox-cont">';
                if(khaki_nk_check($title)){
                    $result .='<h3 class="nk-ibox-title">';
                    if(khaki_nk_check($link)){
                        $result .='<a href="'.esc_url($link).'">';
                    }
                    $result .= esc_html($title);
                    if(khaki_nk_check($link)){
                        $result .='</a>';
                    }                   
                    $result .= '</h3>';
                }
                if(khaki_nk_check($content)){
                    $result .= khaki_remove_wpautop($content, true);
                }
                $result .= '</div>';
            }
            $result .= '</div>';
        }
        return $result;
    }
endif;

add_action('after_setup_theme', 'vc_nk_icon_box');
if (!function_exists('vc_nk_icon_box')) :
    function vc_nk_icon_box()
    {
        if (function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map(array(
                'name' => esc_html__('nK Icon Box', 'khaki-core'),
                'base' => 'nk_icon_box',
                'controls' => 'full',
                'category' => 'nK',
                'icon' => 'icon-nk icon-nk-icon-box',
                'params' => array_merge(array(
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Style', 'khaki-core'),
                        'param_name' => 'style',
                        'std' => 1,
                        'value' => array(1, 2, 3, 4),
                        'description' => ''
                    ),
                    array(
                        'type' => 'iconpicker',
                        'heading' => esc_html__('Icon', 'khaki-core'),
                        'param_name' => 'icon',
                        'admin_label' => true,
                        'value' => 'fa fa-search',
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => esc_html__('Circle', 'khaki-core'),
                        'param_name' => 'circle',
                        'value' => array('' => true)
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => esc_html__('Hover', 'khaki-core'),
                        'param_name' => 'hover',
                        'value' => array('' => true)
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => esc_html__('Inverted', 'khaki-core'),
                        'param_name' => 'inverted',
                        'value' => array('' => true)
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Color', 'khaki-core'),
                        'param_name' => 'color',
                        'value' => khaki_get_colors(),
                        'description' => ''
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Background Color', 'khaki-core'),
                        'param_name' => 'background_color',
                        'value' => khaki_get_colors(),
                        'description' => ''
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Hover Color', 'khaki-core'),
                        'param_name' => 'hover_color',
                        'value' => khaki_get_colors(),
                        'description' => '',
                        'dependency' => array(
                            'element' => 'hover',
                            'not_empty'  => true
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Hover Color Background', 'khaki-core'),
                        'param_name' => 'hover_color_background',
                        'value' => khaki_get_colors(),
                        'description' => '',
                        'dependency' => array(
                            'element' => 'hover',
                            'not_empty'  => true
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Title', 'khaki-core'),
                        'param_name' => 'title',
                        'value' => '',
                        'description' => '',
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('URL', 'khaki-core'),
                        'param_name' => 'link',
                        'value' => '',
                        'description' => '',
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'textarea_html',
                        'heading' => esc_html__('Inner Text', 'khaki-core'),
                        'param_name' => 'content',
                        'value' => '',
                        'description' => '',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Custom Classes', 'khaki-core'),
                        'param_name' => 'class',
                        'value' => '',
                        'description' => '',
                    )
                ), khaki_get_css_tab())
            ));
        }
    }
endif;