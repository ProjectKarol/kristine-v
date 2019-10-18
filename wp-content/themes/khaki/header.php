<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php wp_head(); ?>

</head>
<?php
$post_type = get_post_type();
if (!$post_type) {
    $post_type = 'page';
}
if($post_type == 'product'){
    $post_type = 'woocommerce';
}
$acf_navigation = khaki_get_theme_mod($post_type . '_custom_navigation', true);

$main_navigation_logo_area = khaki_get_theme_mod('main_navigation_logo_area');
$logo_position = khaki_get_theme_mod('main_navigation_logo_position');
$main_navigation_logo = khaki_get_theme_mod('main_navigation_logo');
$left_navigation_panel_row_side = khaki_get_theme_mod('left_navigation_panel_row_side');
$left_navigation_panel_text = khaki_get_theme_mod('left_navigation_panel_text');
$side_navigation_logo = khaki_get_theme_mod('side_navigation_logo');
$side_navigation_text = khaki_get_theme_mod('side_navigation_text');
$fullscreen_navbar_text = khaki_get_theme_mod('fullscreen_navbar_text');
$main_navigation_logo_mobile = khaki_get_theme_mod('main_navigation_logo_mobile');
$side_navigation_social = khaki_get_theme_mod('side_navigation_social');
$fullscreen_navigation_social = khaki_get_theme_mod('fullscreen_navigation_social');
$main_navigation_custom_content = khaki_get_theme_mod('main_navigation_custom_content');
$main_navigation_custom_content_position = khaki_get_theme_mod('main_navigation_custom_content_position');
if( !class_exists('Kirki') ){
    $main_navigation_logo_area = 'navigation';
    $logo_position = false;
    $main_navigation_logo = $side_navigation_logo = $main_navigation_logo_mobile = get_template_directory_uri() . '/assets/images/logo.svg';
    $left_navigation_panel_row_side = 'center';
    $left_navigation_panel_text = $side_navigation_text = $fullscreen_navbar_text = '<a href="https://nkdev.info" target="_blank">nK</a> &copy; 2018. All rights reserved';
    $side_navigation_social = $fullscreen_navigation_social = array();
    $main_navigation_custom_content = false;
}
$menu_locations = get_nav_menu_locations();
$main_menu = '';
if ( isset( $menu_locations ) && ! empty( $menu_locations ) && is_array( $menu_locations ) && isset( $menu_locations['primary'] ) && ! empty( $menu_locations['primary'] ) ) {
    $main_menu = wp_get_nav_menu_object( $menu_locations['primary'] );
}
?>
<body <?php body_class(); ?>>

<?php if(khaki_get_theme_mod('show_border')):?>
<!-- START: Page Border -->
<div class="nk-page-border<?php echo khaki_sanitize_class(khaki_get_theme_mod('size_border') ? ' nk-page-border-'.khaki_get_theme_mod('size_border') : '');?>">
        <div class="nk-page-border-t"></div>
        <div class="nk-page-border-r"></div>
        <div class="nk-page-border-b"></div>
        <div class="nk-page-border-l"></div>
</div>
<!-- END: Page Border -->
<?php endif;?>

<?php if(khaki_get_theme_mod('main_navigation_show_share_button') && function_exists('sociality')):?>
<!--
START: Share Place

Additional Classes:
.nk-share-place-light
-->
<div class="nk-share-place<?php echo khaki_sanitize_class(khaki_get_theme_mod('share_light') ? ' nk-share-place-light' : '');?>">
    <div>
        <div class="container">
            <?php do_action('sociality-sharing'); ?>
        </div>
    </div>
</div>
<!-- END: Share Place -->
<?php endif;?>

<header
    class="nk-header<?php if (khaki_get_theme_mod('main_navigation_opaque')) echo khaki_sanitize_class(' nk-header-opaque'); ?>">
    <?php if (khaki_get_theme_mod('top_menu_show', $acf_navigation) and !khaki_get_theme_mod('main_navigation_show_left_navigation_panel', $acf_navigation)): ?>
        <!-- START: Top Contacts -->
        <?php
        $top_menu_light = khaki_get_theme_mod('top_menu_light');
        $additional_navigation_class = 'nk-contacts-top';
        $additional_navbar_class = 'nk-navbar';
        if($top_menu_light){
            $additional_navigation_class .= ' nk-contacts-top-light';
            $additional_navbar_class .= ' nk-navbar-light';
        }
        if ( khaki_get_theme_mod('top_menu_blur') ) {
            $additional_navigation_class .= ' nk-contacts-top-blur';
        }
        ?>
        <div
            class="<?php echo khaki_sanitize_class($additional_navigation_class); ?>">
            <div class="container">
                <div class="nk-contacts-left">
                    <div class="<?php echo khaki_sanitize_class($additional_navbar_class); ?>">
                    <?php wp_nav_menu(array(
                        'theme_location' => 'top_menu',
                        'container' => '',
                        'menu_class' => 'nk-nav',
                        'walker' => new nk_walker(),
                        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>'
                    )); ?>
                    </div>
                </div>
                    <div class="nk-contacts-right khaki_top_icons_menu">
                        <div class="<?php echo khaki_sanitize_class($additional_navbar_class); ?>">
                            <?php wp_nav_menu(array(
                                'theme_location' => 'top_icons_menu',
                                'container' => '',
                                'menu_class' => 'nk-nav',
                                'walker' => new nk_walker(),
                                'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>'
                            )); ?>
                        </div>
                    </div>
            </div>
        </div>
        <!-- END: Top Contacts -->
    <?php endif; ?>
    <?php if($main_navigation_logo_area == 'top'):?>
    <?php
        $navbarAdditionalClasses = 'nk-logo-top';
        if (khaki_get_theme_mod('main_navigation_light')) {
            $navbarAdditionalClasses .= " nk-logo-top-light";
        }
     ?>
    <div class="<?php echo khaki_sanitize_class($navbarAdditionalClasses);?>">
    <?php echo khaki_get_main_navigation_logo();?>
    </div>
    <?php endif; ?>
    <!--
        START: Navbar

        Additional Classes:
            .nk-navbar-sticky
            .nk-navbar-transparent
            .nk-navbar-autohide
            .nk-navbar-light
    -->
    <?php if (khaki_get_theme_mod('main_navigation_show', $acf_navigation) and !khaki_get_theme_mod('main_navigation_show_left_navigation_panel', $acf_navigation)): ?>
        <?php
        //defend additional classes
        $navbarAdditionalClasses = "";
        if (khaki_get_theme_mod('main_navigation_light')) {
            $navbarAdditionalClasses .= " nk-navbar-light";
        }
        if (khaki_get_theme_mod('main_navigation_blur')) {
            $navbarAdditionalClasses .= " nk-navbar-blur";
        }
        if (khaki_get_theme_mod('main_navigation_autohide')) {
            $navbarAdditionalClasses .= " nk-navbar-autohide";
        }
        if (khaki_get_theme_mod('main_navigation_transparent')) {
            $navbarAdditionalClasses .= " nk-navbar-transparent";
        }
        if (khaki_get_theme_mod('main_navigation_sticky')) {
            $navbarAdditionalClasses .= " nk-navbar-sticky";
        }
        ?>
        <nav
            class="nk-navbar nk-navbar-top<?php if ($navbarAdditionalClasses) echo khaki_sanitize_class($navbarAdditionalClasses); ?>">
            <div class="container">
                <div class="nk-nav-table">
                    <?php if ($main_navigation_logo && $logo_position==false && $main_navigation_logo_area=='navigation'): ?>
                        <?php echo khaki_get_main_navigation_logo();?>
                    <?php endif; ?>
                    <?php
                    $main_nav_align = khaki_get_theme_mod('main_menu_align') ? ' nk-nav-'.khaki_get_theme_mod('main_menu_align') : '';
                    ?>
                    <?php if(isset($main_navigation_custom_content) && !empty($main_navigation_custom_content) && $main_navigation_custom_content_position == 'before_menu'):?>
                        <?php echo wp_kses_post(do_shortcode($main_navigation_custom_content));?>
                    <?php endif;?>
                    <?php wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container' => '',
                        'menu_class' => khaki_sanitize_class('nk-nav d-none d-lg-table-cell'.$main_nav_align),
                        'walker' => new nk_walker($logo_position),
                        'items_wrap' => '<ul id="%1$s" class="%2$s" data-nav-mobile="#nk-nav-mobile">%3$s</ul>'
                    )); ?>
                    <?php if(isset($main_navigation_custom_content) && !empty($main_navigation_custom_content) && $main_navigation_custom_content_position == 'after_menu'):?>
                        <?php echo wp_kses_post(do_shortcode($main_navigation_custom_content));?>
                    <?php endif;?>
                    <ul class="nk-nav nk-nav-right nk-nav-icons">
                        <?php if(isset($main_navigation_custom_content) && !empty($main_navigation_custom_content) && $main_navigation_custom_content_position == 'before_icons'):?>
                            <li><div><?php echo wp_kses_post(do_shortcode($main_navigation_custom_content));?></div></li>
                        <?php endif;?>
                        <?php if ( khaki_get_theme_mod( 'main_navigation_mobile_show', $acf_navigation ) && is_object( $main_menu ) && $main_menu->count > 0 ): ?>
                            <li class="single-icon d-lg-none">
                                <a href="#" class="no-link-effect" data-nav-toggle="#nk-nav-mobile">
                                <span class="nk-icon-burger">
                                    <span class="nk-t-1"></span>
                                    <span class="nk-t-2"></span>
                                    <span class="nk-t-3"></span>
                                </span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php
                        if(function_exists('khaki_login_with_ajax_from_navigation_panel_icon')):
                            khaki_login_with_ajax_from_navigation_panel_icon();
                        endif;
                        ?>
                        <?php khaki_small_cart(); ?>
                        <?php if(khaki_get_theme_mod('main_navigation_show_share_button') && function_exists('sociality')):?>
                        <li class="single-icon">
                            <a href="#" class="nk-share-toggle no-link-effect">
                                <span class="ion-md-share"></span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (khaki_get_theme_mod('main_navigation_show_search')): ?>
                            <li class="single-icon">
                                <a href="#" class="nk-search-toggle no-link-effect">
                                    <span class="nk-icon-search"></span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (khaki_get_theme_mod('fullscreen_navbar_show', $acf_navigation)): ?>
                            <li class="single-icon">
                                <a href="#" class="nk-navbar-full-toggle no-link-effect">
                            <span class="nk-icon-burger">
                                <span class="nk-t-1"></span>
                                <span class="nk-t-2"></span>
                                <span class="nk-t-3"></span>
                            </span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (khaki_get_theme_mod('side_navigation_show', $acf_navigation)): ?>
                            <li class="single-icon">
                                <a href="#" class="no-link-effect" data-nav-toggle="#nk-side">
                            <span class="nk-icon-burger">
                                <span class="nk-t-1"></span>
                                <span class="nk-t-2"></span>
                                <span class="nk-t-3"></span>
                            </span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(isset($main_navigation_custom_content) && !empty($main_navigation_custom_content) && $main_navigation_custom_content_position == 'after_icons'):?>
                            <li><div><?php echo wp_kses_post(do_shortcode($main_navigation_custom_content));?></div></li>
                        <?php endif;?>
                    </ul>
                </div>
            </div>
        </nav>
    <?php endif; ?>
    <!-- END: Navbar -->

</header>

<?php if (khaki_get_theme_mod('main_navigation_show_left_navigation_panel', $acf_navigation) || !khaki_get_theme_mod('main_navigation_show', $acf_navigation)): ?>
    <?php
    $fullscreen_navbar_show = khaki_get_theme_mod('fullscreen_navbar_show', $acf_navigation);
    $side_navigation_show = khaki_get_theme_mod('side_navigation_show', $acf_navigation);
    ?>
    <!-- START: Navbar -->
    <?php if($fullscreen_navbar_show || $side_navigation_show):?>
    <ul class="nk-nav-toggler-right">
        <?php if ($fullscreen_navbar_show): ?>
            <?php
            $full_toggle_class = 'nk-navbar-full-toggle';
            $full_toggle_class .= khaki_get_theme_mod('fullscreen_navbar_white_icon') ? ' bg-white text-dark-1' : '';
            ?>
            <li class="single-icon">
                <a href="#" class="<?php echo khaki_sanitize_class($full_toggle_class);?>">
                    <span class="nk-icon-burger">
                        <span class="nk-t-1"></span>
                        <span class="nk-t-2"></span>
                        <span class="nk-t-3"></span>
                    </span>
                </a>
            </li>
        <?php endif; ?>
        <?php if ($side_navigation_show): ?>
            <li class="single-icon">
                <a href="#" data-nav-toggle="#nk-side"<?php echo khaki_get_theme_mod('side_navigation_white_icon') ? ' class="bg-white text-dark-1"' : '';?>>
                    <span class="nk-icon-burger">
                        <span class="nk-t-1"></span>
                        <span class="nk-t-2"></span>
                        <span class="nk-t-3"></span>
                    </span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
    <?php endif; ?>
<?php endif; ?>
<?php if (khaki_get_theme_mod('main_navigation_show_left_navigation_panel', $acf_navigation)): ?>
    <?php if ( has_nav_menu('primary') && khaki_get_theme_mod('main_navigation_mobile_show', $acf_navigation) && is_object( $main_menu ) && $main_menu->count > 0 ): ?>

            <ul class="nk-nav-toggler-left">
                <li class="single-icon d-lg-none">
                    <a href="#" data-nav-toggle="#nk-nav-mobile"<?php echo khaki_get_theme_mod('mobile_navbar_white_icon') ? ' class="bg-white text-dark-1"' : '';?>>
                        <span class="nk-icon-burger">
                            <span class="nk-t-1"></span>
                            <span class="nk-t-2"></span>
                            <span class="nk-t-3"></span>
                        </span>
                    </a>
                </li>
            </ul>
    <?php endif; ?>
    <!--&& khaki_get_theme_mod('main_navigation_show') need?-->
    <?php if (has_nav_menu('primary')): ?>
        <?php
        //defend additional classes
        $navbarAdditionalClasses = "";
        $navbarAdditionalClasses .= "nk-navbar nk-navbar-side nk-navbar-left";
        if (khaki_get_theme_mod('left_navigation_panel_lg')) {
            $navbarAdditionalClasses .= " nk-navbar-lg";
        }
        if (khaki_get_theme_mod('main_navigation_light')) {
            $navbarAdditionalClasses .= " nk-navbar-light";
        }
        if (khaki_get_theme_mod('left_navigation_panel_align')) {
            $navbarAdditionalClasses .= " nk-navbar-align-" . khaki_get_theme_mod('left_navigation_panel_align');
        }
        ?>
        <nav
            class="<?php if ($navbarAdditionalClasses) echo khaki_sanitize_class($navbarAdditionalClasses); ?>"
            id="nk-navbar-left">
            <div class="nano">
                <div class="nano-content">
                    <div class="nk-nav-table">
                        <div class="nk-nav-row">
                            <?php if ($main_navigation_logo): ?>
                                <?php $attachment = khaki_get_attachment($main_navigation_logo); ?>
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="nk-nav-logo">
                                    <img
                                        src="<?php echo esc_url($attachment['src']); ?>"
                                        alt="<?php if ($attachment['alt']) echo esc_attr($attachment['alt']); else get_bloginfo('name'); ?>"
                                        width="<?php echo esc_attr(khaki_get_theme_mod('main_navigation_logo_width')); ?>">
                                </a>
                            <?php endif; ?>

                            <ul class="nk-nav-icons">
                                <?php if(isset($main_navigation_custom_content) && !empty($main_navigation_custom_content) && $main_navigation_custom_content_position == 'before_icons'):?>
                                    <li><div><?php echo wp_kses_post(do_shortcode($main_navigation_custom_content));?></div></li>
                                <?php endif;?>
                                <?php
                                if(function_exists('khaki_login_with_ajax_from_navigation_panel_icon')):
                                    khaki_login_with_ajax_from_navigation_panel_icon('side_panel');
                                endif;
                                ?>
                                <?php khaki_small_cart(); ?>
                                <?php if(khaki_get_theme_mod('main_navigation_show_share_button') && function_exists('sociality')):?>
                                    <li>
                                        <a href="#" class="nk-share-toggle no-link-effect">
                                            <span class="ion-md-share"></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (khaki_get_theme_mod('main_navigation_show_search')): ?>
                                    <li>
                                        <a href="#" class="nk-search-toggle no-link-effect">
                                            <span class="nk-icon-search"></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if(isset($main_navigation_custom_content) && !empty($main_navigation_custom_content) && $main_navigation_custom_content_position == 'after_icons'):?>
                                    <li><div><?php echo wp_kses_post(do_shortcode($main_navigation_custom_content));?></div></li>
                                <?php endif;?>
                            </ul>


                        </div>
                        <!-- START: Navigation -->
                        <?php
                        //defend additional classes
                        $navbarAdditionalClasses = "";
                        $navbarAdditionalClasses .= "nk-nav-row nk-nav-row-full";
                        if ($left_navigation_panel_row_side) {
                            $navbarAdditionalClasses .= " nk-nav-row-" . $left_navigation_panel_row_side;
                        }
                        ?>
                        <?php if(isset($main_navigation_custom_content) && !empty($main_navigation_custom_content) && $main_navigation_custom_content_position == 'before_menu'):?>
                            <?php echo wp_kses_post(do_shortcode($main_navigation_custom_content));?>
                        <?php endif;?>
                        <div
                            class="<?php if ($navbarAdditionalClasses) echo khaki_sanitize_class($navbarAdditionalClasses); ?>">
                            <?php wp_nav_menu(array(
                                'theme_location' => 'primary',
                                'container' => '',
                                'menu_class' => 'nk-nav',
                                'walker' => new nk_walker_no_mega(),
                                'items_wrap' => '<ul id="%1$s" class="%2$s" data-nav-mobile="#nk-nav-mobile">%3$s</ul>'
                            )); ?>
                        </div>
                        <?php if(isset($main_navigation_custom_content) && !empty($main_navigation_custom_content) && $main_navigation_custom_content_position == 'after_menu'):?>
                            <?php echo wp_kses_post(do_shortcode($main_navigation_custom_content));?>
                        <?php endif;?>
                        <!--
                            END: Navigation
                        -->
                        <?php if ($left_navigation_panel_text): ?>
                            <div class="nk-nav-row">
                                <div class="nk-widget-social">
                                    <footer>
                                        <?php echo wp_kses_post($left_navigation_panel_text); ?>
                                    </footer>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    <?php endif; ?>
    <!-- END: Navbar -->
<?php endif; ?>


<!-- START: Right Navbar-->
<?php if (khaki_get_theme_mod('side_navigation_show', $acf_navigation)): ?>
    <?php
//defend additional classes
    $navbarAdditionalClasses = "";
    if (khaki_get_theme_mod('side_navigation_light')) {
        $navbarAdditionalClasses .= " nk-navbar-light";
    }
    if (khaki_get_theme_mod('side_navigation_overlay_content')) {
        $navbarAdditionalClasses .= " nk-navbar-overlay-content";
    }
    if (khaki_get_theme_mod('side_navigation_lg')) {
        $navbarAdditionalClasses .= " nk-navbar-lg";
    }
    if (khaki_get_theme_mod('side_navigation_blur')) {
        $navbarAdditionalClasses .= " nk-navbar-blur";
    }
    if (khaki_get_theme_mod('side_navigation_side')) {
        $navbarAdditionalClasses .= " nk-navbar-" . khaki_get_theme_mod('side_navigation_side') . "-side";
    }
    if (khaki_get_theme_mod('side_navigation_align')) {
        $navbarAdditionalClasses .= " nk-navbar-align-" . khaki_get_theme_mod('side_navigation_align');
    }
    ?>
    <nav
        class="nk-navbar nk-navbar-side<?php if ($navbarAdditionalClasses) echo khaki_sanitize_class($navbarAdditionalClasses); ?>"
        id="nk-side">
        <?php if (khaki_get_theme_mod('side_navigation_background_image')): ?>
            <div class="nk-navbar-bg nk-navbar-align-center">
                <div class="bg-image">
                    <?php
                    echo khaki_get_image( khaki_get_theme_mod('side_navigation_background_image'), 'khaki_1920x1080', false, array(
                        'class' => 'jarallax-img',
                    ) );
                    ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="nano">
            <div class="nano-content">
                <div class="nk-nav-table">
                    <?php
                    $navbarAdditionalClasses = 'nk-nav-row';
                    if (khaki_get_theme_mod('side_navigation_vertical_align')) {
                        $navbarAdditionalClasses .= " nk-nav-row-" . khaki_get_theme_mod('side_navigation_vertical_align');
                    }
                    ?>
                    <?php if ($side_navigation_logo): ?>
                        <?php $attachment = khaki_get_attachment($side_navigation_logo); ?>
                        <div class="<?php if ($navbarAdditionalClasses) echo khaki_sanitize_class($navbarAdditionalClasses); ?>">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="nk-nav-logo">
                                <img
                                    src="<?php echo esc_url($attachment['src']); ?>"
                                    alt="<?php if ($attachment['alt']) echo esc_attr($attachment['alt']); else get_bloginfo('name'); ?>"
                                    width="<?php echo esc_attr(khaki_get_theme_mod('side_navigation_logo_width')); ?>">
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="nk-nav-row-full <?php if ($navbarAdditionalClasses) echo khaki_sanitize_class($navbarAdditionalClasses); ?>">
                        <?php wp_nav_menu(array(
                            'theme_location' => 'side_navigation_menu',
                            'container' => '',
                            'menu_class' => 'nk-nav',
                            'walker' => new nk_walker(),
                        )); ?>
                    </div>
                        <div class="<?php if ($navbarAdditionalClasses) echo khaki_sanitize_class($navbarAdditionalClasses); ?>">
                            <div class="nk-widget-social nk-navbar-align-center">
                                <?php if(isset($side_navigation_social) && !empty($side_navigation_social) && is_array($side_navigation_social)):?>
                                <ul>
                                    <?php foreach ($side_navigation_social as $social_item): ?>
                                    <li><a href="<?php echo esc_url($social_item['link_url']); ?>" class="no-link-effect" target="<?php echo esc_attr($social_item['target']); ?>"><span class="<?php echo khaki_sanitize_class($social_item['icon']); ?>"></span></a></li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php endif; ?>
                                <?php if ($side_navigation_text): ?>
                                <footer>
                                    <?php echo wp_kses_post($side_navigation_text); ?>
                                </footer>
                                <?php endif; ?>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </nav>
<?php endif; ?>
<!-- END: Right Navbar -->

<!-- START: Fullscreen Navbar -->
<?php
//defend additional classes
$navbarAdditionalClasses = "";
if (khaki_get_theme_mod('fullscreen_navbar_light')) {
    $navbarAdditionalClasses .= " nk-navbar-light";
}
if (khaki_get_theme_mod('fullscreen_navbar_blur')) {
    $navbarAdditionalClasses .= " nk-navbar-blur";
}
if (khaki_get_theme_mod('fullscreen_navigation_align')) {
    $navbarAdditionalClasses .= " nk-navbar-align-" . khaki_get_theme_mod('fullscreen_navigation_align');
}
?>
<?php if (khaki_get_theme_mod('fullscreen_navbar_show', $acf_navigation)): ?>
    <nav
        class="nk-navbar nk-navbar-full<?php if ($navbarAdditionalClasses) echo khaki_sanitize_class($navbarAdditionalClasses); ?>"
        id="nk-full">
        <div class="nk-nav-table">
            <?php
            $navbarAdditionalClasses = '';
            if (khaki_get_theme_mod('fullscreen_navigation_vertical_align')) {
                $navbarAdditionalClasses .= " nk-nav-row-" . khaki_get_theme_mod('fullscreen_navigation_vertical_align');
            }
            ?>
            <div class="nk-nav-row-full nk-nav-row">
                <div class="nano">
                    <div class="nano-content">
                        <div class="nk-nav-table">
                            <div class="nk-nav-row nk-nav-row-full<?php echo khaki_sanitize_class($navbarAdditionalClasses);?>">
                                <?php wp_nav_menu(array(
                                    'theme_location' => 'fullscreen_navigation_menu',
                                    'container' => '',
                                    'menu_class' => 'nk-nav',
                                    'walker' => new nk_walker(),
                                )); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($fullscreen_navbar_text || $fullscreen_navigation_social): ?>
                <div class="nk-nav-row">
                    <div class="nk-widget-social">
                        <div class="container">
                            <div class="row">
                                <?php if(isset($fullscreen_navigation_social) && !empty($fullscreen_navigation_social) && is_array($fullscreen_navigation_social)):?>
                                <div class="col-sm-6 text-sm-left">
                                    <ul>
                                        <?php foreach ($fullscreen_navigation_social as $social_item): ?>
                                            <li><a href="<?php echo esc_url($social_item['link_url']); ?>" class="no-link-effect" target="<?php echo esc_attr($social_item['target']); ?>"><span class="<?php echo khaki_sanitize_class($social_item['icon']); ?>"></span></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <?php endif; ?>
                                <?php if ($fullscreen_navbar_text): ?>
                                <div class="col-sm-6 text-sm-right">
                                    <footer>
                                        <?php echo wp_kses_post($fullscreen_navbar_text); ?>
                                    </footer>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </nav>
<?php endif; ?>
<!-- END: Fullscreen Navbar -->

<!-- START: Navbar Mobile -->
<?php
//defend additional classes
$navbarAdditionalClasses = "";
if (khaki_get_theme_mod('mobile_navbar_light')) {
    $navbarAdditionalClasses .= " nk-navbar-light";
}
if (khaki_get_theme_mod('mobile_navbar_blur')) {
    $navbarAdditionalClasses .= " nk-navbar-blur";
}
if (khaki_get_theme_mod('mobile_navigation_overlay_content')) {
    $navbarAdditionalClasses .= " nk-navbar-overlay-content";
}
if (khaki_get_theme_mod('mobile_navigation_lg')) {
    $navbarAdditionalClasses .= " nk-navbar-lg";
}
if (khaki_get_theme_mod('mobile_navigation_align')) {
    $navbarAdditionalClasses .= " nk-navbar-align-" . khaki_get_theme_mod('mobile_navigation_align');
}
if (khaki_get_theme_mod('side_navigation_side')) {
    if (khaki_get_theme_mod('side_navigation_side') == 'right') {
        $side = 'left';
    } else {
        $side = 'right';
    }
    $navbarAdditionalClasses .= " nk-navbar-" . $side . "-side";
}

?>
<?php if ( khaki_get_theme_mod( 'main_navigation_mobile_show', $acf_navigation ) && is_object( $main_menu ) && $main_menu->count > 0 ): ?>
    <div id="nk-nav-mobile"
         class="nk-navbar nk-navbar-side d-lg-none<?php if ($navbarAdditionalClasses) echo khaki_sanitize_class($navbarAdditionalClasses); ?>">
        <div class="nano">
            <div class="nano-content">
                <?php
                $navbarAdditionalClasses = '';
                if (khaki_get_theme_mod('mobile_navigation_vertical_align')) {
                    $navbarAdditionalClasses .= " nk-nav-row-" . khaki_get_theme_mod('mobile_navigation_vertical_align');
                }
                ?>
                <div class="nk-nav-table">
                    <div class="nk-nav-row">
                    <?php if ($main_navigation_logo_mobile): ?>
                        <?php $attachment = khaki_get_attachment($main_navigation_logo_mobile); ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="nk-nav-logo">
                            <img
                                src="<?php echo esc_url($attachment['src']); ?>"
                                alt="<?php if ($attachment['alt']) echo esc_attr($attachment['alt']); else get_bloginfo('name'); ?>"
                                width="<?php echo esc_attr(khaki_get_theme_mod('main_navigation_logo_mobile_width')); ?>">
                        </a>
                    <?php endif; ?>
                    </div>
                    <div class="nk-nav-row nk-nav-row-full<?php echo khaki_sanitize_class($navbarAdditionalClasses);?>">
                        <div class="nk-navbar-mobile-content">
                            <ul class="nk-nav">
                                <!-- Here will be inserted menu from [data-mobile-menu="#nk-nav-mobile"] -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- END: Navbar Mobile -->


<div class="nk-main">
