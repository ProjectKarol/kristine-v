<?php
add_action("rest_api_init", "kristinesearch");

function kristinesearch()
{
	register_rest_route('kristine/v1', 'search', array(
		'methods' => WP_REST_SERVER::READABLE,
		'callback' => 'kristineSearchResult'
	));
}

function kristineSearchResult($data)
{
	$mainQuery = new WP_Query(array(
		"post_type" => array("post", "product"),
		"s" => sanitize_text_field($data['term'])
	));
	$results = array(
		"posts_arr" => array(),
		"product_arr" => array()
	);
	while ($mainQuery->have_posts()) {
		$mainQuery->the_post();
		if (get_post_type() == "post") {
			array_push($results["posts_arr"], array(
				'title' => get_the_title(),
				'link' => get_the_permalink()
			));
		}
		if (get_post_type() == "product") {
			$id = $post->ID;
			array_push($results["product_arr"], array(
				'title' => get_the_title(),
				'link' => get_the_permalink(),
				'image' => get_the_post_thumbnail_url(0, 'khaki_200x200')
			));
		}
	}
	return $results;
}
add_image_size('search_200x300', 200, 300, true);

/// search by title only
function __search_by_title_only($search, $wp_query)
{
	global $wpdb;
	if (empty($search)) {
		return $search; // skip processing - no search term in query
	}
	$q = $wp_query->query_vars;
	$n = !empty($q['exact']) ? '' : '%';
	$search = $searchand = '';
	foreach ((array) $q['search_terms'] as $term) {
		$term = esc_sql($wpdb->esc_like($term));
		$search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
		$searchand = ' AND ';
	}
	if (!empty($search)) {
		$search = " AND ({$search}) ";
		if (!is_user_logged_in()) {
			$search .= " AND ($wpdb->posts.post_password = '') ";
		}
	}
	return $search;
}
add_filter('posts_search', '__search_by_title_only', 500, 2);
