<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
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
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $post;
$post_type = 'woocommerce';
$acf_sidebar = false;
if(is_product()) {
	$acf_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_custom', true);
}
$custom_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_list', $acf_sidebar);
$show_custom_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_show', $acf_sidebar);
$custom_sidebar_side = khaki_get_theme_mod('sidebar_' . $post_type . '_side', $acf_sidebar);
// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

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
	<div <?php wc_product_class( 'nk-product', $product ); ?>>
	<?php
	/**
     * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

	/**
     * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
     * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	do_action( 'woocommerce_shop_loop_item_title' );
	?>

		<div class="nk-product-category">
			<?php echo wc_get_product_category_list( $product->get_id(), ', ', _n( 'In', 'In', count( $product->get_category_ids() ), 'khaki' ) . ' '); ?>
		</div>

		<h2 class="nk-product-title h5"><a href="<?php echo esc_url(get_permalink());?>"><?php echo get_the_title();?></a></h2>

		<?php
	/**
     * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
     * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
	?>
	</div>
</div>	
