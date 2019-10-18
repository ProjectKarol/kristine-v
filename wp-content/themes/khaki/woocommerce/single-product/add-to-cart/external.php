<?php
/**
 * External product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/external.php.
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
 * @version     3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

    <form class="cart nk-form nk-form-style-1 nk-product-addtocart" action="<?php echo esc_url( $product_url ); ?>" method="get">
        <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
        <?php echo $product->get_price_html();?>
        <div class="input-group">
            <button type="submit" class="single_add_to_cart_button nk-btn nk-btn-color-dark-1 alt"><span class="icon"><span class="ion-md-cart"></span></span><?php echo esc_html( $button_text ); ?></button>
        </div>
        <?php wc_query_string_form_fields( $product_url ); ?>

        <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
    </form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
