<?php
/**
 * nK Text Typed
 *
 * Example:
 * [nk_text_typed text_before="Before " text_after=" After" loop="false" shuffle="false" cursor="_" type_speed="90" start_delay="0" back_speed="60" back_delay="1000"]Text 1|Text 2|Text 3[/nk_text_typed]
 */

add_shortcode('nk_text_typed', 'nk_text_typed');
if (!function_exists('nk_text_typed')) :
    function nk_text_typed($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "tag"       => "h2",
            "like"      => "h2",
            "align"      => "left",
            "classes"     => "",

            "text_before" => "",
            "text_after" => "",
            "loop" => "",
            "shuffle" => "",
            "cursor" => "_",
            "type_speed" => "90",
            "start_delay" => "0",
            "back_speed" => "60",
            "back_delay" => "1000",
            "class" => "",
        ), $atts));
        $result = $container_classes = $custom_attributes_str = '';

        switch ($tag) {
            case 'h1':
            case 'h2':
            case 'h3':
            case 'h4':
            case 'h5':
            case 'h6':
                break;
            default:
                $tag = 'div';
                break;
        }

        switch ($like) {
            case false:
            case 'h1':
            case 'h3':
            case 'h4':
            case 'h5':
            case 'h6':
            case 'display-1':
            case 'display-2':
            case 'display-3':
            case 'display-4':
                break;
            default:
                $like = false;
                break;
        }

        if (khaki_nk_check($like)) {
            $container_classes .= ' ' . $like;
        }
        if(khaki_nk_check($align)){
            $container_classes .= ' text-'.$align;
        }
        if(khaki_nk_check($classes)){
            $container_classes .= ' '.$classes;
        }
        $result .= "<" . $tag ." class='" . khaki_sanitize_class($container_classes) . "'>";

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);

        $result .= html_entity_decode($text_before);
        if (khaki_nk_check($content)) {
            if (khaki_nk_check($loop)) {
                $custom_attributes_str .= ' data-loop="' . esc_attr($loop) . '" ';
            }
            if (khaki_nk_check($shuffle)) {
                $custom_attributes_str .= ' data-shuffle="' . esc_attr($shuffle) . '" ';
            }
            if (khaki_nk_check($cursor)) {
                $custom_attributes_str .= ' data-cursor="' . esc_attr($cursor) . '" ';
            }
            if (khaki_nk_check($type_speed)) {
                $custom_attributes_str .= ' data-type-speed="' . esc_attr($type_speed) . '" ';
            }
            if (khaki_nk_check($start_delay)) {
                $custom_attributes_str .= ' data-start-delay="' . esc_attr($start_delay) . '" ';
            }
            if (khaki_nk_check($back_speed)) {
                $custom_attributes_str .= ' data-back-speed="' . esc_attr($back_speed) . '" ';
            }
            if (khaki_nk_check($back_delay)) {
                $custom_attributes_str .= ' data-back-delay="' . esc_attr($back_delay) . '" ';
            }

            $result .= ' <span class="db hidden-sm-up"></span>';
            $result .= '<span class="nk-typed ' . khaki_sanitize_class($class) . '"' . $custom_attributes_str . '>';

            if(khaki_nk_check($content) && function_exists('vc_param_group_parse_atts')) {
                $content = vc_param_group_parse_atts($content);

                foreach($content as $typed_text) {
                    $custom_speed = '';
                    if (isset($typed_text['custom_speed'])) {
                        $custom_speed = '^' . $typed_text['custom_speed'];
                    }
                    $result .= '<span>' . htmlspecialchars_decode(wp_kses_post($typed_text['typed_text'])) . esc_attr($custom_speed) . '</span>';
                }
            } else if (khaki_nk_check($content)) {
                $content = explode("|", $content);
                foreach($content as $typed_text) {
                    $result .= '<span>' . htmlspecialchars_decode(wp_kses_post($typed_text)) . '</span>';
                }
            }

            $result .= '</span>';
            $result .= ' <span class="db hidden-sm-up"></span>';
        }

        $result .= html_entity_decode($text_after);
        $result .= "</" . $tag . ">";
        return $result;
    }
endif;


add_action( 'after_setup_theme', 'vc_nk_text_typed' );
if ( ! function_exists( 'vc_nk_text_typed' ) ) :
    function vc_nk_text_typed() {
        if(function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name' => esc_html__('nK Text Typed', 'khaki-shortcodes'),
                'base' => 'nk_text_typed',
                'controls' => 'full',
                'category' => 'nK',
                'icon'     => 'icon-nk icon-nk-text-typed',
                'params' => array_merge(array(
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Tag', 'khaki-shortcodes'),
                        'param_name' => 'tag',
                        'std'        => 'h2',
                        'value'      => array(
                            esc_html__('h1', 'khaki-shortcodes')  => 'h1',
                            esc_html__('h2', 'khaki-shortcodes')  => 'h2',
                            esc_html__('h3', 'khaki-shortcodes')  => 'h3',
                            esc_html__('h4', 'khaki-shortcodes')  => 'h4',
                            esc_html__('h5', 'khaki-shortcodes')  => 'h5',
                            esc_html__('h6', 'khaki-shortcodes')  => 'h6',
                            esc_html__('div', 'khaki-shortcodes') => 'div',
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Looks Like', 'khaki-shortcodes'),
                        'param_name' => 'like',
                        'std'        => false,
                        'value'      => array(
                            esc_html__('disabled', 'khaki-shortcodes')  => false,
                            esc_html__('h1', 'khaki-shortcodes')  => 'h1',
                            esc_html__('h2', 'khaki-shortcodes')  => 'h2',
                            esc_html__('h3', 'khaki-shortcodes')  => 'h3',
                            esc_html__('h4', 'khaki-shortcodes')  => 'h4',
                            esc_html__('h5', 'khaki-shortcodes')  => 'h5',
                            esc_html__('h6', 'khaki-shortcodes')  => 'h6',
                            esc_html__('display-1', 'khaki-shortcodes')  => 'display-1',
                            esc_html__('display-2', 'khaki-shortcodes')  => 'display-2',
                            esc_html__('display-3', 'khaki-shortcodes')  => 'display-3',
                            esc_html__('display-4', 'khaki-shortcodes')  => 'display-4',
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Align', 'khaki-shortcodes'),
                        'param_name' => 'align',
                        'std'        => 'left',
                        'value'      => array(
                            esc_html__('Left', 'khaki-shortcodes')  => 'left',
                            esc_html__('Right', 'khaki-shortcodes')  => 'right',
                            esc_html__('Center', 'khaki-shortcodes')  => 'center',
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Container Classes', 'khaki-shortcodes'),
                        'param_name'  => 'classes',
                        'value'       => '',
                        'description' => '',
                    ),
                    array(
                        'type'        => 'param_group',
                        'heading'     => esc_html__('Typed Text Variants', 'khaki-shortcodes'),
                        'value'       => '',
                        'param_name'  => 'content',
                        'params'      => array(
                            array(
                                'type'        => 'textfield',
                                'heading'     => esc_html__('Text', 'khaki-shortcodes'),
                                'param_name'  => 'typed_text',
                                'value'       => 'Typed Text',
                                'admin_label' => true,
                            ),
                            array(
                                'type'        => 'textfield',
                                'heading'     => esc_html__('Custom Speed', 'khaki-shortcodes'),
                                'param_name'  => 'custom_speed',
                                'value'       => '',
                                'description' => esc_html__("Speed in milliseconds, example: 3000", 'khaki-shortcodes'),
                            )
                        ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Text Before', 'khaki-shortcodes'),
                        'param_name'  => 'text_before',
                        'value'       => '',
                        'description' => '',
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Text After', 'khaki-shortcodes'),
                        'param_name'  => 'text_after',
                        'value'       => '',
                        'description' => '',
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Custom Classes', 'khaki-shortcodes'),
                        'param_name'  => 'class',
                        'value'       => '',
                        'description' => '',
                    ),


                    /// Advanced Tab
                    array(
                        'type'        => 'checkbox',
                        'heading'     => esc_html__('Loop', 'khaki-shortcodes'),
                        'group'       => esc_html__( 'Advanced', 'khaki-shortcodes'),
                        'param_name'  => 'loop',
                        'value'       => array( '' => true )
                    ),
                    array(
                        'type'        => 'checkbox',
                        'heading'     => esc_html__('Shuffle', 'khaki-shortcodes'),
                        'group'       => esc_html__( 'Advanced', 'khaki-shortcodes'),
                        'param_name'  => 'shuffle',
                        'value'       => array( '' => true )
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Cursor', 'khaki-shortcodes'),
                        'group'       => esc_html__( 'Advanced', 'khaki-shortcodes'),
                        'param_name'  => 'cursor',
                        'value'       => '_',
                        'description' => '',
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Type Speed', 'khaki-shortcodes'),
                        'group'       => esc_html__( 'Advanced', 'khaki-shortcodes'),
                        'param_name'  => 'type_speed',
                        'value'       => '90',
                        'description' => esc_html__("Speed in milliseconds, example: 90", 'khaki-shortcodes'),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Start Delay', 'khaki-shortcodes'),
                        'group'       => esc_html__( 'Advanced', 'khaki-shortcodes'),
                        'param_name'  => 'start_delay',
                        'value'       => '0',
                        'description' => esc_html__("Delay in milliseconds, example: 0", 'khaki-shortcodes'),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Back Speed', 'khaki-shortcodes'),
                        'group'       => esc_html__( 'Advanced', 'khaki-shortcodes'),
                        'param_name'  => 'back_speed',
                        'value'       => '60',
                        'description' => esc_html__("Speed in milliseconds, example: 60", 'khaki-shortcodes'),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Back Delay', 'khaki-shortcodes'),
                        'group'       => esc_html__( 'Advanced', 'khaki-shortcodes'),
                        'param_name'  => 'back_delay',
                        'value'       => '1000',
                        'description' => esc_html__("Speed in milliseconds, example: 1000", 'khaki-shortcodes'),
                    ),
                ), khaki_get_css_tab())
            ) );
        }
    }
endif;