<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $product;
if ( $upsells ) : ?>

	<?php if ( wc_get_related_products($product->get_id()) ) : ?>
		<div class="nk-gap-3"></div>
	<?php endif;?>

	<?php
	$classes = 'nk-store nk-carousel-2 nk-carousel-no-margin nk-carousel-all-visible';
	if(count($upsells)>=6){
		$classes .= ' nk-carousel-x4';
	} else{
		$classes .= ' nk-carousel-x2';
	}?>

		<h2><?php esc_html_e( 'You may also like&hellip;', 'khaki' ) ?></h2>
	
		<div class="<?php echo khaki_sanitize_class($classes);?>">
			<div class="nk-carousel-inner">

				<?php foreach ( $upsells as $upsell ) : ?>

					<?php
					$post_object = get_post( $upsell->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object );

					wc_get_template_part( 'loop', 'product' ); ?>

				<?php endforeach; ?>

			</div>
		</div>

<?php endif;

wp_reset_postdata();
