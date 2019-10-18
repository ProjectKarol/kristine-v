<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
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
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header();
get_template_part('/template-parts/header/woocommerce');

//use acf settings (return true or null)
$acf_meta = khaki_get_theme_mod('woocommerce_meta_custom', true);
$acf_sidebar = khaki_get_theme_mod('sidebar_woocommerce_custom', true);
$acf_content = khaki_get_theme_mod('content_woocommerce_custom', true);

$custom_sidebar = khaki_get_theme_mod('sidebar_woocommerce_list', $acf_sidebar);
$show_custom_sidebar = khaki_get_theme_mod('sidebar_woocommerce_show', $acf_sidebar);
$custom_sidebar_side = khaki_get_theme_mod('sidebar_woocommerce_side', $acf_sidebar);

$col_class = 'col-12';

if ($show_custom_sidebar && $custom_sidebar && is_active_sidebar($custom_sidebar)) {
    if (isset($custom_sidebar_side) && $custom_sidebar_side === 'both') {
        $col_class = 'col-lg-6';
    } else {
        $col_class = 'col-lg-8';
    }
}
?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>


<div class="<?php echo khaki_sanitize_class(khaki_get_theme_mod('woocommerce_inner_boxed', $acf_content) ? 'container' : 'container-fluid'); ?>">

	<div class="row">

		<div class="<?php echo khaki_sanitize_class($col_class); ?>">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>

		</div>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>
	</div>
</div>


	<?php
	/**
	 * woocommerce_after_main_content hook.
	 *
	 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
	 */
	do_action( 'woocommerce_after_main_content' );
	?>

<?php get_footer( 'shop' ); ?>
