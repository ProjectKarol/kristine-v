<?php
/**
 * Created by PhpStorm.
 * User: Aleksey
 * Date: 31.08.2016
 * Time: 10:39
 */

add_shortcode('nk_text', 'nk_text');
if (!function_exists('nk_text')) :
    function nk_text($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "dropcap" => "",
            "dropcap_style" => "",
            "dropcap_circle" => "",
            "dropcap_color" => "",
            "dropcap_bg_color" => "",
            "class" => "",
        ), $atts));

        // dropcap
        $dropcap_class = '';
        if($dropcap_style == 2 || $dropcap_style == 3) {
            $dropcap_class .= ' nk-dropcap-' . $dropcap_style;
        } else {
            $dropcap_class .= ' nk-dropcap';
        }
        if(khaki_nk_check($dropcap_circle)) {
            $dropcap_class .= ' nk-dropcap-circle';
        }
        if(khaki_nk_check($dropcap)) {
            $dropcap_styles = '';
            if(khaki_nk_check($dropcap_color)) {
                $dropcap_styles .= 'color: ' . $dropcap_color . ';';
            }
            if(khaki_nk_check($dropcap_bg_color)) {
                $dropcap_styles .= 'background-color: ' . $dropcap_bg_color . ';';
            }
            $dropcap = '<span class="' . khaki_sanitize_class($dropcap_class) . '" style="' . esc_attr($dropcap_styles) . '">' . esc_html($dropcap) . '</span>';
        } else {
            $dropcap = '';
        }

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);

        return '<div class="' . khaki_sanitize_class($class) . '">'
                    . $dropcap . khaki_remove_wpautop($content, true) .
               '</div>';
    }
endif;


add_action( 'after_setup_theme', 'vc_nk_text' );
if ( ! function_exists( 'vc_nk_text' ) ) :
    function vc_nk_text() {
        if(function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name' => esc_html__('nK Text', 'khaki-shortcodes'),
                'base' => 'nk_text',
                'controls' => 'full',
                'category' => 'nK',
                'icon'     => 'icon-nk icon-nk-text',
                'params' => array_merge(array(
                    array(
                        'type'        => 'textarea_html',
                        'heading'     => esc_html__('Text', 'khaki-shortcodes'),
                        'param_name'  => 'content',
                        'value'       => '',
                        'description' => '',
                        'holder'      => 'div',
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Custom Classes', 'khaki-shortcodes'),
                        'param_name'  => 'class',
                        'value'       => '',
                        'description' => '',
                    ),


                    // dropcap
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Dropcap', 'khaki-shortcodes'),
                        'group'       => esc_html__('Dropcap', 'khaki-shortcodes'),
                        'param_name'  => 'dropcap',
                        'value'       => '',
                        'description' => '',
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Style', 'khaki-shortcodes'),
                        'group'       => esc_html__('Dropcap', 'khaki-shortcodes'),
                        'param_name' => 'dropcap_style',
                        'std'        => '1',
                        'value'      => array(
                            esc_html__('Style 1', 'khaki-shortcodes')  => '1',
                            esc_html__('Style 2', 'khaki-shortcodes')  => '2',
                            esc_html__('Style 3', 'khaki-shortcodes')  => '3'
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'        => 'checkbox',
                        'heading'     => esc_html__('Circle', 'khaki-shortcodes'),
                        'group'       => esc_html__('Dropcap', 'khaki-shortcodes'),
                        'param_name'  => 'dropcap_circle',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        'type'       => 'colorpicker',
                        'heading'    => esc_html__('Color', 'khaki-shortcodes'),
                        'group'       => esc_html__('Dropcap', 'khaki-shortcodes'),
                        'param_name' => 'dropcap_color',
                    ),
                    array(
                        'type'       => 'colorpicker',
                        'heading'    => esc_html__('Background Color', 'khaki-shortcodes'),
                        'group'       => esc_html__('Dropcap', 'khaki-shortcodes'),
                        'param_name' => 'dropcap_bg_color',
                    ),
                ), khaki_get_css_tab())
            ) );
        }
    }
endif;
