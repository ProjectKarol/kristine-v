<?php
/**
 * nK Plain Video
 *
 * Example:
 * [nk_plain_video video="https://www.youtube.com/watch?v=Wb2qjfpOeMo" thumb="13"]
 */

add_shortcode('nk_plain_video', 'nk_plain_video');
if (!function_exists('nk_plain_video')) :
    function nk_plain_video($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "video" => "https://vimeo.com/108018156",
            "video_thumb"=>"",
            "class" => "",
        ), $atts));

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);

        $thumb_attribute = '';
        if(khaki_nk_check($video_thumb)){
            $attachment = khaki_get_attachment($video_thumb);
            if(isset($attachment['src'])){
                $thumb_attribute='data-video-thumb="'.esc_url($attachment['src']).'"';
            }
        }

        return '<div class="nk-plain-video ' . khaki_sanitize_class($class) . '" data-video="' . esc_url($video) . '"' . $thumb_attribute . '></div>';
    }
endif;


add_action( 'after_setup_theme', 'vc_nk_plain_video' );
if ( ! function_exists( 'vc_nk_plain_video' ) ) :
    function vc_nk_plain_video() {
        if(function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name' => esc_html__('nK Plain Video', 'khaki-shortcodes'),
                'base' => 'nk_plain_video',
                'controls' => 'full',
                'category' => 'nK',
                'icon'     => 'icon-nk icon-nk-plain-video',
                'params' => array_merge(array(
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Video Link', 'khaki-shortcodes'),
                        'param_name'  => 'video',
                        'value'       => 'https://vimeo.com/108018156',
                        'description' => esc_html__("Supported Youtube and Vimeo", 'khaki-shortcodes'),
                        'admin_label' => true,
                    ),
                    array(
                        'type'       => 'attach_image',
                        'heading'    => esc_html__('Video Thumbnail', 'khaki-shortcodes'),
                        'param_name' => 'video_thumb',
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