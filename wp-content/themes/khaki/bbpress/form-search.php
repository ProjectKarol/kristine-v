<?php

/**
 * Search
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<form role="search" method="get" id="bbp-search-form" class="nk-form nk-form-style-1" action="<?php bbp_search_url(); ?>">
	<div class="input-group">
		<input type="hidden" name="action" value="bbp-search-request" />
		<input tabindex="<?php bbp_tab_index(); ?>" type="text" value="<?php echo esc_attr( bbp_get_search_terms() ); ?>" name="bbp_search" id="bbp_search" class="form-control" placeholder="<?php esc_html_e( 'Search for:', 'khaki' ); ?>"/>
        <button tabindex="<?php bbp_tab_index(); ?>" id="bbp_search_submit" class="nk-btn nk-btn-color-dark-1"><span class="ion-ios-search"></span></button>
	</div>
</form>
