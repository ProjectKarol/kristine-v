<?php

/**
 * Pagination for pages of search results 
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_pagination_loop' ); ?>


<!-- START: Pagination -->

<div class="bbp-pagination">
	<div class="bbp-pagination-count">

		<?php bbp_search_pagination_count(); ?>

	</div>
</div>

<div class="bbp-pagination-links">

		<?php khaki_bb_output_pagination(bbp_get_search_pagination_links()); ?>

</div>
<div class="nk-gap-2"></div>
<!-- END: Pagination -->

<?php do_action( 'bbp_template_after_pagination_loop' ); ?>
