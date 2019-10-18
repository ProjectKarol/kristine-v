<?php
/**
 * nK Pricing Table
 *
 * Example:
 * [nk_pricing_table title="Business" price="12" currency_symbol="$" period="month"]
 */

add_shortcode('nk_pricing_table', 'nk_pricing_table');
if (!function_exists('nk_pricing_table')) :
    function nk_pricing_table($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "style" => 1,
            "title" => "",
            "price" => "",
            "start_from" => 0,
            "currency_symbol" => "",
            "period" => "",
            "features_list" => "",
            "price_list"    => "",
            "text_color" => "",
            "header_color" => "",
            "header_background_image" => "",
            "substrate_color" => false,
            "button_title" => "",
            "button_link"  => "",
            "class" => "",
        ), $atts));
        $result = $title_str = $features_str = $price_str = $start_from_str = $content_str = $color_style = '';
        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);
        if (khaki_nk_check($style)) {
            // title
            if (khaki_nk_check($title)) {
                $title_str = '<h3 class="nk-pricing-title">' . esc_html($title) . '</h3>';
            }
            // features list
            if (khaki_nk_check($features_list) && function_exists('vc_param_group_parse_atts')) {
                $features_str = '<ul class="nk-pricing-features">';

                $features_list = vc_param_group_parse_atts($features_list);
                foreach ($features_list as $feature) {
                    if (is_array($feature) && isset($feature['feature']) && !empty($feature['feature'])) {
                        $features_str .= '<li>' . esc_html($feature['feature']) . '</li>';
                    }
                }

                $features_str .= '</ul>';
            }
            // price
            if (khaki_nk_check($price) || khaki_nk_check($currency_symbol) || khaki_nk_check($period)) {
                $price_str = '<div class="nk-pricing-price">';
                if (khaki_nk_check($currency_symbol)) {
                    $price_str .= '<span class="nk-pricing-currency">' . esc_html($currency_symbol) . '</span>';
                }
                if (khaki_nk_check($price)) {
                    if(isset($start_from) && !empty($start_from)){
                        $start_from_str = ' data-nk-count-from="'.esc_attr($start_from).'"';
                        $price_str .= '<span class="nk-count"'.$start_from_str.'>';
                    }
                    $price_str .= esc_html($price);
                    if(isset($start_from) && !empty($start_from)){
                        $price_str .= '</span>';
                    }
                }
                if (khaki_nk_check($period)) {
                    $price_str .= '<span class="nk-pricing-period">/ ' . esc_html($period) . '</span>';
                }
                $price_str .= '</div>';
            }
            // content
            if (khaki_nk_check($content)) {
                $content_str = '<div class="nk-pricing-button">' . do_shortcode($content) . '</div>';
            }
            // text color
            if(khaki_nk_check($text_color)) {
                $color_style .= ' style="';
                $color_style .= 'color: ' . esc_attr($text_color) . ';';
                $color_style .= '"';
            }
            $class .= 'nk-pricing-' . $style;
            $result .= '<div class="' . khaki_sanitize_class($class) . '" ' . $color_style . '>';
            switch ($style) {
                case 1:
                    $substrate_classes = 'nk-pricing-cover';
                    $result .= $price_str;
                    $result .= $title_str;
                    $result .= '<div class="nk-gap-3"></div>';
                    $result .= '<div class="nk-divider"></div>';
                    $result .= '<div class="nk-gap-3"></div>';
                    $result .= $features_str;
                    if(khaki_nk_check($substrate_color)){
                        $substrate_classes .= ' bg-' . $substrate_color;
                    }
                    $result .= '<div class="'.khaki_sanitize_class($substrate_classes).'"></div>';
                    if(khaki_nk_check($button_title)){
                        $result .= khaki_nk_check($button_link) ? '<a href="'.esc_url($button_link).'"' : '<span';
                        $result .= ' class="nk-pricing-button">';
                        $result .= esc_html($button_title);
                        $result .= khaki_nk_check($button_link) ? '</a>' : '</span>';
                    }
                    $result .= $content_str;
                    break;
                case 2:
                    $header_color_str = '';
                    if(khaki_nk_check($header_color)) {
                        $header_color_str .= ' style="';
                        $header_color_str .= 'background-color: ' . esc_attr($header_color) . ';';
                        $header_color_str .= '"';
                    }
                    $result .= '<div class="nk-pricing-header"'.$header_color_str.'>';
                    if(khaki_nk_check($header_background_image)){
                        $header_background_image = khaki_get_attachment($header_background_image, 'khaki_800x600');
                        if(isset($header_background_image) && is_array($header_background_image) && !empty($header_background_image)){
                            $result .='<div class="bg-image op-6" style="background-image: url('."'".$header_background_image['src']."'".');"></div>';
                        }
                    }
                    $result .= $price_str;
                    $result .= $title_str;
                    $result .= '</div>';
                    $result .= '<div class="nk-pricing-body">';
                    $result .= $features_str;
                    $result .= $content_str;
                    $result .= '</div>';  
                    break;
                case 3:
                    $result .= $title_str;
                    $result .= $price_str;
                    $result .= $features_str;
                    $result .= $content_str;
                    break;
                case 'menu':
                    if (khaki_nk_check($title)) {
                        $result .= '<h2 class="nk-title h4">' . esc_html($title) . '</h2>';
                        $result .= '<div class="nk-gap-1"></div>';
                    }
                    if (khaki_nk_check($price_list) && function_exists('vc_param_group_parse_atts')) {
                        $price_list = vc_param_group_parse_atts($price_list);
                        foreach ($price_list as $price_item) {
                            if (is_array($price_item)) {
                                $result .= '<div class="nk-pricing-menu-item">';
                                    if(isset($price_item['name']) && !empty($price_item['name'])){
                                        $result .= '<div class="nk-pricing-header">';
                                        $result .= '<h3 class="nk-pricing-title h5">';
                                        $result .= esc_html($price_item['name']);
                                        $result .= '</h3>';
                                        if(isset($price_item['price']) && !empty($price_item['price'])){
                                            $result .= '<div class="nk-pricing-title-dots"></div>';
                                            $result .= '<div class="nk-pricing-price">';
                                            $result .= khaki_nk_check($currency_symbol) ? $currency_symbol : '';
                                            $result .= esc_html($price_item['price']);
                                            $result .= '</div>';
                                        }
                                        $result .= '</div>';
                                    }
                                    if(isset($price_item['description']) && !empty($price_item['description'])){
                                        $result .= '<div class="nk-pricing-sub-title">';
                                        $result .= esc_html($price_item['description']);
                                        $result .= '</div>';
                                    }
                                $result .= '</div>';
                            }
                        }
                    }
                    $result .= $content_str;
                    break;
            }
            $result .= '</div>';
            $result .= '<div class="clearfix"></div>';
        }

return $result;

        
    }
endif;


add_action('after_setup_theme', 'vc_nk_pricing_table');
if (!function_exists('vc_nk_pricing_table')) :
    function vc_nk_pricing_table()
    {
        if (function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map(array(
                'name' => esc_html__('nK Pricing Table', 'khaki-core'),
                'base' => 'nk_pricing_table',
                'controls' => 'full',
                'category' => 'nK',
                'icon' => 'icon-nk icon-nk-pricing-table',
                "is_container" => true,
                "js_view" => 'VcColumnView',
                'params' => array_merge(array(
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Style", 'khaki-core'),
                        "param_name" => "style",
                        "value" => array(1, 2, 3, 'menu'),
                        "std" => 1,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Title', 'khaki-core'),
                        'param_name' => 'title',
                        'value' => '',
                        'description' => '',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Price', 'khaki-core'),
                        'param_name' => 'price',
                        'value' => '',
                        'description' => '',
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array(
                                '1',
                                '2',
                                '3',
                            ),
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Start From', 'khaki-core'),
                        'param_name' => 'start_from',
                        'value' => '',
                        "std" => 0,
                        'description' => esc_html__('Price of accumulation effect', 'khaki-core'),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array(
                                '1',
                                '2',
                                '3',
                            ),
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Currency Symbol', 'khaki-core'),
                        'param_name' => 'currency_symbol',
                        'value' => '',
                        'description' => '',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Period', 'khaki-core'),
                        'param_name' => 'period',
                        'value' => '',
                        'description' => '',
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array(
                                '1',
                                '2',
                                '3',
                            ),
                        ),
                    ),
                    array(
                        'type' => 'param_group',
                        'heading' => esc_html__('Features List', 'khaki-core'),
                        'value' => '',
                        'param_name' => 'features_list',
                        'params' => array(
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Feature', 'khaki-core'),
                                'param_name' => 'feature',
                                'admin_label' => true,
                            ),
                        ),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array(
                                '1',
                                '2',
                                '3',
                            ),
                        ),
                    ),
                    array(
                        'type' => 'param_group',
                        'heading' => esc_html__('Price List', 'khaki-core'),
                        'value' => '',
                        'param_name' => 'price_list',
                        'params' => array(
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Service or Product Title', 'khaki-core'),
                                'param_name' => 'name',
                                'admin_label' => true,
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Price', 'khaki-core'),
                                'param_name' => 'price',
                                'admin_label' => true,
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Description', 'khaki-core'),
                                'param_name' => 'description',
                                'admin_label' => true,
                            ),
                        ),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => 'menu',
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Button Title', 'khaki-core'),
                        'param_name' => 'button_title',
                        'value' => '',
                        'description' => '',
                        'dependency' => array(
                            'element' => 'style',
                            'value' => "1",
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Button Link', 'khaki-core'),
                        'param_name' => 'button_link',
                        'value' => '',
                        'description' => '',
                        'dependency' => array(
                            'element' => 'style',
                            'value' => "1",
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Custom Classes', 'khaki-core'),
                        'param_name' => 'class',
                        'value' => '',
                        'description' => '',
                    ),
                    array(
                        'type' => 'colorpicker',
                        'heading' => esc_html__('Text Color', 'khaki-core'),
                        'param_name' => 'text_color',
                        'group' => esc_html__('Design Options', 'khaki-core'),

                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Substrate Background Color', 'khaki-core'),
                        'param_name' => 'substrate_color',
                        'group' => esc_html__('Design Options', 'khaki-core'),
                        'std'        => false,
                        'value'      => khaki_get_colors(),
                        'description' => '',
                        'dependency' => array(
                            'element' => 'style',
                            'value' => "1",
                        ),
                    ),
                    array(
                        'type' => 'colorpicker',
                        'heading' => esc_html__('Header Color', 'khaki-core'),
                        'param_name' => 'header_color',
                        'group' => esc_html__('Design Options', 'khaki-core'),
                        "dependency" => array(
                            "element" => "style",
                            "value" => "2"
                        )
                    ),
                    array(
                        'type'       => 'attach_image',
                        'heading'    => esc_html__('Header Background Image', 'khaki-core'),
                        'param_name' => 'header_background_image',
                        'group' => esc_html__('Design Options', 'khaki-core'),
                        'description' => '',
                        "dependency" => array(
                            "element" => "style",
                            "value" => "2"
                        )
                    ),
                ), khaki_get_css_tab())
            ));
        }
    }
endif;


//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_nk_pricing_table extends WPBakeryShortCodesContainer
    {
    }
}