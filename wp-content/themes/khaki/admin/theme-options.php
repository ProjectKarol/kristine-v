<?php
/**
 * Fix for body typography font Variants
 */
if (!function_exists('khaki_enqueue_body_font_variants')) :
    function khaki_enqueue_body_font_variants( $fonts ) {
        $bodyFamily = get_theme_mod('typography_main_body', false);
        $titlesFamily = get_theme_mod('typography_titles', false);

        if (!is_array($bodyFamily)) {
            $bodyFamily = array('font-family' => 'Nunito Sans');
        }

        if (!is_array($titlesFamily)) {
            $titlesFamily = array('font-family' => 'Montserrat');
        }

        $bodyFamily = $bodyFamily['font-family'];
        $titlesFamily = $titlesFamily['font-family'];

        $fonts[$bodyFamily] = array(
            'regular',
            'italic',
            '600',
            '700'
        );
        $fonts[$titlesFamily] = array(
            'regular',
            '700'
        );

        return $fonts;
    }
endif;
add_filter( 'kirki/enqueue_google_fonts', 'khaki_enqueue_body_font_variants' );

if (!function_exists('khaki_customize_register')) :
    function khaki_customize_register($wp_customize)
    {
        $wp_customize->get_setting('blogname')->transport = 'postMessage';
        $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
        $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';
        $wp_customize->get_control('site_icon')->priority = 10;

        $wp_customize->remove_control('display_header_text');

        $wp_customize->get_section('title_tagline')->title = 'General';
        $wp_customize->get_section('title_tagline')->priority = 1;

        $wp_customize->remove_section('colors');
        $wp_customize->remove_section('header_image');
        $wp_customize->remove_section('background_image');
    }
endif;
add_action('customize_register', 'khaki_customize_register');

/*if (!function_exists('khaki_theme_kirki_update_url')) {
    function khaki_theme_kirki_update_url($config)
    {
        $config['url_path'] = nk_admin()->admin_uri . '/lib/kirki/';
        return $config;
    }
}
add_filter('kirki/config', 'khaki_theme_kirki_update_url');
*/
if(!function_exists('khaki_get_sidebars')):
    function khaki_get_sidebars(){
        global $wp_registered_sidebars;
        $sidebars = array();
        foreach ($wp_registered_sidebars as $k => $sidebar) {
            $sidebars[$sidebar['id']] = $sidebar['name'];
        }
        return $sidebars;
    }
endif;
if (!function_exists('khaki_initial_kirki_options') && class_exists('NK_Options')) {
    function khaki_initial_kirki_options()
    {

        $sidebars = khaki_get_sidebars();

        NK_Options::add_config(array(
            'capability' => 'edit_theme_options',
            'option_type' => 'theme_mod',
        ));
        /**
         * Add panels
         */
        NK_Options::add_panel('single_page', array(
            'priority' => 9,
            'title' => esc_html__('Single Page', 'khaki'),
        ));
        NK_Options::add_panel('single_post', array(
            'priority' => 9,
            'title' => esc_html__('Single Post', 'khaki'),
            'icon' => ''
        ));
        /**
         * Add Portfolio pages panel
         * */
        NK_Options::add_panel('portfolio', array(
            'priority' => 9,
            'title' => esc_html__('Portfolio', 'khaki'),
        ));
        /**
         * Add BBpress panel
         * */
        NK_Options::add_panel('bbpress', array(
            'priority' => 9,
            'title' => esc_html__('bbPress', 'khaki'),
            'icon' => ''
        ));

        NK_Options::add_panel('archive', array(
            'priority' => 9,
            'title' => esc_html__('Archive', 'khaki'),
            'icon' => ''
        ));
        NK_Options::add_panel('search', array(
            'priority' => 9,
            'title' => esc_html__('Search', 'khaki'),
            'icon' => ''
        ));
        /**
         * Add sections
         */
        NK_Options::add_section('top_navigation', array(
            'title' => esc_html__('Top Navigation', 'khaki'),
            'priority' => 9,
            'panel' => 'navigation',
        ));
        NK_Options::add_section('main_navigation', array(
            'title' => esc_html__('Main Navigation', 'khaki'),
            'priority' => 9,
            'panel' => 'navigation',
        ));
        NK_Options::add_section('side_navigation', array(
            'title' => esc_html__('Side Navigation', 'khaki'),
            'priority' => 9,
            'panel' => 'navigation',
        ));
        NK_Options::add_section('fullscreen_navigation', array(
            'title' => esc_html__('Fullscreen Navigation', 'khaki'),
            'priority' => 9,
            'panel' => 'navigation',
        ));
        NK_Options::add_section('mobile_navigation', array(
            'title' => esc_html__('Mobile Navigation', 'khaki'),
            'priority' => 9,
            'panel' => 'navigation',
        ));
        /**
         * 404 Page section
         */
        NK_Options::add_section('not_found_page', array(
            'title' => esc_html__('404 Page', 'khaki'),
            'priority' => 10,
        ));
        NK_Options::add_panel('navigation', array(
            'priority' => 11,
            'title' => esc_html__('Navigation', 'khaki'),
            'icon' => 'fa fa-bars'
        ));
        /**
         * Custom Style
         */
        NK_Options::add_section('style', array(
            'title' => esc_html__('Styles', 'khaki'),
            'priority' => 12,
            'icon' => 'fa fa-paint-brush'
        ));
        /**
         * Archive Page section
         */
        NK_Options::add_section('archive_content', array(
            'title' => esc_html__('Content', 'khaki'),
            'priority' => 12,
            'panel' => 'archive'
        ));
        NK_Options::add_section('archive_header', array(
            'title' => esc_html__('Header', 'khaki'),
            'priority' => 12,
            'panel' => 'archive'
        ));
        NK_Options::add_section('archive_breadcrumbs', array(
            'title' => esc_html__('Breadcrumbs', 'khaki'),
            'priority' => 12,
            'panel' => 'archive',
        ));
        /**
         * Search Page section
         */
        NK_Options::add_section('search_content', array(
            'title' => esc_html__('Content', 'khaki'),
            'priority' => 12,
            'panel' => 'search'
        ));
        NK_Options::add_section('search_header', array(
            'title' => esc_html__('Header', 'khaki'),
            'priority' => 12,
            'panel' => 'search'
        ));
        NK_Options::add_section('search_breadcrumbs', array(
            'title' => esc_html__('Breadcrumbs', 'khaki'),
            'priority' => 12,
            'panel' => 'search',
        ));
        /**
         * Background section
         */
        NK_Options::add_section('background', array(
            'title' => esc_html__('Background', 'khaki'),
            'priority' => 12,
            //'panel' => 'general',
            'icon' => 'fa fa-picture-o'
        ));
        NK_Options::add_section('background_page_border', array(
            'title' => esc_html__('Page Border', 'khaki'),
            'priority' => 12,
            'icon' => 'fa fa-square-o'
        ));
        NK_Options::add_section('header', array(
            'title' => esc_html__('Header', 'khaki'),
            'priority' => 12,
            'panel' => 'single_page',
        ));
        NK_Options::add_section('single_page_content', array(
            'title' => esc_html__('Content', 'khaki'),
            'priority' => 12,
            'panel' => 'single_page',
        ));

        NK_Options::add_section('audio_player', array(
            'title' => esc_html__('Audio Player', 'khaki'),
            'priority' => 12,
            'icon' => 'fa fa-music'
        ));
        /**
         * Cookie-alert section
         */
        NK_Options::add_section('cookie_alert', array(
            'title' => esc_html__('Cookie-Alert', 'khaki'),
            'priority' => 12,
            //'panel' => 'general',
            'icon' => 'fa fa-exclamation-circle'
        ));
        /**
         * ShortCuts section
         */
        NK_Options::add_section('shortcuts', array(
            'title' => esc_html__('Shortcuts', 'khaki'),
            'priority' => 12,
            //'panel' => 'general',
            'icon' => 'fa fa-keyboard-o'
        ));
        /**
         * Sharing section
         */
        NK_Options::add_section('sharing_block', array(
            'title' => esc_html__('Sharing Block', 'khaki'),
            'priority' => 12,
            //'panel' => 'general',
            'icon' => 'fa fa-share-alt'
        ));
        /**
         * Side buttons section
         */
        NK_Options::add_section('side_buttons', array(
            'title' => esc_html__('Side Buttons', 'khaki'),
            'priority' => 12,
            //'panel' => 'general',
            'icon' => 'fa fa-square'
        ));
        /**
         * Typography section
         */
        NK_Options::add_section('typography', array(
            'title' => esc_html__('Typography', 'khaki'),
            'priority' => 12,
            //'panel' => 'general',
            'icon' => 'fa fa-font'
        ));
        /**
         * Footer section
         */
        NK_Options::add_section('footer', array(
            'title' => esc_html__('Footer', 'khaki'),
            'priority' => 12,
            'icon' => 'fa fa-hand-o-down'
        ));
        /**
         * Single Page section
         */
        NK_Options::add_section('single_page_header', array(
            'title' => esc_html__('Header', 'khaki'),
            'priority' => 12,
            'panel' => 'single_page',
        ));
        NK_Options::add_section('single_page_breadcrumbs', array(
            'title' => esc_html__('Breadcrumbs', 'khaki'),
            'priority' => 12,
            'panel' => 'single_page',
        ));
        NK_Options::add_section('single_page_sidebar', array(
            'title' => esc_html__('Sidebar', 'khaki'),
            'priority' => 12,
            'panel' => 'single_page',
        ));
        /**
         * Single Post section
         */
        NK_Options::add_section('single_post_content', array(
            'title' => esc_html__('Content', 'khaki'),
            'priority' => 12,
            'panel' => 'single_post',
        ));
        NK_Options::add_section('single_post_header', array(
            'title' => esc_html__('Header', 'khaki'),
            'priority' => 12,
            'panel' => 'single_post',
        ));
        NK_Options::add_section('single_post_meta', array(
            'title' => esc_html__('Meta', 'khaki'),
            'priority' => 12,
            'panel' => 'single_post',
        ));
        NK_Options::add_section('single_post_sidebar', array(
            'title' => esc_html__('Sidebar', 'khaki'),
            'priority' => 12,
            'panel' => 'single_post',
        ));
        NK_Options::add_section('single_post_breadcrumbs', array(
            'title' => esc_html__('Breadcrumbs', 'khaki'),
            'priority' => 12,
            'panel' => 'single_post',
        ));
        /**
         * Portfolio Page section
         */
        NK_Options::add_section('portfolio_content', array(
            'title' => esc_html__('Content', 'khaki'),
            'priority' => 12,
            'panel' => 'portfolio',
        ));
        NK_Options::add_section('portfolio_header', array(
            'title' => esc_html__('Header', 'khaki'),
            'priority' => 12,
            'panel' => 'portfolio',
        ));
        NK_Options::add_section('portfolio_breadcrumbs', array(
            'title' => esc_html__('Breadcrumbs', 'khaki'),
            'priority' => 12,
            'panel' => 'portfolio',
        ));
        NK_Options::add_section('portfolio_sidebar', array(
            'title' => esc_html__('Sidebar', 'khaki'),
            'priority' => 12,
            'panel' => 'portfolio',
        ));
        NK_Options::add_section('portfolio_archive', array(
            'title' => esc_html__('Archive', 'khaki'),
            'priority' => 12,
            'panel' => 'portfolio',
        ));
        NK_Options::add_section('portfolio_single', array(
            'title' => esc_html__('Single', 'khaki'),
            'priority' => 12,
            'panel' => 'portfolio',
        ));
        NK_Options::add_section('portfolio_meta', array(
            'title' => esc_html__('Meta', 'khaki'),
            'priority' => 12,
            'panel' => 'portfolio',
        ));
        /**
         * BBpress section
         */
        NK_Options::add_section('bbpress_header', array(
            'title' => esc_html__('Header', 'khaki'),
            'priority' => 12,
            'panel' => 'bbpress',
        ));
        NK_Options::add_section('bbpress_breadcrumbs', array(
            'title' => esc_html__('Breadcrumbs', 'khaki'),
            'priority' => 12,
            'panel' => 'bbpress',
        ));
        NK_Options::add_section('bbpress_content', array(
            'title' => esc_html__('Content', 'khaki'),
            'priority' => 12,
            'panel' => 'bbpress',
        ));

        /*
        General
        */
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'page_boxed',
            'label' => esc_html__('Boxed Overall', 'khaki'),
            'section' => 'title_tagline',
            'default' => 'off',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'enable_search_autofocus',
            'label' => esc_html__('Search Autofocus', 'khaki'),
            'section' => 'title_tagline',
            'default' => 'on',
            'priority' => 10
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'enable_action_like_animation',
            'label' => esc_html__('Posts Like Animation', 'khaki'),
            'section' => 'title_tagline',
            'default' => 'on',
            'priority' => 10
        ));
        NK_Options::add_field( array(
            'type' => 'number',
            'settings' => 'scroll_to_anchor_speed',
            'label' => esc_html__('Scroll To Anchor Speed', 'khaki'),
            'section' => 'title_tagline',
            'default' => 700,
            'choices' => array(
                'min' => 0,
                'max' => 2000,
                'step' => 1,
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'plain_video_icon',
            'label' => esc_html__('Plain Video Icon', 'khaki'),
            'section' => 'title_tagline',
            'default' => 'fa fa-play',
            'priority' => 10,
            'description' => sprintf(wp_kses(__('Enter icon class. You can use <a href="%s" target="_blank">"ioicons"</a> and <a href="%2s" target="_blank">"Font Awesome"</a> icons.', 'khaki'), array('a' => array('href' => array(), 'target' => array()))), esc_url("http://ionicons.com/"), esc_url("http://fontawesome.io/icons/")),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'gif_icon',
            'label' => esc_html__('Gif Icon', 'khaki'),
            'section' => 'title_tagline',
            'default' => 'fa fa-hand-pointer-o',
            'priority' => 10,
            'description' => sprintf(wp_kses(__('Enter icon class. You can use <a href="%s" target="_blank">"ioicons"</a> and <a href="%2s" target="_blank">"Font Awesome"</a> icons.', 'khaki'), array('a' => array('href' => array(), 'target' => array()))), esc_url("http://ionicons.com/"), esc_url("http://fontawesome.io/icons/")),
        ));
        /*
        Navigation Fields
        */
        /*
        Top Navigation
        */
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'top_menu_show',
            'label' => esc_html__('Show', 'khaki'),
            'section' => 'top_navigation',
            'default' => 'off',
            'priority' => 10
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'top_menu_light',
            'label' => esc_html__('Light Color', 'khaki'),
            'section' => 'top_navigation',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'top_menu_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'top_menu_blur',
            'label' => esc_html__('Blur Background', 'khaki'),
            'section' => 'top_navigation',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'top_menu_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));

        /*
        Main Navigation Panel
        */
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'main_navigation_show',
            'label' => esc_html__('Show', 'khaki'),
            'section' => 'main_navigation',
            'default' => 'on',
            'priority' => 10,

        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'main_navigation_show_left_navigation_panel',
            'label' => esc_html__('On Left Side', 'khaki'),
            'section' => 'main_navigation',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'left_navigation_panel_lg',
            'label' => esc_html__('Large Size', 'khaki'),
            'section' => 'main_navigation',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_show_left_navigation_panel',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'left_navigation_panel_align',
            'label' => esc_html__('Navbar Align', 'khaki'),
            'section' => 'main_navigation',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'right' => esc_attr__('Right', 'khaki'),
                'center' => esc_attr__('Center', 'khaki'),
                'left' => esc_attr__('Left', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_show_left_navigation_panel',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'left_navigation_panel_row_side',
            'label' => esc_html__('Vertical Align', 'khaki'),
            'section' => 'main_navigation',
            'default' => 'center',
            'priority' => 10,
            'choices' => array(
                'top' => esc_attr__('Top', 'khaki'),
                'center' => esc_attr__('Center', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_show_left_navigation_panel',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'editor',
            'settings' => 'left_navigation_panel_text',
            'label' => esc_html__('Bottom Text', 'khaki'),
            'section' => 'main_navigation',
            'priority' => 10,
            'default' => '<a href="https://nkdev.info" target="_blank">nK</a> &copy; 2018. All rights reserved',
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_show_left_navigation_panel',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'main_navigation_show_search',
            'label' => esc_html__('Search Button', 'khaki'),
            'section' => 'main_navigation',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'main_navigation_search_light',
            'label' => esc_html__('Light Search Modal', 'khaki'),
            'section' => 'main_navigation',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'main_navigation_show_search',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'khaki_login_with_ajax_show_icon',
            'label' => esc_html__('Sign In Icon', 'khaki'),
            'section' => 'main_navigation',
            'default' => 'off',
            'description' => esc_html__('required Login To Ajax plugin' ,'khaki'),
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'khaki_login_with_ajax_profile_url',
            'label' => esc_attr__('Account Url', 'khaki'),
            'section' => 'main_navigation',
            'priority' => 10,
            'default' => '',
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'khaki_login_with_ajax_show_icon',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'main_navigation_show_left_navigation_panel',
                    'operator' => '==',
                    'value' => false,
                ),
            ),
        ));
        //social share
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'main_navigation_show_share_button',
            'label' => esc_html__('Share Button', 'khaki'),
            'description' => esc_html__('Required Sociality plugin' ,'khaki'),
            'section' => 'main_navigation',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'main_navigation_light',
            'label' => esc_html__('Light Color', 'khaki'),
            'section' => 'main_navigation',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'main_navigation_show_left_navigation_panel',
                    'operator' => '==',
                    'value' => false,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'main_navigation_blur',
            'label' => esc_html__('Blur Background', 'khaki'),
            'section' => 'main_navigation',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'main_navigation_show_left_navigation_panel',
                    'operator' => '==',
                    'value' => false,
                ),
            ),
        ));
        /*
        Additional Classes
        */
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'main_navigation_opaque',
            'label' => esc_html__('Opaque', 'khaki'),
            'section' => 'main_navigation',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'main_navigation_show_left_navigation_panel',
                    'operator' => '==',
                    'value' => false,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'main_navigation_transparent',
            'label' => esc_html__('Transparent', 'khaki'),
            'section' => 'main_navigation',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'main_navigation_show_left_navigation_panel',
                    'operator' => '==',
                    'value' => false,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'main_navigation_sticky',
            'label' => esc_html__('Sticky', 'khaki'),
            'section' => 'main_navigation',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'main_navigation_show_left_navigation_panel',
                    'operator' => '==',
                    'value' => false,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'main_navigation_autohide',
            'label' => esc_html__('Hide on Scroll', 'khaki'),
            'section' => 'main_navigation',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'main_navigation_show_left_navigation_panel',
                    'operator' => '==',
                    'value' => false,
                ),
                array(
                    'setting' => 'main_navigation_sticky',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'main_menu_align',
            'label' => esc_html__('Align', 'khaki'),
            'section' => 'main_navigation',
            'default' => 'right',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'center' => esc_attr__('Center', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
                'left' => esc_attr__('Left', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'main_navigation_show_left_navigation_panel',
                    'operator' => '==',
                    'value' => false,
                ),
            ),
        ));
        /*
        Logo
        */
        NK_Options::add_field( array(
            'type' => 'image',
            'settings' => 'main_navigation_logo',
            'label' => esc_html__('Logo', 'khaki'),
            'section' => 'main_navigation',
            'default' => get_template_directory_uri() . '/assets/images/logo.svg',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'main_navigation_logo_width',
            'label' => esc_html__('Logo width', 'khaki'),
            'section' => 'main_navigation',
            'default' => 70,
            'choices' => array(
                'min' => '50',
                'max' => '400',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_logo',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'main_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'main_navigation_logo_area',
            'label' => esc_html__('Logo Area', 'khaki'),
            'section' => 'main_navigation',
            'default' => 'navigation',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'navigation' => esc_attr__('Navigation', 'khaki'),
                'top' => esc_attr__('Top', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_show_left_navigation_panel',
                    'operator' => '!=',
                    'value' => true,
                ),
                array(
                    'setting' => 'main_navigation_logo',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'main_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
            )
        ));
        $menu_name = 'primary';
        $menu_array = array(
            false => esc_html__('Not Use', 'khaki')
        );
        $locations = get_nav_menu_locations();
        if(is_array($locations) && isset($locations) && !empty($locations) && array_key_exists($menu_name, $locations)){
            $menu_items = wp_get_nav_menu_items(wp_get_nav_menu_object($locations[$menu_name]));
            if(is_array($menu_items) && isset($menu_items) && !empty($menu_items)){
                foreach ($menu_items as $menu_item) {
                    if ($menu_item->menu_item_parent == 0 && $menu_item->post_status == 'publish') {
                        $menu_array[$menu_item->ID] = $menu_item->title;
                    }
                }
            }
        }

        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'main_navigation_logo_position',
            'label' => esc_html__('Insert Logo After Menu Item', 'khaki'),
            'section' => 'main_navigation',
            'default' => false,
            'priority' => 10,
            'multiple' => 1,
            'choices' => $menu_array,
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_show_left_navigation_panel',
                    'operator' => '!=',
                    'value' => true,
                ),
                array(
                    'setting' => 'main_navigation_logo',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'main_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'main_navigation_logo_area',
                    'operator' => '!=',
                    'value' => 'top',
                ),
            )
        ));
        NK_Options::add_field( array(
            'type' => 'editor',
            'settings' => 'main_navigation_custom_content',
            'label' => esc_html__('Custom Content', 'khaki'),
            'section' => 'main_navigation',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'main_navigation_custom_content_position',
            'label' => esc_html__('Content Position', 'khaki'),
            'section' => 'main_navigation',
            'default' => 'before_icons',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'before_icons' => esc_attr__('Before Icons', 'khaki'),
                'after_icons' => esc_attr__('After Icons', 'khaki'),
                'before_menu' => esc_attr__('Before Menu', 'khaki'),
                'after_menu' => esc_attr__('After Menu', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_custom_content',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'main_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
            )
        ));
        /*
        For Mobile
        */
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'main_navigation_mobile_show',
            'label' => esc_html__('Show', 'khaki'),
            'section' => 'mobile_navigation',
            'default' => 'on',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'image',
            'settings' => 'main_navigation_logo_mobile',
            'label' => esc_html__('Logo', 'khaki'),
            'section' => 'mobile_navigation',
            'default' => get_template_directory_uri() . '/assets/images/logo.svg',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_mobile_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'main_navigation_logo_mobile_width',
            'label' => esc_attr__('Logo width', 'khaki'),
            'section' => 'mobile_navigation',
            'default' => 90,
            'choices' => array(
                'min' => '50',
                'max' => '160',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_logo_mobile',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'main_navigation_mobile_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'mobile_navbar_light',
            'label' => esc_html__('Light Color', 'khaki'),
            'section' => 'mobile_navigation',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_mobile_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'mobile_navbar_white_icon',
            'label' => esc_html__('Light Icon', 'khaki'),
            'section' => 'mobile_navigation',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_mobile_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'mobile_navbar_blur',
            'label' => esc_html__('Blur Background', 'khaki'),
            'section' => 'mobile_navigation',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_mobile_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'mobile_navigation_overlay_content',
            'label' => esc_html__('Overlay Content', 'khaki'),
            'section' => 'mobile_navigation',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_mobile_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'mobile_navigation_lg',
            'label' => esc_html__('Large Size', 'khaki'),
            'section' => 'mobile_navigation',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_mobile_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));

        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'mobile_navigation_align',
            'label' => esc_html__('Navbar Align', 'khaki'),
            'section' => 'mobile_navigation',
            'default' => 'left',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'center' => esc_attr__('Center', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
                'left' => esc_attr__('Left', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_mobile_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'mobile_navigation_vertical_align',
            'label' => esc_html__('Vertical Align', 'khaki'),
            'section' => 'mobile_navigation',
            'default' => 'top',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'center' => esc_attr__('Center', 'khaki'),
                'top' => esc_attr__('Top', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'main_navigation_mobile_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        /*
        Side navigation
        */
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'side_navigation_show',
            'label' => esc_html__('Show', 'khaki'),
            'section' => 'side_navigation',
            'default' => 'false',
            'priority' => 10
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'side_navigation_light',
            'label' => esc_html__('Light Color', 'khaki'),
            'section' => 'side_navigation',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'side_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'side_navigation_white_icon',
            'label' => esc_html__('Light Icon', 'khaki'),
            'section' => 'side_navigation',
            'description' => esc_html__('Work if not set main navigation panel or if offset main navigation panel to left', 'khaki'),
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'side_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'side_navigation_overlay_content',
            'label' => esc_html__('Overlay Content', 'khaki'),
            'section' => 'side_navigation',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'side_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'side_navigation_lg',
            'label' => esc_html__('Large Size', 'khaki'),
            'section' => 'side_navigation',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'side_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'side_navigation_blur',
            'label' => esc_html__('Blur Background', 'khaki'),
            'section' => 'side_navigation',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'side_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'side_navigation_side',
            'label' => esc_html__('Side', 'khaki'),
            'section' => 'side_navigation',
            'default' => 'left',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'right' => esc_attr__('Right', 'khaki'),
                'left' => esc_attr__('Left', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'side_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'side_navigation_align',
            'label' => esc_html__('Navbar Align', 'khaki'),
            'section' => 'side_navigation',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'center' => esc_attr__('Center', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
                'left' => esc_attr__('Left', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'side_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'side_navigation_vertical_align',
            'label' => esc_html__('Vertical Align', 'khaki'),
            'section' => 'side_navigation',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'center' => esc_attr__('Center', 'khaki'),
                'top' => esc_attr__('Top', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'side_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'image',
            'settings' => 'side_navigation_logo',
            'label' => esc_html__('Logo', 'khaki'),
            'section' => 'side_navigation',
            'default' => get_template_directory_uri() . '/assets/images/logo.svg',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'side_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'side_navigation_logo_width',
            'label' => esc_attr__('Logo width', 'khaki'),
            'section' => 'side_navigation',
            'default' => 130,
            'choices' => array(
                'min' => '50',
                'max' => '300',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'side_navigation_logo',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'side_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'image',
            'settings' => 'side_navigation_background_image',
            'label' => esc_attr__('Background Image', 'khaki'),
            'section' => 'side_navigation',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'side_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'repeater',
            'label' => esc_html__('Social', 'khaki'),
            'section' => 'side_navigation',
            'priority' => 10,
            'settings' => 'side_navigation_social',
            'description' => sprintf(wp_kses(__('Enter icon class. You can use <a href="%s" target="_blank">"ioicons"</a> and <a href="%2s" target="_blank">"Font Awesome"</a> icons.', 'khaki'), array('a' => array('href' => array(), 'target' => array()))), esc_url("http://ionicons.com/"), esc_url("http://fontawesome.io/icons/")),
            'default' => array(
                array(
                    'target' => '_blank',
                    'link_url' => 'https://themeforest.net/user/_nk/portfolio?ref=_nK',
                    'icon' => 'fab fa-twitter',
                ),
                array(
                    'target' => '_blank',
                    'link_url' => 'https://themeforest.net/user/_nk/portfolio?ref=_nK',
                    'icon' => 'fab fa-instagram',
                ),
                array(
                    'target' => '_blank',
                    'link_url' => 'https://themeforest.net/user/_nk/portfolio?ref=_nK',
                    'icon' => 'fab fa-dribbble',
                ),
                array(
                    'target' => '_blank',
                    'link_url' => 'https://themeforest.net/user/_nk/portfolio?ref=_nK',
                    'icon' => 'fab fa-pinterest',
                ),
            ),
            'fields' => array(
                'target' => array(
                    'type' => 'select',
                    'label' => esc_html__('Target', 'khaki'),
                    'priority' => 10,
                    'multiple' => 0,
                    'choices' => array(
                        '_blank' => esc_attr__('Blank', 'khaki'),
                        '_self' => esc_attr__('Self', 'khaki'),
                        '_parent' => esc_attr__('Parent', 'khaki'),
                        '_top' => esc_attr__('Top', 'khaki')
                    ),
                ),
                'link_url' => array(
                    'type' => 'text',
                    'label' => esc_attr__('Link URL', 'khaki'),
                ),
                'icon' => array(
                    'type' => 'text',
                    'label' => esc_html__('Icon', 'khaki'),
                ),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'side_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'editor',
            'settings' => 'side_navigation_text',
            'label' => esc_html__('Footer Text', 'khaki'),
            'section' => 'side_navigation',
            'priority' => 10,
            'default' => '<a href="https://nkdev.info" target="_blank">nK</a> &copy; 2018. All rights reserved',
            'active_callback' => array(
                array(
                    'setting' => 'side_navigation_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        /*
        Fullscreen Navigation
        */
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'fullscreen_navbar_show',
            'label' => esc_html__('Show', 'khaki'),
            'section' => 'fullscreen_navigation',
            'default' => 'off',
            'priority' => 10
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'fullscreen_navbar_light',
            'label' => esc_html__('Light Color', 'khaki'),
            'section' => 'fullscreen_navigation',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'fullscreen_navbar_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'fullscreen_navbar_white_icon',
            'label' => esc_html__('Light Icon', 'khaki'),
            'section' => 'fullscreen_navigation',
            'description' => esc_html__('Work if not set main navigation panel or if offset main navigation panel to left', 'khaki'),
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'fullscreen_navbar_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'fullscreen_navbar_blur',
            'label' => esc_html__('Blur Background', 'khaki'),
            'section' => 'fullscreen_navigation',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'fullscreen_navbar_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'fullscreen_navigation_align',
            'label' => esc_html__('Navbar Align', 'khaki'),
            'section' => 'fullscreen_navigation',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'center' => esc_attr__('Center', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
                'left' => esc_attr__('Left', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'fullscreen_navbar_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'fullscreen_navigation_vertical_align',
            'label' => esc_html__('Vertical Align', 'khaki'),
            'section' => 'fullscreen_navigation',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'center' => esc_attr__('Center', 'khaki'),
                'top' => esc_attr__('Top', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'fullscreen_navbar_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'repeater',
            'label' => esc_html__('Social', 'khaki'),
            'section' => 'fullscreen_navigation',
            'priority' => 10,
            'settings' => 'fullscreen_navigation_social',
            'description' => sprintf(wp_kses(__('Enter icon class. You can use <a href="%s" target="_blank">"ioicons"</a> and <a href="%2s" target="_blank">"Font Awesome"</a> icons.', 'khaki'), array('a' => array('href' => array(), 'target' => array()))), esc_url("http://ionicons.com/"), esc_url("http://fontawesome.io/icons/")),
            'default' => array(
                array(
                    'target' => '_blank',
                    'link_url' => 'https://themeforest.net/user/_nk/portfolio?ref=_nK',
                    'icon' => 'fab fa-twitter',
                ),
                array(
                    'target' => '_blank',
                    'link_url' => 'https://themeforest.net/user/_nk/portfolio?ref=_nK',
                    'icon' => 'fab fa-instagram',
                ),
                array(
                    'target' => '_blank',
                    'link_url' => 'https://themeforest.net/user/_nk/portfolio?ref=_nK',
                    'icon' => 'fab fa-dribbble',
                ),
                array(
                    'target' => '_blank',
                    'link_url' => 'https://themeforest.net/user/_nk/portfolio?ref=_nK',
                    'icon' => 'fab fa-pinterest',
                ),
            ),
            'fields' => array(
                'target' => array(
                    'type' => 'select',
                    'label' => esc_html__('Target', 'khaki'),
                    'priority' => 10,
                    'multiple' => 0,
                    'choices' => array(
                        '_blank' => esc_attr__('Blank', 'khaki'),
                        '_self' => esc_attr__('Self', 'khaki'),
                        '_parent' => esc_attr__('Parent', 'khaki'),
                        '_top' => esc_attr__('Top', 'khaki')
                    ),
                ),
                'link_url' => array(
                    'type' => 'text',
                    'label' => esc_attr__('Link URL', 'khaki'),
                ),
                'icon' => array(
                    'type' => 'text',
                    'label' => esc_html__('Icon', 'khaki'),
                ),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'fullscreen_navbar_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'editor',
            'settings' => 'fullscreen_navbar_text',
            'label' => esc_attr__('Footer Text', 'khaki'),
            'section' => 'fullscreen_navigation',
            'priority' => 10,
            'default' => '<a href="https://nkdev.info" target="_blank">nK</a> &copy; 2018. All rights reserved',
            'active_callback' => array(
                array(
                    'setting' => 'fullscreen_navbar_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));

        /*
        Background
        */
        NK_Options::add_field( array(
            'type' => 'color',
            'settings' => 'background_color',
            'label' => esc_attr__('Background Color', 'khaki'),
            'section' => 'title_tagline',
            'default' => '#1c1c1c',
            'priority' => 10,
            'choices'     => array(
                'alpha' => true,
            ),
            'output' => array(
                array(
                    'element' => 'body',
                    'property' => 'background-color',
                ),
            ),
        ));



        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'show_border',
            'label' => esc_html__('Show Border', 'khaki'),
            'section' => 'background_page_border',
            'default' => false,
            'priority' => 10,
            'choices' => array(
                true => esc_attr__('on', 'khaki'),
                false => esc_attr__('off', 'khaki'),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'size_border',
            'label' => esc_html__('Size Border', 'khaki'),
            'section' => 'background_page_border',
            'default' => 'md',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                false => esc_attr__('Default', 'khaki'),
                'md' => esc_attr__('Mid Size', 'khaki'),
                'sm' => esc_attr__('Small Size', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'show_border',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'color',
            'settings' => 'background_border',
            'label' => esc_html__('Border color', 'khaki'),
            'section' => 'background_page_border',
            'default' => '#fff',
            'choices'     => array(
                'alpha' => true,
            ),
            'priority' => 10,
            'output' => array(
                array(
                    'element' => '.nk-page-border .nk-page-border-t',
                    'property' => 'background-color',
                    'suffix' => '!important'
                ),
                array(
                    'element' => '.nk-page-border .nk-page-border-b',
                    'property' => 'background-color',
                    'suffix' => '!important'
                ),
                array(
                    'element' => '.nk-page-border .nk-page-border-l',
                    'property' => 'background-color',
                    'suffix' => '!important'
                ),
                array(
                    'element' => '.nk-page-border .nk-page-border-r',
                    'property' => 'background-color',
                    'suffix' => '!important'
                ),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'show_border',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        /*
        Shortcuts
        */
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'enable_shortcuts',
            'label' => esc_html__('Enable Shortcuts', 'khaki'),
            'section' => 'shortcuts',
            'default' => 'on',
            'priority' => 10
        ));
        NK_Options::add_field( array(
            'type' => 'custom',
            'settings' => 'my_setting',
            'section' => 'shortcuts',
            'default' => wp_kses(__('All supported keys you can find here: <a href="https://github.com/madrobby/keymaster#supported-keys">https://github.com/madrobby/keymaster#supported-keys</a>', 'khaki'),
                array('a' => array(
                    'href' => true,
                    'title' => true,
                    'target' => true
                ))),
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_toggle_share',
            'label' => esc_html__('Toggle Share', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'n',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_show_share',
            'label' => esc_html__('Show Share', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => '',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_close_share',
            'label' => esc_html__('Close Share', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'esc',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_toggle_search',
            'label' => esc_html__('Toggle Search', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 's',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_show_search',
            'label' => esc_html__('Show Search', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => '',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_close_search',
            'label' => esc_html__('Close Search', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'esc',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_close_fullscreen_video',
            'label' => esc_html__('Close Fullscreen Video', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'esc',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_post_like',
            'label' => esc_html__('Post Like', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'l',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_post_dislike',
            'label' => esc_html__('Post Dislike', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'd',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_post_scroll_to_comments',
            'label' => esc_html__('Post Scroll To Comments', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'c',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_toggle_side_left_navbar',
            'label' => esc_html__('Toggle SideLeft Navbar', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'alt+l',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_open_side_left_navbar',
            'label' => esc_html__('Open Side Left Navbar', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => '',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_close_side_left_navbarr',
            'label' => esc_html__('Close Side Left Navbar', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'esc',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_toggle_side_right_navbar',
            'label' => esc_html__('Toggle Side Right Navbar', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'alt+r',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_open_side_right_navbar',
            'label' => esc_html__('Open Side Right Navbar', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => '',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_close_side_right_navbar',
            'label' => esc_html__('Close Side Right Navbar', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'esc',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_toggle_fullscreen_navbar',
            'label' => esc_html__('Toggle Fullscreen Navbar', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'alt+f',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_open_fullscreen_navbar',
            'label' => esc_html__('Open Fullscreen Navbar', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => '',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_close_fullscreen_navbar',
            'label' => esc_html__('Close Fullscreen Navbar', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'esc',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_close_quick_view',
            'label' => esc_html__('Close Quick View', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'esc',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_audio_player_pause',
            'label' => esc_html__('Audio Player Pause', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'shift+p',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_audio_player_play',
            'label' => esc_html__('Audio Player Play', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => '',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_audio_player_pause',
            'label' => esc_html__('Audio Player Pause', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => '',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_audio_player_forward',
            'label' => esc_html__('Audio Player Forward', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'shift+right',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_audio_player_backward',
            'label' => esc_html__('Audio Player Backward', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'shift+left',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_audio_player_volume_up',
            'label' => esc_html__('Audio Player Volume Up', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'shift+up',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_audio_player_volume_down',
            'label' => esc_html__('Audio Player Volume Down', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'shift+down',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_audio_player_mute',
            'label' => esc_html__('Audio Player Mute', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'shift+m',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_audio_player_loop',
            'label' => esc_html__('Audio Player Loop', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'shift+l',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_audio_player_snuffle',
            'label' => esc_html__('Audio Player Snuffle', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'shift+s',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_audio_player_playlist',
            'label' => esc_html__('Audio Player Playlist', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'shift+a',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'shortcuts_audio_player_pin',
            'label' => esc_html__('Audio Player Pin', 'khaki'),
            'section' => 'shortcuts',
            'priority' => 10,
            'default' => 'shift+r',
            'active_callback' => array(
                array(
                    'setting' => 'enable_shortcuts',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        /*
        Side Buttons
        */
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'side_buttons_visible',
            'label' => esc_html__('Buttons Visible', 'khaki'),
            'section' => 'side_buttons',
            'default' => 'on',
            'priority' => 10
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'side_buttons_light',
            'label' => esc_html__('Light Buttons', 'khaki'),
            'section' => 'side_buttons',
            'default' => 'off',
            'priority' => 10
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'side_buttons_show_scroll_top',
            'label' => esc_html__('Scroll Top Button', 'khaki'),
            'section' => 'side_buttons',
            'default' => 'on',
            'priority' => 10
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'side_buttons_show_link_button',
            'label' => esc_html__('Link Button', 'khaki'),
            'section' => 'side_buttons',
            'default' => 'off',
            'priority' => 10
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'side_buttons_link_button',
            'label' => esc_html__('Link Button', 'khaki'),
            'section' => 'side_buttons',
            'default' => '#',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'side_buttons_show_link_button',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        /**
         * Typography
         */
        NK_Options::add_field( array(
            'type' => 'typography',
            'settings' => 'typography_main_body',
            'label' => esc_attr__('Body', 'khaki'),
            'section' => 'typography',
            'default' => array(
                'font-family' => 'Nunito Sans',
                'line-height' => '1.7',
                'letter-spacing' => '0rem'
            ),
            'priority' => 10,
            'output' => array(
                array(
                    'element' => 'body, .nk-counter-3 .nk-counter-title, .nk-sub-title, .nk-pricing-2 .nk-pricing-currency, .nk-pricing-2 .nk-pricing-period, .nk-pricing-3 .nk-pricing-currency, .nk-pricing-3 .nk-pricing-period',
                ),
            ),
            'transport' => 'auto'
        ));
        NK_Options::add_field( array(
            'type' => 'typography',
            'settings' => 'typography_html',
            'label' => esc_attr__('HTML', 'khaki'),
            'section' => 'typography',
            'default' => array(
                'font-size' => '15px'
            ),
            'priority' => 10,
            'output' => array(
                array(
                    'element' => 'html',
                ),
            ),
            'transport' => 'auto'
        ));
        NK_Options::add_field( array(
            'type' => 'typography',
            'settings' => 'typography_titles',
            'label' => esc_attr__('Main Titles', 'khaki'),
            'section' => 'typography',
            'default' => array(
                'font-family' => 'Montserrat',
                'variant' => '700'
            ),
            'priority' => 10,
            'output' => array(
                array(
                    'element' => 'h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6, .display-1, .display-2, .display-3, .display-4, .nk-forum-topic > li .nk-forum-topic-author-name, .nk-countdown > div > span, .nk-carousel-3 .nk-carousel-prev .nk-carousel-arrow-name, .nk-carousel-3 .nk-carousel-next .nk-carousel-arrow-name, .nk-carousel .nk-carousel-prev .nk-carousel-arrow-name, .nk-carousel .nk-carousel-next .nk-carousel-arrow-name, .nk-pricing .nk-pricing-price, .nk-dropcap-3, .nk-counter .nk-count, .nk-counter-2 .nk-count, .nk-counter-3 .nk-count'
                ),
            ),
            'transport' => 'auto'
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'typography_titles_h1',
            'label' => esc_attr__('H1 Titles', 'khaki'),
            'section' => 'typography',
            'default' => '37',
            'priority' => 10,
            'output' => array(
                array(
                    'element' => 'h1, .h1',
                    'property' => 'font-size',
                    'units' => 'px',
                )
            ),
            'choices' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
            'transport' => 'auto'
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'typography_titles_h2',
            'label' => esc_attr__('H2 Titles', 'khaki'),
            'section' => 'typography',
            'default' => '30',
            'priority' => 10,
            'output' => array(
                array(
                    'element' => 'h2, .h2',
                    'property' => 'font-size',
                    'units' => 'px',
                ),
            ),
            'choices' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
            'transport' => 'auto'
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'typography_titles_h3',
            'label' => esc_attr__('H3 Titles', 'khaki'),
            'section' => 'typography',
            'default' => '27',
            'priority' => 10,
            'output' => array(
                array(
                    'element' => 'h3, .h3',
                    'property' => 'font-size',
                    'units' => 'px',
                ),
            ),
            'choices' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
            'transport' => 'auto'
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'typography_titles_h4',
            'label' => esc_attr__('H4 Titles', 'khaki'),
            'section' => 'typography',
            'default' => '23',
            'priority' => 10,
            'output' => array(
                array(
                    'element' => 'h4, .h4',
                    'property' => 'font-size',
                    'units' => 'px',
                ),
            ),
            'choices' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
            'transport' => 'auto'
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'typography_titles_h5',
            'label' => esc_attr__('H5 Titles', 'khaki'),
            'section' => 'typography',
            'default' => '19',
            'priority' => 10,
            'output' => array(
                array(
                    'element' => 'h5, .h5',
                    'property' => 'font-size',
                    'units' => 'px',
                ),
            ),
            'choices' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
            'transport' => 'auto'
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'typography_titles_h6',
            'label' => esc_attr__('H6 Titles', 'khaki'),
            'section' => 'typography',
            'default' => '15',
            'priority' => 10,
            'output' => array(
                array(
                    'element' => 'h6, .h6',
                    'property' => 'font-size',
                    'units' => 'px',
                ),
            ),
            'choices' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
            'transport' => 'auto'
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'typography_titles_display1',
            'label' => esc_attr__('Display 1 Titles', 'khaki'),
            'section' => 'typography',
            'default' => '70',
            'priority' => 10,
            'output' => array(
                array(
                    'element' => '.display-1',
                    'property' => 'font-size',
                    'units' => 'px',
                ),
            ),
            'choices' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
            'transport' => 'auto'
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'typography_titles_display2',
            'label' => esc_attr__('Display 2 Titles', 'khaki'),
            'section' => 'typography',
            'default' => '63',
            'priority' => 10,
            'output' => array(
                array(
                    'element' => '.display-2',
                    'property' => 'font-size',
                    'units' => 'px',
                ),
            ),
            'choices' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
            'transport' => 'auto'
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'typography_titles_display3',
            'label' => esc_attr__('Display 3 Titles', 'khaki'),
            'section' => 'typography',
            'default' => '55',
            'priority' => 10,
            'output' => array(
                array(
                    'element' => '.display-3',
                    'property' => 'font-size',
                    'units' => 'px',
                ),
            ),
            'choices' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
            'transport' => 'auto'
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'typography_titles_display4',
            'label' => esc_attr__('Display 4 Titles', 'khaki'),
            'section' => 'typography',
            'default' => '48',
            'priority' => 10,
            'output' => array(
                array(
                    'element' => '.display-4',
                    'property' => 'font-size',
                    'units' => 'px',
                )
            ),
            'choices' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
            'transport' => 'auto'
        ));
        /**
         * Footer
         */
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'footer_show',
            'label' => esc_html__('Show', 'khaki'),
            'section' => 'footer',
            'default' => 'on',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'color',
            'settings' => 'footer_background_color',
            'label' => esc_html__('Background Color', 'khaki'),
            'section' => 'footer',
            'default' => '#262626',
            'priority' => 10,
            'choices'     => array(
                'alpha' => true,
            ),
            'transport' => 'auto',
            'output' => array(
                array(
                    'element' => '.nk-footer',
                    'property' => 'background-color',
                )
            ),
            'active_callback' => array(
                array(
                    'setting' => 'footer_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'footer_parallax',
            'label' => esc_html__('Parallax', 'khaki'),
            'section' => 'footer',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'footer_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'footer_parallax_opacity',
            'label' => esc_html__('Parallax Opacity', 'khaki'),
            'section' => 'footer',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'footer_parallax',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'footer_parallax_blur',
            'label' => esc_html__('Parallax Blur', 'khaki'),
            'section' => 'footer',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'footer_parallax',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'image',
            'settings' => 'footer_background_image',
            'label' => esc_html__('Background Image', 'khaki'),
            'section' => 'footer',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'footer_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'footer_show_logo',
            'label' => esc_html__('Show Logo', 'khaki'),
            'section' => 'footer',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'footer_show',
                    'operator' => '==',
                    'value' => true,
                )
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'image',
            'settings' => 'footer_logo',
            'label' => esc_html__('Logo', 'khaki'),
            'section' => 'footer',
            'default' => get_template_directory_uri() . '/assets/images/logo-3.svg',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'footer_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'footer_show_logo',
                    'operator' => '==',
                    'value' => true,
                )
            ),
        ));

        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'footer_logo_width',
            'label' => esc_html__('Logo width', 'khaki'),
            'section' => 'footer',
            'default' => 70,
            'choices' => array(
                'min' => '50',
                'max' => '400',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'footer_logo',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'footer_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'footer_show_logo',
                    'operator' => '==',
                    'value' => true,
                )
            ),
        ));
        //Footer Widgets
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'footer_widget_col_one_size',
            'label' => esc_attr__('Widget 1 Size', 'khaki'),
            'section' => 'footer',
            'default' => 3,
            'choices' => array(
                'min' => '0',
                'max' => '12',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'footer_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'footer_widget_col_two_size',
            'label' => esc_attr__('Widget 2 Size', 'khaki'),
            'section' => 'footer',
            'default' => 3,
            'choices' => array(
                'min' => '0',
                'max' => '12',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'footer_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'footer_widget_col_three_size',
            'label' => esc_attr__('Widget 3 Size', 'khaki'),
            'section' => 'footer',
            'default' => 3,
            'choices' => array(
                'min' => '0',
                'max' => '12',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'footer_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'footer_widget_col_four_size',
            'label' => esc_attr__('Widget 4 Size', 'khaki'),
            'section' => 'footer',
            'default' => 3,
            'choices' => array(
                'min' => '0',
                'max' => '12',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'footer_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'footer_sidebar_one_row',
            'label' => esc_html__('Select Sidebar For 1 Col', 'khaki'),
            'section' => 'footer',
            'default' => 'sidebar-footer-1',
            'priority' => 10,
            'multiple' => 1,
            'choices' => $sidebars,
            'active_callback' => array(
                array(
                    'setting' => 'footer_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'footer_widget_col_one_size',
                    'operator' => '!=',
                    'value' => '0',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'footer_sidebar_two_row',
            'label' => esc_html__('Select Sidebar For 2 Col', 'khaki'),
            'section' => 'footer',
            'default' => 'sidebar-footer-2',
            'priority' => 10,
            'multiple' => 1,
            'choices' => $sidebars,
            'active_callback' => array(
                array(
                    'setting' => 'footer_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'footer_widget_col_two_size',
                    'operator' => '!=',
                    'value' => '0',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'footer_sidebar_three_row',
            'label' => esc_html__('Select Sidebar For 3 Col', 'khaki'),
            'section' => 'footer',
            'default' => 'sidebar-footer-3',
            'priority' => 10,
            'multiple' => 1,
            'choices' => $sidebars,
            'active_callback' => array(
                array(
                    'setting' => 'footer_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'footer_widget_col_three_size',
                    'operator' => '!=',
                    'value' => '0',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'footer_sidebar_four_row',
            'label' => esc_html__('Select Sidebar For 4 Col', 'khaki'),
            'section' => 'footer',
            'default' => 'sidebar-footer-4',
            'priority' => 10,
            'multiple' => 1,
            'choices' => $sidebars,
            'active_callback' => array(
                array(
                    'setting' => 'footer_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'footer_widget_col_four_size',
                    'operator' => '!=',
                    'value' => '0',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'footer_row_align_items_center',
            'label' => esc_html__('Row Items Align Center', 'khaki'),
            'section' => 'footer',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'footer_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'editor',
            'settings' => 'footer_text',
            'label' => esc_html__('Text', 'khaki'),
            'section' => 'footer',
            'default' => '<a href="https://nkdev.info/" target="_blank">nK</a> &copy; 2018. All rights reserved',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'footer_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));

        /**
         * Single page. Header
         * show,
         * size,
         * parallax for background image,
         * opacity parallax for content,
         * boxed,
         * Background Image,
         * Back Title,
         * Title - in ACF!,
         * Sub Title,
         * Content
         * Video Link,
         * */
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_page_header_show',
            'label' => esc_html__('Show', 'khaki'),
            'section' => 'single_page_header',
            'default' => 'on',
            'priority' => 10
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_page_header_show_title',
            'label' => esc_html__('Show Title', 'khaki'),
            'section' => 'single_page_header',
            'default' => 'on',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_page_header_size',
            'label' => esc_html__('Size', 'khaki'),
            'section' => 'single_page_header',
            'default' => false,
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                false => esc_attr__('Default', 'khaki'),
                'sm' => esc_attr__('Small', 'khaki'),
                'md' => esc_attr__('Middle', 'khaki'),
                'lg' => esc_attr__('Large', 'khaki'),
                'xl' => esc_attr__('X-Large', 'khaki'),
                'full' => esc_attr__('Full', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_page_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_page_header_parallax',
            'label' => esc_html__('Parallax for Background Image', 'khaki'),
            'section' => 'single_page_header',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_page_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_page_header_parallax_opacity',
            'label' => esc_html__('Opacity Parallax Content', 'khaki'),
            'section' => 'single_page_header',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_page_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_page_header_parallax_blur',
            'label' => esc_html__('Parallax Blur', 'khaki'),
            'section' => 'single_page_header',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_page_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_page_header_background_type',
            'label' => esc_html__('Select Type of Background', 'khaki'),
            'section' => 'single_page_header',
            'default' => 'image',
            'priority' => 10,
            'choices' => array(
                'image' => esc_attr__('Image', 'khaki'),
                'video' => esc_attr__('Video', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_page_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_page_header_type_image',
            'label' => esc_html__('Select Type of Background Image', 'khaki'),
            'section' => 'single_page_header',
            'default' => 'featured',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                false => esc_attr__('False', 'khaki'),
                'featured' => esc_attr__('Featured', 'khaki'),
                'custom' => esc_attr__('Custom', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_page_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'single_page_header_background_type',
                    'operator' => '==',
                    'value' => 'image',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'image',
            'settings' => 'single_page_header_background_image',
            'label' => esc_html__('Background Image', 'khaki'),
            'section' => 'single_page_header',
            'default' => get_template_directory_uri() . '/assets/images/default-banner.jpg',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_page_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'single_page_header_type_image',
                    'operator' => '==',
                    'value' => 'custom',
                ),
                array(
                    'setting' => 'single_page_header_background_type',
                    'operator' => '==',
                    'value' => 'image',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'single_page_header_background_image_opacity',
            'label' => esc_attr__('Opacity', 'khaki'),
            'section' => 'single_page_header',
            'default' => 5,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '10',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_page_header_type_image',
                    'operator' => '!=',
                    'value' => false,
                ),
                array(
                    'setting' => 'single_page_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'single_page_header_background_type',
                    'operator' => '==',
                    'value' => 'image',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'single_page_header_background_video_link',
            'label' => esc_html__('Background Video Link', 'khaki'),
            'section' => 'single_page_header',
            'default' => '',
            'description' => esc_html__('Supported YouTube and Vimeo video link', 'khaki'),
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_page_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'single_page_header_background_type',
                    'operator' => '==',
                    'value' => 'video',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'image',
            'settings' => 'single_page_header_background_video_poster',
            'label' => esc_html__('Background Video Poster', 'khaki'),
            'section' => 'single_page_header',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_page_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'single_page_header_background_type',
                    'operator' => '==',
                    'value' => 'video',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'number',
            'settings' => 'single_page_header_title_padding_bottom',
            'label' => esc_attr__('Title Padding Bottom', 'khaki'),
            'section' => 'single_page_header',
            'default' => 0,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '500',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_page_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_page_header_title_looks_like',
            'label' => esc_html__('Title Looks Like', 'khaki'),
            'section' => 'single_page_header',
            'default' => '',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                '' => esc_attr__('disabled', 'khaki'),
                'h1' => esc_attr__('h1', 'khaki'),
                'h2' => esc_attr__('h2', 'khaki'),
                'h3' => esc_attr__('h3', 'khaki'),
                'h4' => esc_attr__('h4', 'khaki'),
                'h5' => esc_attr__('h5', 'khaki'),
                'h6' => esc_attr__('h6', 'khaki'),
                'display-1' => esc_attr__('display-1', 'khaki'),
                'display-2' => esc_attr__('display-2', 'khaki'),
                'display-3' => esc_attr__('display-3', 'khaki'),
                'display-4' => esc_attr__('display-4', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_page_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_page_header_title_align',
            'label' => esc_html__('Title Align', 'khaki'),
            'section' => 'single_page_header',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'center' => esc_attr__('Center', 'khaki'),
                'left' => esc_attr__('Left', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_page_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'single_page_header_back_title',
            'label' => esc_html__('Back Title', 'khaki'),
            'section' => 'single_page_header',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_page_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'single_page_header_back_title_opacity',
            'label' => esc_attr__('Back Title Opacity', 'khaki'),
            'section' => 'single_page_header',
            'default' => 1,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '10',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_page_header_back_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'single_page_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'number',
            'settings' => 'single_page_header_back_title_padding_bottom',
            'label' => esc_attr__('Back Title Padding Bottom', 'khaki'),
            'section' => 'single_page_header',
            'default' => 0,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '500',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_page_header_back_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'single_page_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_page_header_back_title_align',
            'label' => esc_html__('Back Title Align', 'khaki'),
            'section' => 'single_page_header',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'center' => esc_attr__('Center', 'khaki'),
                'left' => esc_attr__('Left', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_page_header_back_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'single_page_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'single_page_header_sub_title',
            'label' => esc_html__('Sub Title', 'khaki'),
            'section' => 'single_page_header',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_page_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'number',
            'settings' => 'single_page_header_sub_title_padding_bottom',
            'label' => esc_attr__('Sub Title Padding Bottom', 'khaki'),
            'section' => 'single_page_header',
            'default' => 40,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '500',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_page_header_sub_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'single_page_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_page_header_sub_title_align',
            'label' => esc_html__('Sub Title Align', 'khaki'),
            'section' => 'single_page_header',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'center' => esc_attr__('Center', 'khaki'),
                'left' => esc_attr__('Left', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_page_header_sub_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'single_page_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'editor',
            'settings' => 'single_page_header_content',
            'label' => esc_html__('Content', 'khaki'),
            'section' => 'single_page_header',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_page_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'single_page_header_video_link',
            'label' => esc_html__('Video Link', 'khaki'),
            'section' => 'single_page_header',
            'default' => '',
            'description' => esc_html__('Supported YouTube and Vimeo video link', 'khaki'),
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_page_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_page_header_video_style',
            'label' => esc_html__('Icon Video Style', 'khaki'),
            'section' => 'single_page_header',
            'default' => false,
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                false => esc_attr__('Black', 'khaki'),
                '2' => esc_attr__('Black 2', 'khaki'),
                'light' => esc_attr__('Light', 'khaki'),
                '2-light' => esc_attr__('Light 2', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_page_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'single_page_header_video_link',
                    'operator' => '!=',
                    'value' => '',
                ),
            ),
        ));
        /**
         * Single page. Breadcrumbs
         * */
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_page_breadcrumbs_show',
            'label' => esc_html__('Show', 'khaki'),
            'section' => 'single_page_breadcrumbs',
            'default' => 'header',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                false => esc_attr__('Disabled', 'khaki'),
                'header' => esc_attr__('Header', 'khaki'),
                'out_header' => esc_attr__('Under Header', 'khaki'),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'single_page_breadcrumbs_homepage_title',
            'label' => esc_html__('Homepage Title', 'khaki'),
            'section' => 'single_page_breadcrumbs',
            'default' => 'Home',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_page_breadcrumbs_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_page_breadcrumbs_side',
            'label' => esc_html__('Side', 'khaki'),
            'section' => 'single_page_breadcrumbs',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                false => esc_attr__('Left', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
                'center' => esc_attr__('Center', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_page_breadcrumbs_show',
                    'operator' => '!=',
                    'value' => false,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_page_breadcrumbs_background',
            'label' => esc_html__('Background', 'khaki'),
            'section' => 'single_page_breadcrumbs',
            'default' => 'default',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                'default' => esc_attr__('Default', 'khaki'),
                false => esc_attr__('Black', 'khaki'),
                'white' => esc_attr__('White', 'khaki')
            )
        ));
        /**
         * Single page. Sidebar
         * */
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'sidebar_page_show',
            'label' => esc_html__('Show', 'khaki'),
            'section' => 'single_page_sidebar',
            'default' => 'off',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'sidebar_page_list',
            'label' => esc_html__('Type', 'khaki'),
            'section' => 'single_page_sidebar',
            'default' => 'single_page',
            'priority' => 10,
            'multiple' => 1,
            'choices' => $sidebars,
            'active_callback' => array(
                array(
                    'setting' => 'sidebar_page_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'sidebar_page_side',
            'label' => esc_html__('Side', 'khaki'),
            'section' => 'single_page_sidebar',
            'default' => 'right',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                'right' => esc_attr__('Right', 'khaki'),
                'left' => esc_attr__('Left', 'khaki'),
                'both' => esc_attr__('Both', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'sidebar_page_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'sidebar_page_additional_list',
            'label' => esc_html__('Type additional', 'khaki'),
            'section' => 'single_page_sidebar',
            'default' => 'single_page',
            'priority' => 10,
            'multiple' => 1,
            'choices' => $sidebars,
            'active_callback' => array(
                array(
                    'setting' => 'sidebar_page_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'sidebar_page_side',
                    'operator' => '==',
                    'value' => 'both',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'sidebar_page_sticky',
            'label' => esc_html__('Sticky', 'khaki'),
            'section' => 'single_page_sidebar',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'sidebar_page_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'color',
            'settings' => 'sidebar_single_page_background_color',
            'label' => esc_attr__('Background Color', 'khaki'),
            'section' => 'single_page_sidebar',
            'default' => '#f7f7f7',
            'priority' => 10,
            'choices'     => array(
                'alpha' => true,
            ),
            'output' => array(
                array(
                    'element' => '.nk-sidebar.nk-sidebar-page:after',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'sidebar_page_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'color',
            'settings' => 'sidebar_single_page_text_color',
            'label' => esc_attr__('Text Color', 'khaki'),
            'section' => 'single_page_sidebar',
            'default' => 'inherit',
            'priority' => 10,
            'choices'     => array(
                'alpha' => true,
            ),
            'output' => array(
                array(
                    'element' => '.nk-sidebar.nk-sidebar-page',
                    'property' => 'color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'sidebar_page_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        /**
         * Single page. Content
         * */
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_page_content_show_title',
            'label' => esc_html__('Show Title', 'khaki'),
            'section' => 'single_page_content',
            'default' => 'off',
            'priority' => 10,
        ));

        //Boxed for body tag
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_page_boxed',
            'label' => esc_html__('Boxed Content', 'khaki'),
            'section' => 'single_page_content',
            'default' => 'on',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_page_paddings',
            'label' => esc_html__('Top and Bottom paddings', 'khaki'),
            'section' => 'single_page_content',
            'default' => 'on',
            'priority' => 10,
        ));
        /**
         * Single post. Content
         * */
        /* NK_Options::add_field( array(
             'type' => 'toggle',
             'settings' => 'single_post_boxed',
             'label' => esc_html__('Boxed', 'khaki'),
             'section' => 'single_post_content',
             'default' => 'on',
             'priority' => 10,
         ));*/
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_post_boxed',
            'label' => esc_html__('Boxed', 'khaki'),
            'section' => 'single_post_content',
            'default' => true,
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                true => esc_attr__('Enabled', 'khaki'),
                false => esc_attr__('Disabled', 'khaki'),
                'narrow' => esc_attr__('Narrow', 'khaki'),
            ),
        ));

        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_post_content_show_title',
            'label' => esc_html__('Show Title', 'khaki'),
            'section' => 'single_post_content',
            'default' => 'off',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_post_adjacent_pagination',
            'label' => esc_html__('Adjacent Pagination', 'khaki'),
            'section' => 'single_post_content',
            'default' => 'on',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_post_adjacent_pagination_style',
            'label' => esc_html__('Style Pagination', 'khaki'),
            'section' => 'single_post_content',
            'default' => 'fixed',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                'fixed' => esc_attr__('Fixed', 'khaki'),
                'fixed-2' => esc_attr__('Fixed 2', 'khaki'),
                'static' => esc_attr__('Static', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_post_adjacent_pagination',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_post_adjacent_pagination_grid_link',
            'label' => esc_html__('Grid Link', 'khaki'),
            'section' => 'single_post_content',
            'default' => 'post-list',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                'disabled' => esc_attr__('Disabled', 'khaki'),
                'post-list' => esc_attr__('Posts List', 'khaki'),
                'custom' => esc_attr__('Custom', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_post_adjacent_pagination',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'single_post_adjacent_pagination_style',
                    'operator' => '==',
                    'value' => 'static',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'single_post_adjacent_pagination_grid_custom_link',
            'label' => esc_html__('URL', 'khaki'),
            'section' => 'single_post_content',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_post_adjacent_pagination',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'single_post_adjacent_pagination_style',
                    'operator' => '==',
                    'value' => 'static',
                ),
                array(
                    'setting' => 'single_post_adjacent_pagination_grid_link',
                    'operator' => '==',
                    'value' => 'custom',
                ),
            ),
        ));
        /**
         * Single post. Header
         * */
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_post_header_show',
            'label' => esc_html__('Show header', 'khaki'),
            'section' => 'single_post_header',
            'default' => 'on',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_post_header_show_title',
            'label' => esc_html__('Show Title', 'khaki'),
            'section' => 'single_post_header',
            'default' => 'on',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'number',
            'settings' => 'single_post_header_title_padding_bottom',
            'label' => esc_attr__('Title Padding Bottom', 'khaki'),
            'section' => 'single_post_header',
            'default' => 0,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '500',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_post_header_show_title',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'single_post_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_post_header_title_looks_like',
            'label' => esc_html__('Title Looks Like', 'khaki'),
            'section' => 'single_post_header',
            'default' => '',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                '' => esc_attr__('disabled', 'khaki'),
                'h1' => esc_attr__('h1', 'khaki'),
                'h2' => esc_attr__('h2', 'khaki'),
                'h3' => esc_attr__('h3', 'khaki'),
                'h4' => esc_attr__('h4', 'khaki'),
                'h5' => esc_attr__('h5', 'khaki'),
                'h6' => esc_attr__('h6', 'khaki'),
                'display-1' => esc_attr__('display-1', 'khaki'),
                'display-2' => esc_attr__('display-2', 'khaki'),
                'display-3' => esc_attr__('display-3', 'khaki'),
                'display-4' => esc_attr__('display-4', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_post_header_show_title',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'single_post_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_post_header_title_align',
            'label' => esc_html__('Title Align', 'khaki'),
            'section' => 'single_post_header',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'center' => esc_attr__('Center', 'khaki'),
                'left' => esc_attr__('Left', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_post_header_show_title',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'single_post_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_post_header_size',
            'label' => esc_html__('Size', 'khaki'),
            'section' => 'single_post_header',
            'default' => false,
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                false => esc_attr__('Default', 'khaki'),
                'sm' => esc_attr__('Small', 'khaki'),
                'md' => esc_attr__('Middle', 'khaki'),
                'lg' => esc_attr__('Large', 'khaki'),
                'xl' => esc_attr__('X-Large', 'khaki'),
                'full' => esc_attr__('Full', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_post_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_post_header_parallax',
            'label' => esc_html__('Parallax for Background Image', 'khaki'),
            'section' => 'single_post_header',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_post_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_post_header_parallax_opacity',
            'label' => esc_html__('Opacity Parallax Content', 'khaki'),
            'section' => 'single_post_header',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_post_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_post_header_parallax_blur',
            'label' => esc_html__('Parallax Blur', 'khaki'),
            'section' => 'single_post_header',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_post_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_post_header_background_type',
            'label' => esc_html__('Select Type of Background', 'khaki'),
            'section' => 'single_post_header',
            'default' => 'image',
            'priority' => 10,
            'choices' => array(
                'image' => esc_attr__('Image', 'khaki'),
                'video' => esc_attr__('Video', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_post_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_post_header_type_image',
            'label' => esc_html__('Select Type of Background Image', 'khaki'),
            'section' => 'single_post_header',
            'default' => 'featured',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                false => esc_attr__('False', 'khaki'),
                'featured' => esc_attr__('Featured', 'khaki'),
                'custom' => esc_attr__('Custom', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_post_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'single_post_header_background_type',
                    'operator' => '==',
                    'value' => 'image',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'image',
            'settings' => 'single_post_header_background_image',
            'label' => esc_html__('Background Image', 'khaki'),
            'section' => 'single_post_header',
            'default' => get_template_directory_uri() . '/assets/images/default-banner.jpg',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_post_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'single_post_header_type_image',
                    'operator' => '==',
                    'value' => 'custom',
                ),
                array(
                    'setting' => 'single_post_header_background_type',
                    'operator' => '==',
                    'value' => 'image',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'single_post_header_background_image_opacity',
            'label' => esc_attr__('Opacity', 'khaki'),
            'section' => 'single_post_header',
            'default' => 5,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '10',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_post_header_type_image',
                    'operator' => '!=',
                    'value' => false,
                ),
                array(
                    'setting' => 'single_post_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'single_post_header_background_type',
                    'operator' => '==',
                    'value' => 'image',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'single_post_header_background_video_link',
            'label' => esc_html__('Background Video Link', 'khaki'),
            'section' => 'single_post_header',
            'default' => '',
            'description' => esc_html__('Supported YouTube and Vimeo video link', 'khaki'),
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_post_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'single_post_header_background_type',
                    'operator' => '==',
                    'value' => 'video',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'image',
            'settings' => 'single_post_header_background_video_poster',
            'label' => esc_html__('Background Video Poster', 'khaki'),
            'section' => 'single_post_header',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_post_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'single_post_header_background_type',
                    'operator' => '==',
                    'value' => 'video',
                ),
            ),
        ));
        /**
         * Single post. Meta
         * */
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_post_meta_show',
            'label' => esc_html__('Show Meta', 'khaki'),
            'section' => 'single_post_meta',
            'default' => 'on',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_post_date_author_category_show',
            'label' => esc_html__('Show Date, Author, Category block', 'khaki'),
            'section' => 'single_post_meta',
            'default' => 'on',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_post_date_author_category_area',
            'label' => esc_html__('Block Area', 'khaki'),
            'section' => 'single_post_meta',
            'default' => 'header-middle',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                'header-middle' => esc_attr__('Header. Middle', 'khaki'),
                'header-bottom' => esc_attr__('Header. Bottom', 'khaki'),
                'content-top' => esc_attr__('Content. Top', 'khaki'),
                'content-after-format' => esc_attr__('After Format Content', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_post_date_author_category_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_post_meta_published_show',
            'label' => esc_html__('Show Meta Published', 'khaki'),
            'section' => 'single_post_meta',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_post_meta_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_post_meta_categories_show',
            'label' => esc_html__('Show Meta Categories', 'khaki'),
            'section' => 'single_post_meta',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_post_meta_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_post_meta_author_show',
            'label' => esc_html__('Show Meta Author', 'khaki'),
            'section' => 'single_post_meta',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_post_meta_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_post_meta_comments_show',
            'label' => esc_html__('Show Meta Comments', 'khaki'),
            'section' => 'single_post_meta',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_post_meta_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_post_meta_like_show',
            'label' => esc_html__('Show Meta Like', 'khaki'),
            'section' => 'single_post_meta',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_post_meta_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_post_meta_views_show',
            'label' => esc_html__('Show Meta Views', 'khaki'),
            'section' => 'single_post_meta',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_post_meta_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        /**
         * Single Post. Sidebar
         * */
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'sidebar_post_show',
            'label' => esc_html__('Show', 'khaki'),
            'section' => 'single_post_sidebar',
            'default' => 'on',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'sidebar_post_list',
            'label' => esc_html__('Type', 'khaki'),
            'section' => 'single_post_sidebar',
            'default' => 'sidebar-post',
            'priority' => 10,
            'multiple' => 1,
            'choices' => $sidebars,
            'active_callback' => array(
                array(
                    'setting' => 'sidebar_post_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'sidebar_post_side',
            'label' => esc_html__('Side', 'khaki'),
            'section' => 'single_post_sidebar',
            'default' => 'right',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                'right' => esc_attr__('Right', 'khaki'),
                'left' => esc_attr__('Left', 'khaki'),
                'both' => esc_attr__('Both', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'sidebar_post_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'sidebar_post_additional_list',
            'label' => esc_html__('Type additional', 'khaki'),
            'section' => 'single_post_sidebar',
            'default' => 'single_page',
            'priority' => 10,
            'multiple' => 1,
            'choices' => $sidebars,
            'active_callback' => array(
                array(
                    'setting' => 'sidebar_post_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'sidebar_post_side',
                    'operator' => '==',
                    'value' => 'both',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'sidebar_post_sticky',
            'label' => esc_html__('Sticky', 'khaki'),
            'section' => 'single_post_sidebar',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'sidebar_post_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'color',
            'settings' => 'sidebar_post_background_color',
            'label' => esc_attr__('Background Color', 'khaki'),
            'section' => 'single_post_sidebar',
            'default' => '#f7f7f7',
            'priority' => 10,
            'choices'     => array(
                'alpha' => true,
            ),
            'output' => array(
                array(
                    'element' => '.nk-sidebar.nk-sidebar-post:after',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'sidebar_post_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'color',
            'settings' => 'sidebar_post_text_color',
            'label' => esc_attr__('Text Color', 'khaki'),
            'section' => 'single_post_sidebar',
            'default' => 'inherit',
            'priority' => 10,
            'choices'     => array(
                'alpha' => true,
            ),
            'output' => array(
                array(
                    'element' => '.nk-sidebar.nk-sidebar-post',
                    'property' => 'color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'sidebar_post_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        /**
         * Single post. Breadcrumbs
         * */
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_post_breadcrumbs_show',
            'label' => esc_html__('Show', 'khaki'),
            'section' => 'single_post_breadcrumbs',
            'default' => 'header',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                false => esc_attr__('Disabled', 'khaki'),
                'header' => esc_attr__('Header', 'khaki'),
                'out_header' => esc_attr__('Under Header', 'khaki'),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'single_post_breadcrumbs_homepage_title',
            'label' => esc_html__('Homepage Title', 'khaki'),
            'section' => 'single_post_breadcrumbs',
            'default' => 'Home',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_post_breadcrumbs_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_post_breadcrumbs_side',
            'label' => esc_html__('Side', 'khaki'),
            'section' => 'single_post_breadcrumbs',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                false => esc_attr__('Left', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
                'center' => esc_attr__('Center', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_post_breadcrumbs_show',
                    'operator' => '!=',
                    'value' => false,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_post_breadcrumbs_background',
            'label' => esc_html__('Background', 'khaki'),
            'section' => 'single_post_breadcrumbs',
            'default' => 'default',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                'default' => esc_attr__('Default', 'khaki'),
                false => esc_attr__('Black', 'khaki'),
                'white' => esc_attr__('White', 'khaki')
            ),
        ));
        /**
         * Portfolio. Header
         */
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'portfolio_header_show',
            'label' => esc_html__('Show', 'khaki'),
            'section' => 'portfolio_header',
            'default' => 'on',
            'priority' => 10
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'portfolio_header_show_title',
            'label' => esc_html__('Show Title', 'khaki'),
            'section' => 'portfolio_header',
            'default' => 'on',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'portfolio_header_archive_custom_title',
            'label' => esc_html__('Custom Archive Title', 'khaki'),
            'section' => 'portfolio_header',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_show_title',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'number',
            'settings' => 'portfolio_header_title_padding_bottom',
            'label' => esc_attr__('Title Padding Bottom', 'khaki'),
            'section' => 'portfolio_header',
            'default' => 0,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '500',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_show_title',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'portfolio_header_title_looks_like',
            'label' => esc_html__('Title Looks Like', 'khaki'),
            'section' => 'portfolio_header',
            'default' => '',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                '' => esc_attr__('disabled', 'khaki'),
                'h1' => esc_attr__('h1', 'khaki'),
                'h2' => esc_attr__('h2', 'khaki'),
                'h3' => esc_attr__('h3', 'khaki'),
                'h4' => esc_attr__('h4', 'khaki'),
                'h5' => esc_attr__('h5', 'khaki'),
                'h6' => esc_attr__('h6', 'khaki'),
                'display-1' => esc_attr__('display-1', 'khaki'),
                'display-2' => esc_attr__('display-2', 'khaki'),
                'display-3' => esc_attr__('display-3', 'khaki'),
                'display-4' => esc_attr__('display-4', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_show_title',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'portfolio_header_title_align',
            'label' => esc_html__('Title Align', 'khaki'),
            'section' => 'portfolio_header',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'center' => esc_attr__('Center', 'khaki'),
                'left' => esc_attr__('Left', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_show_title',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'portfolio_header_size',
            'label' => esc_html__('Size', 'khaki'),
            'section' => 'portfolio_header',
            'default' => false,
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                false => esc_attr__('Default', 'khaki'),
                'sm' => esc_attr__('Small', 'khaki'),
                'md' => esc_attr__('Middle', 'khaki'),
                'lg' => esc_attr__('Large', 'khaki'),
                'xl' => esc_attr__('X-Large', 'khaki'),
                'full' => esc_attr__('Full', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'portfolio_header_parallax',
            'label' => esc_html__('Parallax for Background Image', 'khaki'),
            'section' => 'portfolio_header',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'portfolio_header_parallax_opacity',
            'label' => esc_html__('Opacity Parallax Content', 'khaki'),
            'section' => 'portfolio_header',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'portfolio_header_parallax_blur',
            'label' => esc_html__('Parallax Blur', 'khaki'),
            'section' => 'portfolio_header',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'portfolio_header_background_type',
            'label' => esc_html__('Select Type of Background', 'khaki'),
            'section' => 'portfolio_header',
            'default' => 'image',
            'priority' => 10,
            'choices' => array(
                'image' => esc_attr__('Image', 'khaki'),
                'video' => esc_attr__('Video', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'portfolio_header_type_image',
            'label' => esc_html__('Select Type of Background Image', 'khaki'),
            'section' => 'portfolio_header',
            'default' => 'featured',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                false => esc_attr__('False', 'khaki'),
                'featured' => esc_attr__('Featured', 'khaki'),
                'custom' => esc_attr__('Custom', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'portfolio_header_background_type',
                    'operator' => '==',
                    'value' => 'image',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'image',
            'settings' => 'portfolio_header_background_image',
            'label' => esc_html__('Background Image', 'khaki'),
            'section' => 'portfolio_header',
            'default' => get_template_directory_uri() . '/assets/images/default-banner.jpg',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'portfolio_header_type_image',
                    'operator' => '==',
                    'value' => 'custom',
                ),
                array(
                    'setting' => 'portfolio_header_background_type',
                    'operator' => '==',
                    'value' => 'image',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'image',
            'settings' => 'portfolio_header_archive_background_image',
            'label' => esc_html__('Background Archive Image', 'khaki'),
            'section' => 'portfolio_header',
            'default' => get_template_directory_uri() . '/assets/images/default-banner.jpg',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'portfolio_header_background_image_opacity',
            'label' => esc_attr__('Opacity', 'khaki'),
            'section' => 'portfolio_header',
            'default' => 5,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '10',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_type_image',
                    'operator' => '!=',
                    'value' => false,
                ),
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'portfolio_header_background_type',
                    'operator' => '==',
                    'value' => 'image',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'portfolio_header_background_video_link',
            'label' => esc_html__('Background Video Link', 'khaki'),
            'section' => 'portfolio_header',
            'default' => '',
            'description' => esc_html__('Supported YouTube and Vimeo video link', 'khaki'),
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'portfolio_header_background_type',
                    'operator' => '==',
                    'value' => 'video',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'image',
            'settings' => 'portfolio_header_background_video_poster',
            'label' => esc_html__('Background Video Poster', 'khaki'),
            'section' => 'portfolio_header',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'portfolio_header_background_type',
                    'operator' => '==',
                    'value' => 'video',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'portfolio_header_back_title',
            'label' => esc_html__('Back Title', 'khaki'),
            'section' => 'portfolio_header',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'portfolio_header_back_title_opacity',
            'label' => esc_attr__('Back Title Opacity', 'khaki'),
            'section' => 'portfolio_header',
            'default' => 1,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '10',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_back_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'number',
            'settings' => 'portfolio_header_back_title_padding_bottom',
            'label' => esc_attr__('Back Title Padding Bottom', 'khaki'),
            'section' => 'portfolio_header',
            'default' => 0,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '500',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_back_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'portfolio_header_back_title_align',
            'label' => esc_html__('Back Title Align', 'khaki'),
            'section' => 'portfolio_header',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'center' => esc_attr__('Center', 'khaki'),
                'left' => esc_attr__('Left', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_back_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'portfolio_header_sub_title',
            'label' => esc_html__('Sub Title', 'khaki'),
            'section' => 'portfolio_header',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'number',
            'settings' => 'portfolio_header_sub_title_padding_bottom',
            'label' => esc_attr__('Sub Title Padding Bottom', 'khaki'),
            'section' => 'portfolio_header',
            'default' => 40,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '500',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_sub_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'portfolio_header_sub_title_align',
            'label' => esc_html__('Sub Title Align', 'khaki'),
            'section' => 'portfolio_header',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'center' => esc_attr__('Center', 'khaki'),
                'left' => esc_attr__('Left', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_sub_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'editor',
            'settings' => 'portfolio_header_content',
            'label' => esc_html__('Content', 'khaki'),
            'section' => 'portfolio_header',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'portfolio_header_video_link',
            'label' => esc_html__('Video Link', 'khaki'),
            'section' => 'portfolio_header',
            'default' => '',
            'description' => esc_html__('Supported YouTube and Vimeo video link', 'khaki'),
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'portfolio_header_video_style',
            'label' => esc_html__('Icon Video Style', 'khaki'),
            'section' => 'portfolio_header',
            'default' => false,
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                false => esc_attr__('Black', 'khaki'),
                '2' => esc_attr__('Black 2', 'khaki'),
                'light' => esc_attr__('Light', 'khaki'),
                '2-light' => esc_attr__('Light 2', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'portfolio_header_video_link',
                    'operator' => '!=',
                    'value' => '',
                ),
            ),
        ));
        /**
         * Portfolio. Archive
         */
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'portfolio_archive_style',
            'label' => esc_html__('Select Portfolios List Style', 'khaki'),
            'section' => 'portfolio_archive',
            'default' => 'masonry',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'list' => esc_attr__('List', 'khaki'),
                'list_2' => esc_attr__('List 2', 'khaki'),
                'masonry' => esc_attr__('Masonry', 'khaki')
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'image',
            'settings' => 'portfolio_no_image',
            'label' => esc_html__('No Image', 'khaki'),
            'section' => 'portfolio_archive',
            'default' => get_template_directory_uri() . '/assets/images/no-image.jpg',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'portfolio_pagination',
            'label' => esc_html__('Pagination', 'khaki'),
            'section' => 'portfolio_archive',
            'default' => 'load_more',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                false => esc_html__("No Pagination", 'khaki'),
                true => esc_html__("Simple Pagination", 'khaki'),
                'load_more' => esc_html__("Load More button", 'khaki'),
                'infinite' => esc_html__("Infinite Scroll", 'khaki'),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'portfolio_preview_description_type_content',
            'label' => esc_html__('Preview Description Type', 'khaki'),
            'section' => 'portfolio_archive',
            'default' => 'excerpt',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                'false' => esc_attr__('Disabled', 'khaki'),
                'excerpt' => esc_attr__('Excerpt', 'khaki'),
                'more' => esc_attr__('Use more tag', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_archive_style',
                    'operator' => '!=',
                    'value' => 'masonry',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'number',
            'settings' => 'portfolio_preview_description_trim_cnt',
            'label' => esc_html__('Trim to a value', 'khaki'),
            'section' => 'portfolio_archive',
            'default' => 15,
            'priority' => 10,
            'choices' => array(
                'min' => 0,
                'max' => 2000,
                'step' => 1,
            ),
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_preview_description_type_content',
                    'operator' => '==',
                    'value' => 'excerpt',
                ),
                array(
                    'setting' => 'portfolio_archive_style',
                    'operator' => '!=',
                    'value' => 'masonry',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'portfolio_archive_show_date',
            'label' => esc_html__('Show Date', 'khaki'),
            'section' => 'portfolio_archive',
            'default' => 'on',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'portfolio_archive_show_likes',
            'label' => esc_html__('Show Likes', 'khaki'),
            'section' => 'portfolio_archive',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_archive_style',
                    'operator' => '==',
                    'value' => 'masonry',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'portfolio_archive_show_title',
            'label' => esc_html__('Show Title', 'khaki'),
            'section' => 'portfolio_archive',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_archive_style',
                    'operator' => '==',
                    'value' => 'masonry',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'portfolio_archive_show_comments_count',
            'label' => esc_html__('Show Comments Count', 'khaki'),
            'section' => 'portfolio_archive',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_archive_style',
                    'operator' => '==',
                    'value' => 'masonry',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'portfolio_archive_show_eye_icon',
            'label' => esc_html__('Show Eye Icon', 'khaki'),
            'section' => 'portfolio_archive',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_archive_style',
                    'operator' => '==',
                    'value' => 'masonry',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'portfolio_archive_show_link_icon',
            'label' => esc_html__('Show Link Icon', 'khaki'),
            'section' => 'portfolio_archive',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_archive_style',
                    'operator' => '==',
                    'value' => 'masonry',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'portfolio_archive_global_link',
            'label' => esc_html__('Use Global Link', 'khaki'),
            'section' => 'portfolio_archive',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_archive_style',
                    'operator' => '==',
                    'value' => 'masonry',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'portfolio_archive_effect_style',
            'label' => esc_html__('Effect Style', 'khaki'),
            'section' => 'portfolio_archive',
            'default' => '1',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                '1' => esc_attr__('Style 1', 'khaki'),
                '1-a' => esc_attr__('Style 1-a', 'khaki'),
                '2' => esc_attr__('Style 2', 'khaki'),
                '3' => esc_attr__('Style 3', 'khaki'),
                '4' => esc_attr__('Style 4', 'khaki'),
                '5' => esc_attr__('Style 5', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_archive_style',
                    'operator' => '==',
                    'value' => 'masonry',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'portfolio_archive_content_vertical_align',
            'label' => esc_html__('Content Vertical Align', 'khaki'),
            'section' => 'portfolio_archive',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'top' => esc_attr__('Top', 'khaki'),
                'center' => esc_attr__('Center', 'khaki'),
                'bottom' => esc_attr__('Bottom', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_archive_style',
                    'operator' => '==',
                    'value' => 'masonry',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'portfolio_archive_no_effect',
            'label' => esc_html__('No Hover Effect', 'khaki'),
            'section' => 'portfolio_archive',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_archive_style',
                    'operator' => '==',
                    'value' => 'masonry',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'portfolio_archive_hovered',
            'label' => esc_html__('Hovered', 'khaki'),
            'section' => 'portfolio_archive',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_archive_style',
                    'operator' => '==',
                    'value' => 'masonry',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'portfolio_archive_filter',
            'label' => esc_html__('Use Filter', 'khaki'),
            'section' => 'portfolio_archive',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_archive_style',
                    'operator' => '==',
                    'value' => 'masonry',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'portfolio_archive_cross',
            'label' => esc_html__('Cross', 'khaki'),
            'section' => 'portfolio_archive',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_archive_style',
                    'operator' => '==',
                    'value' => 'masonry',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'portfolio_archive_columns',
            'label' => esc_attr__('Number of Columns', 'khaki'),
            'section' => 'portfolio_archive',
            'default' => 3,
            'priority' => 10,
            'choices' => array(
                'min' => 2,
                'max' => 4,
                'step' => 1,
            ),
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_archive_style',
                    'operator' => '==',
                    'value' => 'masonry',
                ),
            ),
        ));
        /**
         * Portfolio Page. Content
         * */
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'portfolio_content_show_title',
            'label' => esc_html__('Show Title', 'khaki'),
            'section' => 'portfolio_content',
            'default' => 'off',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'portfolio_inner_boxed',
            'label' => esc_html__('Boxed Content', 'khaki'),
            'section' => 'portfolio_content',
            'default' => 'on',
            'priority' => 10,
        ));
        /**
         * Portfolio. Single
         */
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'single_portfolio_adjacent_pagination',
            'label' => esc_html__('Adjacent Pagination', 'khaki'),
            'section' => 'portfolio_single',
            'default' => 'on',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_portfolio_adjacent_pagination_style',
            'label' => esc_html__('Style Pagination', 'khaki'),
            'section' => 'portfolio_single',
            'default' => 'fixed',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                'fixed' => esc_attr__('Fixed', 'khaki'),
                'fixed-2' => esc_attr__('Fixed 2', 'khaki'),
                'static' => esc_attr__('Static', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_portfolio_adjacent_pagination',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_portfolio_adjacent_pagination_position',
            'label' => esc_html__('Pagination Position', 'khaki'),
            'section' => 'portfolio_single',
            'default' => 'after',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                'before' => esc_attr__('Before Content', 'khaki'),
                'after' => esc_attr__('After Content', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_portfolio_adjacent_pagination',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'single_portfolio_adjacent_pagination_style',
                    'operator' => '==',
                    'value' => 'static',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'single_portfolio_adjacent_pagination_grid_link',
            'label' => esc_html__('Grid Link', 'khaki'),
            'section' => 'portfolio_single',
            'default' => 'post-list',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                'disabled' => esc_attr__('Disabled', 'khaki'),
                'post-list' => esc_attr__('Posts List', 'khaki'),
                'custom' => esc_attr__('Custom', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'single_portfolio_adjacent_pagination',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'single_portfolio_adjacent_pagination_style',
                    'operator' => '==',
                    'value' => 'static',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'single_portfolio_adjacent_pagination_grid_custom_link',
            'label' => esc_html__('URL', 'khaki'),
            'section' => 'portfolio_single',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'single_portfolio_adjacent_pagination',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'single_portfolio_adjacent_pagination_style',
                    'operator' => '==',
                    'value' => 'static',
                ),
                array(
                    'setting' => 'single_portfolio_adjacent_pagination_grid_link',
                    'operator' => '==',
                    'value' => 'custom',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'portfolio_detail_show_title',
            'label' => esc_html__('Show Title', 'khaki'),
            'section' => 'portfolio_single',
            'default' => 'off',
            'priority' => 10,
        ));
        /**
        /**
         * Portfolio. Breadcrumbs
         * */
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'portfolio_breadcrumbs_show',
            'label' => esc_html__('Show', 'khaki'),
            'section' => 'portfolio_breadcrumbs',
            'default' => 'header',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                false => esc_attr__('Disabled', 'khaki'),
                'header' => esc_attr__('Header', 'khaki'),
                'out_header' => esc_attr__('Under Header', 'khaki'),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'portfolio_breadcrumbs_homepage_title',
            'label' => esc_html__('Homepage Title', 'khaki'),
            'section' => 'portfolio_breadcrumbs',
            'default' => 'Home',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_breadcrumbs_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'portfolio_breadcrumbs_side',
            'label' => esc_html__('Side', 'khaki'),
            'section' => 'portfolio_breadcrumbs',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                false => esc_attr__('Left', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
                'center' => esc_attr__('Center', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_breadcrumbs_show',
                    'operator' => '!=',
                    'value' => false,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'portfolio_breadcrumbs_background',
            'label' => esc_html__('Background', 'khaki'),
            'section' => 'portfolio_breadcrumbs',
            'default' => 'default',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                'default' => esc_attr__('Default', 'khaki'),
                false => esc_attr__('Black', 'khaki'),
                'white' => esc_attr__('White', 'khaki')
            )
        ));
        /**
         * Portfolio. Sidebar
         * */
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'sidebar_portfolio_show',
            'label' => esc_html__('Show', 'khaki'),
            'section' => 'portfolio_sidebar',
            'default' => 'off',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'sidebar_portfolio_list',
            'label' => esc_html__('Type', 'khaki'),
            'section' => 'portfolio_sidebar',
            'default' => 'single_page',
            'priority' => 10,
            'multiple' => 1,
            'choices' => $sidebars,
            'active_callback' => array(
                array(
                    'setting' => 'sidebar_portfolio_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'sidebar_portfolio_side',
            'label' => esc_html__('Side', 'khaki'),
            'section' => 'portfolio_sidebar',
            'default' => 'right',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                'right' => esc_attr__('Right', 'khaki'),
                'left' => esc_attr__('Left', 'khaki'),
                'both' => esc_attr__('Both', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'sidebar_portfolio_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'sidebar_portfolio_additional_list',
            'label' => esc_html__('Type additional', 'khaki'),
            'section' => 'portfolio_sidebar',
            'default' => 'single_portfolio',
            'priority' => 10,
            'multiple' => 1,
            'choices' => $sidebars,
            'active_callback' => array(
                array(
                    'setting' => 'sidebar_portfolio_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'sidebar_portfolio_side',
                    'operator' => '==',
                    'value' => 'both',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'sidebar_portfolio_sticky',
            'label' => esc_html__('Sticky', 'khaki'),
            'section' => 'portfolio_sidebar',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'sidebar_portfolio_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'color',
            'settings' => 'sidebar_portfolio_background_color',
            'label' => esc_attr__('Background Color', 'khaki'),
            'section' => 'portfolio_sidebar',
            'default' => '#f7f7f7',
            'priority' => 10,
            'choices'     => array(
                'alpha' => true,
            ),
            'output' => array(
                array(
                    'element' => '.nk-sidebar.nk-sidebar-portfolio:after',
                    'property' => 'background-color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'sidebar_portfolio_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'color',
            'settings' => 'sidebar_portfolio_text_color',
            'label' => esc_attr__('Text Color', 'khaki'),
            'section' => 'portfolio_sidebar',
            'default' => 'inherit',
            'priority' => 10,
            'choices'     => array(
                'alpha' => true,
            ),
            'output' => array(
                array(
                    'element' => '.nk-sidebar.nk-sidebar-portfolio',
                    'property' => 'color',
                ),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'sidebar_portfolio_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        /**
         * Portfolio. Meta
         */
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'portfolio_show_meta',
            'label' => esc_html__('Show Meta', 'khaki'),
            'section' => 'portfolio_meta',
            'default' => 'on',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'portfolio_position_meta',
            'label' => esc_html__('Position', 'khaki'),
            'section' => 'portfolio_meta',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                'header' => esc_html__("Header", 'khaki'),
                'out header' => esc_html__("Under Header", 'khaki'),
                'before content' => esc_html__("Before Content", 'khaki'),
                'after content' => esc_html__("After Content", 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'portfolio_show_meta',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        /**
         * Custom posts function for init kirki standard fields
         * */
        kirki_initial_custom_post(
            array(
                'event',
                'playlist',
                'woocommerce'
            )
        );
        /**
         *
         * Instagram
         */
        NK_Options::add_section('khaki_instagram', array(
            'title' => esc_html__('Instagram', 'khaki'),
            'priority' => 12,
            'capability' => 'edit_theme_options',
            'icon' => 'fa fa-instagram'
        ));
        $get_token_url = 'https://instagram.com/oauth/authorize/?client_id=50ab03ef9bce4dac96349824154d1833&redirect_uri=http://instagram-api.nkdev.info?return_uri=' . admin_url('customize.php?autofocus[section]=khaki_instagram') . '&response_type=token';
        NK_Options::add_field( array(
            'type' => 'custom',
            'settings' => 'instagram_access_token_btn',
            'label' => esc_html__('Get Access Token', 'khaki'),
            'section' => 'khaki_instagram',
            'default' => '<a href="' . esc_url($get_token_url) . '" class="button button-hero button-primary">Log In and get Access Token</a>',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'instagram_access_token',
            'label' => esc_html__('Access Token', 'khaki'),
            'section' => 'khaki_instagram',
            'default' => '',
            'priority' => 10
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'instagram_user_id',
            'label' => esc_html__('User ID', 'khaki'),
            'description' => sprintf(wp_kses(__('Note that User ID corresponds to your Instagram <strong>account ID (eg: 4385108)</strong>, not your username. <br><br> If you do not know your account ID, Google <a href="%s" target="_blank">"What is my Instagram account ID?"</a>. There are several free tools available online that will look it up for you.', 'khaki'), array('a' => array('href' => array()), 'strong' => array(), 'br' => array())), esc_url("https://google.com/search?q=What%20is%20my%20Instagram%20account%20ID%3F")),
            'section' => 'khaki_instagram',
            'default' => '',
            'priority' => 10
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'instagram_cachetime',
            'label' => esc_html__('Cache Time [seconds]', 'khaki'),
            'section' => 'khaki_instagram',
            'default' => '3600',
            'priority' => 10
        ));

        add_action('customize_controls_print_footer_scripts', 'nk_get_instagram_access_token_script', 20);
        if (!function_exists('nk_get_instagram_access_token_script')) :
            function nk_get_instagram_access_token_script()
            {
                ?>
                <script>
                    jQuery(function ($) {
                        var token = window.location.hash.replace('#access_token=', '');
                        var $input = $('#customize-control-instagram_access_token input');
                        var isValidToken = /#access_token=/g.test(window.location.hash);
                        var isDifferentValue = $input.val() !== token;

                        if (isValidToken && isDifferentValue && $input.length) {
                            $input.val(token).change();
                        }
                    })
                </script>
                <?php
            }
        endif;
        /**
         *
         * Twitter
         */
        NK_Options::add_section('khaki_twitter', array(
            'title' => esc_html__('Twitter', 'khaki'),
            'priority' => 12,
            'capability' => 'edit_theme_options',
            'icon' => 'fa fa-twitter'
        ));
        NK_Options::add_field( array(
            'type' => 'custom',
            'settings' => 'twitter_custom_text',
            'label' => sprintf(wp_kses(__('How to create Twitter API key you can read here (or use google): <a href="%s" target="_blank">%s</a>', 'khaki'), array('a' => array('href' => array(), 'target' => array()))), esc_url("http://www.gabfirethemes.com/create-twitter-api-key/"), esc_url("http://www.gabfirethemes.com/create-twitter-api-key/")),
            'section' => 'khaki_twitter',
            'default' => '',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'twitter_consumer_key',
            'label' => esc_html__('Consumer Key', 'khaki'),
            'section' => 'khaki_twitter',
            'default' => '',
            'priority' => 10
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'twitter_consumer_secret',
            'label' => esc_html__('Consumer Secret', 'khaki'),
            'section' => 'khaki_twitter',
            'default' => '',
            'priority' => 10
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'twitter_access_token',
            'label' => esc_html__('Access Token', 'khaki'),
            'section' => 'khaki_twitter',
            'default' => '',
            'priority' => 10
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'twitter_access_token_secret',
            'label' => esc_html__('Access Token Secret', 'khaki'),
            'section' => 'khaki_twitter',
            'default' => '',
            'priority' => 10
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'twitter_cache_time',
            'label' => esc_html__('Cache Time [seconds]', 'khaki'),
            'section' => 'khaki_twitter',
            'default' => '3',
            'priority' => 10
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'twitter_show_replies',
            'label' => esc_html__('Show Replies', 'khaki'),
            'section' => 'khaki_twitter',
            'default' => 'off',
            'priority' => 10,
        ));
        /**
         * Not Found page
         **/
        NK_Options::add_field( array(
            'type' => 'image',
            'settings' => 'not_found_image',
            'label' => esc_html__('Background Image', 'khaki'),
            'section' => 'not_found_page',
            'default' => get_template_directory_uri() . '/assets/images/default-banner.jpg',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'not_found_show_text',
            'label' => esc_html__('Show Text', 'khaki'),
            'section' => 'not_found_page',
            'default' => 'on',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'not_found_show_home_button',
            'label' => esc_html__('Show Home Button', 'khaki'),
            'section' => 'not_found_page',
            'default' => 'on',
            'priority' => 10,
        ));
        /**
         * Archive page
         **/
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'archive_pagination',
            'label' => esc_html__('Pagination', 'khaki'),
            'section' => 'archive_content',
            'default' => 'load_more',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                false => esc_html__("No Pagination", 'khaki'),
                true => esc_html__("Simple Pagination", 'khaki'),
                'load_more' => esc_html__("Load More button", 'khaki'),
                'infinite' => esc_html__("Infinite Scroll", 'khaki'),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'archive_show_title',
            'label' => esc_html__('Show Title', 'khaki'),
            'section' => 'archive_content',
            'default' => 'off',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'archive_boxed',
            'label' => esc_html__('Boxed Content', 'khaki'),
            'section' => 'archive_content',
            'default' => 'on',
            'priority' => 10,
        ));
        //for posts list
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'archive_list_style_content',
            'label' => esc_html__('Blog List Style', 'khaki'),
            'section' => 'archive_content',
            'default' => 'classic',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                'classic' => esc_attr__('Classic', 'khaki'),
                'list' => esc_attr__('List', 'khaki'),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'archive_list_columns_content',
            'label' => esc_attr__('Number of Columns', 'khaki'),
            'section' => 'archive_content',
            'default' => 3,
            'priority' => 10,
            'choices' => array(
                'min' => 1,
                'max' => 3,
                'step' => 1,
            ),
            'active_callback' => array(
                array(
                    'setting' => 'archive_list_style_content',
                    'operator' => '!=',
                    'value' => 'list',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'archive_preview_description_type_content',
            'label' => esc_html__('Preview Description Type', 'khaki'),
            'section' => 'archive_content',
            'default' => 'excerpt',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                'false' => esc_attr__('Disabled', 'khaki'),
                'excerpt' => esc_attr__('Excerpt', 'khaki'),
                'more' => esc_attr__('Use more tag', 'khaki')
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'number',
            'settings' => 'archive_preview_description_trim_cnt',
            'label' => esc_html__('Cut in the number of words', 'khaki'),
            'section' => 'archive_content',
            'default' => 50,
            'priority' => 10,
            'choices' => array(
                'min' => 0,
                'max' => 200,
                'step' => 1,
            ),
            'active_callback' => array(
                array(
                    'setting' => 'archive_preview_description_type_content',
                    'operator' => '==',
                    'value' => 'excerpt',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'archive_simple_view',
            'label' => esc_html__('Simple View', 'khaki'),
            'section' => 'archive_content',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'archive_list_style_content',
                    'operator' => '==',
                    'value' => 'classic',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'archive_show_continue_button',
            'label' => esc_html__('Show Continue Button', 'khaki'),
            'section' => 'archive_content',
            'default' => 'off',
            'priority' => 10,
        ));
        /**
         * Archive page. Header
         **/
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'archive_header_show',
            'label' => esc_html__('Show', 'khaki'),
            'section' => 'archive_header',
            'default' => 'on',
            'priority' => 10
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'archive_header_show_title',
            'label' => esc_html__('Show Title', 'khaki'),
            'section' => 'archive_header',
            'default' => 'on',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'number',
            'settings' => 'archive_header_title_padding_bottom',
            'label' => esc_attr__('Title Padding Bottom', 'khaki'),
            'section' => 'archive_header',
            'default' => 0,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '500',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'archive_header_show_title',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'archive_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'archive_header_title_looks_like',
            'label' => esc_html__('Title Looks Like', 'khaki'),
            'section' => 'archive_header',
            'default' => '',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                '' => esc_attr__('disabled', 'khaki'),
                'h1' => esc_attr__('h1', 'khaki'),
                'h2' => esc_attr__('h2', 'khaki'),
                'h3' => esc_attr__('h3', 'khaki'),
                'h4' => esc_attr__('h4', 'khaki'),
                'h5' => esc_attr__('h5', 'khaki'),
                'h6' => esc_attr__('h6', 'khaki'),
                'display-1' => esc_attr__('display-1', 'khaki'),
                'display-2' => esc_attr__('display-2', 'khaki'),
                'display-3' => esc_attr__('display-3', 'khaki'),
                'display-4' => esc_attr__('display-4', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'archive_header_show_title',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'archive_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'archive_header_title_align',
            'label' => esc_html__('Title Align', 'khaki'),
            'section' => 'archive_header',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'center' => esc_attr__('Center', 'khaki'),
                'left' => esc_attr__('Left', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'archive_header_show_title',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'archive_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'archive_header_size',
            'label' => esc_html__('Size', 'khaki'),
            'section' => 'archive_header',
            'default' => false,
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                false => esc_attr__('Default', 'khaki'),
                'sm' => esc_attr__('Small', 'khaki'),
                'md' => esc_attr__('Middle', 'khaki'),
                'lg' => esc_attr__('Large', 'khaki'),
                'xl' => esc_attr__('X-Large', 'khaki'),
                'full' => esc_attr__('Full', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'archive_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'archive_header_parallax',
            'label' => esc_html__('Parallax for Background Image', 'khaki'),
            'section' => 'archive_header',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'archive_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'archive_header_parallax_opacity',
            'label' => esc_html__('Opacity Parallax Content', 'khaki'),
            'section' => 'archive_header',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'archive_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'archive_header_parallax_blur',
            'label' => esc_html__('Parallax Blur', 'khaki'),
            'section' => 'archive_header',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'archive_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'archive_header_background_type',
            'label' => esc_html__('Select Type of Background', 'khaki'),
            'section' => 'archive_header',
            'default' => 'image',
            'priority' => 10,
            'choices' => array(
                'image' => esc_attr__('Image', 'khaki'),
                'video' => esc_attr__('Video', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'archive_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'image',
            'settings' => 'archive_header_background_image',
            'label' => esc_html__('Background Image', 'khaki'),
            'section' => 'archive_header',
            'default' => get_template_directory_uri() . '/assets/images/default-banner.jpg',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'archive_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'archive_header_background_type',
                    'operator' => '==',
                    'value' => 'image',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'archive_header_background_image_opacity',
            'label' => esc_attr__('Opacity', 'khaki'),
            'section' => 'archive_header',
            'default' => 5,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '10',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'archive_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'archive_header_background_image',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'archive_header_background_type',
                    'operator' => '==',
                    'value' => 'image',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'archive_header_background_video_link',
            'label' => esc_html__('Background Video Link', 'khaki'),
            'section' => 'archive_header',
            'default' => '',
            'description' => esc_html__('Supported YouTube and Vimeo video link', 'khaki'),
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'archive_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'archive_header_background_type',
                    'operator' => '==',
                    'value' => 'video',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'image',
            'settings' => 'archive_header_background_video_poster',
            'label' => esc_html__('Background Video Poster', 'khaki'),
            'section' => 'archive_header',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'archive_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'archive_header_background_type',
                    'operator' => '==',
                    'value' => 'video',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'archive_header_back_title',
            'label' => esc_html__('Back Title', 'khaki'),
            'section' => 'archive_header',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'archive_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'archive_header_back_title_opacity',
            'label' => esc_attr__('Back Title Opacity', 'khaki'),
            'section' => 'archive_header',
            'default' => 1,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '10',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'archive_header_back_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'archive_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'number',
            'settings' => 'archive_header_back_title_padding_bottom',
            'label' => esc_attr__('Back Title Padding Bottom', 'khaki'),
            'section' => 'archive_header',
            'default' => 0,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '500',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'archive_header_back_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'archive_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'archive_header_back_title_align',
            'label' => esc_html__('Back Title Align', 'khaki'),
            'section' => 'archive_header',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'center' => esc_attr__('Center', 'khaki'),
                'left' => esc_attr__('Left', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'archive_header_back_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'archive_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'archive_header_sub_title',
            'label' => esc_html__('Sub Title', 'khaki'),
            'section' => 'archive_header',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'archive_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'number',
            'settings' => 'archive_header_sub_title_padding_bottom',
            'label' => esc_attr__('Sub Title Padding Bottom', 'khaki'),
            'section' => 'archive_header',
            'default' => 40,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '500',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'archive_header_sub_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'archive_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'archive_header_sub_title_align',
            'label' => esc_html__('Sub Title Align', 'khaki'),
            'section' => 'archive_header',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'center' => esc_attr__('Center', 'khaki'),
                'left' => esc_attr__('Left', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'archive_header_sub_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'archive_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'editor',
            'settings' => 'archive_header_content',
            'label' => esc_html__('Content', 'khaki'),
            'section' => 'archive_header',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'archive_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'archive_header_video_link',
            'label' => esc_html__('Video Link', 'khaki'),
            'section' => 'archive_header',
            'description' => esc_html__('Supported YouTube and Vimeo video link', 'khaki'),
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'archive_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'archive_header_video_style',
            'label' => esc_html__('Icon Video Style', 'khaki'),
            'section' => 'archive_header',
            'default' => false,
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                false => esc_attr__('Black', 'khaki'),
                '2' => esc_attr__('Black 2', 'khaki'),
                'light' => esc_attr__('Light', 'khaki'),
                '2-light' => esc_attr__('Light 2', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'archive_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'archive_header_video_link',
                    'operator' => '!=',
                    'value' => '',
                ),
            ),
        ));
        /**
         * Archive page. Breadcrumbs
         **/
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'archive_breadcrumbs_show',
            'label' => esc_html__('Show', 'khaki'),
            'section' => 'archive_breadcrumbs',
            'default' => 'header',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                false => esc_attr__('Disabled', 'khaki'),
                'header' => esc_attr__('Header', 'khaki'),
                'out_header' => esc_attr__('Under Header', 'khaki'),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'archive_breadcrumbs_homepage_title',
            'label' => esc_html__('Homepage Title', 'khaki'),
            'section' => 'archive_breadcrumbs',
            'default' => 'Home',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'archive_breadcrumbs_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'archive_breadcrumbs_side',
            'label' => esc_html__('Side', 'khaki'),
            'section' => 'archive_breadcrumbs',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                false => esc_attr__('Left', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
                'center' => esc_attr__('Center', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'archive_breadcrumbs_show',
                    'operator' => '!=',
                    'value' => false,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'archive_breadcrumbs_background',
            'label' => esc_html__('Background', 'khaki'),
            'section' => 'archive_breadcrumbs',
            'default' => 'default',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                'default' => esc_attr__('Default', 'khaki'),
                false => esc_attr__('Black', 'khaki'),
                'white' => esc_attr__('White', 'khaki')
            )
        ));
        /**
         * Search page
         **/
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'search_pagination',
            'label' => esc_html__('Pagination', 'khaki'),
            'section' => 'search_content',
            'default' => 'load_more',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                false => esc_html__("No Pagination", 'khaki'),
                true => esc_html__("Simple Pagination", 'khaki'),
                'load_more' => esc_html__("Load More button", 'khaki'),
                'infinite' => esc_html__("Infinite Scroll", 'khaki'),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'search_show_title',
            'label' => esc_html__('Show Title', 'khaki'),
            'section' => 'search_content',
            'default' => 'off',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'search_boxed',
            'label' => esc_html__('Boxed', 'khaki'),
            'section' => 'search_content',
            'default' => 'on',
            'priority' => 10,
        ));
        //for posts list
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'search_list_style_content',
            'label' => esc_html__('Blog List Style', 'khaki'),
            'section' => 'search_content',
            'default' => 'classic',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                'classic' => esc_attr__('Classic', 'khaki'),
                'list' => esc_attr__('List', 'khaki')
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'search_list_columns_content',
            'label' => esc_attr__('Number of Columns', 'khaki'),
            'section' => 'search_content',
            'default' => 3,
            'priority' => 10,
            'choices' => array(
                'min' => 1,
                'max' => 3,
                'step' => 1,
            ),
            'active_callback' => array(
                array(
                    'setting' => 'search_list_style_content',
                    'operator' => '==',
                    'value' => 'classic',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'search_preview_description_type_content',
            'label' => esc_html__('Preview Description Type', 'khaki'),
            'section' => 'search_content',
            'default' => 'excerpt',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                'false' => esc_attr__('Disabled', 'khaki'),
                'excerpt' => esc_attr__('Excerpt', 'khaki'),
                'more' => esc_attr__('Use more tag', 'khaki')
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'number',
            'settings' => 'search_preview_description_trim_cnt',
            'label' => esc_html__('Cut in the number of words', 'khaki'),
            'section' => 'search_content',
            'default' => 50,
            'priority' => 10,
            'choices' => array(
                'min' => 0,
                'max' => 200,
                'step' => 1,
            ),
            'active_callback' => array(
                array(
                    'setting' => 'search_preview_description_type_content',
                    'operator' => '==',
                    'value' => 'excerpt',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'search_simple_view',
            'label' => esc_html__('Simple View', 'khaki'),
            'section' => 'search_content',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'search_list_style_content',
                    'operator' => '==',
                    'value' => 'classic',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'search_show_continue_button',
            'label' => esc_html__('Show Continue Button', 'khaki'),
            'section' => 'search_content',
            'default' => 'off',
            'priority' => 10,
        ));

        /**
         * Search page. Header
         **/
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'search_header_show',
            'label' => esc_html__('Show', 'khaki'),
            'section' => 'search_header',
            'default' => 'on',
            'priority' => 10
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'search_header_show_title',
            'label' => esc_html__('Show Title', 'khaki'),
            'section' => 'search_header',
            'default' => 'on',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'number',
            'settings' => 'search_header_title_padding_bottom',
            'label' => esc_attr__('Title Padding Bottom', 'khaki'),
            'section' => 'search_header',
            'default' => 0,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '500',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'search_header_show_title',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'search_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'search_header_title_looks_like',
            'label' => esc_html__('Title Looks Like', 'khaki'),
            'section' => 'search_header',
            'default' => '',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                '' => esc_attr__('disabled', 'khaki'),
                'h1' => esc_attr__('h1', 'khaki'),
                'h2' => esc_attr__('h2', 'khaki'),
                'h3' => esc_attr__('h3', 'khaki'),
                'h4' => esc_attr__('h4', 'khaki'),
                'h5' => esc_attr__('h5', 'khaki'),
                'h6' => esc_attr__('h6', 'khaki'),
                'display-1' => esc_attr__('display-1', 'khaki'),
                'display-2' => esc_attr__('display-2', 'khaki'),
                'display-3' => esc_attr__('display-3', 'khaki'),
                'display-4' => esc_attr__('display-4', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'search_header_show_title',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'search_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'search_header_title_align',
            'label' => esc_html__('Title Align', 'khaki'),
            'section' => 'search_header',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'center' => esc_attr__('Center', 'khaki'),
                'left' => esc_attr__('Left', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'search_header_show_title',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'search_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'search_header_size',
            'label' => esc_html__('Size', 'khaki'),
            'section' => 'search_header',
            'default' => false,
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                false => esc_attr__('Default', 'khaki'),
                'sm' => esc_attr__('Small', 'khaki'),
                'md' => esc_attr__('Middle', 'khaki'),
                'lg' => esc_attr__('Large', 'khaki'),
                'xl' => esc_attr__('X-Large', 'khaki'),
                'full' => esc_attr__('Full', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'search_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'search_header_parallax',
            'label' => esc_html__('Parallax for Background Image', 'khaki'),
            'section' => 'search_header',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'search_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'search_header_parallax_opacity',
            'label' => esc_html__('Opacity Parallax Content', 'khaki'),
            'section' => 'search_header',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'search_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'search_header_parallax_blur',
            'label' => esc_html__('Parallax Blur', 'khaki'),
            'section' => 'search_header',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'search_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'search_header_background_type',
            'label' => esc_html__('Select Type of Background', 'khaki'),
            'section' => 'search_header',
            'default' => 'image',
            'priority' => 10,
            'choices' => array(
                'image' => esc_attr__('Image', 'khaki'),
                'video' => esc_attr__('Video', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'search_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'image',
            'settings' => 'search_header_background_image',
            'label' => esc_html__('Background Image', 'khaki'),
            'section' => 'search_header',
            'default' => get_template_directory_uri() . '/assets/images/default-banner.jpg',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'search_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'search_header_background_type',
                    'operator' => '==',
                    'value' => 'image',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'search_header_background_image_opacity',
            'label' => esc_attr__('Opacity', 'khaki'),
            'section' => 'search_header',
            'default' => 5,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '10',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'search_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'search_header_background_image',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'search_header_background_type',
                    'operator' => '==',
                    'value' => 'image',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'search_header_background_video_link',
            'label' => esc_html__('Background Video Link', 'khaki'),
            'section' => 'search_header',
            'default' => '',
            'description' => esc_html__('Supported YouTube and Vimeo video link', 'khaki'),
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'search_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'search_header_background_type',
                    'operator' => '==',
                    'value' => 'video',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'image',
            'settings' => 'search_header_background_video_poster',
            'label' => esc_html__('Background Video Poster', 'khaki'),
            'section' => 'search_header',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'search_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'search_header_background_type',
                    'operator' => '==',
                    'value' => 'video',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'search_header_back_title',
            'label' => esc_html__('Back Title', 'khaki'),
            'section' => 'search_header',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'search_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'search_header_back_title_opacity',
            'label' => esc_attr__('Back Title Opacity', 'khaki'),
            'section' => 'search_header',
            'default' => 1,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '10',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'search_header_back_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'search_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'number',
            'settings' => 'search_header_back_title_padding_bottom',
            'label' => esc_attr__('Back Title Padding Bottom', 'khaki'),
            'section' => 'search_header',
            'default' => 0,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '500',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'search_header_back_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'search_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'search_header_back_title_align',
            'label' => esc_html__('Back Title Align', 'khaki'),
            'section' => 'search_header',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'center' => esc_attr__('Center', 'khaki'),
                'left' => esc_attr__('Left', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'search_header_back_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'search_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'search_header_sub_title',
            'label' => esc_html__('Sub Title', 'khaki'),
            'section' => 'search_header',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'search_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'number',
            'settings' => 'search_header_sub_title_padding_bottom',
            'label' => esc_attr__('Sub Title Padding Bottom', 'khaki'),
            'section' => 'search_header',
            'default' => 40,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '500',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'search_header_sub_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'search_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'search_header_sub_title_align',
            'label' => esc_html__('Sub Title Align', 'khaki'),
            'section' => 'search_header',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'center' => esc_attr__('Center', 'khaki'),
                'left' => esc_attr__('Left', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'search_header_sub_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'search_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'editor',
            'settings' => 'search_header_content',
            'label' => esc_html__('Content', 'khaki'),
            'section' => 'search_header',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'search_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'search_header_video_link',
            'label' => esc_html__('Video Link', 'khaki'),
            'section' => 'search_header',
            'description' => esc_html__('Supported YouTube and Vimeo video link', 'khaki'),
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'search_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'search_header_video_style',
            'label' => esc_html__('Icon Video Style', 'khaki'),
            'section' => 'search_header',
            'default' => false,
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                false => esc_attr__('Black', 'khaki'),
                '2' => esc_attr__('Black 2', 'khaki'),
                'light' => esc_attr__('Light', 'khaki'),
                '2-light' => esc_attr__('Light 2', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'search_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'search_header_video_link',
                    'operator' => '!=',
                    'value' => '',
                ),
            ),
        ));
        /**
         * Search page. Breadcrumbs
         **/
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'search_breadcrumbs_show',
            'label' => esc_html__('Show', 'khaki'),
            'section' => 'search_breadcrumbs',
            'default' => 'header',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                false => esc_attr__('Disabled', 'khaki'),
                'header' => esc_attr__('Header', 'khaki'),
                'out_header' => esc_attr__('Under Header', 'khaki'),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'search_breadcrumbs_homepage_title',
            'label' => esc_html__('Homepage Title', 'khaki'),
            'section' => 'search_breadcrumbs',
            'default' => 'Home',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'search_breadcrumbs_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'search_breadcrumbs_side',
            'label' => esc_html__('Side', 'khaki'),
            'section' => 'search_breadcrumbs',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                false => esc_attr__('Left', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
                'center' => esc_attr__('Center', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'search_breadcrumbs_show',
                    'operator' => '!=',
                    'value' => false,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'search_breadcrumbs_background',
            'label' => esc_html__('Background', 'khaki'),
            'section' => 'search_breadcrumbs',
            'default' => 'default',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                'default' => esc_attr__('Default', 'khaki'),
                false => esc_attr__('Black', 'khaki'),
                'white' => esc_attr__('White', 'khaki')
            )
        ));
        /**
         * Add BBpress options
         */
        /**
         * BBpress. Header
         */
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'bbpress_header_show',
            'label' => esc_html__('Show', 'khaki'),
            'section' => 'bbpress_header',
            'default' => 'on',
            'priority' => 10
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'bbpress_header_show_title',
            'label' => esc_html__('Show Title', 'khaki'),
            'section' => 'bbpress_header',
            'default' => 'on',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'number',
            'settings' => 'bbpress_header_title_padding_bottom',
            'label' => esc_attr__('Title Padding Bottom', 'khaki'),
            'section' => 'bbpress_header',
            'default' => 0,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '500',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_header_show_title',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'bbpress_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'bbpress_header_title_looks_like',
            'label' => esc_html__('Title Looks Like', 'khaki'),
            'section' => 'bbpress_header',
            'default' => '',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                '' => esc_attr__('disabled', 'khaki'),
                'h1' => esc_attr__('h1', 'khaki'),
                'h2' => esc_attr__('h2', 'khaki'),
                'h3' => esc_attr__('h3', 'khaki'),
                'h4' => esc_attr__('h4', 'khaki'),
                'h5' => esc_attr__('h5', 'khaki'),
                'h6' => esc_attr__('h6', 'khaki'),
                'display-1' => esc_attr__('display-1', 'khaki'),
                'display-2' => esc_attr__('display-2', 'khaki'),
                'display-3' => esc_attr__('display-3', 'khaki'),
                'display-4' => esc_attr__('display-4', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_header_show_title',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'bbpress_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'bbpress_header_title_align',
            'label' => esc_html__('Title Align', 'khaki'),
            'section' => 'bbpress_header',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'center' => esc_attr__('Center', 'khaki'),
                'left' => esc_attr__('Left', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_header_show_title',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'bbpress_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'bbpress_header_size',
            'label' => esc_html__('Size', 'khaki'),
            'section' => 'bbpress_header',
            'default' => false,
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                false => esc_attr__('Default', 'khaki'),
                'sm' => esc_attr__('Small', 'khaki'),
                'md' => esc_attr__('Middle', 'khaki'),
                'lg' => esc_attr__('Large', 'khaki'),
                'xl' => esc_attr__('X-Large', 'khaki'),
                'full' => esc_attr__('Full', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'bbpress_header_parallax',
            'label' => esc_html__('Parallax for Background Image', 'khaki'),
            'section' => 'bbpress_header',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'bbpress_header_parallax_opacity',
            'label' => esc_html__('Opacity Parallax Content', 'khaki'),
            'section' => 'bbpress_header',
            'default' => 'on',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'bbpress_header_parallax_blur',
            'label' => esc_html__('Parallax Blur', 'khaki'),
            'section' => 'bbpress_header',
            'default' => 'off',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'bbpress_header_background_type',
            'label' => esc_html__('Select Type of Background', 'khaki'),
            'section' => 'bbpress_header',
            'default' => 'image',
            'priority' => 10,
            'choices' => array(
                'image' => esc_attr__('Image', 'khaki'),
                'video' => esc_attr__('Video', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'bbpress_header_type_image',
            'label' => esc_html__('Select Type of Background Image', 'khaki'),
            'section' => 'bbpress_header',
            'default' => 'featured',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                false => esc_attr__('False', 'khaki'),
                'featured' => esc_attr__('Featured', 'khaki'),
                'custom' => esc_attr__('Custom', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'bbpress_header_background_type',
                    'operator' => '==',
                    'value' => 'image',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'image',
            'settings' => 'bbpress_header_background_image',
            'label' => esc_html__('Background Image', 'khaki'),
            'section' => 'bbpress_header',
            'default' => get_template_directory_uri() . '/assets/images/default-banner.jpg',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'bbpress_header_type_image',
                    'operator' => '==',
                    'value' => 'custom',
                ),
                array(
                    'setting' => 'bbpress_header_background_type',
                    'operator' => '==',
                    'value' => 'image',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'bbpress_header_background_image_opacity',
            'label' => esc_attr__('Opacity', 'khaki'),
            'section' => 'bbpress_header',
            'default' => 5,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '10',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'bbpress_header_background_image',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'bbpress_header_type_image',
                    'operator' => '==',
                    'value' => 'custom',
                ),
                array(
                    'setting' => 'bbpress_header_background_type',
                    'operator' => '==',
                    'value' => 'image',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'bbpress_header_background_video_link',
            'label' => esc_html__('Background Video Link', 'khaki'),
            'section' => 'bbpress_header',
            'default' => '',
            'description' => esc_html__('Supported YouTube and Vimeo video link', 'khaki'),
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'bbpress_header_background_type',
                    'operator' => '==',
                    'value' => 'video',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'image',
            'settings' => 'bbpress_header_background_video_poster',
            'label' => esc_html__('Background Video Poster', 'khaki'),
            'section' => 'bbpress_header',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'bbpress_header_background_type',
                    'operator' => '==',
                    'value' => 'video',
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'bbpress_header_back_title',
            'label' => esc_html__('Back Title', 'khaki'),
            'section' => 'bbpress_header',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'slider',
            'settings' => 'bbpress_header_back_title_opacity',
            'label' => esc_attr__('Back Title Opacity', 'khaki'),
            'section' => 'bbpress_header',
            'default' => 1,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '10',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_header_back_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'bbpress_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'number',
            'settings' => 'bbpress_header_back_title_padding_bottom',
            'label' => esc_attr__('Back Title Padding Bottom', 'khaki'),
            'section' => 'bbpress_header',
            'default' => 0,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '500',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_header_back_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'bbpress_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'bbpress_header_back_title_align',
            'label' => esc_html__('Back Title Align', 'khaki'),
            'section' => 'bbpress_header',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'center' => esc_attr__('Center', 'khaki'),
                'left' => esc_attr__('Left', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_header_back_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'bbpress_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'bbpress_header_sub_title',
            'label' => esc_html__('Sub Title', 'khaki'),
            'section' => 'bbpress_header',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'number',
            'settings' => 'bbpress_header_sub_title_padding_bottom',
            'label' => esc_attr__('Sub Title Padding Bottom', 'khaki'),
            'section' => 'bbpress_header',
            'default' => 40,
            'priority' => 10,
            'choices' => array(
                'min' => '0',
                'max' => '500',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_header_sub_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'bbpress_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'bbpress_header_sub_title_align',
            'label' => esc_html__('Sub Title Align', 'khaki'),
            'section' => 'bbpress_header',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                'center' => esc_attr__('Center', 'khaki'),
                'left' => esc_attr__('Left', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_header_sub_title',
                    'operator' => '!=',
                    'value' => '',
                ),
                array(
                    'setting' => 'bbpress_header_show',
                    'operator' => '==',
                    'value' => true,
                ),

            ),
        ));
        NK_Options::add_field( array(
            'type' => 'editor',
            'settings' => 'bbpress_header_content',
            'label' => esc_html__('Content', 'khaki'),
            'section' => 'bbpress_header',
            'default' => '',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'bbpress_header_video_link',
            'label' => esc_html__('Video Link', 'khaki'),
            'section' => 'bbpress_header',
            'default' => '',
            'description' => esc_html__('Supported YouTube and Vimeo video link', 'khaki'),
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'bbpress_header_video_style',
            'label' => esc_html__('Icon Video Style', 'khaki'),
            'section' => 'bbpress_header',
            'default' => false,
            'priority' => 10,
            'multiple' => 0,
            'choices' => array(
                false => esc_attr__('Black', 'khaki'),
                '2' => esc_attr__('Black 2', 'khaki'),
                'light' => esc_attr__('Light', 'khaki'),
                '2-light' => esc_attr__('Light 2', 'khaki')
            ),
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_header_show',
                    'operator' => '==',
                    'value' => true,
                ),
                array(
                    'setting' => 'bbpress_header_video_link',
                    'operator' => '!=',
                    'value' => '',
                ),
            ),
        ));
        /**
         * BBpress. Breadcrumbs
         * */
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'bbpress_breadcrumbs_show',
            'label' => esc_html__('Show', 'khaki'),
            'section' => 'bbpress_breadcrumbs',
            'default' => 'header',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                false => esc_attr__('Disabled', 'khaki'),
                'header' => esc_attr__('Header', 'khaki'),
                'out_header' => esc_attr__('Under Header', 'khaki'),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'text',
            'settings' => 'bbpress_breadcrumbs_homepage_title',
            'label' => esc_html__('Homepage Title', 'khaki'),
            'section' => 'bbpress_breadcrumbs',
            'default' => 'Home',
            'priority' => 10,
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_breadcrumbs_show',
                    'operator' => '==',
                    'value' => true,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'bbpress_breadcrumbs_side',
            'label' => esc_html__('Side', 'khaki'),
            'section' => 'bbpress_breadcrumbs',
            'default' => 'center',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                false => esc_attr__('Left', 'khaki'),
                'right' => esc_attr__('Right', 'khaki'),
                'center' => esc_attr__('Center', 'khaki'),
            ),
            'active_callback' => array(
                array(
                    'setting' => 'bbpress_breadcrumbs_show',
                    'operator' => '!=',
                    'value' => false,
                ),
            ),
        ));
        NK_Options::add_field( array(
            'type' => 'select',
            'settings' => 'bbpress_breadcrumbs_background',
            'label' => esc_html__('Background', 'khaki'),
            'section' => 'bbpress_breadcrumbs',
            'default' => 'default',
            'priority' => 10,
            'multiple' => 1,
            'choices' => array(
                'default' => esc_attr__('Default', 'khaki'),
                false => esc_attr__('Black', 'khaki'),
                'white' => esc_attr__('White', 'khaki')
            )
        ));
        /**
         * BBpress. Content
         * */
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'bbpress_show_title',
            'label' => esc_html__('Show Title', 'khaki'),
            'section' => 'bbpress_content',
            'default' => 'off',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'bbpress_inner_boxed',
            'label' => esc_html__('Boxed', 'khaki'),
            'section' => 'bbpress_content',
            'default' => 'on',
            'priority' => 10,
        ));
        NK_Options::add_field( array(
            'type' => 'toggle',
            'settings' => 'bbpress_tinymce',
            'label' => esc_html__('Tinymce', 'khaki'),
            'section' => 'bbpress_content',
            'default' => 'on',
            'priority' => 10,
        ));

        $custom_style = function_exists('nk_theme');
        if (!$custom_style) {
            NK_Options::add_field( array(
                'type' => 'custom',
                'settings' => 'style_message_without_nk_themes_helper',
                'label' => esc_html__('Required Plugin', 'khaki'),
                'description' => esc_html__('To generate custom styles you should install nK Themes Helper Plugin', 'khaki'),
                'section' => 'style',
                'priority' => 10,
            ));
        } elseif (  nk_theme()->theme_dashboard()->is_envato_hosted && ! nk_theme()->theme_dashboard()->activation()->active ) {
            NK_Options::add_field( array(
                'type' => 'custom',
                'settings' => 'style_message_without_nk_themes_activated',
                'label' => esc_html__('Required Theme License Activation', 'khaki'),
                'description' => sprintf(wp_kses(__('Custom styles can only be used in the activated theme. Please visit the <a href="%s" target="_blank">theme dashboard page</a> and activate the theme.', 'khaki'), array( 'a' => array( 'href' => array() ) ) ), admin_url( "admin.php?page=nk-theme" ) ),
                'section' => 'style',
                'priority' => 10,
            ));
        } elseif (version_compare(phpversion(), '5.4', '<')) {
            NK_Options::add_field( array(
                'type' => 'custom',
                'settings' => 'style_message_without_php',
                'label' => esc_html__('Required PHP version 5.4 or higher', 'khaki'),
                'section' => 'style',
                'priority' => 10,
            ));
        } else {

            NK_Options::add_field( array(
                'type' => 'toggle',
                'settings' => 'style_custom',
                'label' => esc_html__('Enable Custom Styles', 'khaki'),
                'section' => 'style',
                'default' => 'off',
                'priority' => 10,
            ));

            // main colors
            NK_Options::add_field( array(
                'type' => 'color',
                'settings' => 'style_color_main_1',
                'label' => esc_html__('Main Color 1', 'khaki'),
                'section' => 'style',
                'default' => '#bea175',
                'priority' => 10,
                'active_callback' => array(
                    array(
                        'setting' => 'style_custom',
                        'operator' => '==',
                        'value' => true,
                    ),
                )
            ));
            NK_Options::add_field( array(
                'type' => 'color',
                'settings' => 'style_color_main_2',
                'label' => esc_html__('Main Color 2', 'khaki'),
                'section' => 'style',
                'default' => '#8c9176',
                'priority' => 10,
                'active_callback' => array(
                    array(
                        'setting' => 'style_custom',
                        'operator' => '==',
                        'value' => true,
                    ),
                )
            ));
            NK_Options::add_field( array(
                'type' => 'color',
                'settings' => 'style_color_main_3',
                'label' => esc_html__('Main Color 3', 'khaki'),
                'section' => 'style',
                'default' => '#7d88ab',
                'priority' => 10,
                'active_callback' => array(
                    array(
                        'setting' => 'style_custom',
                        'operator' => '==',
                        'value' => true,
                    ),
                )
            ));
            NK_Options::add_field( array(
                'type' => 'color',
                'settings' => 'style_color_main_4',
                'label' => esc_html__('Main Color 4', 'khaki'),
                'section' => 'style',
                'default' => '#77b0b3',
                'priority' => 10,
                'active_callback' => array(
                    array(
                        'setting' => 'style_custom',
                        'operator' => '==',
                        'value' => true,
                    ),
                )
            ));
            NK_Options::add_field( array(
                'type' => 'color',
                'settings' => 'style_color_main_5',
                'label' => esc_html__('Main Color 5', 'khaki'),
                'section' => 'style',
                'default' => '#c18d8d',
                'priority' => 10,
                'active_callback' => array(
                    array(
                        'setting' => 'style_custom',
                        'operator' => '==',
                        'value' => true,
                    ),
                )
            ));

            // bootstrap colors
            NK_Options::add_field( array(
                'type' => 'color',
                'settings' => 'style_color_primary',
                'label' => esc_html__('Color Primary', 'khaki'),
                'section' => 'style',
                'default' => '#0275D8',
                'priority' => 10,
                'active_callback' => array(
                    array(
                        'setting' => 'style_custom',
                        'operator' => '==',
                        'value' => true,
                    ),
                )
            ));
            NK_Options::add_field( array(
                'type' => 'color',
                'settings' => 'style_color_success',
                'label' => esc_html__('Color Success', 'khaki'),
                'section' => 'style',
                'default' => '#5CB85C',
                'priority' => 10,
                'active_callback' => array(
                    array(
                        'setting' => 'style_custom',
                        'operator' => '==',
                        'value' => true,
                    ),
                )
            ));
            NK_Options::add_field( array(
                'type' => 'color',
                'settings' => 'style_color_info',
                'label' => esc_html__('Color Info', 'khaki'),
                'section' => 'style',
                'default' => '#5BC0DE',
                'priority' => 10,
                'active_callback' => array(
                    array(
                        'setting' => 'style_custom',
                        'operator' => '==',
                        'value' => true,
                    ),
                )
            ));
            NK_Options::add_field( array(
                'type' => 'color',
                'settings' => 'style_color_warning',
                'label' => esc_html__('Color Warning', 'khaki'),
                'section' => 'style',
                'default' => '#F0AD4E',
                'priority' => 10,
                'active_callback' => array(
                    array(
                        'setting' => 'style_custom',
                        'operator' => '==',
                        'value' => true,
                    ),
                )
            ));
            NK_Options::add_field( array(
                'type' => 'color',
                'settings' => 'style_color_danger',
                'label' => esc_html__('Color Danger', 'khaki'),
                'section' => 'style',
                'default' => '#D9534F',
                'priority' => 10,
                'active_callback' => array(
                    array(
                        'setting' => 'style_custom',
                        'operator' => '==',
                        'value' => true,
                    ),
                )
            ));
            NK_Options::add_field( array(
                'type' => 'color',
                'settings' => 'style_color_dark',
                'label' => esc_html__('Color Dark', 'khaki'),
                'section' => 'style',
                'default' => '#1c1c1c',
                'priority' => 10,
                'active_callback' => array(
                    array(
                        'setting' => 'style_custom',
                        'operator' => '==',
                        'value' => true,
                    ),
                )
            ));
            NK_Options::add_field( array(
                'type' => 'color',
                'settings' => 'style_color_gray',
                'label' => esc_html__('Color Gray', 'khaki'),
                'section' => 'style',
                'default' => '#FAFAFA',
                'priority' => 10,
                'active_callback' => array(
                    array(
                        'setting' => 'style_custom',
                        'operator' => '==',
                        'value' => true,
                    ),
                )
            ));
            NK_Options::add_field( array(
                'type' => 'slider',
                'settings' => 'page_border_size',
                'label' => esc_attr__('Page Border Size', 'khaki'),
                'section' => 'style',
                'default' => 35,
                'priority' => 10,
                'choices' => array(
                    'min' => '0',
                    'max' => '150',
                    'step' => '1',
                ),
                'active_callback' => array(
                    array(
                        'setting' => 'style_custom',
                        'operator' => '==',
                        'value' => true,
                    ),
                )
            ));
            NK_Options::add_field( array(
                'type' => 'slider',
                'settings' => 'page_border_size_md',
                'label' => esc_attr__('Page Border Size Middle', 'khaki'),
                'section' => 'style',
                'default' => 25,
                'priority' => 10,
                'choices' => array(
                    'min' => '0',
                    'max' => '150',
                    'step' => '1',
                ),
                'active_callback' => array(
                    array(
                        'setting' => 'style_custom',
                        'operator' => '==',
                        'value' => true,
                    ),
                )
            ));
            NK_Options::add_field( array(
                'type' => 'slider',
                'settings' => 'page_border_size_sm',
                'label' => esc_attr__('Page Border Size Small', 'khaki'),
                'section' => 'style',
                'default' => 15,
                'priority' => 10,
                'choices' => array(
                    'min' => '0',
                    'max' => '150',
                    'step' => '1',
                ),
                'active_callback' => array(
                    array(
                        'setting' => 'style_custom',
                        'operator' => '==',
                        'value' => true,
                    ),
                )
            ));
            NK_Options::add_field( array(
                'type' => 'slider',
                'settings' => 'share_place_height',
                'label' => esc_attr__('Share Place Height', 'khaki'),
                'section' => 'style',
                'default' => 200,
                'priority' => 10,
                'choices' => array(
                    'min' => '0',
                    'max' => '500',
                    'step' => '1',
                ),
                'active_callback' => array(
                    array(
                        'setting' => 'style_custom',
                        'operator' => '==',
                        'value' => true,
                    ),
                )
            ));
            NK_Options::add_field( array(
                'type' => 'slider',
                'settings' => 'audio_player_height',
                'label' => esc_attr__('Audio Player Height', 'khaki'),
                'section' => 'style',
                'default' => 62,
                'priority' => 10,
                'choices' => array(
                    'min' => '0',
                    'max' => '150',
                    'step' => '1',
                ),
                'active_callback' => array(
                    array(
                        'setting' => 'style_custom',
                        'operator' => '==',
                        'value' => true,
                    ),
                )
            ));
            NK_Options::add_field( array(
                'type' => 'slider',
                'settings' => 'audio_player_playlist_height',
                'label' => esc_attr__('Audio Player Playlist Height', 'khaki'),
                'section' => 'style',
                'default' => 250,
                'priority' => 10,
                'choices' => array(
                    'min' => '0',
                    'max' => '500',
                    'step' => '1',
                ),
                'active_callback' => array(
                    array(
                        'setting' => 'style_custom',
                        'operator' => '==',
                        'value' => true,
                    ),
                )
            ));
            NK_Options::add_field( array(
                'type' => 'slider',
                'settings' => 'audio_player_mobile_height',
                'label' => esc_attr__('Audio Player Mobile Height', 'khaki'),
                'section' => 'style',
                'default' => 170,
                'priority' => 10,
                'choices' => array(
                    'min' => '0',
                    'max' => '500',
                    'step' => '1',
                ),
                'active_callback' => array(
                    array(
                        'setting' => 'style_custom',
                        'operator' => '==',
                        'value' => true,
                    ),
                )
            ));

            NK_Options::add_field( array(
                'type' => 'toggle',
                'settings' => 'audio_player_show',
                'label' => esc_html__('Show Audio Player', 'khaki'),
                'section' => 'audio_player',
                'default' => 'off',
                'priority' => 10,
            ));

            //add all playlist posts for show in post_id option
            $args = array(
                'posts_per_page' => -1,
                'post_type' => 'playlist',
            );
            $posts = new WP_Query($args);
            $post_list = array();
            $post_list[] = esc_attr__('Disable', 'khaki');
            foreach ($posts->posts as $post) {
                $post_list[$post->ID] = $post->post_title;
            }

            NK_Options::add_field( array(
                'type' => 'select',
                'settings' => 'audio_player_active_playlist',
                'label' => esc_html__('Select Active Playlist', 'khaki'),
                'section' => 'audio_player',
                'default' => false,
                'priority' => 10,
                'multiple' => 0,
                'choices' => $post_list,
                'active_callback' => array(
                    array(
                        'setting' => 'audio_player_show',
                        'operator' => '==',
                        'value' => true,
                    ),
                ),
            ));
        }
    }

    add_action('init', 'khaki_initial_kirki_options');
}
if(!function_exists('kirki_initial_custom_post')):
    function kirki_initial_custom_post($type_posts){
        if(is_array($type_posts) && isset($type_posts) && !empty($type_posts)){
            $sidebars = khaki_get_sidebars();
            foreach($type_posts as $type_post){
                //main panel
                NK_Options::add_panel($type_post, array(
                    'priority' => 9,
                    'title' => ucfirst($type_post),
                ));
                //main sections inner panel
                NK_Options::add_section($type_post.'_content', array(
                    'title' => esc_html__('Content', 'khaki'),
                    'priority' => 12,
                    'panel' => $type_post,
                ));
                NK_Options::add_section($type_post.'_header', array(
                    'title' => esc_html__('Header', 'khaki'),
                    'priority' => 12,
                    'panel' => $type_post,
                ));
                NK_Options::add_section($type_post.'_breadcrumbs', array(
                    'title' => esc_html__('Breadcrumbs', 'khaki'),
                    'priority' => 12,
                    'panel' => $type_post,
                ));
                NK_Options::add_section($type_post.'_sidebar', array(
                    'title' => esc_html__('Sidebar', 'khaki'),
                    'priority' => 12,
                    'panel' => $type_post,
                ));
                NK_Options::add_section($type_post.'_archive', array(
                    'title' => esc_html__('Archive', 'khaki'),
                    'priority' => 12,
                    'panel' => $type_post,
                ));
                NK_Options::add_section($type_post.'_single', array(
                    'title' => esc_html__('Single', 'khaki'),
                    'priority' => 12,
                    'panel' => $type_post,
                ));
                NK_Options::add_section($type_post.'_meta', array(
                    'title' => esc_html__('Meta', 'khaki'),
                    'priority' => 12,
                    'panel' => $type_post,
                ));
                /**
                 * $type_post. Header
                 */
                NK_Options::add_field( array(
                    'type' => 'toggle',
                    'settings' => $type_post.'_header_show',
                    'label' => esc_html__('Show', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => 'on',
                    'priority' => 10
                ));
                NK_Options::add_field( array(
                    'type' => 'toggle',
                    'settings' => $type_post.'_header_show_title',
                    'label' => esc_html__('Show Title', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => 'on',
                    'priority' => 10,
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'text',
                    'settings' => $type_post.'_header_archive_custom_title',
                    'label' => esc_html__('Custom Archive Title', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => '',
                    'priority' => 10,
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_show_title',
                            'operator' => '==',
                            'value' => true,
                        ),
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'number',
                    'settings' => $type_post.'_header_title_padding_bottom',
                    'label' => esc_attr__('Title Padding Bottom', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => 0,
                    'priority' => 10,
                    'choices' => array(
                        'min' => '0',
                        'max' => '500',
                        'step' => '1',
                    ),
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_show_title',
                            'operator' => '==',
                            'value' => true,
                        ),
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'select',
                    'settings' => $type_post.'_header_title_looks_like',
                    'label' => esc_html__('Title Looks Like', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => '',
                    'priority' => 10,
                    'multiple' => 0,
                    'choices' => array(
                        '' => esc_attr__('disabled', 'khaki'),
                        'h1' => esc_attr__('h1', 'khaki'),
                        'h2' => esc_attr__('h2', 'khaki'),
                        'h3' => esc_attr__('h3', 'khaki'),
                        'h4' => esc_attr__('h4', 'khaki'),
                        'h5' => esc_attr__('h5', 'khaki'),
                        'h6' => esc_attr__('h6', 'khaki'),
                        'display-1' => esc_attr__('display-1', 'khaki'),
                        'display-2' => esc_attr__('display-2', 'khaki'),
                        'display-3' => esc_attr__('display-3', 'khaki'),
                        'display-4' => esc_attr__('display-4', 'khaki')
                    ),
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_show_title',
                            'operator' => '==',
                            'value' => true,
                        ),
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'select',
                    'settings' => $type_post.'_header_title_align',
                    'label' => esc_html__('Title Align', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => 'center',
                    'priority' => 10,
                    'multiple' => 0,
                    'choices' => array(
                        'center' => esc_attr__('Center', 'khaki'),
                        'left' => esc_attr__('Left', 'khaki'),
                        'right' => esc_attr__('Right', 'khaki'),
                    ),
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_show_title',
                            'operator' => '==',
                            'value' => true,
                        ),
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'select',
                    'settings' => $type_post.'_header_size',
                    'label' => esc_html__('Size', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => false,
                    'priority' => 10,
                    'multiple' => 0,
                    'choices' => array(
                        false => esc_attr__('Default', 'khaki'),
                        'sm' => esc_attr__('Small', 'khaki'),
                        'md' => esc_attr__('Middle', 'khaki'),
                        'lg' => esc_attr__('Large', 'khaki'),
                        'xl' => esc_attr__('X-Large', 'khaki'),
                        'full' => esc_attr__('Full', 'khaki'),
                    ),
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'toggle',
                    'settings' => $type_post.'_header_parallax',
                    'label' => esc_html__('Parallax for Background Image', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => 'on',
                    'priority' => 10,
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'toggle',
                    'settings' => $type_post.'_header_parallax_opacity',
                    'label' => esc_html__('Opacity Parallax Content', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => 'on',
                    'priority' => 10,
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'toggle',
                    'settings' => $type_post.'_header_parallax_blur',
                    'label' => esc_html__('Parallax Blur', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => 'off',
                    'priority' => 10,
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'select',
                    'settings' => $type_post.'_header_background_type',
                    'label' => esc_html__('Select Type of Background', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => 'image',
                    'priority' => 10,
                    'choices' => array(
                        'image' => esc_attr__('Image', 'khaki'),
                        'video' => esc_attr__('Video', 'khaki'),
                    ),
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'select',
                    'settings' => $type_post.'_header_type_image',
                    'label' => esc_html__('Select Type of Background Image', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => 'featured',
                    'priority' => 10,
                    'multiple' => 0,
                    'choices' => array(
                        false => esc_attr__('False', 'khaki'),
                        'featured' => esc_attr__('Featured', 'khaki'),
                        'custom' => esc_attr__('Custom', 'khaki'),
                    ),
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                        array(
                            'setting' => $type_post.'_header_background_type',
                            'operator' => '==',
                            'value' => 'image',
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'image',
                    'settings' => $type_post.'_header_background_image',
                    'label' => esc_html__('Background Image', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => get_template_directory_uri() . '/assets/images/default-banner.jpg',
                    'priority' => 10,
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                        array(
                            'setting' => $type_post.'_header_type_image',
                            'operator' => '==',
                            'value' => 'custom',
                        ),
                        array(
                            'setting' => $type_post.'_header_background_type',
                            'operator' => '==',
                            'value' => 'image',
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'image',
                    'settings' => $type_post.'_header_archive_background_image',
                    'label' => esc_html__('Background Archive Image', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => get_template_directory_uri() . '/assets/images/default-banner.jpg',
                    'priority' => 10,
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'slider',
                    'settings' => $type_post.'_header_background_image_opacity',
                    'label' => esc_attr__('Opacity', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => 5,
                    'priority' => 10,
                    'choices' => array(
                        'min' => '0',
                        'max' => '10',
                        'step' => '1',
                    ),
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_type_image',
                            'operator' => '!=',
                            'value' => false,
                        ),
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                        array(
                            'setting' => $type_post.'_header_background_type',
                            'operator' => '==',
                            'value' => 'image',
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'text',
                    'settings' => $type_post . '_header_background_video_link',
                    'label' => esc_html__('Background Video Link', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => '',
                    'description' => esc_html__('Supported YouTube and Vimeo video link', 'khaki'),
                    'priority' => 10,
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                        array(
                            'setting' => $type_post.'_header_background_type',
                            'operator' => '==',
                            'value' => 'video',
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'image',
                    'settings' => $type_post . '_header_background_video_poster',
                    'label' => esc_html__('Background Video Poster', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => '',
                    'priority' => 10,
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                        array(
                            'setting' => $type_post.'_header_background_type',
                            'operator' => '==',
                            'value' => 'video',
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'text',
                    'settings' => $type_post.'_header_back_title',
                    'label' => esc_html__('Back Title', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => '',
                    'priority' => 10,
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'slider',
                    'settings' => $type_post.'_header_back_title_opacity',
                    'label' => esc_attr__('Back Title Opacity', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => 1,
                    'priority' => 10,
                    'choices' => array(
                        'min' => '0',
                        'max' => '10',
                        'step' => '1',
                    ),
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                        array(
                            'setting' => $type_post.'_header_back_title',
                            'operator' => '!=',
                            'value' => '',
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'number',
                    'settings' => $type_post.'_header_back_title_padding_bottom',
                    'label' => esc_attr__('Back Title Padding Bottom', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => 0,
                    'priority' => 10,
                    'choices' => array(
                        'min' => '0',
                        'max' => '500',
                        'step' => '1',
                    ),
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                        array(
                            'setting' => $type_post.'_header_back_title',
                            'operator' => '!=',
                            'value' => '',
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'select',
                    'settings' => $type_post.'_header_back_title_align',
                    'label' => esc_html__('Back Title Align', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => 'center',
                    'priority' => 10,
                    'multiple' => 0,
                    'choices' => array(
                        'center' => esc_attr__('Center', 'khaki'),
                        'left' => esc_attr__('Left', 'khaki'),
                        'right' => esc_attr__('Right', 'khaki'),
                    ),
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_back_title',
                            'operator' => '!=',
                            'value' => '',
                        ),
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),

                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'text',
                    'settings' => $type_post.'_header_sub_title',
                    'label' => esc_html__('Sub Title', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => '',
                    'priority' => 10,
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'number',
                    'settings' => $type_post.'_header_sub_title_padding_bottom',
                    'label' => esc_attr__('Sub Title Padding Bottom', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => 40,
                    'priority' => 10,
                    'choices' => array(
                        'min' => '0',
                        'max' => '500',
                        'step' => '1',
                    ),
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                        array(
                            'setting' => $type_post.'_header_sub_title',
                            'operator' => '!=',
                            'value' => '',
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'select',
                    'settings' => $type_post.'_header_sub_title_align',
                    'label' => esc_html__('Sub Title Align', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => 'center',
                    'priority' => 10,
                    'multiple' => 0,
                    'choices' => array(
                        'center' => esc_attr__('Center', 'khaki'),
                        'left' => esc_attr__('Left', 'khaki'),
                        'right' => esc_attr__('Right', 'khaki'),
                    ),
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_sub_title',
                            'operator' => '!=',
                            'value' => '',
                        ),
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),

                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'editor',
                    'settings' => $type_post.'_header_content',
                    'label' => esc_html__('Content', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => '',
                    'priority' => 10,
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'text',
                    'settings' => $type_post.'_header_video_link',
                    'label' => esc_html__('Video Link', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => '',
                    'description' => esc_html__('Supported YouTube and Vimeo video link', 'khaki'),
                    'priority' => 10,
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'select',
                    'settings' => $type_post.'_header_video_style',
                    'label' => esc_html__('Icon Video Style', 'khaki'),
                    'section' => $type_post.'_header',
                    'default' => false,
                    'priority' => 10,
                    'multiple' => 0,
                    'choices' => array(
                        false => esc_attr__('Black', 'khaki'),
                        '2' => esc_attr__('Black 2', 'khaki'),
                        'light' => esc_attr__('Light', 'khaki'),
                        '2-light' => esc_attr__('Light 2', 'khaki')
                    ),
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_header_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                        array(
                            'setting' => $type_post.'_header_video_link',
                            'operator' => '!=',
                            'value' => '',
                        ),
                    ),
                ));
                /**
                 * $type_post. Breadcrumbs
                 * */
                NK_Options::add_field( array(
                    'type' => 'select',
                    'settings' => $type_post.'_breadcrumbs_show',
                    'label' => esc_html__('Show', 'khaki'),
                    'section' => $type_post.'_breadcrumbs',
                    'default' => 'header',
                    'priority' => 10,
                    'multiple' => 1,
                    'choices' => array(
                        false => esc_attr__('Disabled', 'khaki'),
                        'header' => esc_attr__('Header', 'khaki'),
                        'out_header' => esc_attr__('Under Header', 'khaki'),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'text',
                    'settings' => $type_post.'_breadcrumbs_homepage_title',
                    'label' => esc_html__('Homepage Title', 'khaki'),
                    'section' => $type_post.'_breadcrumbs',
                    'default' => 'Home',
                    'priority' => 10,
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_breadcrumbs_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'select',
                    'settings' => $type_post.'_breadcrumbs_side',
                    'label' => esc_html__('Side', 'khaki'),
                    'section' => $type_post.'_breadcrumbs',
                    'default' => 'center',
                    'priority' => 10,
                    'multiple' => 1,
                    'choices' => array(
                        false => esc_attr__('Left', 'khaki'),
                        'right' => esc_attr__('Right', 'khaki'),
                        'center' => esc_attr__('Center', 'khaki'),
                    ),
                    'active_callback' => array(
                        array(
                            'setting' => $type_post.'_breadcrumbs_show',
                            'operator' => '!=',
                            'value' => false,
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'select',
                    'settings' => $type_post.'_breadcrumbs_background',
                    'label' => esc_html__('Background', 'khaki'),
                    'section' => $type_post.'_breadcrumbs',
                    'default' => 'default',
                    'priority' => 10,
                    'multiple' => 1,
                    'choices' => array(
                        'default' => esc_attr__('Default', 'khaki'),
                        false => esc_attr__('Black', 'khaki'),
                        'white' => esc_attr__('White', 'khaki')
                    )
                ));

                /**
                 * $type_post. Sidebar
                 * */
                $default_sidebar_color = '#f7f7f7';
                if($type_post == 'playlist'){
                    $default_sidebar_color = '#262626';
                }
                NK_Options::add_field( array(
                    'type' => 'toggle',
                    'settings' => 'sidebar_'.$type_post.'_show',
                    'label' => esc_html__('Show', 'khaki'),
                    'section' => $type_post.'_sidebar',
                    'default' => 'off',
                    'priority' => 10,
                ));
                NK_Options::add_field( array(
                    'type' => 'select',
                    'settings' => 'sidebar_'.$type_post.'_list',
                    'label' => esc_html__('Type', 'khaki'),
                    'section' => $type_post.'_sidebar',
                    'default' => 'single_page',
                    'priority' => 10,
                    'multiple' => 1,
                    'choices' => $sidebars,
                    'active_callback' => array(
                        array(
                            'setting' => 'sidebar_'.$type_post.'_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'select',
                    'settings' => 'sidebar_'.$type_post.'_side',
                    'label' => esc_html__('Side', 'khaki'),
                    'section' => $type_post.'_sidebar',
                    'default' => 'right',
                    'priority' => 10,
                    'multiple' => 1,
                    'choices' => array(
                        'right' => esc_attr__('Right', 'khaki'),
                        'left' => esc_attr__('Left', 'khaki'),
                        'both' => esc_attr__('Both', 'khaki'),
                    ),
                    'active_callback' => array(
                        array(
                            'setting' => 'sidebar_'.$type_post.'_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'select',
                    'settings' => 'sidebar_'.$type_post.'_additional_list',
                    'label' => esc_html__('Type additional', 'khaki'),
                    'section' => $type_post.'_sidebar',
                    'priority' => 10,
                    'multiple' => 1,
                    'choices' => $sidebars,
                    'active_callback' => array(
                        array(
                            'setting' => 'sidebar_'.$type_post.'_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                        array(
                            'setting' => 'sidebar_'.$type_post.'_side',
                            'operator' => '==',
                            'value' => 'both',
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'toggle',
                    'settings' => 'sidebar_'.$type_post.'_sticky',
                    'label' => esc_html__('Sticky', 'khaki'),
                    'section' => $type_post.'_sidebar',
                    'default' => 'on',
                    'priority' => 10,
                    'active_callback' => array(
                        array(
                            'setting' => 'sidebar_'.$type_post.'_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'color',
                    'settings' => 'sidebar_'.$type_post . '_background_color',
                    'label' => esc_attr__('Background Color', 'khaki'),
                    'section' => $type_post . '_sidebar',
                    'default' => $default_sidebar_color,
                    'priority' => 10,
                    'choices'     => array(
                        'alpha' => true,
                    ),
                    'output' => array(
                        array(
                            'element' => '.nk-sidebar.nk-sidebar-'.$type_post.':after',
                            'property' => 'background-color',
                        ),
                    ),
                    'active_callback' => array(
                        array(
                            'setting' => 'sidebar_'.$type_post.'_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                    ),
                ));
                NK_Options::add_field( array(
                    'type' => 'color',
                    'settings' => 'sidebar_'.$type_post . '_text_color',
                    'label' => esc_attr__('Text Color', 'khaki'),
                    'section' => $type_post . '_sidebar',
                    'default' => 'inherit',
                    'priority' => 10,
                    'choices'     => array(
                        'alpha' => true,
                    ),
                    'output' => array(
                        array(
                            'element' => '.nk-sidebar.nk-sidebar-'.$type_post,
                            'property' => 'color',
                        ),
                    ),
                    'active_callback' => array(
                        array(
                            'setting' => 'sidebar_'.$type_post.'_show',
                            'operator' => '==',
                            'value' => true,
                        ),
                    ),
                ));

                /**
                 * $type_post. Content
                 * */
                if($type_post == 'woocommerce') {
                    NK_Options::add_field( array(
                        'type' => 'toggle',
                        'settings' => $type_post . '_cart_show',
                        'label' => esc_html__('Small Cart Show', 'khaki'),
                        'section' => $type_post . '_content',
                        'default' => 'on',
                        'priority' => 10,
                    ));
                }
                NK_Options::add_field( array(
                    'type' => 'toggle',
                    'settings' => $type_post.'_inner_boxed',
                    'label' => esc_html__('Boxed Content', 'khaki'),
                    'section' => $type_post.'_content',
                    'default' => 'on',
                    'priority' => 10,
                ));
                NK_Options::add_field( array(
                    'type' => 'toggle',
                    'settings' => $type_post.'_show_title',
                    'label' => esc_html__('Show Title', 'khaki'),
                    'section' => $type_post.'_content',
                    'default' => 'off',
                    'priority' => 10,
                ));

                /**
                 * $type_post. Archive
                 */
                if($type_post == 'playlist'){
                    NK_Options::add_field( array(
                        'type' => 'image',
                        'settings' => $type_post.'_no_image',
                        'label' => esc_html__('No Image', 'khaki'),
                        'section' => $type_post.'_archive',
                        'default' => get_template_directory_uri() . '/assets/images/no-image.jpg',
                        'priority' => 10,
                    ));
                    NK_Options::add_field( array(
                        'type' => 'toggle',
                        'settings' => $type_post . '_rotate',
                        'label' => esc_html__('Inverse', 'khaki'),
                        'section' => $type_post . '_single',
                        'default' => 'off',
                        'priority' => 10,
                    ));
                    NK_Options::add_field( array(
                        'type' => 'color',
                        'settings' => $type_post . '_background_archive_color',
                        'label' => esc_attr__('Background Color', 'khaki'),
                        'section' => $type_post . '_archive',
                        'default' => '#1c1c1c',
                        'priority' => 10,
                        'choices'     => array(
                            'alpha' => true,
                        ),
                        'output' => array(
                            array(
                                'element' => '.bg-custom-playlist-archive-color',
                                'property' => 'background-color',
                            ),
                        ),
                    ));
                    NK_Options::add_field( array(
                        'type' => 'color',
                        'settings' => $type_post . '_archive_text_color',
                        'label' => esc_attr__('Text Color', 'khaki'),
                        'section' => $type_post . '_archive',
                        'default' => '#fff',
                        'priority' => 10,
                        'choices'     => array(
                            'alpha' => true,
                        ),
                        'output' => array(
                            array(
                                'element' => '.text-custom-playlist-archive-color',
                                'property' => 'color',
                            ),
                        ),
                    ));

                }
                NK_Options::add_field( array(
                    'type' => 'select',
                    'settings' => $type_post.'_pagination',
                    'label' => esc_html__('Pagination', 'khaki'),
                    'section' => $type_post.'_archive',
                    'default' => 'load_more',
                    'priority' => 10,
                    'multiple' => 0,
                    'choices' => array(
                        false => esc_html__("No Pagination", 'khaki'),
                        true => esc_html__("Simple Pagination", 'khaki'),
                        'load_more' => esc_html__("Load More button", 'khaki'),
                        'infinite' => esc_html__("Infinite Scroll", 'khaki'),
                    ),
                ));

                /**
                 * $type_post. Single
                 */
                if($type_post == 'event') {
                    NK_Options::add_field( array(
                        'type' => 'toggle',
                        'settings' => $type_post . '_show_meta',
                        'label' => esc_html__('Show Meta', 'khaki'),
                        'section' => $type_post . '_meta',
                        'default' => 'on',
                        'priority' => 10,
                    ));
                    NK_Options::add_field( array(
                        'type' => 'select',
                        'settings' => $type_post.'_position_meta',
                        'label' => esc_html__('Position', 'khaki'),
                        'section' => $type_post.'_meta',
                        'priority' => 10,
                        'multiple' => 1,
                        'choices' => array(
                            'header' => esc_html__("Header", 'khaki'),
                            'out header' => esc_html__("Under Header", 'khaki'),
                            'before content' => esc_html__("Before Content", 'khaki'),
                            'after content' => esc_html__("After Content", 'khaki'),
                        ),
                        'active_callback' => array(
                            array(
                                'setting' => $type_post . '_show_meta',
                                'operator' => '==',
                                'value' => true,
                            ),
                        ),
                    ));
                }
                if($type_post == 'playlist') {
                    NK_Options::add_field( array(
                        'type' => 'toggle',
                        'settings' => $type_post . '_rotate',
                        'label' => esc_html__('Inverse', 'khaki'),
                        'section' => $type_post . '_single',
                        'default' => 'off',
                        'priority' => 10,
                    ));
                    NK_Options::add_field( array(
                        'type' => 'color',
                        'settings' => $type_post . '_background_color',
                        'label' => esc_attr__('Background Color', 'khaki'),
                        'section' => $type_post . '_single',
                        'default' => '#1c1c1c',
                        'priority' => 10,
                        'choices'     => array(
                            'alpha' => true,
                        ),
                        'output' => array(
                            array(
                                'element' => '.bg-custom-playlist-color',
                                'property' => 'background-color',
                            ),
                        ),
                    ));
                    NK_Options::add_field( array(
                        'type' => 'color',
                        'settings' => $type_post . '_text_color',
                        'label' => esc_attr__('Text Color', 'khaki'),
                        'section' => $type_post . '_single',
                        'default' => '#fff',
                        'priority' => 10,
                        'choices'     => array(
                            'alpha' => true,
                        ),
                        'output' => array(
                            array(
                                'element' => '.text-custom-playlist-color',
                                'property' => 'color',
                            ),
                        ),
                    ));
                }
                if($type_post == 'woocommerce'){
                    NK_Options::add_field( array(
                        'type' => 'toggle',
                        'settings' => 'single_' . $type_post . '_adjacent_pagination',
                        'label' => esc_html__('Adjacent Pagination', 'khaki'),
                        'section' => $type_post . '_single',
                        'default' => 'on',
                        'priority' => 10,
                    ));
                    NK_Options::add_field( array(
                        'type' => 'select',
                        'settings' => 'single_' . $type_post . '_adjacent_pagination_style',
                        'label' => esc_html__('Style Pagination', 'khaki'),
                        'section' => $type_post . '_single',
                        'default' => 'fixed',
                        'priority' => 10,
                        'multiple' => 1,
                        'choices' => array(
                            'fixed' => esc_attr__('Fixed', 'khaki'),
                            'fixed-2' => esc_attr__('Fixed 2', 'khaki'),
                            'static' => esc_attr__('Static', 'khaki'),
                        ),
                        'active_callback' => array(
                            array(
                                'setting' => 'single_' . $type_post . '_adjacent_pagination',
                                'operator' => '==',
                                'value' => true,
                            ),
                        ),
                    ));
                    NK_Options::add_field( array(
                        'type' => 'select',
                        'settings' => 'single_' . $type_post . '_adjacent_pagination_position',
                        'label' => esc_html__('Pagination Position', 'khaki'),
                        'section' => $type_post . '_single',
                        'default' => 'after',
                        'priority' => 10,
                        'multiple' => 1,
                        'choices' => array(
                            'before' => esc_attr__('Before Content', 'khaki'),
                            'after' => esc_attr__('After Content', 'khaki')
                        ),
                        'active_callback' => array(
                            array(
                                'setting' => 'single_' . $type_post . '_adjacent_pagination',
                                'operator' => '==',
                                'value' => true,
                            ),
                            array(
                                'setting' => 'single_' . $type_post . '_adjacent_pagination_style',
                                'operator' => '==',
                                'value' => 'static',
                            ),
                        ),
                    ));
                    NK_Options::add_field( array(
                        'type' => 'select',
                        'settings' => 'single_' . $type_post . '_adjacent_pagination_grid_link',
                        'label' => esc_html__('Grid Link', 'khaki'),
                        'section' => $type_post . '_single',
                        'default' => 'post-list',
                        'priority' => 10,
                        'multiple' => 1,
                        'choices' => array(
                            'disabled' => esc_attr__('Disabled', 'khaki'),
                            'product-list' => esc_attr__('Product List', 'khaki'),
                            'custom' => esc_attr__('Custom', 'khaki'),
                        ),
                        'active_callback' => array(
                            array(
                                'setting' => 'single_' . $type_post . '_adjacent_pagination',
                                'operator' => '==',
                                'value' => true,
                            ),
                            array(
                                'setting' => 'single_' . $type_post . '_adjacent_pagination_style',
                                'operator' => '==',
                                'value' => 'static',
                            ),
                        ),
                    ));
                    NK_Options::add_field( array(
                        'type' => 'text',
                        'settings' => 'single_' . $type_post . '_adjacent_pagination_grid_custom_link',
                        'label' => esc_html__('URL', 'khaki'),
                        'section' => $type_post . '_single',
                        'default' => '',
                        'priority' => 10,
                        'active_callback' => array(
                            array(
                                'setting' => 'single_' . $type_post . '_adjacent_pagination',
                                'operator' => '==',
                                'value' => true,
                            ),
                            array(
                                'setting' => 'single_' . $type_post . '_adjacent_pagination_style',
                                'operator' => '==',
                                'value' => 'static',
                            ),
                            array(
                                'setting' => 'single_' . $type_post . '_adjacent_pagination_grid_link',
                                'operator' => '==',
                                'value' => 'custom',
                            ),
                        ),
                    ));
                }
                NK_Options::add_field( array(
                    'type' => 'toggle',
                    'settings' => $type_post . '_detail_show_title',
                    'label' => esc_html__('Show Title', 'khaki'),
                    'section' => $type_post . '_single',
                    'default' => 'off',
                    'priority' => 10,
                ));
            }
        }
    }
endif;
if (!function_exists('khaki_get_theme_mod')):
    function khaki_get_theme_mod($name = null, $use_acf = null, $postId = null, $acf_name = null)
    {

        if ($name == null) {
            return null;
        }
        $value = null;

        // get Post ID of Shop Page
        if (
            function_exists( 'is_shop' ) && is_shop() ||
            function_exists( 'is_product_category' ) && is_product_category() ||
            function_exists( 'is_product_tag' ) && is_product_tag()
        ) {
            if ( empty( $postId ) ) {
                $postId = get_option( 'woocommerce_shop_page_id' );
            }
        }

        // try get value from meta box
        if ($use_acf) {
            $value = khaki_get_metabox($acf_name ? $acf_name : $name, $postId);
        }

        // get value from options
        if (($value === null || $value === 'default')) {
            if (class_exists('NK_Options')) {
                $value = NK_Options::get_option($name);
            }
        }

        $value = apply_filters('khaki_filter_get_theme_mod', $value, $name);
        return $value;
    }
endif;

// get metabox
if (!function_exists('khaki_get_metabox')):
    function khaki_get_metabox($name = null, $postId = null)
    {
        $value = null;

        // try get value from meta box
        if (function_exists('get_field')) {
            if ($postId == null) {
                $postId = get_the_ID();
            }
            $value = get_field($name, $postId);
        }

        return $value;
    }
endif;
