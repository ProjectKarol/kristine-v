<?php
/**
 * nK Title
 *
 * Example:
 * [nk_title tag="h2" like="h2"]My Title[/nk_title]
 */

add_shortcode('nk_title', 'nk_title');
if (!function_exists('nk_title')) :
    function nk_title($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "tag"       => "h2",
            "like"      => "h2",
            "style"     => false,
            "align"      => "left",
            "class"     => ""
        ), $atts));

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
                $like = 'h2';
                break;
        }
        if(khaki_nk_check($style)){
            $class .= ' nk-' . $style;
        }
        if (khaki_nk_check($like)) {
            $class .= ' ' . $like;
        }
        if(khaki_nk_check($align)){
            $class .= ' text-'.$align;
        }
        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);

        return "<" . $tag . " class='" . khaki_sanitize_class($class) . "'>" . do_shortcode($content) . "</" . $tag . ">";
    }
endif;


add_action( 'after_setup_theme', 'vc_nk_title' );
if ( ! function_exists( 'vc_nk_title' ) ) :
    function vc_nk_title() {
        if(function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name' => esc_html__('nK Title', 'khaki-core'),
                'base' => 'nk_title',
                'controls' => 'full',
                'category' => 'nK',
                'icon'     => 'icon-nk icon-nk-title',
                'params' => array_merge(array(
                    array(
                        'type'        => 'textarea_html',
                        'heading'     => esc_html__('Inner Text', 'khaki-core'),
                        'param_name'  => 'content',
                        'holder'      => 'div',
                        'value'       => '',
                        'description' => '',
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Tag', 'khaki-core'),
                        'param_name' => 'tag',
                        'std'        => 'h2',
                        'value'      => array(
                            esc_html__('h1', 'khaki-core')  => 'h1',
                            esc_html__('h2', 'khaki-core')  => 'h2',
                            esc_html__('h3', 'khaki-core')  => 'h3',
                            esc_html__('h4', 'khaki-core')  => 'h4',
                            esc_html__('h5', 'khaki-core')  => 'h5',
                            esc_html__('h6', 'khaki-core')  => 'h6',
                            esc_html__('div', 'khaki-core') => 'div',
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Looks Like', 'khaki-core'),
                        'param_name' => 'like',
                        'std'        => false,
                        'value'      => array(
                            esc_html__('disabled', 'khaki-core')  => false,
                            esc_html__('h1', 'khaki-core')  => 'h1',
                            esc_html__('h2', 'khaki-core')  => 'h2',
                            esc_html__('h3', 'khaki-core')  => 'h3',
                            esc_html__('h4', 'khaki-core')  => 'h4',
                            esc_html__('h5', 'khaki-core')  => 'h5',
                            esc_html__('h6', 'khaki-core')  => 'h6',
                            esc_html__('display-1', 'khaki-core')  => 'display-1',
                            esc_html__('display-2', 'khaki-core')  => 'display-2',
                            esc_html__('display-3', 'khaki-core')  => 'display-3',
                            esc_html__('display-4', 'khaki-core')  => 'display-4'
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Style', 'khaki-core'),
                        'param_name' => 'style',
                        'std'        => false,
                        'value'      => array(
                            esc_html__('disabled', 'khaki-core')  => false,
                            esc_html__('Title', 'khaki-core')  => 'title',
                            esc_html__('Sub Title', 'khaki-core')  => 'sub-title',
                            esc_html__('Title Back', 'khaki-core')  => 'title-back',
                            esc_html__('Portfolio Title', 'khaki-core')  => 'portfolio-title',
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Align', 'khaki-core'),
                        'param_name' => 'align',
                        'std'        => 'left',
                        'value'      => array(
                            esc_html__('Left', 'khaki-core')  => 'left',
                            esc_html__('Right', 'khaki-core')  => 'right',
                            esc_html__('Center', 'khaki-core')  => 'center',
                        ),
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
