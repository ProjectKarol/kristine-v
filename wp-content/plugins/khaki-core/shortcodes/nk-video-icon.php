<?php
/**
 * nK Video Icon
 *
 */

add_shortcode('nk_video_icon', 'nk_video_icon');
if (!function_exists('nk_video_icon')) :
    function nk_video_icon($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "link" => "https://www.youtube.com/watch?v=JtnHPNlzCz8",
            "style" => "",
            "class" => "",
        ), $atts));
        $result = '';

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);
        $class .= ' nk-video-fullscreen-toggle';

        $style_video_icon = 'nk-video-icon';
        $style_video_icon .= !empty($style) ? '-'.$style : '';

        $result .= '<a class="'.khaki_sanitize_class($class).'" href="'.esc_url($link).'"><span class="'.khaki_sanitize_class($style_video_icon).'"><span class="fa fa-play pl-5"></span></span></a>';

        return $result;
    }
endif;


add_action( 'after_setup_theme', 'vc_nk_video_icon' );
if ( ! function_exists( 'vc_nk_video_icon' ) ) :
    function vc_nk_video_icon() {
        if(function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name' => esc_html__('nK Video Icon', 'khaki-core'),
                'base' => 'nk_video_icon',
                'controls' => 'full',
                'category' => 'nK',
                'icon'     => 'icon-nk',
                'params' => array_merge(array(
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Video Link', 'khaki-core'),
                        'param_name'  => 'link',
                        'value'       => 'https://www.youtube.com/watch?v=JtnHPNlzCz8',
                        'description' => esc_html__("Supported Youtube and Vimeo", 'khaki-core'),
                        'admin_label' => true,
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Style', 'khaki-core'),
                        'param_name' => 'style',
                        'std'        => false,
                        'value'      => array(
                            esc_html__('Black', 'khaki-core')  => false,
                            esc_html__('Black 2', 'khaki-core')  => '2',
                            esc_html__('Light', 'khaki-core')  => 'light',
                            esc_html__('Light 2', 'khaki-core')  => '2-light',
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Custom Classes', 'khaki-core'),
                        'param_name'  => 'class',
                        'value'       => '',
                        'description' => '',
                    ),
                ), khaki_get_css_tab())
            ) );
        }
    }
endif;
