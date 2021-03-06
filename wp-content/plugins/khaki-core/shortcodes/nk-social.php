<?php
/**
 * nK Social
 */

add_shortcode('nk_social', 'nk_social');
if (!function_exists('nk_social')) :
    function nk_social($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "socials" => "",
            "class" => "",
        ), $atts));
        $result = '';

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);
        $class .= ' nk-widget-social';

        // parsing social array
        if (khaki_nk_check($socials) && function_exists('vc_param_group_parse_atts')) {
            $socials = vc_param_group_parse_atts($socials);
        } elseif (khaki_nk_check($socials)) {
            $socials_array = explode("|", $socials);
            $socials = array();
            foreach ($socials_array as $key_track => $track) {
                $track_array = explode(",", $track);
                foreach ($track_array as $key_field => $field) {
                    $field = trim($field);
                    switch ($key_field) {
                        case 0:
                            $socials[$key_track]['icon'] = $field;
                            break;
                        case 1:
                            $socials[$key_track]['link'] = $field;
                            break;
                    }
                }
            }
        }

        // output
        if (khaki_nk_check($socials) && is_array($socials) && !empty($socials)) {
            $result .= '<div class="'.khaki_sanitize_class(trim($class)).'">';
            foreach($socials as $social){
                if(khaki_nk_check($social) && is_array($social) && !empty($social) && isset($social['link']) && isset($social['icon'])){
                    $result .= '<a href="'.esc_url($social['link']).'"><span class="'.khaki_sanitize_class($social['icon']).'"></span></a>';
                }
            }
            $result .= '</div>';
        }
        return $result;
    }
endif;

add_action( 'after_setup_theme', 'vc_nk_social' );
if ( ! function_exists( 'vc_nk_social' ) ) :
    function vc_nk_social() {
        if(function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name' => esc_html__('nK Social', 'khaki-core'),
                'base' => 'nk_social',
                'controls' => 'full',
                'category' => 'nK',
                'icon'     => 'icon-nk',
                'params' => array_merge(array(
                    array(
                        'type' => 'param_group',
                        'heading' => esc_html__('Socials', 'khaki-core'),
                        'value' => '',
                        'param_name' => 'socials',
                        'params' => array(
                            array(
                                "type"        => "iconpicker",
                                "heading"     => esc_html__('Icon', 'khaki-core'),
                                "param_name"  => "icon"
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Link', 'khaki-core'),
                                'param_name' => 'link',
                                'value' => '',
                            ),
                        ),
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
