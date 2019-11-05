<?php
/**
 * khaki functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package khaki
 */

if (!function_exists('khaki_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function khaki_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on khaki, use a find and replace
         * to change 'khaki' to the name of your theme in all the template files.
         */
        load_theme_textdomain('khaki', get_template_directory() . '/languages');

        // Add Editor styles.
        add_editor_style();

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        add_theme_support( 'post-formats', array( 'video', 'gallery', 'audio', 'image', 'quote' ) );
        add_post_type_support( 'post', 'post-formats' );
        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'top_menu' => esc_html__('Top Menu', 'khaki'),
            'top_icons_menu' => esc_html__('Top Icons Menu', 'khaki'),
            'primary' => esc_html__('Main Menu', 'khaki'),
            'fullscreen_navigation_menu' => esc_html__('Fullscreen Navigation Menu', 'khaki'),
            'side_navigation_menu' => esc_html__('Side Navigation Menu', 'khaki')
        ));
        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('khaki_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        // Add default image sizes
        add_theme_support('post-thumbnails');
        add_image_size('khaki_48x48_crop', 48, 48, true);
        add_image_size('khaki_48x48', 48);
        add_image_size('khaki_90x90_crop', 90, 90, true);
        add_image_size('khaki_90x90', 90);
        add_image_size('khaki_150x150_crop', 150, 150, true);
        add_image_size('khaki_150x150', 150);
        add_image_size('khaki_200x200_crop', 200, 200, true);
        add_image_size('khaki_200x200', 200);
        add_image_size('khaki_300x300_crop', 300, 300, true);
        add_image_size('khaki_300x300', 300);
        add_image_size('khaki_400x400_crop', 400, 400, true);
        add_image_size('khaki_400x400', 400);
        add_image_size('khaki_500x375_crop', 500, 375, true);
        add_image_size('khaki_500x375', 500);
        add_image_size('khaki_600x600_crop', 600, 600, true);
        add_image_size('khaki_600x600', 600);
        add_image_size('khaki_600x1200_crop', 600, 1200, true);
        add_image_size('khaki_800x450_crop', 800, 450, true);
        add_image_size('khaki_800x450', 800);
        add_image_size('khaki_800x533_crop', 800, 533, true);
        add_image_size('khaki_800x600_crop', 800, 600, true);
        add_image_size('khaki_800x600', 800);
        add_image_size('khaki_1200x600_crop', 1200, 600, true);
        add_image_size('khaki_1200x1200_crop', 1200, 1200, true);
        add_image_size('khaki_1280x720_crop', 1280, 720, true);
        add_image_size('khaki_1280x720', 1280);
        add_image_size('khaki_1400x600_crop', 1400, 600, true);
        add_image_size('khaki_1400x600', 1400);
        add_image_size('khaki_1440x900_crop', 1440, 900, true);
        add_image_size('khaki_1440x900', 1440);
        add_image_size('khaki_1600x751', 1600);
        add_image_size('khaki_1920x1080_crop', 1920, 1080, true);
        add_image_size('khaki_1920x1080', 1920);


        // Register the three useful image sizes for use in Add Media modal
        add_filter('image_size_names_choose', 'khaki_custom_sizes');
        if (!function_exists('khaki_custom_sizes')) :
            function khaki_custom_sizes($sizes)
            {
                return array_merge($sizes, array(
                    'khaki_48x48_crop' => '48x48 crop',
                    'khaki_48x48' => '48x48',
                    'khaki_90x90_crop' => '90x90 crop',
                    'khaki_90x90' => '90x90',
                    'khaki_150x150_crop' => '150x150 crop',
                    'khaki_150x150' => '150x150',
                    'khaki_200x200_crop' => '200x200 crop',
                    'khaki_200x200' => '200x200',
                    'khaki_300x300_crop' => '300x300 crop',
                    'khaki_300x300' => '300x300',
                    'khaki_400x400_crop' => '400x400 crop',
                    'khaki_400x400' => '400x400',
                    'khaki_500x375_crop' => '500x375 crop',
                    'khaki_500x375' => '500x375',
                    'khaki_600x600_crop' => '600x600 crop',
                    'khaki_600x600' => '600x600',
                    'khaki_600x1200_crop' => '600x1200 crop',
                    'khaki_800x450_crop' => '800x450 crop',
                    'khaki_800x450' => '800x450',
                    'khaki_800x533_crop' => '800x533 crop',
                    'khaki_800x600_crop' => '800x600 crop',
                    'khaki_800x600' => '800x600',
                    'khaki_1200x600_crop' => '1200x600 crop',
                    'khaki_1200x1200_crop' => '1200x1200 crop',
                    'khaki_1280x720_crop' => '1280x720 crop',
                    'khaki_1280x720' => '1280x720',
                    'khaki_1400x600_crop' => '1400x600 crop',
                    'khaki_1400x600' => '1400x600',
                    'khaki_1440x900_crop' => '1440x900 crop',
                    'khaki_1440x900' => '1440x900',
                    'khaki_1600x751' => '1600x751',
                    'khaki_1920x1080_crop' => '1920x1080 crop',
                    'khaki_1920x1080' => '1920x1080',
                ));
            }
        endif;
    }
endif;
add_action('after_setup_theme', 'khaki_setup');
if ( ! isset( $content_width ) ) $content_width = 1140;
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
if (!function_exists('khaki_widgets_init')) :
    function khaki_widgets_init()
    {
        register_sidebar(array(
            'name' => esc_html__('Pages Sidebar', 'khaki'),
            'id' => 'sidebar-page',
            'description' => esc_html__('For single pages.', 'khaki'),
            'before_widget' => '<div id="%1$s" class="nk-widget">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="nk-widget-title">',
            'after_title' => '</h4>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Posts Sidebar', 'khaki'),
            'id' => 'sidebar-post',
            'description' => esc_html__('For posts pages.', 'khaki'),
            'before_widget' => '<div id="%1$s" class="nk-widget">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="nk-widget-title">',
            'after_title' => '</h4>',
        ));
        register_sidebar(array(
            'name' => esc_html__('First Column Footer', 'khaki'),
            'id' => 'sidebar-footer-1',
            'description' => esc_html__('For First Column Footer.', 'khaki'),
            'before_widget' => '<div id="%1$s" class="nk-widget">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="nk-widget-title">',
            'after_title' => '</h4>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Second Column Footer', 'khaki'),
            'id' => 'sidebar-footer-2',
            'description' => esc_html__('For Second Column Footer.', 'khaki'),
            'before_widget' => '<div id="%1$s" class="nk-widget">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="nk-widget-title">',
            'after_title' => '</h4>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Three Column Footer', 'khaki'),
            'id' => 'sidebar-footer-3',
            'description' => esc_html__('For Three Column Footer.', 'khaki'),
            'before_widget' => '<div id="%1$s" class="nk-widget">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="nk-widget-title">',
            'after_title' => '</h4>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Four Column Footer', 'khaki'),
            'id' => 'sidebar-footer-4',
            'description' => esc_html__('For Four Column Footer.', 'khaki'),
            'before_widget' => '<div id="%1$s" class="nk-widget">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="nk-widget-title">',
            'after_title' => '</h4>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Shop Sidebar', 'khaki'),
            'id' => 'woocommerce',
            'description' => esc_html__('For shop pages.', 'khaki'),
            'before_widget' => '<div id="%1$s" class="nk-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="nk-widget-title">',
            'after_title' => '</h4>',
        ));
    }
endif;
add_action('widgets_init', 'khaki_widgets_init');

/**
 * Enqueue scripts and styles.
 */
if (!function_exists('khaki_scripts')) :
    function khaki_scripts()
    {
        // Styles

        // If Kirki plugin is disabled use custom google fonts
        if ( ! class_exists( 'Kirki' ) ) {
            wp_enqueue_style( 'khaki-google-fonts', "//fonts.googleapis.com/css?family=Montserrat:400,700%7cNunito+Sans:400,400i,700", '', '1.0.0', 'screen' );
        }

        wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/vendor/bootstrap/dist/css/bootstrap.min.css');
        wp_enqueue_style('ionicons', get_template_directory_uri() . '/assets/vendor/ionicons/dist/css/ionicons.min.css');

        // Flickity
        wp_enqueue_style('flickity', get_template_directory_uri() . '/assets/vendor/flickity/dist/flickity.min.css');

        // Photoswipe
        wp_enqueue_style('photoswipe', get_template_directory_uri() . '/assets/vendor/photoswipe/dist/photoswipe.css');
        wp_enqueue_style('photoswipedefault-skin', get_template_directory_uri() . '/assets/vendor/photoswipe/dist/default-skin/default-skin.css');

        // DateTimePicker
        wp_enqueue_style('datetimepicker', get_template_directory_uri() . '/assets/vendor/jquery-datetimepicker/build/jquery.datetimepicker.min.css');

        // deregister bbPress styles
        wp_deregister_style( 'bbp-default' );
        wp_enqueue_style('bbpress', get_template_directory_uri() . '/assets/css/bbpress.css');

        $khaki_url = get_template_directory_uri() . '/assets/scss/khaki.min.css';
        $khaki_version = '2.0.4';

        khaki_compile_colors();

        if (khaki_get_theme_mod('style_custom') && function_exists('nk_theme') && nk_theme()->get_compiled_css_url('khaki-custom.min.css')) {
            $khaki_url = nk_theme()->get_compiled_css_url('khaki-custom.min.css');
            $khaki_version = nk_theme()->get_compiled_css_version('khaki-custom.min.css');
        }
        wp_enqueue_style('khaki', $khaki_url, '', $khaki_version);

        wp_enqueue_style('khaki-style', get_template_directory_uri() . '/style.css');

        //scripts

        wp_register_script('khaki-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true);

        wp_register_script('khaki-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true);

        // Font Awesome
        wp_register_script( 'font-awesome-v4-shims', get_template_directory_uri() . '/assets/vendor/fontawesome-free/js/v4-shims.js', array(), '5.6.1' );
        wp_register_script( 'font-awesome', get_template_directory_uri() . '/assets/vendor/fontawesome-free/js/all.js', array( 'font-awesome-v4-shims' ), '5.6.1' );

        // GSAP
        wp_register_script('tween-max', get_template_directory_uri() . '/assets/vendor/gsap/src/minified/TweenMax.min.js', '', '', true);
        wp_register_script('gsap-scroll-to-plugin', get_template_directory_uri() . '/assets/vendor/gsap/src/minified/plugins/ScrollToPlugin.min.js', array('tween-max'), '', true);

        // Bootstrap
        wp_register_script('popper.js', get_template_directory_uri() . '/assets/vendor/popper.js/dist/umd/popper.min.js', array('jquery'), '', true);
        wp_register_script('bootstrap', get_template_directory_uri() . '/assets/vendor/bootstrap/dist/js/bootstrap.min.js', array('jquery'), '', true);

        // Sticky Kit
        wp_register_script('sticky-kit', get_template_directory_uri() . '/assets/vendor/sticky-kit/dist/sticky-kit.min.js', array('jquery'), '', true);

        // Jarallax
        wp_register_script('jarallax', get_template_directory_uri() . '/assets/vendor/jarallax/dist/jarallax.min.js', '', '', true);
        wp_register_script('jarallax-video', get_template_directory_uri() . '/assets/vendor/jarallax/dist/jarallax-video.min.js', array('jarallax'), '', true);

        // Flickity
        wp_register_script('flickity', get_template_directory_uri() . '/assets/vendor/flickity/dist/flickity.pkgd.min.js', array('jquery'), '', true);

        // Isotope
        wp_register_script('isotope', get_template_directory_uri() . '/assets/vendor/isotope-layout/dist/isotope.pkgd.min.js', array('jquery'), '', true);

        // Photoswipe
        wp_register_script('photoswipe', get_template_directory_uri() . '/assets/vendor/photoswipe/dist/photoswipe.min.js', '', '', true);
        wp_register_script('photoswipe-ui-default', get_template_directory_uri() . '/assets/vendor/photoswipe/dist/photoswipe-ui-default.min.js', array('photoswipe'), '', true);

        // Social Likes
        wp_register_script('social-likes', get_template_directory_uri() . '/assets/vendor/social-likes/dist/social-likes.min.js', array('jquery'), '', true);

        // Typed.js
        wp_register_script('typed', get_template_directory_uri() . '/assets/vendor/typed.js/lib/typed.min.js', array('jquery'), '', true);

        // Jquery Countdown + Moment
        wp_register_script('jquery-countdown', get_template_directory_uri() . '/assets/vendor/jquery-countdown/dist/jquery.countdown.min.js', array('jquery'), '', true);
        wp_register_script('moment', get_template_directory_uri() . '/assets/vendor/moment/min/moment.min.js', '', '', true);
        wp_register_script('moment-timezone', get_template_directory_uri() . '/assets/vendor/moment-timezone/builds/moment-timezone-with-data.min.js', array('moment'), '', true);

        // Hammer.js
        wp_register_script('hammer', get_template_directory_uri() . '/assets/vendor/hammerjs/hammer.min.js', '', '', true);

        // NanoSroller
        wp_register_script('nanoscroller', get_template_directory_uri() . '/assets/vendor/nanoscroller/bin/javascripts/jquery.nanoscroller.js', array('jquery'), '', true);

        // SoundManager2
        wp_register_script('soundmanager2', get_template_directory_uri() . '/assets/vendor/soundmanager2/script/soundmanager2-nodebug-jsmin.js', '', '', true);

        // DateTimePicker
        wp_register_script('datetimepicker', get_template_directory_uri() . '/assets/vendor/jquery-datetimepicker/build/jquery.datetimepicker.full.min.js', array('jquery'), '', true);

        // Keymaster
        wp_register_script('keymaster', get_template_directory_uri() . '/assets/vendor/keymaster/keymaster.js', '', '', true);

        // khaki
        wp_register_script('khaki', get_template_directory_uri() . '/assets/js/khaki.min.js', array('jquery', 'font-awesome-v4-shims', 'font-awesome', 'tween-max', 'gsap-scroll-to-plugin', 'popper.js', 'bootstrap', 'sticky-kit', 'jarallax', 'jarallax-video', 'flickity', 'isotope', 'imagesloaded', 'photoswipe', 'photoswipe-ui-default', 'social-likes', 'typed', 'jquery-countdown', 'moment', 'moment-timezone', 'hammer', 'nanoscroller', 'soundmanager2', 'datetimepicker', 'keymaster'), '2.0.4', true);

        wp_enqueue_script('khaki-init', get_template_directory_uri() . '/assets/js/khaki-init.js', array('khaki'), '2.0.4', true);

        $dataInit = array(

            'enableSearchAutofocus' => khaki_get_theme_mod('enable_search_autofocus'),
            'enableActionLikeAnimation' => khaki_get_theme_mod('enable_action_like_animation'),
            'enableShortcuts' => khaki_get_theme_mod('enable_shortcuts'),
            'enableFadeBetweenPages' => true,
            'enableMouseParallax' => true,
            'scrollToAnchorSpeed' => khaki_get_theme_mod('scroll_to_anchor_speed'),
            'parallaxSpeed' => 0.8,
            'plainVideoIcon' => esc_attr(khaki_get_theme_mod('plain_video_icon')),
            'gifIcon' => esc_attr(khaki_get_theme_mod('gif_icon')),
            'toggleShare' => khaki_get_theme_mod('shortcuts_toggle_share'),
            'showShare' => khaki_get_theme_mod('shortcuts_show_share'),
            'closeShare' => khaki_get_theme_mod('shortcuts_close_share'),
            'closeQuckView' => khaki_get_theme_mod('shortcuts_close_quick_view'),
            'audioPlayerPlayPause' => khaki_get_theme_mod('shortcuts_audio_player_pause'),
            'audioPlayerPlay' => khaki_get_theme_mod('shortcuts_audio_player_play'),
            'audioPlayerPause' => khaki_get_theme_mod('shortcuts_audio_player_pause'),
            'audioPlayerForward' => khaki_get_theme_mod('shortcuts_audio_player_forward'),
            'audioPlayerBackward' => khaki_get_theme_mod('shortcuts_audio_player_backward'),
            'audioPlayerVolumeUp' => khaki_get_theme_mod('shortcuts_audio_player_volume_up'),
            'audioPlayerVolumeDown' => khaki_get_theme_mod('shortcuts_audio_player_volume_down'),
            'audioPlayerMute' => khaki_get_theme_mod('shortcuts_audio_player_mute'),
            'audioPlayerLoop' => khaki_get_theme_mod('shortcuts_audio_player_loop'),
            'audioPlayerShuffle' => khaki_get_theme_mod('shortcuts_audio_player_snuffle'),
            'audioPlayerPlaylist' => khaki_get_theme_mod('shortcuts_audio_player_playlist'),
            'audioPlayerPin' => khaki_get_theme_mod('shortcuts_audio_player_pin'),
            'toggleSearch' => khaki_get_theme_mod('shortcuts_toggle_search'),
            'showSearch' => khaki_get_theme_mod('shortcuts_show_search'),
            'closeSearch' => khaki_get_theme_mod('shortcuts_close_search'),
            'closeFullscreenVideo' => khaki_get_theme_mod('shortcuts_close_fullscreen_video'),
            'postLike' => khaki_get_theme_mod('shortcuts_post_like'),
            'postDislike' => khaki_get_theme_mod('shortcuts_post_dislike'),
            'postScrollToComments' => khaki_get_theme_mod('shortcuts_post_scroll_to_comments'),
            'toggleSideLeftNavbar' => khaki_get_theme_mod('shortcuts_toggle_side_left_navbar'),
            'openSideLeftNavbar' => khaki_get_theme_mod('shortcuts_open_side_left_navbar'),
            'closeSideLeftNavbar' => khaki_get_theme_mod('shortcuts_close_side_left_navbarr'),
            'toggleSideRightNavbar' => khaki_get_theme_mod('shortcuts_toggle_side_right_navbar'),
            'openSideRightNavbar' => khaki_get_theme_mod('shortcuts_open_side_right_navbar'),
            'closeSideRightNavbar' => khaki_get_theme_mod('shortcuts_close_side_right_navbar'),
            'toggleFullscreenNavbar' => khaki_get_theme_mod('shortcuts_toggle_fullscreen_navbar'),
            'openFullscreenNavbar' => khaki_get_theme_mod('shortcuts_open_fullscreen_navbar'),
            'closeFullscreenNavbar' => khaki_get_theme_mod('shortcuts_close_fullscreen_navbar'),
            'secondaryNavbarBackItem' => esc_html__('Back', 'khaki'),
            'likeAnimationLiked' => esc_html__('Liked!', 'khaki'),
            'likeAnimationDisliked' => esc_html__('Disliked!', 'khaki'),
            'days' => esc_html__('Days', 'khaki'),
            'hours' => esc_html__('Hours', 'khaki'),
            'minutes' => esc_html__('Minutes', 'khaki'),
            'seconds' => esc_html__('Seconds', 'khaki'),
            'url' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'ajax-nonce' )
        );

        wp_localize_script('khaki-init', 'khakiInitOptions', $dataInit);

        // khaki WP
        wp_enqueue_script('khaki-wp', get_template_directory_uri() . '/assets/js/khaki-wp.js', array('khaki'), '', true);

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }
endif;

add_action('wp_enqueue_scripts', 'khaki_scripts');

/**
 * Compiling custom styles
 */
if (!function_exists('khaki_compile_colors')) :
    function khaki_compile_colors()
    {
        if ( ! function_exists('nk_theme') ||
            ( ! nk_theme()->theme_dashboard()->is_envato_hosted && ! nk_theme()->theme_dashboard()->activation()->active ) ||
            version_compare(phpversion(), '5.4', '<') ) {
            return;
        }

        if (!khaki_get_theme_mod('style_custom')) {
            return;
        }

        $file_scss = get_template_directory() . '/assets/scss/';

        $variables_scss = '
                        @import "_variables.scss";

                        // main colors
                        $color_main_1:' . khaki_get_theme_mod('style_color_main_1') . ';
                        $color_main_2:' . khaki_get_theme_mod('style_color_main_2') . ';
                        $color_main_3:' . khaki_get_theme_mod('style_color_main_3') . ';
                        $color_main_4:' . khaki_get_theme_mod('style_color_main_4') . ';
                        $color_main_5:' . khaki_get_theme_mod('style_color_main_5') . ';

                        // bootstrap colors
                        $color_primary:' . khaki_get_theme_mod('style_color_primary') . ';
                        $color_success:' . khaki_get_theme_mod('style_color_success') . ';
                        $color_info:' . khaki_get_theme_mod('style_color_info') . ';
                        $color_warning:' . khaki_get_theme_mod('style_color_warning') . ';
                        $color_danger:' . khaki_get_theme_mod('style_color_danger') . ';

                        // dark colors
                        $color_dark_1:' . khaki_get_theme_mod('style_color_dark') . ';
                        $color_dark_2: lighten($color_dark_1, 4%);
                        $color_dark_3: lighten($color_dark_1, 8%);
                        $color_dark_4: lighten($color_dark_1, 12%);

                        // gray colors
                        $color_gray_1:' . khaki_get_theme_mod('style_color_gray') . ';
                        $color_gray_2: darken($color_gray_1, 1%);
                        $color_gray_3: darken($color_gray_1, 2%);
                        $color_gray_4: darken($color_gray_1, 3%);

                        // main colors list
                        $colors: (
                            "main-1"  : $color_main_1,
                            "main-2"  : $color_main_2,
                            "main-3"  : $color_main_3,
                            "main-4"  : $color_main_4,
                            "main-5"  : $color_main_5,
                            "primary" : $color_primary,
                            "success" : $color_success,
                            "info"    : $color_info,
                            "warning" : $color_warning,
                            "danger"  : $color_danger,
                            "white"   : #fff,
                            "black"   : #000,
                            "dark-1"  : $color_dark_1,
                            "dark-2"  : $color_dark_2,
                            "dark-3"  : $color_dark_3,
                            "dark-4"  : $color_dark_4,
                            "gray-1"  : $color_gray_1,
                            "gray-2"  : $color_gray_2,
                            "gray-3"  : $color_gray_3,
                            "gray-4"  : $color_gray_4
                        );

                        // Page Border
                        $page_border_size: ' . khaki_get_theme_mod('page_border_size') . 'px;
                        $page_border_size_md: ' . khaki_get_theme_mod('page_border_size_md') . 'px;
                        $page_border_size_sm: ' . khaki_get_theme_mod('page_border_size_sm') . 'px;

                        // Share Place
                        $share_place_height: ' . khaki_get_theme_mod('share_place_height') . 'px;

                        // audio player
                        $audio_player_height: ' . khaki_get_theme_mod('audio_player_height') . 'px;
                        $audio_player_playlist_height: ' . khaki_get_theme_mod('audio_player_playlist_height') . 'px;
                        $audio_player_mobile_height: ' . khaki_get_theme_mod('audio_player_mobile_height') . 'px;

                        @import "_includes.scss"';

        // compile styles
        nk_theme()->scss('khaki-custom.min.css', $file_scss, $variables_scss);
    }
endif;

add_action('customize_preview_init', 'khaki_compile_colors');
add_action('customize_save_after', 'khaki_compile_colors');

// Prevent Kirki to load shitty FontAwesome script, that breaks some theme things.
add_filter('kirki_load_fontawesome', '__return_false');

/**
 * Admin References
 */
require get_template_directory() . '/admin/admin.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';
/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
/**
 * Comments walker
 */
require get_template_directory() . '/inc/comments-walker.php';
/**
 * Custom WooCommerce functions
 */
require get_template_directory() . '/woocommerce/functions.php';
/**
 * Custom bbPress functions
 */
require get_template_directory() . '/bbpress/functions.php';
/**
 * Infinite Scroll for Posts
 */
require get_template_directory() . '/inc/lib/nk-infinite-scroll/nk-infinite-scroll.php';
/**
 * Inicial custom posts (portfolios, eventsm, playlist etc..)
 * */
require get_template_directory() . '/inc/custom-posts.php';
