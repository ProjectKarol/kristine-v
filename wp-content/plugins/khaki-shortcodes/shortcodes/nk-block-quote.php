<?php
/**
 * nK Block Quote
 *
 * Example:
 * [nk_block_quote author="John" style="2" icon_color="" text_color="" link="http://google.com"]My Quote[/nk_block_quote]
 */

add_shortcode('nk_block_quote', 'nk_block_quote');
if (!function_exists('nk_block_quote')) :
    function nk_block_quote($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "author" => "",
            "style"  => "",
            "icon_color" => "",
            "text_color" => "",
            "link" => "",
            "class" => "",
        ), $atts));

        // style
        if($style == '2') {
            $class .= ' nk-blockquote-styled';
        }

        // text color
        if (khaki_nk_check($text_color)) {
            $content = '<div style="color: ' . esc_attr($text_color) . ';">' . $content . '</div>';
        }

        // icon
        $style_icon_color = '';
        if (khaki_nk_check($icon_color)) {
            $style_icon_color = ' style="color: ' . esc_attr($icon_color) . ';"';
        }
        $content = '<div class="nk-blockquote-icon"' . $style_icon_color . '>&ldquo;</div>' . $content;

        // author
        if (khaki_nk_check($author)) {
            $content .= '<div class="nk-blockquote-author">' . esc_html($author) . '</div>';
        }

        // link
        $link_atts = '';
        if (khaki_nk_check($link) && function_exists('vc_build_link')) {
            $link = vc_build_link($link);

            if(isset($link['url']) && $link['url']) {
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
            $link_atts = ' href="' . esc_attr($link) . '"';
        }

        if(khaki_nk_check($link_atts)) {
            $content = '<a class="nk-blockquote-cont"' . $link_atts . '>' . $content . '</a>';
        } else {
            $content = '<div class="nk-blockquote-cont">' . $content . '</div>';
        }

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);
        
        return '<blockquote class="nk-blockquote ' . khaki_sanitize_class($class) . '">' . khaki_remove_wpautop($content) . '</blockquote>';
    }
endif;

add_action( 'after_setup_theme', 'vc_nk_block_quote' );
if ( ! function_exists( 'vc_nk_block_quote' ) ) :
    function vc_nk_block_quote() {
        if(function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name' => esc_html__('nK Block Quote', 'khaki-shortcodes'),
                'base' => 'nk_block_quote',
                'controls' => 'full',
                'category' => 'nK',
                'icon'     => 'icon-nk icon-nk-block-quote',
                'params' => array_merge(array(
                    array(
                        'type'        => 'textarea_html',
                        'heading'     => esc_html__('Text', 'khaki-shortcodes'),
                        'param_name'  => 'content',
                        'holder'      => 'div',
                        'value'       => '<em>Creature dry face appear it had gathered earth seasons blessed Don\'t. Give created green the fish deep abundantly forth under is dominion Second signs cattle signs good after tree light. Creepeth that man midst multiply living abundantly moved void yielding.</em>',
                        'description' => '',
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Author', 'khaki-shortcodes'),
                        'param_name'  => 'author',
                        'value'       => 'John',
                        'description' => '',
                        'admin_label' => true
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Style', 'khaki-shortcodes'),
                        'param_name' => 'style',
                        'std'        => '1',
                        'value'      => array(
                            esc_html__('Style 1', 'khaki-shortcodes')  => '1',
                            esc_html__('Style 2', 'khaki-shortcodes')  => '2',
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'vc_link',
                        'heading'    => esc_html__('Link', 'khaki-shortcodes'),
                        'param_name' => 'link',
                    ),
                    array(
                        'type'       => 'colorpicker',
                        'heading'    => esc_html__('Icon Color', 'khaki-shortcodes'),
                        'param_name' => 'icon_color'
                    ),
                    array(
                        'type'       => 'colorpicker',
                        'heading'    => esc_html__('Text Color', 'khaki-shortcodes'),
                        'param_name' => 'text_color'
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