<?php
/**
 * nK Team Member
 *
 * Example:
 * [nk_team_member photo="12" photo_size="400x400" link="https://google.com" title="John" title_like="h4" rank="CEO" info_side="right" info_vertical_align="top"]
 */

add_shortcode('nk_team_member', 'nk_team_member');
if (!function_exists('nk_team_member')) :
    function nk_team_member($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "photo" => "",
            "photo_size" => "",
            "link" => "",
            "title" => "",
            "title_like" => "",
            "rank" => "",
            "info_side" => "right",
            "info_vertical_align" => "top",
            "class" => "",
        ), $atts));

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
        $link_str_begin = '<' . $tag . ' ' . $link_atts . '>';
        $link_str_end = '</' . $tag . '>';

        // photo
        $image_str = '';
        if (khaki_nk_check($photo)) {
            if (khaki_nk_check($photo_size)) {
                $image_path = wp_get_attachment_image_src($photo, $photo_size);
                if (khaki_nk_check($image_path)) {
                    $image_str = '<div class="nk-team-member-photo">' . $link_str_begin . '<img src="' . esc_url($image_path[0]) . '" alt="' . esc_attr($title) . '">' . $link_str_end . '</div>';
                }
            }
        }

        // title
        $str_title = '';
        if (khaki_nk_check($title)) {
            $str_title = '<h3 class="' . khaki_sanitize_class('nk-title ' . $title_like) . '">' . $link_str_begin . esc_html($title) . $link_str_end . '</h3>';
        }

        // rank
        $str_rank = '';
        if (khaki_nk_check($rank)) {
            $str_rank = '<div>' . esc_html($rank) . '</div>';
        }

        // info on left side
        if ($info_side == 'left') {
            $class .= ' nk-team-member-revert';
        }

        // info on bottom
        $info_class = '';
        if($info_vertical_align == 'bottom') {
            $info_class .= ' nk-team-member-info-bottom';
        }

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);

        return '<div class="nk-team-member ' . khaki_sanitize_class($class) . '">'
                    . $image_str .
                    '<div class="nk-team-member-info ' . khaki_sanitize_class($info_class) . '">
                        <div>
                           ' . $str_title . '
                           ' . $str_rank . '
                        </div>
                    </div>
                </div>';
    }
endif;


add_action( 'after_setup_theme', 'vc_nk_team_member' );
if ( ! function_exists( 'vc_nk_team_member' ) ) :
    function vc_nk_team_member() {
        if(function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name' => esc_html__('nK Team Member', 'khaki-shortcodes'),
                'base' => 'nk_team_member',
                'controls' => 'full',
                'category' => 'nK',
                'icon'     => 'icon-nk icon-nk-team-member',
                'params' => array_merge(array(
                    array(
                        'type'        => 'attach_image',
                        'heading'     => esc_html__("Select Photo", 'khaki-shortcodes'),
                        'param_name'  => 'photo',
                        'admin_label' => true,
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Photo Size', 'khaki-shortcodes'),
                        'param_name' => 'photo_size',
                        'std'        => 'full',
                        'value'      => khaki_get_image_sizes(),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'vc_link',
                        'heading'    => esc_html__('Link', 'khaki-shortcodes'),
                        'param_name' => 'link',
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Name', 'khaki-shortcodes'),
                        'param_name'  => 'title',
                        'value'       => '',
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
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Rank', 'khaki-shortcodes'),
                        'param_name'  => 'rank',
                        'value'       => '',
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Info Side', 'khaki-shortcodes'),
                        'param_name' => 'info_side',
                        'std'        => 'right',
                        'value'      => array(
                            esc_html__('Left', 'khaki-shortcodes')  => 'left',
                            esc_html__('Right', 'khaki-shortcodes')  => 'right',
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Info Vertical Align', 'khaki-shortcodes'),
                        'param_name' => 'info_vertical_align',
                        'std'        => 'top',
                        'value'      => array(
                            esc_html__('Top', 'khaki-shortcodes')  => 'top',
                            esc_html__('Bottom', 'khaki-shortcodes')  => 'bottom',
                        ),
                        'description' => ''
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