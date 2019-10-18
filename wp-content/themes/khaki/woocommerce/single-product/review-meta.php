<?php
/**
 * The template to display the reviewers meta data (name, verified owner, review date)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review-meta.php.
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
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $comment;
$verified = wc_review_is_from_verified_owner( $comment->comment_ID );

if ( '0' === $comment->comment_approved ) { ?>

	<p class="meta">
        <em>
            <?php esc_html_e( 'Your comment is awaiting approval', 'khaki' ); ?>
        </em>
    </p>

<?php } else { ?>
	<div class="nk-comment-name h5">
		<?php comment_author(); ?>
		<?php

		/**
		 * The woocommerce_review_before_comment_meta hook.
		 *
		 * @hooked woocommerce_review_display_rating - 10
		 */
		do_action('woocommerce_review_before_comment_meta', $comment);
		?>
	</div>
		<?php

		if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $verified ) {
			echo '<em class="verified">(' . esc_attr__( 'verified owner', 'khaki' ) . ')</em> ';
		}

		?>
	<div class="nk-comment-date" datetime="<?php echo get_comment_date( 'c' ); ?>">
		<?php echo esc_html( get_comment_date( wc_date_format() ) ); ?>
        <?php
        if (function_exists('sociality')) {
            echo sociality()->likes()->get_likes(get_comment_ID(), 'wc_review');
        }
        ?>
	</div>
<?php }
