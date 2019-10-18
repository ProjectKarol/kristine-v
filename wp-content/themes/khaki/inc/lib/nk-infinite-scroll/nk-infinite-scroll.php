<?php
/**
 * Infinite Scroll for Khaki
 * Based on: PBD AJAX Load Posts [http://www.problogdesign.com/]
 */
if(!function_exists('nk_infinite_scroll_init')) :
    function nk_infinite_scroll_init($nk_query = null) {
        if($nk_query == null) {
            global $wp_query;
        } else {
            $wp_query = $nk_query;
        }

        wp_enqueue_script('nk-infinite-scroll', get_template_directory_uri() . '/inc/lib/nk-infinite-scroll/js/load-posts.js', array('jquery'), '', true);

        // What page are we on? And what is the pages limit?
        $max = $wp_query->max_num_pages;
        $paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;

        // Add some parameters for the JS.
        wp_localize_script(
            'nk-infinite-scroll',
            'nk_infinite_scroll',
            array(
                'startPage' => $paged,
                'maxPages' => $max,
                'nextLink' => next_posts($max, false)
            )
        );
    }
// add_action('template_redirect', 'nk_infinite_scroll_init');
endif;
