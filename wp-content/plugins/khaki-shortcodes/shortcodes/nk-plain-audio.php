<?php
/**
 * nK Plain Audio
 *
 * Example:
 * [nk_plain_audio audio_file="10" dark_style="1"]
 */

add_shortcode('nk_plain_audio', 'nk_plain_audio');
if (!function_exists('nk_plain_audio')) :
    function nk_plain_audio($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "audio_file" => "",
            "dark_style"=> false,
            "class" => "",
        ), $atts));
        $result = '';
        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);
        $class .= ' nk-audio-plain';
        if(khaki_nk_check($dark_style)){
            $class .= ' nk-audio-plain-dark';
        }
        if(khaki_nk_check($audio_file) && is_numeric($audio_file)){
            $meta_audio = get_post_meta($audio_file, '_wp_attachment_metadata', true);
            $album = isset($meta_audio['album']) ? $meta_audio['album'] : '';
            $track_length = isset($meta_audio['length_formatted']) ? $meta_audio['length_formatted'] : '';
            $url = wp_get_attachment_url($audio_file);
            $media_title = get_the_title($audio_file);

            $result .= '<div class="'.khaki_sanitize_class($class).'" data-src="' . esc_url($url) . '">';
            if (isset($media_title) || isset($album)) {
                $result .= '<div class="nk-audio-plain-title">';
                $result .=  '<strong>' . esc_html($album) . '</strong> ' . esc_html((isset($media_title) && isset($album)) ? ' - ' : '') . esc_html(isset($media_title) ? $media_title : '');
                if (isset($track_length) && !empty($track_length)) {
                    $result .=  '<div class="nk-audio-progress">
                            <div class="nk-audio-progress-current"></div>
                        </div>';
                }
                $result .=  '</div>';
            }
            if (isset($track_length) && !empty($track_length)) {
                $result .= '<div class="nk-audio-plain-duration">'.esc_html($track_length).'</div>';
            }
            $result .= '</div>';
        }
       return $result;
    }
endif;


add_action( 'after_setup_theme', 'vc_nk_plain_audio' );
if ( ! function_exists( 'vc_nk_plain_audio' ) ) :
    function vc_nk_plain_audio() {
        if(function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name' => esc_html__('nK Plain Audio', 'khaki-shortcodes'),
                'base' => 'nk_plain_audio',
                'controls' => 'full',
                'category' => 'nK',
                'icon'     => 'icon-nk icon-nk-plain-audio',
                'params' => array_merge(array(
                    array(
                        "type" => "awb_attach_audio",
                        "param_name" => "audio_file",
                        "heading" => esc_html__("Audio File", 'khaki-shortcodes'),
                        "edit_field_class" => "vc_col-sm-4",
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => esc_html__('Dark Style', 'khaki-shortcodes'),
                        'param_name' => 'dark_style',
                        'value' => array('' => true)
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