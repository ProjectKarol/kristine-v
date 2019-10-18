<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     3.6.0
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

global $product;

if (!comments_open()) {
	return;
}

?>
<?php
$option_rating_count_name = 'khaki_rating_count' . $product->get_id();
$option_rating_collect_marks_name = 'khaki_collect_review_mark' . $product->get_id();
$rating_count = get_option($option_rating_count_name);
$current_rating_count = $product->get_rating_count();
if ($rating_count != $current_rating_count) {
	if (!$rating_count) {
		add_option($option_rating_count_name, $current_rating_count, '', 'no');
	} else {
		update_option($option_rating_count_name, $current_rating_count);
	}

	$collect_marks = array(5=>0,4=>0,3=>0,2=>0,1=>0);
	$args = array(
		'orderby' => 'date',
		'post_type' => 'product',
		'post_id' => $product->get_id()
	);
	$comments = get_comments($args);
	$mark_count = 0;
	foreach($comments as $comment){
		if($comment->comment_approved){
			$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
			$collect_marks[$rating] += 1;
			$mark_count++;
		}
	}
	foreach($collect_marks as $key=>$mark){
		$collect_marks[$key]=round(($mark/$mark_count)*100, 2);
	}

	add_option($option_rating_collect_marks_name, $collect_marks, '', 'no');
	update_option($option_rating_collect_marks_name, $collect_marks);
} else {
	$collect_marks = get_option($option_rating_collect_marks_name);
}

?>
<div class="row vertical-gap">
	<?php if (isset($collect_marks) && !empty($collect_marks) && is_array($collect_marks)): ?>
		<div class="col-md-6">
			<div class="nk-box-2 bg-gray-2">
				<h3 class="nk-title h4"><?php echo esc_html('Reviews Summary', 'khaki'); ?></h3>
				<div class="nk-gap"></div>
				<?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
				<br>
                <small><?php printf (esc_html( '%s out of 5', 'khaki' ), round( $product->get_average_rating(), 2 ) ); ?></small>
				<div class="nk-product-progress">
					<table>
						<?php foreach ($collect_marks as $key => $mark): ?>
							<tr>
								<td><?php printf(esc_html__('%s Star', 'khaki'), $key); ?></td>
								<td>
									<div class="nk-progress nk-progress-percent-static nk-count"
										 data-progress="<?php echo esc_attr($mark); ?>">
										<div class="nk-progress-line">
											<div style="width: <?php echo esc_attr($mark); ?>%;">
												<div class="nk-progress-percent"><?php echo esc_html($mark); ?>%</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					</table>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<div class="col-md-6">
		<div class="nk-box-2 bg-gray-2">
			<?php if (get_option('woocommerce_review_rating_verification_required') === 'no' || wc_customer_bought_product('', get_current_user_id(), $product->get_id())) : ?>
				<h3 class="nk-title h4"><?php esc_html_e('Add a Review', 'khaki');?></h3>
				<div class="nk-gap"></div>
				<div class="nk-reply mt-0">
					<div id="review_form_wrapper">
						<div id="review_form">
							<?php
							$commenter = wp_get_current_commenter();
							$rating_field = '';
							if ( wc_review_ratings_enabled() ) {
								$rating_field='<div class="comment-form-rating"><select name="rating" id="rating" required>
							<option value="">' . esc_html__( 'Rate&hellip;', 'khaki' ) . '</option>
							<option value="5">' . esc_html__( 'Perfect', 'khaki' ) . '</option>
							<option value="4">' . esc_html__( 'Good', 'khaki' ) . '</option>
							<option value="3">' . esc_html__( 'Average', 'khaki' ) . '</option>
							<option value="2">' . esc_html__( 'Not that bad', 'khaki' ) . '</option>
							<option value="1">' . esc_html__( 'Very poor', 'khaki' ) . '</option>
						</select></div>';
							}
							$comment_form = array(
								'title_reply' => '',
                                'title_reply_before'   => '',
                                'title_reply_after'    => '',
								'title_reply_to' => esc_html__('Leave a Reply to %s', 'khaki'),
								'fields' => array(
									'rating'=>'',
									'author' => '<div class="nk-gap"></div><div class="row vertical-gap">
<div class="col-sm-6"><input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" required class="form-control required" placeholder="'.esc_html__('Name *', 'khaki').'"/></div>',
									'email' => '<div class="col-sm-6"><input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" class="form-control required" required placeholder="'.esc_html__('Email *', 'khaki').'"/></div>
                                        </div>',
								),
								'label_submit' => esc_html__('Submit', 'khaki'),
								'logged_in_as' => '',
								'comment_field' => '',
								'class_form' => 'nk-form nk-form-style-1',
								'comment_notes_after' => '<button type="submit" id="submit" class="nk-btn nk-btn-color-dark-1 float-right">' . esc_html__('Submit', 'khaki') . '</button>',
								'class_submit' => 'hidden button',
							);

							if ($account_page_url = wc_get_page_permalink('myaccount')) {
								$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf(__('You must be <a href="%s">logged in</a> to post a review.', 'khaki'), esc_url($account_page_url)) . '</p>';
							}

							if ( wc_review_ratings_enabled() ) {
								if(is_user_logged_in()){
									$comment_form['comment_field']=$rating_field;
								}else{
									$comment_form['fields']['rating']=$rating_field;
								}
							}

							$comment_form['comment_field'] .= '<div class="nk-gap-1"></div><textarea class="form-control required" id="comment" name="comment"rows="5" required placeholder="' . esc_html__('Your Review *', 'khaki') . '"></textarea><div class="nk-gap-1"></div>';

							comment_form(apply_filters('woocommerce_product_review_comment_form_args', $comment_form));
							?>
						</div>
					</div>
				</div>
			<?php else : ?>

				<p class="woocommerce-verification-required"><?php esc_html_e('Only logged in customers who have purchased this product may leave a review.', 'khaki'); ?></p>

			<?php endif; ?>
		</div>
	</div>
</div>

<div class="nk-gap"></div>
<div class="nk-comments mb-0" id="reviews">
	<div id="comments">
		<?php if (have_comments()) : ?>

			<?php wp_list_comments(apply_filters('woocommerce_product_review_list_args', array('callback' => 'woocommerce_comments'))); ?>

			<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) :

				$page_links = paginate_comments_links(apply_filters('nk_pagination_args', array(
					'prev_text' => '<span class="nk-icon-arrow-left"></span>',
					'next_text' => '<span class="nk-icon-arrow-right"></span>',
					'type' => 'array',
					'end_size' => 3,
					'mid_size' => 3,
					'echo' => false
				)));
				if (is_array($page_links)):
					$page_prev_or_next_links = $page_links;
					$prev_link = array_shift($page_prev_or_next_links);
					$next_link = array_pop($page_prev_or_next_links);
			 ?>
			<div class="nk-pagination nk-pagination-center">
				<?php if (isset($prev_link)): ?>
					<?php if (strpos($prev_link, 'prev page-numbers') !== false): ?>
						<?php echo(str_replace('prev page-numbers', khaki_sanitize_class('nk-pagination-prev'), $prev_link)); ?>
					<?php else: ?>
						<a href="#"
						   class="nk-pagination-prev <?php echo khaki_sanitize_class( strpos($prev_link, 'current') !== false ? 'disabled' : ''); ?>">
							<span class="nk-icon-arrow-left"></span>
						</a>
					<?php endif; ?>
				<?php endif; ?>
				<nav>
					<?php foreach ($page_links as $cur) : ?>
						<?php
						if ((strpos($cur, 'prev page-numbers') === false) && (strpos($cur, 'next page-numbers') === false)):
							if (strpos($cur, 'current') !== false):
								$cur = str_replace('page-numbers current', khaki_sanitize_class('nk-pagination-current-white'), $cur);
							else:
								if (strpos($cur, 'dots') !== false):
									$cur = str_replace('class="page-numbers dots"', '', $cur);
								else:
									$cur = str_replace('class="page-numbers"', '', $cur);
								endif;
							endif;
							echo wp_kses_post($cur);
						endif; ?>
					<?php endforeach; ?>
				</nav>
				<?php if (isset($next_link)): ?>
					<?php if (strpos($next_link, 'next page-numbers') !== false): ?>
						<?php echo(str_replace('next page-numbers', khaki_sanitize_class('nk-pagination-next'), $next_link)); ?>
					<?php else: ?>
						<a href="#"
						   class="nk-pagination-next <?php echo khaki_sanitize_class( strpos($next_link, 'current') !== false ? 'disabled' : ''); ?>">
							<span class="nk-icon-arrow-right"></span>
						</a>
					<?php endif; ?>
				<?php endif; ?>
			</div>
				<?php endif;?>
		<?php endif;?>
		<?php else : ?>

			<p class="woocommerce-noreviews"><?php esc_html_e('There are no reviews yet.', 'khaki'); ?></p>

		<?php endif; ?>
	</div>


	<div class="clear"></div>

</div>
