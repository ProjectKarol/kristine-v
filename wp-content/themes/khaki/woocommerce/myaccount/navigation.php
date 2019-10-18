<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
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
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
?>
<!--start row-->
<div class="row vertical-gap">
<div class="col-lg-4">
	<aside class="nk-sidebar nk-sidebar-left nk-sidebar-sticky" data-offset-top="20">
		<div class="nk-gap-4"></div>
		<div class="nk-doc-links">
			<ul>
				<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
					<?php
					$classes = wc_get_account_menu_item_classes( $endpoint );
					$classes = strpos($classes, 'is-active')!==false ? str_replace('is-active', 'active', $classes) : $classes;
					?>
					<li class="<?php echo khaki_sanitize_class( $classes ); ?>">
						<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="nk-gap-4"></div>
	</aside>
</div>
<?php do_action( 'woocommerce_after_account_navigation' ); ?>
