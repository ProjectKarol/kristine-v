<?php
/**
 * nK Testimonial
 *
 * Example:
 * [nk_testimonial style="1" photo="12" photo_size="60x60_crop" user_name="John" user_source="CEO"]My Text[/nk_testimonial]
 */

add_shortcode('nk_testimonial', 'nk_testimonial');
if (!function_exists('nk_testimonial')) :
    function nk_testimonial($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "style" => "1",
            "photo" => "",
            "photo_size" => "",
            "user_name" => "",
            "user_source" => "",
            "class" => "",
        ), $atts));

        $result = $testimonal_body = $testimonal_name = $testimonal_source = $testimonal_photo = '';

        // style
        if (khaki_nk_check($style)) {
            $class .= ' nk-testimonial-' . $style;
        } else {
            $class .= ' nk-testimonial';
        }

        // photo
        if (khaki_nk_check($photo)) {
            $image_array = wp_get_attachment_image_src($photo, $photo_size);
            if (khaki_nk_check($image_array) && isset($image_array[0])) {
                $testimonal_photo = '<div class="nk-testimonial-photo" style="background-image: url(' . "'" . esc_url($image_array[0]) . "'" . ');"></div>';
            }
        }

        // content
        if (khaki_nk_check($content)) {
            $testimonal_body = '<div class="nk-testimonial-body">' . khaki_remove_wpautop($content, true) . '</div>';
        }
        if (khaki_nk_check($user_name)) {
            $testimonal_name = '<div class="nk-testimonial-name nk-carousel-item-name h4">' . esc_html($user_name) . '</div>';
        }
        if (khaki_nk_check($user_source)) {
            $testimonal_source = '<div class="nk-testimonial-source">' . esc_html($user_source) . '</div>';
        }

        if(khaki_nk_check($style)){
            switch ($style) {
                case '1':
                    $result .= $testimonal_photo;
                    $result .= $testimonal_name;
                    $result .= $testimonal_source;
                    $result .= $testimonal_body;
                    break;
                case '2':
                case '3':
                    $result .= $testimonal_photo;
                    $result .= $testimonal_body;
                    $result .= $testimonal_name;
                    $result .= $testimonal_source;
                    break;
            }
        }

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);

        return '<blockquote class="' . khaki_sanitize_class(trim($class)) . '">' . $result . '</blockquote>';
    }
endif;


add_action( 'after_setup_theme', 'vc_nk_testimonial' );
if ( ! function_exists( 'vc_nk_testimonial' ) ) :
    function vc_nk_testimonial() {
        if(function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name' => esc_html__('nK Testimonial', 'khaki-shortcodes'),
                'base' => 'nk_testimonial',
                'controls' => 'full',
                'category' => 'nK',
                'icon'     => 'icon-nk icon-nk-testimonial',
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
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Style', 'khaki-shortcodes'),
                        'param_name' => 'style',
                        'std'        => '1',
                        'value'      => array(
                            esc_html__('Style 1', 'khaki-shortcodes')  => '1',
                            esc_html__('Style 2', 'khaki-shortcodes')  => '2',
                            esc_html__('Style 3', 'khaki-shortcodes')  => '3',
                        ),
                        'description' => ''
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__("Select Photo", 'khaki-shortcodes'),
                        'param_name' => 'photo',
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Photo Size', 'khaki-shortcodes'),
                        'param_name' => 'photo_size',
                        'std'        => 'full',
                        'value'      => khaki_get_image_sizes(),
                        'description' => '',
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('User Name', 'khaki-shortcodes'),
                        'param_name'  => 'user_name',
                        'value'       => '',
                        'description' => '',
                        'admin_label' => true
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('User Source', 'khaki-shortcodes'),
                        'param_name'  => 'user_source',
                        'value'       => '',
                        'description' => '',
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