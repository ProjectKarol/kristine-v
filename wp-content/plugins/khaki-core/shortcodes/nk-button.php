<?php
/**
 * nK Button
 *
 * Example:
 * [nk_button link="https://googlee.com" effect="4" icon_right="" icon_left="" block="false" size="md" circle="false" color="black"]My Button[/nk_button]
 */

add_shortcode('nk_button', 'nk_button');
if (!function_exists('nk_button')) :
    function nk_button($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "link" => "",
            "effect" => "",
            "background_effect" => "",
            "effect_color" => "",
            "icon_right" => "",
            "icon_left" => "",
            "block" => "",
            "circle_hover" => "",
            "three_dimensional" => "",
            "outline" => "",
            "hover" => "",
            "size" => 'default',
            "edges" => "",
            "color" => "dark-1",
            "text_color" => "dark-1",
            "hover_color" => "",
            "class" => "",
        ), $atts));
        $icon_str_right = $icon_str_left = $background_effect_container = '';

        $fill_color_effects = array(
            '3-left',
            '3-right',
            '4-top',
            '4-bottom',
            '4-left',
            '4-right',
            '6-v',
            '6-h',
            '7-v',
            '7-h'
        );
        // add classes
        if (khaki_nk_check($text_color)) {
            $class .= ' text-' . $text_color;
        }
        if (khaki_nk_check($color)) {
            $class .= ' nk-btn-color-' . $color;
        }

        if(khaki_nk_check($effect)) {
            $class .= ' nk-btn-effect-' . $effect;
        }

        if(khaki_nk_check($size) && $size!='default') {
            $class .= ' nk-btn-' . $size;
        }

        if(khaki_nk_check($edges)) {
            $class .= ' nk-btn-'.$edges;
        }

        if(khaki_nk_check($block)) {
            $class .= ' nk-btn-block';
        }
        if(khaki_nk_check($three_dimensional)) {
            $class .= ' nk-btn-3d';
        }
        if(khaki_nk_check($outline)) {
            $class .= ' nk-btn-outline';
        }
        if(khaki_nk_check($circle_hover)) {
            $class .= ' nk-btn-circle-hover';
        }
        if(khaki_nk_check($hover)) {
            $class .= ' hover';
        }
        if($hover_color){
            $class .= ' nk-btn-color-hover-'.$hover_color;
        }
        if(khaki_nk_check($effect)) {
            if (array_search($effect, $fill_color_effects)!==false) {
                $class_effect = 'nk-btn-effect-bg';
                if ($effect_color) {
                    $class_effect .= ' bg-' . $effect_color;
                }
                $background_effect_container = '<span class="' . khaki_sanitize_class($class_effect) . '"></span>';
            }
        }
        // icons
        if (khaki_nk_check($icon_right)) {
            $icon_str_right = ' <span class="icon"><span class="' . khaki_sanitize_class($icon_right) . '"></span></span> ';
        }
        if (khaki_nk_check($icon_left)) {
            $icon_str_left = ' <span class="icon' . khaki_sanitize_class(' '.$icon_left) . '"></span> ';
        }

        // link
        $link_atts = '';
        $tag = 'span';
        if (khaki_nk_check($link) && function_exists('vc_build_link')) {
            $link = vc_build_link($link);

            if(isset($link['url']) && $link['url']) {
                $tag = 'a';
                $link_atts = ' href="' . esc_attr($link['url']) . '"';

                if(isset($link['title']) && $link['title']) {
                    $link_atts .= ' title="' . esc_attr($link['title']) . '"';
                }
                if(isset($link['target']) && $link['target']) {
                    $link_atts .= ' target="' . esc_attr($link['target']) . '"';
                }
                if(isset($link['rel']) && $link['rel']) {
                    $link_atts .= ' rel="' . esc_attr($link['rel']) . '"';
                }
            }
        } else if (khaki_nk_check($link)) {
            $tag = 'a';
            $link_atts = ' href="' . esc_attr($link) . '"';
        }

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);

        return '<' . $tag . $link_atts . ' class="' . khaki_sanitize_class('nk-btn ' . $class) . '">'.$background_effect_container.$icon_str_left.'<span>' . $content . '</span>' . $icon_str_right . '</' . $tag . '>';
    }
endif;


add_action( 'after_setup_theme', 'vc_nk_button' );
if ( ! function_exists( 'vc_nk_button' ) ) :
    function vc_nk_button() {
        if(function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name' => esc_html__('nK Button', 'khaki-core'),
                'base' => 'nk_button',
                'controls' => 'full',
                'category' => 'nK',
                'icon'     => 'icon-nk icon-nk-button',
                'params' => array_merge(array(
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Text', 'khaki-core'),
                        'param_name'  => 'content',
                        'value'       => 'Button',
                        'description' => '',
                        'admin_label' => true,
                    ),
                    array(
                        'type'       => 'vc_link',
                        'heading'    => esc_html__('Link', 'khaki-core'),
                        'param_name' => 'link',
                    ),
                    array(
                        "type"        => "iconpicker",
                        "heading"     => esc_html__('Icon Right', 'khaki-core'),
                        "param_name"  => "icon_right"
                    ),
                    array(
                        "type"        => "iconpicker",
                        "heading"     => esc_html__('Icon Left', 'khaki-core'),
                        "param_name"  => "icon_left"
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Effect', 'khaki-core'),
                        'param_name' => 'effect',
                        'std'        => false,
                        'value'      => array(
                            esc_html__('Disable', 'khaki-core')  => false,
                            esc_html__('Icon From Top no title', 'khaki-core')  => '1-top',
                            esc_html__('Icon From Bottom no title', 'khaki-core')  => '1-bottom',
                            esc_html__('Icon from left no title', 'khaki-core')  => '1-left',
                            esc_html__('Icon from Right no title', 'khaki-core')  => '1-right',
                            esc_html__('Icon From Left', 'khaki-core') => '2-left',
                            esc_html__('Icon From Right', 'khaki-core')  => '2-right',
                            esc_html__('Glow From Left', 'khaki-core') => '5-left',
                            esc_html__('Glow From Right', 'khaki-core') => '5-right',
                            esc_html__('Fill From Left Angle', 'khaki-core') => '3-left',
                            esc_html__('Fill From Right Angle', 'khaki-core')  => '3-right',
                            esc_html__('Fill From Top', 'khaki-core')  => '4-top',
                            esc_html__('Fill From Bottom', 'khaki-core')  => '4-bottom',
                            esc_html__('Fill From Left', 'khaki-core') => '4-left',
                            esc_html__('Fill From Right', 'khaki-core') => '4-right',
                            esc_html__('Fill From Center Vertical', 'khaki-core') => '6-v',
                            esc_html__('Fill From Center Horizontal', 'khaki-core') =>'6-h',
                            esc_html__('Fill From Center Vertical 2 ', 'khaki-core') => '7-v',
                            esc_html__('Fill From Center Horizontal 2', 'khaki-core') =>'7-h'
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Fill Color', 'khaki-core'),
                        'param_name' => 'effect_color',
                        'std'        => false,
                        'value'      => khaki_get_colors(),
                        'description' => '',
                        'dependency' => array(
                            'element' => 'effect',
                            'value' => array(
                                '3-left',
                                '3-right',
                                '4-top',
                                '4-bottom',
                                '4-left',
                                '4-right',
                                '6-v',
                                '6-h',
                                '7-v',
                                '7-h',
                            ),
                        ),
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Size', 'khaki-core'),
                        'param_name' => 'size',
                        'std'        => 'default',
                        'value'      => array(
                            esc_html__('Default', 'khaki-core')  => 'default',
                            esc_html__('Extra Small', 'khaki-core')  => 'xs',
                            esc_html__('Small', 'khaki-core')  => 'sm',
                            esc_html__('Mid', 'khaki-core')    => 'md',
                            esc_html__('Large', 'khaki-core')  => 'lg',
                            esc_html__('X2', 'khaki-core')     => 'x2',
                            esc_html__('X3', 'khaki-core')     => 'x3',
                            esc_html__('X4', 'khaki-core')     => 'x4'
                        ),
                        'description' => ''
                    ),
                    array(
                        'param_name'  => 'block',
                        'heading'     => esc_html__('Block', 'khaki-core'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        'param_name'  => 'outline',
                        'heading'     => esc_html__('Outline', 'khaki-core'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        'param_name'  => 'three_dimensional',
                        'heading'     => esc_html__('3D Effect', 'khaki-core'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        'param_name'  => 'circle_hover',
                        'heading'     => esc_html__('Circle Hover', 'khaki-core'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        'param_name'  => 'hover',
                        'heading'     => esc_html__('Always Hover', 'khaki-core'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('The Edges', 'khaki-core'),
                        'param_name' => 'edges',
                        'std'        => false,
                        'value'      => array(
                            esc_html__('Disabled', 'khaki-core')  => false,
                            esc_html__('Circle', 'khaki-core')  => 'circle',
                            esc_html__('Rounded', 'khaki-core')  => 'rounded',
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Background Color', 'khaki-core'),
                        'param_name' => 'color',
                        'std'        => 'dark-1',
                        'value'      => khaki_get_colors(),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Background Hover Color', 'khaki-core'),
                        'param_name' => 'hover_color',
                        'std'        => false,
                        'value'      => khaki_get_colors(),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Text Color', 'khaki-core'),
                        'param_name' => 'text_color',
                        'std'        => 'dark-1',
                        'value'      => khaki_get_colors(),
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
