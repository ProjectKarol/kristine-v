<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
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

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post" novalidate="novalidate" class="nk-form nk-form-style-1 woocommerce-cart-form">

<?php do_action( 'woocommerce_before_cart_table' ); ?>
	<div class="nk-store nk-store-cart">
		<div class="table-responsive">
<table class="shop_table shop_table_responsive cart table nk-store-cart-products woocommerce-cart-form__contents" cellspacing="0">
	<thead class="thead-default">
		<tr>
			<th class="nk-product-cart-thumb"><?php esc_html_e('Product', 'khaki');?></th>
			<th class="nk-product-cart-title"><span class="sr-only"><?php esc_html_e('Product', 'khaki');?></span></th>
			<th class="nk-product-cart-price"><?php esc_html_e('Price', 'khaki');?></th>
			<th class="nk-product-cart-quantity"><?php esc_html_e('Quantity', 'khaki');?></th>
			<th class="nk-product-cart-total"><?php esc_html_e('Total', 'khaki');?></th>
			<th class="nk-product-cart-remove">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

					<td class="product-thumbnail nk-product-cart-thumb">
						<?php
						$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('khaki_800x600'), $cart_item, $cart_item_key );

						if ( ! $product_permalink ) {
                            echo wp_kses_post( $thumbnail );
						} else {
							printf( '<a href="%s" class="nk-image-box-1 nk-post-image">%s</a>', esc_url( $product_permalink ), wp_kses_post( $thumbnail ) );
						}
						?>
					</td>

					<td class="product-name nk-product-cart-title" data-title="<?php esc_html_e( 'Product', 'khaki' ); ?>">
						<?php
						if ( ! $product_permalink ) {
                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                        } else {
                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
						}

                        do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

						// Meta data
                        echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

						// Backorder notification
						if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'khaki' ) . '</p>', $product_id ) );
                        }
						?>
					</td>

					<td class="product-price nk-product-cart-price" data-title="<?php esc_html_e( 'Price', 'khaki' ); ?>">
						<?php
						echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
						?>
					</td>

					<td class="product-quantity nk-product-cart-quantity" data-title="<?php esc_html_e( 'Quantity', 'khaki' ); ?>">
						<?php
						if ( $_product->is_sold_individually() ) {
							$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
						} else {
							$product_quantity = woocommerce_quantity_input( array(
								'input_name'  => "cart[{$cart_item_key}][qty]",
								'input_value' => $cart_item['quantity'],
								'max_value'   => $_product->get_max_purchase_quantity(),
								'min_value'   => '0',
								'product_name' => $_product->get_name(),
							), $_product, false );
						}

						echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
						?>
					</td>

					<td class="product-subtotal nk-product-cart-total" data-title="<?php esc_html_e( 'Total', 'khaki' ); ?>">
						<?php
						echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
						?>
					</td>

					<td class="product-remove nk-product-cart-remove">
						<?php
						echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
							'<a href="%s" class="no-fade" title="%s" data-product_id="%s" data-product_sku="%s"><span class="ion-ios-trash"></span></a>',
                            esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
							esc_html__( 'Remove this item', 'khaki' ),
							esc_attr( $product_id ),
							esc_attr( $_product->get_sku() )
						), $cart_item_key );
						?>
					</td>

				</tr>
				<?php
			}
		}

		do_action( 'woocommerce_cart_contents' );
		?>
		<tr>
			<td colspan="6" class="actions khaki-hide-border">
				<?php if ( wc_coupons_enabled() ) { ?>
					<div class="coupon">

						<div class="input-group">
							<input type="text" name="coupon_code" class="form-control" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'khaki' ); ?>" />
                            <span class="nk-btn nk-btn-color-dark-1"><?php esc_html_e( 'Apply Coupon', 'khaki' ); ?><input type="submit" class="khaki-wc-submit" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'khaki' ); ?>" /></span>
						</div>

						<?php do_action( 'woocommerce_cart_coupon' ); ?>
					</div>
				<?php } ?>

				<span class="nk-btn nk-btn-color-dark-1 float-right khaki-shadow-button" id="khaki-cart-update">
					<span class="icon"><span class="ion-md-refresh"></span></span> <?php esc_html_e( 'Update Cart', 'khaki' ); ?>
					<input type="submit" class="khaki-wc-submit" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'khaki' ); ?>" />
				</span>

				<?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>

			</td>
		</tr>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</tbody>
</table>

<?php do_action( 'woocommerce_after_cart_table' ); ?>
		</div>
	</div>
</form>
<div class="nk-store nk-store-cart">
	<div class="clearfix"></div>
	<div class="nk-gap-2"></div>
	<div class="cart-collaterals">

		<?php
        /**
         * woocommerce_cart_collaterals hook.
         *
         * @hooked woocommerce_cross_sell_display
         * @hooked woocommerce_cart_totals - 10
         */
        do_action( 'woocommerce_cart_collaterals' ); ?>

	</div>
</div>
<?php do_action( 'woocommerce_after_cart' ); ?>
