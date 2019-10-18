<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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


get_header();
get_template_part('/template-parts/header/woocommerce');


//use acf settings (return true or null)
$acf_meta = false;
$acf_sidebar = false;
$acf_content = false;
if(is_product()){
	$acf_meta = khaki_get_theme_mod('woocommerce_meta_custom', true);
	$acf_sidebar = khaki_get_theme_mod('sidebar_woocommerce_custom', true);
	$acf_content = khaki_get_theme_mod('content_woocommerce_custom', true);
}

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
            <?php if (!khaki_get_theme_mod('woocommerce_header_show', false) && khaki_get_theme_mod('woocommerce_show_title', false)): ?>
                <!-- START: Header Title -->
                <div class="nk-gap-4"></div>
                <div class="container">
                    <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
                        <h1 class="nk-title">
                            <?php if(is_post_type_archive() || is_search() || is_tax()){
                                woocommerce_page_title();
                            }else{
                                echo get_the_title();
                            } ?>
                        </h1>
                    <?php endif; ?>
                </div>
                <!-- END: Header Title -->
            <?php endif; ?>
            <div class="nk-gap-4"></div>
            <div class="nk-store">

		<?php
			/**
			 * woocommerce_archive_description hook.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>

		<?php if ( woocommerce_product_loop() ) { ?>

			<?php
                // START: Sort Order
				/**
				 * woocommerce_before_shop_loop hook.
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );

                // END: Sort Order
			?>

            <div class="nk-gap-4"></div>

            <?php
            woocommerce_product_loop_start();
            if ( wc_get_loop_prop( 'total' ) ) {
                while ( have_posts() ) {
                    the_post();
                    /**
                     * Hook: woocommerce_shop_loop.
                     *
                     * @hooked WC_Structured_Data::generate_product_data() - 10
                     */
                    do_action( 'woocommerce_shop_loop' );
                    wc_get_template_part( 'content', 'product' );
                }
            }
            woocommerce_product_loop_end();
            ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

        <?php } else {
            /**
             * Hook: woocommerce_no_products_found.
             *
             * @hooked wc_no_products_found - 10
             */
            do_action('woocommerce_no_products_found');

        } ?>

            </div>

            <div class="nk-gap-4"></div>

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
<?php get_footer(); ?>
