<?php
/**
 * nK Separator
 * 
 * Example:
 * 
 */

add_shortcode('nk_separator', 'nk_separator');
if (!function_exists('nk_separator')) :
    function nk_separator($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "style" => false,
            "icon" => "fa fa-search",
            "align" => "",
            "class" => ""
        ), $atts));

        if(khaki_nk_check($style) && $style=='icon'){
            $class .= ' nk-title-sep-icon';
        }else{
            $class .= ' nk-title-sep';
        }
        if(khaki_nk_check($align)){
            $class .= ' text-'.$align;
        }
        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);

        $result = '<div class="' . khaki_sanitize_class($class) . '">';

        if(khaki_nk_check($icon) && khaki_nk_check($style) && $style=='icon'){
            $result.='<span class="icon"><span class="' . khaki_sanitize_class($icon) . '"></span></span>';
        }

        $result.='</div>';

        return $result;
    }
endif;

add_action( 'after_setup_theme', 'vc_nk_separator' );
if ( ! function_exists( 'vc_nk_separator' ) ) :
    function vc_nk_separator() {
        if(function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name' => esc_html__('nK Separator', 'khaki-core'),
                'base' => 'nk_separator',
                'controls' => 'full',
                'category' => 'nK',
                'icon'     => 'icon-nk',
                'params' => array_merge(array(
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Style', 'khaki-core'),
                        'param_name' => 'style',
                        'std'        => false,
                        'value'      => array(
                            esc_html__('disabled', 'khaki-core')  => false,
                            esc_html__('Icon', 'khaki-core')  => 'icon',
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'        => 'iconpicker',
                        'heading'     => esc_html__('Icon', 'khaki-core'),
                        'param_name'  => 'icon',
                        'admin_label' => true,
                        'value'       => 'fa fa-search',
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