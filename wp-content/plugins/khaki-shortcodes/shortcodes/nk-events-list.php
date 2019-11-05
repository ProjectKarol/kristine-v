<?php
/**
 * nK Events List
 */

add_shortcode('nk_events_list', 'nk_events_list');
if (!function_exists('nk_events_list')) :
    function nk_events_list($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "exclude_ids" => "",
            'order' => 'DESC',
            "count" => 5,
            "pagination" => false, // false, true, 'load_more', 'infinite'
            "color" => "",
            "hide_price_column" => false,
            "class" => ""
        ), $atts));

        /**
         * Set Up Query
         */
        $paged = 0;
        if (khaki_nk_check($pagination)) {
            $paged = max(1, get_query_var('page'), get_query_var('paged'));
        }
        $query_opts = array(
            'showposts' => intval($count),
            'posts_per_page' => intval($count),
            'category_name' => get_post_meta(get_queried_object_id(), 'WP_Catid', 'true'),
            'paged' => $paged,
            'post_type' => 'event',
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num',
            'order' => $order
        );
        

        // Exclude IDs
        $exclude_ids = explode(",", $exclude_ids);
        if ($exclude_ids) {
            $query_opts['post__not_in'] = $exclude_ids;
        }

        /**
         * Work with printing posts
         */
        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);
        $class .= ' nk-events-list';

        // set container for ajax loading
        if ($pagination === 'infinite') {
            $class .= ' nk-infinite-scroll-container';
        }
        if ($pagination === 'load_more') {
            $class .= ' nk-load-more-container';
        }
        if(khaki_nk_check($color)){
            $class .= ' text-' . $color;
        }
        $khaki_query = new WP_Query($query_opts);
        $result = '<ul class="'.khaki_sanitize_class($class).'">';
        while ($khaki_query->have_posts()) : $khaki_query->the_post();
            $event_date = explode('|', khaki_get_theme_mod('event_date', true));
            $detail_url = get_permalink();
            $title = get_the_title();
            $location = khaki_get_theme_mod('event_location', true);
            $price = khaki_get_theme_mod('event_price', true);
            $product_type = khaki_get_theme_mod('event_product_type', true);
            
            $result .= '<li>';
            
            if (isset($event_date) && !empty($event_date) && is_array($event_date)){
                $result .= '<a href="'.esc_url($detail_url).'" class="nk-event-date">';
                $result .= esc_html(array_shift($event_date));
                $result .= '<span>'.esc_html(array_pop($event_date)).'</span>';
                $result .= '</a>';
            }

            if ((isset($title) && !empty($title)) || (isset($location) && !empty($location))){
                $result .= '<a href="'.esc_url($detail_url).'" class="nk-event-name">';
                if (isset($title) && !empty($title)){
                    $result .= '<strong>'. esc_html($title).'</strong>';
                }
                if (isset($location) && !empty($location)){
                    $result .= '<span>'. esc_html($location).'</span>';
                }
                $result .= '</a>';
            }

            if (((isset($price) && !empty($price)) || (isset($product_type) && !empty($product_type))) && !khaki_nk_check($hide_price_column)){
                $result .= '<a href="'.esc_url($detail_url).'" class="nk-event-price">';
                if (isset($price) && !empty($price)){
                    $result .= esc_html($price);
                }
                if (isset($product_type) && !empty($product_type)){
                    $result .= '<span>'. esc_html($product_type).'</span>';
                }
                $result .= '</a>';
            }
            set_query_var( 'color', $color );
            ob_start();
            get_template_part('/template-parts/event/event-status');
            $result .= ob_get_contents();
            ob_end_clean();
            $result .= '</li>';
        endwhile;
        wp_reset_postdata();
        $result .= '</ul>';
        $result .= '<div class="clearfix"></div>';
        ob_start();
        if (khaki_nk_check($pagination)) {
            khaki_posts_navigation($khaki_query);
            if ($pagination == 'infinite' || $pagination == 'load_more') {
                nk_infinite_scroll_init($khaki_query);
            }
        }
        $result .= ob_get_contents();
        ob_end_clean();
        return $result;
    }
endif;

add_action('after_setup_theme', 'vc_nk_events_list');
if (!function_exists('vc_nk_events_list')) :
    function vc_nk_events_list()
    {
        if (function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map(array(
                'name' => esc_html__('nK Event List', 'khaki-shortcodes'),
                'base' => 'nk_events_list',
                'controls' => 'full',
                'category' => 'nK',
                'icon' => 'icon-nk icon-nk-posts-list',
                'params' => array_merge(array(
                    /**
                     * General
                     */
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Recent Posts Count", 'khaki-shortcodes'),
                        "param_name" => "count",
                        "value" => 5,
                        "description" => "",
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Pagination", 'khaki-shortcodes'),
                        "param_name" => "pagination",
                        "value" => array(
                            esc_html__("No Pagination", 'khaki-shortcodes') => "",
                            esc_html__("Simple Pagination", 'khaki-shortcodes') => true,
                            esc_html__("Load More button", 'khaki-shortcodes') => 'load_more',
                            esc_html__("Infinite Scroll", 'khaki-shortcodes') => 'infinite'
                        ),
                        "description" => ""
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Color', 'khaki-shortcodes'),
                        'param_name' => 'color',
                        'std'        => false,
                        'value'      => khaki_get_colors(),
                        'description' => '',
                    ),
                    array(
                        'param_name'  => 'hide_price_column',
                        'heading'     => esc_html__('Hide Price Column', 'khaki-shortcodes'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Custom Classes", 'khaki-shortcodes'),
                        "param_name" => "class",
                        "value" => "",
                        "description" => "",
                    ),


                    /**
                     * Query
                     */
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Exclude IDs", 'khaki-shortcodes'),
                        "group" => esc_html__("Query", 'khaki-shortcodes'),
                        "param_name" => "exclude_ids",
                        "description" => esc_html__("Type here the posts, pages, etc. IDs you want to use separated by coma. ex: 23,24,25", 'khaki-shortcodes'),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Order", 'khaki-shortcodes'),
                        "group" => esc_html__("Query", 'khaki-shortcodes'),
                        "param_name" => "order",
                        "value" => array(
                            "DESC", "ASC"
                        ),
                        "std" => "DESC",
                    ),
                ), khaki_get_css_tab())
            ));
        }
    }
endif;