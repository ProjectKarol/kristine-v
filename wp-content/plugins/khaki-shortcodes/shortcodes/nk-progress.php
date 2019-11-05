<?php
/**
 * nK Progress
 *
 * Example:
 * [nk_progress title="Progress" value="25" size="xl" animate_on_show="true" show_value="true" value_on_right_side="false" text_color="#ffffff" background="#222222" background_bar="#e6e6e6"]
 */

add_shortcode('nk_progress', 'nk_progress');
if (!function_exists('nk_progress')) :
    function nk_progress($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "title" => "",
            "value" => "25",
            "mask" => '{$}%',
            "size" => "",
            "animate_on_show" => "",
            "show_value" => "",
            "value_on_right_side" => "",
            "text_color" => "",
            "background" => "#e6e6e6",
            "background_bar" => "#1c1c1c",
            "class" => "",
        ), $atts));
        $result = $attribute = '';

        $class .= ' nk-progress';
        if (khaki_nk_check($size) && $size!='default') {
            $class .= ' nk-progress-' . $size;
        }
        if (khaki_nk_check($animate_on_show)) {
            $class .= ' nk-count';
        }
        if (khaki_nk_check($value_on_right_side)) {
            $class .= ' nk-progress-percent-static';
        }

        if (khaki_nk_check($value)) {
            $attribute = ' data-progress="' . esc_attr($value) . '"';
        }
        $attribute .= ' data-progress-mask="' . esc_attr($mask) . '"';

        // prepare colors
        if (khaki_nk_check($text_color)) {
            $text_color = 'color:' . $text_color . ';';
        } else {
            $text_color = '';
        }
        if (khaki_nk_check($background)) {
            $background = 'background-color:' . $background . ';';
        } else {
            $background = '';
        }
        if (khaki_nk_check($background_bar)) {
            $background_bar = 'background-color:' . $background_bar . ';';
        } else {
            $background_bar = '';
        }

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);

        $result .= '<div class="' . khaki_sanitize_class($class) . '"' . $attribute . '>';
        if (khaki_nk_check($title)) {
            $result .= '<div class="nk-progress-title" style="' . esc_attr($text_color) . '">' . esc_html($title) . '</div>';
        }
        if (khaki_nk_check($value)) {
            $result .= '<div class="nk-progress-line" style="' . esc_attr($background) . '">';
            $result .= '<div style="width: ' . esc_attr($value) . '%; ' . esc_attr($background_bar) . '">';
            if (khaki_nk_check($show_value)) {
                $result .= '<div class="nk-progress-percent" style="' . esc_attr($text_color) . '">';
                $result .= esc_html(str_replace('{$}', $value, $mask));
                $result .= '</div>';
            }
            $result .= '</div>';
            $result .= '</div>';
        }
        $result .= '</div>';
        return $result;
    }
endif;


add_action( 'after_setup_theme', 'vc_nk_progress' );
if ( ! function_exists( 'vc_nk_progress' ) ) :
    function vc_nk_progress() {
        if(function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name' => esc_html__('nK Progress', 'khaki-shortcodes'),
                'base' => 'nk_progress',
                'controls' => 'full',
                'category' => 'nK',
                'icon'     => 'icon-nk icon-nk-progress',
                'params' => array_merge(array(
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Title', 'khaki-shortcodes'),
                        'param_name'  => 'title',
                        'value'       => '',
                        'description' => '',
                        'admin_label' => true
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Value', 'khaki-shortcodes'),
                        'param_name'  => 'value',
                        'value'       => '25',
                        'description' => '',
                        'admin_label' => true
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Show Mask', 'khaki-shortcodes'),
                        'description' => esc_html__('Use mask to change progress value view. Add {$} to show current progress value.', 'khaki-shortcodes'),
                        'param_name'  => 'mask',
                        'value'       => '{$}%',
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Size', 'khaki-shortcodes'),
                        'param_name' => 'size',
                        'std'        => 'default',
                        'value'      => array(
                            esc_html__('Default', 'khaki-shortcodes')  => 'default',
                            esc_html__('Extra Small', 'khaki-shortcodes')  => 'xs',
                            esc_html__('Small', 'khaki-shortcodes')  => 'sm',
                            esc_html__('Mid', 'khaki-shortcodes')  => 'md',
                            esc_html__('Large', 'khaki-shortcodes')  => 'lg',
                            esc_html__('Extra Large', 'khaki-shortcodes')  => 'xlg',
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'        => 'checkbox',
                        'heading'     => esc_html__('Show Value', 'khaki-shortcodes'),
                        'param_name'  => 'show_value',
                        'value'       => array( '' => true ),
                        'std'         => true
                    ),
                    array(
                        'type'        => 'checkbox',
                        'heading'     => esc_html__('Value on Right Side', 'khaki-shortcodes'),
                        'param_name'  => 'value_on_right_side',
                        'value'       => array( '' => true )
                    ),
                    array(
                        'type'        => 'checkbox',
                        'heading'     => esc_html__('Animate on Show', 'khaki-shortcodes'),
                        'param_name'  => 'animate_on_show',
                        'value'       => array( '' => true )
                    ),
                    array(
                        'type'       => 'colorpicker',
                        'heading'    => esc_html__('Text Color', 'khaki-shortcodes'),
                        'param_name' => 'text_color',
                        'value'      => ''
                    ),
                    array(
                        'type'       => 'colorpicker',
                        'heading'    => esc_html__('Background Color', 'khaki-shortcodes'),
                        'param_name' => 'background',
                        'value'      => '#e6e6e6'
                    ),
                    array(
                        'type'       => 'colorpicker',
                        'heading'    => esc_html__('Background Bar Color', 'khaki-shortcodes'),
                        'param_name' => 'background_bar',
                        'value'      => '#1c1c1c'
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
