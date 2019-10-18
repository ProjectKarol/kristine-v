<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product_cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$post_type = 'woocommerce';
$custom_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_list');
$show_custom_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_show');
$custom_sidebar_side = khaki_get_theme_mod('sidebar_' . $post_type . '_side');

$product_class = 'col-sm-6';
if($custom_sidebar && $show_custom_sidebar){
    if (isset($custom_sidebar_side)) {
        if ($custom_sidebar_side === 'left' || $custom_sidebar_side === 'right') {
            $product_class .= ' col-md-4';
        }elseif($custom_sidebar_side === 'both'){
            $product_class .= ' col-md-6';
        }
    }
} else{
    $product_class .= ' col-md-4 col-lg-3';
}
?>
<div class="<?php echo khaki_sanitize_class($product_class);?>">
    <div <?php wc_product_cat_class( 'nk-product', $category ); ?>>
        <div>
            <?php
            /**
             * woocommerce_before_subcategory hook.
             *
             * @hooked woocommerce_template_loop_category_link_open - 10
             */
            do_action( 'woocommerce_before_subcategory', $category );

            /**
             * woocommerce_before_subcategory_title hook.
             *
             * @hooked woocommerce_subcategory_thumbnail - 10
             */
            do_action( 'woocommerce_before_subcategory_title', $category );

            /**
             * woocommerce_shop_loop_subcategory_title hook.
             *
             * @hooked woocommerce_template_loop_category_title - 10
             */
            do_action( 'woocommerce_shop_loop_subcategory_title', $category );

            /**
             * woocommerce_after_subcategory_title hook.
             */
            do_action( 'woocommerce_after_subcategory_title', $category );

            /**
             * woocommerce_after_subcategory hook.
             *
             * @hooked woocommerce_template_loop_category_link_close - 10
             */
            do_action( 'woocommerce_after_subcategory', $category ); ?>
        </div>
    </div>
</div>