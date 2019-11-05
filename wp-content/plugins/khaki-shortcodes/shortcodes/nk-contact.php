<?php
/**
 * nK Contact
 *
 * Example:
 * [nk_contact]ion-ios-email, contact@khaki.com | ion-ios-telephone, + 3 (700) 123 444 10 78[/nk_button]
 */

add_shortcode('nk_contact', 'nk_contact');
if (!function_exists('nk_contact')) :
    function nk_contact($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "class" => "",
        ), $atts));
        $result = '';

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);
        $class .= ' nk-widget-contact';
        
        if (khaki_nk_check($content)) {

            $result .= '<ul class="'.khaki_sanitize_class(trim($class)).'">';
           if(khaki_nk_check($content) && function_exists('vc_param_group_parse_atts')) {
                $content = vc_param_group_parse_atts($content);

                foreach($content as $contact) {
                    $result .= '<li>';
                    if(isset($contact['icon']) && !empty($contact['icon'])){
                        $class = $contact['icon'];
                        $result .= '<span class="nk-widget-contact-icon">';
                        $result .= '<span class="'.khaki_sanitize_class($class).'"></span>';
                        $result .= '</span>';
                    }
                    if(isset($contact['link']) && !empty($contact['link'])) {
                        $result .= '<a href="' . esc_url($contact['link']) . '">';
                    }
                    if(isset($contact['text']) && !empty($contact['text'])){
                        $result .= esc_html($contact['text']);
                    }
                    if(isset($contact['link']) && !empty($contact['link'])) {
                        $result .= '</a> ';
                    }
                    $result .= '</li>';
                }
            } else if (khaki_nk_check($content)) {
                $content = explode("|", $content);
                $content_array = array();
                foreach ($content as $key => $contact) {
                    $contact_array = explode(",", $contact);
                    foreach ($contact_array as $key_field => $field) {
                        $field = trim($field);
                        switch ($key_field) {
                            case 0:
                                $content_array[$key]['icon'] = $field;
                                break;
                            case 1:
                                $content_array[$key]['text'] = $field;
                                break;
                            case 2:
                                $content_array[$key]['link'] = $field;
                                break;
                        }
                    }
                }
                foreach($content_array as $contact) {

                    $result .= '<li>';
                    if(isset($contact['icon']) && !empty($contact['icon'])){
                        $class = $contact['icon'];
                        $result .= '<span class="nk-widget-contact-icon">';
                        $result .= '<span class="'.khaki_sanitize_class($class).'"></span>';
                        $result .= '</span>';
                    }
                    if(isset($contact['link']) && !empty($contact['link'])) {
                        $result .= '<a href="' . esc_url($contact['link']) . '">';
                    }
                    if(isset($contact['text']) && !empty($contact['text'])){
                        $result .= esc_html($contact['text']);
                    }
                    if(isset($contact['link']) && !empty($contact['link'])) {
                        $result .= '</a> ';
                    }
                    $result .= '</li>';
                }
            }
            $result .= '</ul>';

        }

        return $result;
    }
endif;


add_action( 'after_setup_theme', 'vc_nk_contact' );
if ( ! function_exists( 'vc_nk_contact' ) ) :
    function vc_nk_contact() {
        if(function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name' => esc_html__('nK Contact', 'khaki-shortcodes'),
                'base' => 'nk_contact',
                'controls' => 'full',
                'category' => 'nK',
                'icon'     => 'icon-nk',
                'params' => array_merge(array(
                    array(
                        'type'        => 'param_group',
                        'heading'     => esc_html__('Contacts', 'khaki-shortcodes'),
                        'value'       => '',
                        'param_name'  => 'content',
                        'params'      => array(
                            array(
                                "type"        => "iconpicker",
                                "heading"     => esc_html__('Icon', 'khaki-shortcodes'),
                                "param_name"  => "icon",
                                'admin_label' => true,
                            ),
                            array(
                                'type'        => 'textfield',
                                'heading'     => esc_html__('Text', 'khaki-shortcodes'),
                                'param_name'  => 'text',
                                'value'       => '',
                                'admin_label' => true,
                            ),
                            array(
                                'type'        => 'textfield',
                                'heading'     => esc_html__('Link', 'khaki-shortcodes'),
                                'param_name'  => 'link',
                                'value'       => ''
                            )
                        ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Custom Classes', 'khaki-shortcodes'),
                        'param_name'  => 'class',
                        'value'       => '',
                        'description' => '',
                    ),
                ), khaki_get_css_tab())
            ) );
        }
    }
endif;