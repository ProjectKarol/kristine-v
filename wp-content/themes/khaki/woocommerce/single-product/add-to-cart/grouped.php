<?php
/**
 * Grouped product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/grouped.php.
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

global $product, $post;

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="cart nk-form nk-form-style-1 nk-product-addtocart" method="post" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" enctype='multipart/form-data' novalidate="novalidate">
	<table cellspacing="0" class="group_table table">
		<tbody>
		<?php
		$quantites_required = false;
        $previous_post      = $post;
		foreach ( $grouped_products as $grouped_product_child ) {
			$post_object        = get_post( $grouped_product_child->get_id() );
			$quantites_required = $quantites_required || ( $grouped_product_child->is_purchasable() && ! $grouped_product_child->has_options() );

            setup_postdata( $post =& $post_object );
			?>
			<tr id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
				<td>
					<?php if ( ! $grouped_product_child->is_purchasable() || $grouped_product_child->has_options() ) : ?>
						<?php woocommerce_template_loop_add_to_cart(); ?>

					<?php elseif ( $grouped_product_child->is_sold_individually() ) : ?>
						<input type="checkbox" name="<?php echo esc_attr( 'quantity[' . $grouped_product_child->get_id() . ']' ); ?>" value="1" class="wc-grouped-product-add-to-cart-checkbox" />

					<?php else : ?>
						<?php
						/**
						 * @since 3.0.0.
						 */
						do_action( 'woocommerce_before_add_to_cart_quantity' );

						woocommerce_quantity_input( array(
							'input_name'  => 'quantity[' . $grouped_product_child->get_id() . ']',
							'input_value' => isset( $_POST['quantity'][ $grouped_product_child->get_id() ] ) ? wc_stock_amount( $_POST['quantity'][ $grouped_product_child->get_id() ] ) : 0,
							'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 0, $grouped_product_child ),
							'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $grouped_product_child->get_max_purchase_quantity(), $grouped_product_child ),
						) );

						/**
						 * @since 3.0.0.
						 */
						do_action( 'woocommerce_after_add_to_cart_quantity' );
						?>
					<?php endif; ?>
				</td>
				<?php do_action( 'woocommerce_grouped_product_list_before_price', $grouped_product_child ); ?>
				<td class="price nk-product-price">
					<?php
					echo $grouped_product_child->get_price_html();
					echo wc_get_stock_html( $grouped_product_child );
					?>
				</td>
				<td class="label text-right">
					<label for="product-<?php echo $grouped_product_child->get_id(); ?>">
						<?php echo $grouped_product_child->is_visible() ? '<a href="' . esc_url( apply_filters( 'woocommerce_grouped_product_list_link', get_permalink( $grouped_product_child->get_id() ), $grouped_product_child->get_id() ) ) . '">' . $grouped_product_child->get_name() . '</a>' : $grouped_product_child->get_name(); ?>
					</label>
				</td>
			</tr>
			<?php
		}
        $post =& $previous_post; // WPCS: override ok.
        setup_postdata( $post );
		?>
		</tbody>
	</table>

	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />

	<?php if ( $quantites_required ) : ?>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<button type="submit" class="single_add_to_cart_button nk-btn nk-btn-color-dark-1 alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<?php endif; ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
