<?php
/**
 * nK Info Box
 *
 * Example:
 * [nk_info_box icon="fa fa-exclamation-circle" show_close_button="true"]My Info Box Content[/nk_info_box]
 */

add_shortcode('nk_info_box', 'nk_info_box');
if (!function_exists('nk_info_box')) :
    function nk_info_box($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "icon" => "fa fa-exclamation-circle",
            "show_close_button" => "",
            "class" => "",
        ), $atts));
        $icon_str = $close_button_str = '';

        if (khaki_nk_check($icon)) {
            $icon_str = '<div class="nk-info-box-icon">
                            <span class="' . khaki_sanitize_class($icon) . '"></span>
                        </div>';
        }
        if (khaki_nk_check($show_close_button)) {
            $close_button_str = '<div class="nk-info-box-close nk-info-box-close-btn">
                                    <span class="ion-md-close"></span>
                                </div>';
        }

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);

        return '<div class="' . khaki_sanitize_class(trim('nk-info-box ' . $class)) . '">
                    ' . $icon_str . '
                    ' . $close_button_str . '
                    ' . khaki_remove_wpautop($content, true) . '
                </div>';
    }
endif;


add_action( 'after_setup_theme', 'vc_nk_info_box' );
if ( ! function_exists( 'vc_nk_info_box' ) ) :
    function vc_nk_info_box() {
        if(function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name' => esc_html__('nK Info Box', 'khaki-core'),
                'base' => 'nk_info_box',
                'controls' => 'full',
                'category' => 'nK',
                'icon'     => 'icon-nk icon-nk-info-box',
                "is_container"  => true,
                "js_view"  => 'VcColumnView',
                'params' => array_merge(array(
                    array(
                        'type'        => 'iconpicker',
                        'heading'     => esc_html__('Icon', 'khaki-core'),
                        'param_name'  => 'icon',
                        'value'       => 'fa fa-exclamation-circle',
                    ),
                    array(
                        'type'        => 'checkbox',
                        'heading'     => esc_html__('Show Close Button', 'khaki-core'),
                        'param_name'  => 'show_close_button',
                        'value'       => array( '' => true )
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


//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_nk_info_box extends WPBakeryShortCodesContainer {
    }
}
