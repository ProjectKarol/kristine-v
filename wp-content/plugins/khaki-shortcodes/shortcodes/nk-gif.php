<?php
/**
 * nK GIF
 *
 * Example:
 * [nk_gif gif="12" static_image="23" type="click"]
 */

add_shortcode('nk_gif', 'nk_gif');
if (!function_exists('nk_gif')) :
    function nk_gif($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "gif" => "",
            "static_image" => "",
            "type" => "",
            "class" => "",
        ), $atts));

        $class .= ' nk-gif';

        // type
        switch ($type) {
            case 'mouse-over':
                $class .= ' nk-gif-hover';
                break;
            case 'click':
                $class .= ' nk-gif-click';
                break;
            case 'in-viewport':
                $class .= ' nk-gif-viewport';
                break;
            default:
                $type = false;
        }

        $gif_path = $static_image_path = $gif_str = '';
        if (khaki_nk_check($gif)) {
            $gif_path = khaki_get_attachment($gif, 'full');
        }
        if (khaki_nk_check($static_image)) {
            $static_image_path = khaki_get_attachment($static_image, 'full');
        }
        if (khaki_nk_check($gif_path) && (!$type || !khaki_nk_check($static_image_path))) {
            $gif_str = '<img src="' . esc_url($gif_path['src']) . '" data-gif="' . esc_url($gif_path['src']) . '" alt="' . esc_url($gif_path['alt']) . '">';
        } elseif (khaki_nk_check($gif_path) && khaki_nk_check($type) && khaki_nk_check($static_image_path)) {
            $gif_str = '<img src="' . esc_url($static_image_path['src']) . '" data-gif="' . esc_url($gif_path['src']) . '" alt="' . esc_url($gif_path['alt']) . '">';
        }

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);

        return '<div class="' . khaki_sanitize_class($class) . '">
                       ' . $gif_str . '
                </div>';
    }
endif;

add_action( 'after_setup_theme', 'vc_nk_gif' );
if ( ! function_exists( 'vc_nk_gif' ) ) :
    function vc_nk_gif() {
        if(function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name' => esc_html__('nK GIF', 'khaki-shortcodes'),
                'base' => 'nk_gif',
                'controls' => 'full',
                'category' => 'nK',
                'icon'     => 'icon-nk icon-nk-gif',
                'params' => array_merge(array(
                    array(
                        'type'       => 'attach_image',
                        'heading'    => esc_html__('Select GIF', 'khaki-shortcodes'),
                        'param_name' => 'gif',
                        'description' => '',
                        'admin_label' => true
                    ),
                    array(
                        'type'       => 'attach_image',
                        'heading'    => esc_html__('Static Image', 'khaki-shortcodes'),
                        'param_name' => 'static_image',
                        'description' => '',
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Play Type', 'khaki-shortcodes'),
                        'param_name' => 'type',
                        'std'        => 'default',
                        'value'      => array(
                            esc_html__('Default Autoplay', 'khaki-shortcodes')  => 'default',
                            esc_html__('Mouse Over Play', 'khaki-shortcodes')  => 'mouse-over',
                            esc_html__('On Click Play', 'khaki-shortcodes')  => 'click',
                            esc_html__('In Viewport Play', 'khaki-shortcodes')  => 'in-viewport'
                        ),
                        'description' => ''
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