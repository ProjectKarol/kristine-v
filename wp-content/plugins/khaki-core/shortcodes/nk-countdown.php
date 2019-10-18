<?php
/**
 * nK Countdown
 *
 * Example:
 * [nk_countdown date_end="2017-11-26 08:20" date_timezone="EST"]
 */

add_shortcode('nk_countdown', 'nk_countdown');
if (!function_exists('nk_countdown')) :
    function nk_countdown($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "date_end" => "2017-11-26 08:20",
            "date_timezone" => "EST",
            "class" => "",
        ), $atts));

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);

        return '<div class="nk-countdown ' . khaki_sanitize_class($class) . '" data-end="' . esc_attr($date_end) . '" data-timezone="' . esc_attr($date_timezone) . '"></div>';
    }
endif;

add_action( 'after_setup_theme', 'vc_nk_countdown' );
if ( ! function_exists( 'vc_nk_countdown' ) ) :
    function vc_nk_countdown() {
        if(function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name' => esc_html__('nK Countdown', 'khaki-core'),
                'base' => 'nk_countdown',
                'controls' => 'full',
                'category' => 'nK',
                'icon'     => 'icon-nk icon-nk-countdown',
                'params' => array_merge(array(
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__("Date End", 'khaki-core'),
                        'param_name'  => 'date_end',
                        'value'       => '2017-11-26 08:20',
                        'description' => esc_html__("Example: 2017-11-26 08:20", 'khaki-core'),
                        'admin_label' => true,
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Date Timezone', 'khaki-core'),
                        'param_name' => 'date_timezone',
                        'std'        => 'EST',
                        'value'      => khaki_get_tz_list(),
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