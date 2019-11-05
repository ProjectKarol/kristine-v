<?php
/**
 * nK Counter
 *
 * Example:
 * [nk_counter style="1" count="58" count_color="#fff" icon="" icon_color="" title="Title" title_like="h4" show_border="false" align="center"]Text[/nk_counter]
 */

add_shortcode('nk_counter', 'nk_counter');
if (!function_exists('nk_counter')) :
    function nk_counter($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "style" => "1",
            "count" => "58",
            "count_color" => "",
            "icon" => "",
            "icon_color" => "",
            "title" => "",
            "title_like" => "h4",
            "show_border" => "",
            "align" => "center",
            "class" => "",
        ), $atts));

        if ($style == 2 || $style == 3) {
            $class .= ' nk-counter-' . $style;
        } else {
            $class .= ' nk-counter';
        }

        // align
        if (khaki_nk_check($align)) {
            $class .= ' text-' . $align;
        }

        // count
        if (khaki_nk_check($count)) {
            $count_color_style = '';
            if (khaki_nk_check($count_color)) {
                $count_color_style = ' style="color: ' . $count_color . ';"';
            }
            $count = '<div class="' . khaki_sanitize_class('nk-count') . '"' . $count_color_style . '>' . esc_html($count) . '</div>';
        }

        // title
        if (khaki_nk_check($title)) {
            $title = '<h3 class="' . khaki_sanitize_class('nk-counter-title ' . $title_like) . '">' . esc_html($title) . '</h3>';
        }

        // icon
        if (khaki_nk_check($icon)) {
            $icon_color_style = '';
            if (khaki_nk_check($icon_color)) {
                $icon_color_style = ' style="color: ' . $icon_color . ';"';
            }
            $icon = '<div class="' . khaki_sanitize_class('nk-counter-icon') . '"' . $icon_color_style . '>
                                <span class="' . khaki_sanitize_class($icon) . '"></span>
                       </div>';
        }

        // content
        if (khaki_nk_check($content)) {
            $content = '<p>' . do_shortcode($content) . '</p>';

            if ($style == 1) {
                $content = '<div class="nk-gap"></div> ' . $content;
            }
        }

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);
        
        // styles
        switch ($style) {
            case '2': {
                $result = '<div class="' . khaki_sanitize_class($class) . '">
                    ' . $count . '
                    ' . $title . '
                    <div class="nk-gap"></div>
                    ' . $content . '
                </div>';
                break;
            }
            case '3': {
                $result = '<div class="' . khaki_sanitize_class('nk-box-2' . (khaki_nk_check($show_border) ? ' nk-box-line' : '')) . '">
                        <div class="' . khaki_sanitize_class($class) . '">
                    ' . $icon . '
                    ' . $count . '
                    ' . $title . '
                    ' . $content . '
                        </div>
                    </div>';
                break;
            }
            default: {
                $result = '<div class="' . khaki_sanitize_class($class) . '">               
                    ' . $count . '
                    ' . $title . '
                    ' . $content . '
                </div>';
                break;
            }
        }
        return $result;
    }
endif;

add_action( 'after_setup_theme', 'vc_nk_counter' );
if ( ! function_exists( 'vc_nk_counter' ) ) :
    function vc_nk_counter() {
        if(function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name' => esc_html__('nK Counter', 'khaki-shortcodes'),
                'base' => 'nk_counter',
                'controls' => 'full',
                'category' => 'nK',
                'icon'     => 'icon-nk icon-nk-counter',
                'params' => array_merge(array(
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
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Count', 'khaki-shortcodes'),
                        'param_name'  => 'count',
                        'value'       => '58',
                        'description' => '',
                        'admin_label' => true,
                    ),
                    array(
                        'type'       => 'colorpicker',
                        'heading'    => esc_html__('Count Color', 'khaki-shortcodes'),
                        'param_name' => 'count_color',
                        'dependency' => array(
                            'element'    => 'count',
                            'not_empty'  => true
                        ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Title', 'khaki-shortcodes'),
                        'param_name'  => 'title',
                        'value'       => '',
                        'description' => '',
                        'admin_label' => true,
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Title Like', 'khaki-shortcodes'),
                        'param_name' => 'title_like',
                        'std'        => 'h4',
                        'value'      => array(
                            esc_html__('h1', 'khaki-shortcodes')  => 'h1',
                            esc_html__('h2', 'khaki-shortcodes')  => 'h2',
                            esc_html__('h3', 'khaki-shortcodes')  => 'h3',
                            esc_html__('h4', 'khaki-shortcodes')  => 'h4',
                            esc_html__('h5', 'khaki-shortcodes')  => 'h5',
                            esc_html__('h6', 'khaki-shortcodes')  => 'h6',
                            esc_html__('display-1', 'khaki-shortcodes')  => 'display-1',
                            esc_html__('display-2', 'khaki-shortcodes')  => 'display-2',
                            esc_html__('display-3', 'khaki-shortcodes')  => 'display-3',
                            esc_html__('display-4', 'khaki-shortcodes')  => 'display-4'
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'        => 'textarea',
                        'heading'     => esc_html__('Text', 'khaki-shortcodes'),
                        'param_name'  => 'content',
                        'value'       => '',
                        'description' => '',
                        'admin_label' => true,
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Align', 'khaki-shortcodes'),
                        'param_name' => 'align',
                        'std'        => 'center',
                        'value'      => array(
                            esc_html__('Left', 'khaki-shortcodes')  => 'left',
                            esc_html__('Center', 'khaki-shortcodes')  => 'center',
                            esc_html__('Right', 'khaki-shortcodes')  => 'right'
                        ),
                        'description' => ''
                    ),
                    array(
                        "type"        => "iconpicker",
                        "heading"     => esc_html__('Icon', 'khaki-shortcodes'),
                        "param_name"  => "icon",
                        'dependency' => array(
                            'element'    => 'style',
                            'value'      => array('3')
                        ),
                    ),
                    array(
                        'type'       => 'colorpicker',
                        'heading'    => esc_html__('Icon Color', 'khaki-shortcodes'),
                        'param_name' => 'icon_color',
                        'dependency' => array(
                            'element'    => 'icon',
                            'not_empty'  => true
                        ),
                    ),
                    array(
                        "type"        => "checkbox",
                        "heading"     => esc_html__('Show Border', 'khaki-shortcodes'),
                        "param_name"  => "show_border",
                        "value"       => array( "" => true ),
                        'dependency' => array(
                            'element'    => 'style',
                            'value'      => array('3')
                        ),
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