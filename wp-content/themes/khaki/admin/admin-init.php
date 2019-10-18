<?php

/**
 * Init Admin Theme Pages
 */
if ( function_exists('nk_theme') && method_exists ( nk_theme() , 'theme_dashboard' ) ) :
    $khaki_theme_demo_path = nk_admin()->admin_path . '/demos/';
    $khaki_theme_demo_data = array(
        'blog_options' => array(
            'permalink' => '/%postname%/',
            'page_on_front_title' => 'Corporate',
            'posts_per_page' => 6
        ),
        'navigations' => array(
            'Top Menu' => 'top_menu',
            'Main Menu' => 'primary',
            'Side Menu' => array('side_navigation_menu', 'fullscreen_navigation_menu'),
            'Top Menu Icons' => '',
        ),
    );

    nk_theme()->theme_dashboard( array(
        'theme_title'        => 'Khaki',
        'theme_id'           => '19968221',
        'theme_uri'          => 'https://themeforest.net/item/khaki-multipurpose-wordpress-theme/19968221?ref=_nK',
        'ask_for_review'     => true,
        'is_envato_elements' => true,
        'demos'             => array(
            'main' => array(
                'title'      => esc_html__('Main', 'khaki'),
                'preview'    => 'https://wp.nkdev.info/khaki/corporate/',
                'thumbnail'  => get_template_directory_uri() . '/admin/assets/images/demos/main.png',
                'demo_data'  => array_merge_recursive($khaki_theme_demo_data, array(
                    'woocommerce_options' => array(
                        'shop_page_title' => 'Our Store',
                        'cart_page_title' => 'Cart',
                        'checkout_page_title' => 'Checkout',
                        'myaccount_page_title' => 'My Account',
                    ),
                    'navigations' => array(
                        'Top Menu Icons' => 'top_icons_menu'
                    ),
                    'demo_data_file' => $khaki_theme_demo_path . 'main/content.xml',
                    'widgets_file' => $khaki_theme_demo_path . 'main/widgets.wie',
                    'customizer_file' => $khaki_theme_demo_path . 'main/customizer.dat',
                ))
            ),
            'barber' => array(
                'title'      => esc_html__('Barber Shop', 'khaki'),
                'preview'    => 'https://wp.nkdev.info/khaki/demo-barber/',
                'thumbnail'  => get_template_directory_uri() . '/admin/assets/images/demos/barber-shop.jpg',
                'demo_data'  => array_merge_recursive($khaki_theme_demo_data, array(
                    'blog_options' => array(
                        'page_on_front_title' => 'Barberia',
                    ),
                    'navigations' => array(
                        'Top Menu Icons' => 'top_icons_menu'
                    ),
                    'demo_data_file' => $khaki_theme_demo_path . 'barber/content.xml',
                    'widgets_file' => $khaki_theme_demo_path . 'barber/widgets.wie',
                    'customizer_file' => $khaki_theme_demo_path . 'barber/customizer.dat',
                ))
            ),
            'drone' => array(
                'title'      => esc_html__('Quadrocopter', 'khaki'),
                'preview'    => 'https://wp.nkdev.info/khaki/demo-drone/',
                'thumbnail'  => get_template_directory_uri() . '/admin/assets/images/demos/drone.jpg',
                'demo_data'  => array_merge($khaki_theme_demo_data, array(
                    'blog_options' => array(
                        'permalink' => '/%postname%/',
                        'page_on_front_title' => 'Main Page',
                        'posts_per_page' => 6
                    ),
                    'navigations' => array(
                        'Main Drone Menu' => array('top_menu', 'primary', 'side_navigation_menu', 'fullscreen_navigation_menu')
                    ),
                    'demo_data_file' => $khaki_theme_demo_path . 'drone/content.xml',
                    'widgets_file' => $khaki_theme_demo_path . 'drone/widgets.wie',
                    'customizer_file' => $khaki_theme_demo_path . 'drone/customizer.dat',
                ))
            ),
            'music-label' => array(
                'title'      => esc_html__('Music Label', 'khaki'),
                'preview'    => 'https://wp.nkdev.info/khaki/demo-music-label/',
                'thumbnail'  => get_template_directory_uri() . '/admin/assets/images/demos/music-label.jpg',
                'demo_data'  => array_merge($khaki_theme_demo_data, array(
                    'blog_options' => array(
                        'permalink' => '/%postname%/',
                        'page_on_front_title' => 'Music Label',
                        'posts_per_page' => 6
                    ),
                    'navigations' => array(
                        'Music Label Menu' => array('top_menu', 'primary', 'side_navigation_menu', 'fullscreen_navigation_menu')
                    ),
                    'demo_data_file' => $khaki_theme_demo_path . 'music-label/content.xml',
                    'widgets_file' => $khaki_theme_demo_path . 'music-label/widgets.wie',
                    'customizer_file' => $khaki_theme_demo_path . 'music-label/customizer.dat',
                    'rev_slider_file' => $khaki_theme_demo_path . 'music-label/khaki-music-label-carousel.zip'
                ))
            ),
            'gaming' => array(
                'title'      => esc_html__('Gaming', 'khaki'),
                'preview'    => 'https://wp.nkdev.info/khaki/demo-gaming/',
                'thumbnail'  => get_template_directory_uri() . '/admin/assets/images/demos/gaming.jpg',
                'demo_data'  => array_merge($khaki_theme_demo_data, array(
                    'blog_options' => array(
                        'permalink' => '/%postname%/',
                        'page_on_front_title' => 'Gaming Khaki',
                        'posts_per_page' => 6
                    ),
                    'navigations' => array(
                        'Gaming Menu' => array('top_menu', 'primary', 'side_navigation_menu', 'fullscreen_navigation_menu')
                    ),
                    'demo_data_file' => $khaki_theme_demo_path . 'gaming/content.xml',
                    'widgets_file' => $khaki_theme_demo_path . 'gaming/widgets.wie',
                    'customizer_file' => $khaki_theme_demo_path . 'gaming/customizer.dat'
                ))
            ),
            'app' => array(
                'title'      => esc_html__('App Landing', 'khaki'),
                'preview'    => 'https://wp.nkdev.info/khaki/demo-app-2/',
                'thumbnail'  => get_template_directory_uri() . '/admin/assets/images/demos/app.jpg',
                'demo_data'  => array_merge($khaki_theme_demo_data, array(
                    'blog_options' => array(
                        'permalink' => '/%postname%/',
                        'page_on_front_title' => 'Khaki App',
                        'posts_per_page' => 6
                    ),
                    'navigations' => array(
                        'Khaki App Main Menu' => 'primary',
                        'Side Menu' => array('top_menu', 'side_navigation_menu', 'fullscreen_navigation_menu')
                    ),
                    'demo_data_file' => $khaki_theme_demo_path . 'app/content.xml',
                    'widgets_file' => $khaki_theme_demo_path . 'app/widgets.wie',
                    'customizer_file' => $khaki_theme_demo_path . 'app/customizer.dat'
                ))
            ),
            'band' => array(
                'title'      => esc_html__('Band', 'khaki'),
                'preview'    => 'https://wp.nkdev.info/khaki/demo-band/',
                'thumbnail'  => get_template_directory_uri() . '/admin/assets/images/demos/band.jpg',
                'demo_data'  => array_merge_recursive($khaki_theme_demo_data, array(
                    'blog_options' => array(
                        'page_on_front_title' => 'Band Main',
                    ),
                    'demo_data_file' => $khaki_theme_demo_path . 'band/content.xml',
                    'widgets_file' => $khaki_theme_demo_path . 'band/widgets.wie',
                    'customizer_file' => $khaki_theme_demo_path . 'band/customizer.dat'
                ))
            ),
            'app-showcase' => array(
                'title'      => esc_html__('App Showcase', 'khaki'),
                'preview'    => 'https://wp.nkdev.info/khaki/demo-app/',
                'thumbnail'  => get_template_directory_uri() . '/admin/assets/images/demos/app-showcase.jpg',
                'demo_data'  => array_merge_recursive($khaki_theme_demo_data, array(
                    'blog_options' => array(
                        'page_on_front_title' => 'Great App',
                    ),
                    'demo_data_file' => $khaki_theme_demo_path . 'app-showcase/content.xml',
                    'widgets_file' => $khaki_theme_demo_path . 'app-showcase/widgets.wie',
                    'customizer_file' => $khaki_theme_demo_path . 'app-showcase/customizer.dat'
                ))
            ),
            'gallery' => array(
                'title'      => esc_html__('Gallery', 'khaki'),
                'preview'    => 'https://wp.nkdev.info/khaki/demo-gallery/',
                'thumbnail'  => get_template_directory_uri() . '/admin/assets/images/demos/gallery.jpg',
                'demo_data'  => array_merge($khaki_theme_demo_data, array(
                    'blog_options' => array(
                        'permalink' => '/%postname%/',
                        'page_on_front_title' => 'Gallery With Side Navbar',
                        'posts_per_page' => 6
                    ),
                    'navigations' => array(
                        'Top Menu' => 'top_menu',
                        'Side Menu' => array('primary', 'side_navigation_menu', 'fullscreen_navigation_menu')
                    ),
                    'demo_data_file' => $khaki_theme_demo_path . 'gallery/content.xml',
                    'widgets_file' => $khaki_theme_demo_path . 'gallery/widgets.wie',
                    'customizer_file' => $khaki_theme_demo_path . 'gallery/customizer.dat'
                ))
            ),
        ),
    ) );
endif;
