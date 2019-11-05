<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
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
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>

<div class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">

		<?php

        do_action( 'woocommerce_before_mini_cart_contents' );

			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
					$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<div class="nk-widget-post woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
						<?php if ( empty( $product_permalink ) ) : ?>
							<span class="nk-image-box-1 nk-post-image">
                            <?php echo $thumbnail; ?>
							</span>
						<?php else : ?>
							<a href="<?php echo esc_url( $product_permalink ); ?>" class="nk-image-box-1 nk-post-image">
                                <?php echo $thumbnail; ?>
							</a>
						<?php endif; ?>
						<h3 class="nk-post-title">
							<a href="<?php echo esc_url( $product_permalink ); ?>"><?php echo esc_html($product_name);?></a>
							<?php
							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
								'<a href="%s" class="no-fade trash-small-cart float-right remove_from_cart_button" title="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><span class="ion-ios-trash"></span></a>',
								esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
								esc_html__( 'Remove this item', 'khaki' ),
								esc_attr( $product_id ),
                                esc_attr( $cart_item_key ),
								esc_attr( $_product->get_sku() )
							), $cart_item_key );
							?>
						</h3>
						<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>

						<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity nk-post-meta-date">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
					</div>
					<?php
				}
			}
		?>


</div><!-- end product list -->

<?php else : ?>

    <p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'khaki' ); ?></p>

<?php endif; ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>
<div class="nk-gap"></div>
	<p class="woocommerce-mini-cart__total total"><strong><?php esc_html_e( 'Subtotal', 'khaki' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<p class="woocommerce-mini-cart__buttons buttons">
        <?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?>
	</p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>

<div class="khaki_hide_small_cart" data-cart-count="<?php echo esc_attr(WC()->cart->get_cart_contents_count());?>">
	<?php
	$cart_is_not_empty = false;
	if(WC()->cart->get_cart()){
		$cart_is_not_empty = true;
	}
	 ?>
	<?php if($cart_is_not_empty):?>
		<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ):?>
			<?php
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ):?>
				<div class="nk-widget-post">
					<?php
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('khaki_800x600'), $cart_item, $cart_item_key );

					if ( ! $product_permalink ) {
						echo $thumbnail;
					} else {
						printf( '<a href="%s" class="nk-image-box-1 nk-post-image">%s</a>', esc_url( $product_permalink ), $thumbnail );
					}
					?>
					<h3 class="nk-post-title">
						<?php
						echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
							'<a href="%s" class="no-fade trash-small-cart float-right remove_from_cart_button" title="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><span class="ion-ios-trash"></span></a>',
							esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
							esc_html__( 'Remove this item', 'khaki' ),
							esc_attr( $product_id ),
                            esc_attr( $cart_item_key ),
							esc_attr( $_product->get_sku() )
						), $cart_item_key );
						?>
						<?php
						if ( ! $product_permalink ) {
							echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
						} else {
							echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
						}
						?>
					</h3>
					<div class="nk-product-price">
						<?php
						if ( $_product->is_sold_individually() ) {
							$product_quantity = '1';
						} else {
							$product_quantity = $cart_item['quantity'];
						}

						echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
						?> &times; <?php
						echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						?>
					</div>
				</div>
			<?php endif; ?>
		<?php endforeach;?>
		<div class="nk-widget-store-cart-total">
			<a href="<?php echo wp_nonce_url(WC()->cart->get_cart_url(), 'empty_cart');?>&clear-cart=true"><span class="ion-ios-trash"></span> <?php esc_html_e('Empty Cart', 'khaki');?></a>
			<span><?php wc_cart_totals_subtotal_html();?></span>
		</div>

	<?php endif; ?>
	<?php if($cart_is_not_empty == false):?>
		<span class="text-center"><?php esc_html_e('Your cart is empty!', 'khaki'); ?></span>
	<?php endif;?>
	<?php if($cart_is_not_empty):?>
		<div class="nk-widget-store-cart-actions">
            <div class="btn-group">
                <a class="nk-btn nk-btn-rounded nk-btn-color-white text-dark-1" href="<?php echo esc_url(WC()->cart->get_cart_url());?>">
                    <span class="icon"><span class="ion-md-cart"></span></span> <?php esc_html_e('View Cart', 'khaki'); ?>
                </a>
                <a class="nk-btn nk-btn-rounded nk-btn-color-white text-dark-1" href="<?php echo esc_url(WC()->cart->get_checkout_url());?>">
                    <?php esc_html_e('Checkout', 'khaki'); ?>
                </a>
            </div>
		</div>
	<?php endif;?>
</div>
