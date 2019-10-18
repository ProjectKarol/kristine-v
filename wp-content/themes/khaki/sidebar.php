<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package khaki
 */

$post_type = get_post_type();
$header_show_option_prefix = $post_type;
if (!$post_type) {
    $post_type = 'page';
    $header_show_option_prefix = 'single_page';
}

if($post_type == 'product'){
    $post_type = 'woocommerce';
}
if($post_type == 'post'){
    $header_show_option_prefix = 'single_post';
}
$acf_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_custom', true);
$acf_header = khaki_get_theme_mod($post_type . '_header_custom', true);
$acf_meta = khaki_get_theme_mod($post_type . '_meta_custom', true);

if(function_exists('is_shop')){
    if(is_shop() || is_product_category() || is_product_tag()){
        $acf_sidebar = $acf_header = $acf_meta = false;
    }
}

$custom_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_list', $acf_sidebar);
$custom_sidebar_additional = khaki_get_theme_mod('sidebar_' . $post_type . '_additional_list', $acf_sidebar);
$show_custom_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_show', $acf_sidebar);
if ($custom_sidebar && $show_custom_sidebar && (is_active_sidebar($custom_sidebar) || is_active_sidebar($custom_sidebar_additional))):?>
    <?php
    $custom_sidebar_side = khaki_get_theme_mod('sidebar_' . $post_type . '_side', $acf_sidebar);
    $custom_sidebar_sticky = khaki_get_theme_mod('sidebar_' . $post_type . '_sticky', $acf_sidebar);
    $sidebar_class = 'nk-sidebar nk-sidebar-' . $post_type;
    $order_class = 'col-lg-4 order-lg-last';
    $sticky_class = '';
    $side_class = '';
    if (isset($custom_sidebar_side)) {
        if ($custom_sidebar_side === 'left') {
            $order_class = 'col-lg-4 order-lg-first';
        }
        $side_class = ' nk-sidebar-' . $custom_sidebar_side;

        if ($custom_sidebar_side === 'both') {
            $order_class = 'col-lg-3 order-lg-first';
            $side_class = ' nk-sidebar-left';
        }
    }
    if ($custom_sidebar_sticky) {
        $sticky_class = ' nk-sidebar-sticky';
    }
    ?>
    <?php if(is_active_sidebar($custom_sidebar)):?>
        <div class="<?php echo khaki_sanitize_class($order_class); ?>">
            <!-- START: Sidebar -->
            <aside class="<?php echo khaki_sanitize_class($sidebar_class . $side_class . $sticky_class); ?>" data-offset-top="20">
                <div class="nk-gap-4"></div>
                <?php dynamic_sidebar($custom_sidebar); ?>
                <div class="nk-gap-4"></div>
            </aside><!-- #secondary -->
        </div>
    <?php endif; ?>
    <?php if($custom_sidebar_side === 'both' && is_active_sidebar($custom_sidebar_additional)):?>
        <div class="col-lg-3 order-lg-last">
            <aside class="<?php echo khaki_sanitize_class($sidebar_class . ' nk-sidebar-right' . $sticky_class); ?>" data-offset-top="20">
                <div class="nk-gap-4"></div>
                <?php dynamic_sidebar($custom_sidebar_additional); ?>
                <div class="nk-gap-4"></div>
            </aside>
        </div>
    <?php endif; ?>
<?php endif; ?>
