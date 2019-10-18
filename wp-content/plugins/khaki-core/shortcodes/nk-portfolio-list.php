<?php
/**
 * nK Portfolio List
 */

add_shortcode('nk_portfolio_list', 'nk_portfolio_list');
if (!function_exists('nk_portfolio_list')) :
    function nk_portfolio_list($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "show_likes" => "",
            "show_date" => "",
            "show_title" => "",
            "show_comments_count" => "",
            "show_eye_icon" => "",
            "show_link_icon" => "",
            "global_link"=> "",
            "style" => "",
            "content_vertical_align" => "center",
            "no_effect" => "",
            "hovered" => "",
            "filter" => "",
            "cross" => "",
            "no_image" => "",
            "columns" => 3,
            "taxonomies" => "",
            "taxonomies_relation" => "OR",
            "exclude_ids" => "",
            'orderby' => 'post_date',
            'order' => 'DESC',
            "count" => 5,
            "pagination" => false, // false, true, 'load_more', 'infinite'
            "class" => ""
        ), $atts));

        $result = '';
        $filter_values = array();
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
            'paged' => $paged,
            'order' => $order,
            'post_type' => 'portfolio',
        );

        // Taxonomies
        $taxonomies = $taxonomies ? explode(",", $taxonomies) : array();
        if (!empty($taxonomies)) {
            $all_terms = khaki_get_portfolio_terms();
            $query_opts['tax_query'] = array(
                'relation' => khaki_nk_check($taxonomies_relation) ? $taxonomies_relation : 'OR'
            );
            foreach ($taxonomies as $taxonomy) {
                $taxonomy_name = null;

                foreach ($all_terms as $term) {
                    if ($term['value'] == $taxonomy) {
                        $taxonomy_name = $term['group'];
                        continue;
                    }
                }

                if ($taxonomy_name) {
                    $query_opts['tax_query'][] = array(
                        'taxonomy' => $taxonomy_name,
                        'field' => 'id',
                        'terms' => $taxonomy
                    );
                }
            }
        }

        // Order By
        switch ($orderby) {
            case 'title':
                $query_opts['orderby'] = 'title';
                break;

            case 'id':
                $query_opts['orderby'] = 'ID';
                break;

            case 'post__in':
                $query_opts['orderby'] = 'post__in';
                break;

            default:
                $query_opts['orderby'] = 'post_date';
                break;
        }
        /**
         * Work with generated and building content
         */
        // Exclude IDs
        $exclude_ids = explode(",", $exclude_ids);
        if ($exclude_ids) {
            $query_opts['post__not_in'] = $exclude_ids;
        }

        if ($pagination === 'infinite') {
            $class .= ' nk-infinite-scroll-container';
        }
        if ($pagination === 'load_more') {
            $class .= ' nk-load-more-container';
        }
        $class .= ' nk-isotope nk-isotope-gap';

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);
        if($columns>1 && $columns<=3 && is_numeric($columns)){
            $class .=' nk-isotope-'.$columns.'-cols';
        }

        // get Post List
        $portfolio_query = new WP_Query($query_opts);
        $portfolio_list = $image_atts = $class_style = '';

        // set style effect
        if(khaki_nk_check($style)){
            if($style == 2) {
                $image_atts = ' data-from="1.1"';
            }
            $class_style .= 'nk-image-box-' . $style;
        } else {
            $class_style .= 'nk-image-box';
        }

        // no effect
        if (khaki_nk_check($no_effect)) {
            $class_style .= ' nk-no-effect';
        }

        // hovered
        if (khaki_nk_check($hovered)) {
            $class_style .= ' hover';
        }

        // set align content
        $overlay_class = 'nk-image-box-overlay';
        if(isset($content_vertical_align)){
            $overlay_class .= ' nk-image-box-'.$content_vertical_align;
        }

        while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
            $current_post_atts = $alt = $attachment_src = '';

            //Filter Matches
            if($filter){
                $category = get_the_terms(get_the_ID(), 'portfolio-category');
                if ($category){
                    $current_post_atts .= ' data-filter="';
                    foreach ($category as $key => $cat_item){
                        $filter_values[] = $cat_item->name;
                        if($key > 0){
                            $current_post_atts .= ', ';
                        }
                        $current_post_atts .= esc_attr($cat_item->name);
                    }
                    $current_post_atts .= '"';
                }
            }

            //Attachment
            $resolution = 'khaki_1280x720';
            $attachment = khaki_get_attachment(get_post_thumbnail_id(get_the_ID()), $resolution);
            if (!empty($attachment) && is_array($attachment)) {
                if ($attachment['alt']) {
                    $alt = esc_attr($attachment['alt']);
                } else {
                    $alt = esc_attr(get_bloginfo('name'));
                }
                $attachment_src = $attachment['src'];
            } else {
                if(isset($no_image) && !empty($no_image)){
                    $attachment = khaki_get_attachment($no_image, $resolution);
                    if(!empty($attachment) && is_array($attachment)){
                        $alt = esc_attr__('No Image', 'khaki-core');
                        $attachment_src = $attachment['src'];
                    }
                } else{
                    $alt = esc_attr__('No Image', 'khaki-core');
                    $attachment_src = esc_url(get_template_directory_uri() . '/assets/images/no-image.jpg');
                }
            }

            //Post link
            $portfolio_url = get_permalink();

            //Title
            $title = get_the_title();

            //Published Date
            $published_date = get_the_time(esc_html__('F j, Y', 'khaki-core'));

            $portfolio_list .= '<div class="nk-portfolio-item nk-isotope-item"'.$current_post_atts.'>';
            $portfolio_list .= '<div class="'.khaki_sanitize_class($class_style).'">';
            if($global_link && isset($portfolio_url) && !empty($portfolio_url)){
                $portfolio_list .= '<a href="'.esc_url($portfolio_url).'" class="nk-image-box-link"></a>';
            }
            $portfolio_list .= '<img class="nk-portfolio-image" src="'.$attachment_src.'" alt="'.$alt.'"'.$image_atts.'>';
            $portfolio_list .= '<div class="'.khaki_sanitize_class($overlay_class).'">';
            $portfolio_list .= '<div>';
            if($show_eye_icon && isset($portfolio_url) && !empty($portfolio_url)) {
                $portfolio_list .= '<a href="' . esc_url($portfolio_url) . '" class="nk-image-box-icon-btn nk-portfolio-quick-view"><span class="ion-ios-eye"></span></a>';
            }
            if($show_link_icon && isset($portfolio_url) && !empty($portfolio_url)) {
                $portfolio_list .= '<a href="' . esc_url($portfolio_url) . '" class="nk-image-box-icon-btn"><span class="ion-md-link"></span></a>';
            }
            $portfolio_list .= '</div>';
            $portfolio_list .= '</div>';
            $portfolio_list .= '</div>';
            $portfolio_list .= '<div class="nk-image-box-bottom-info">';
            //add meta, heart, title, link, date.
            if(isset($title) && !empty($title) && isset($portfolio_url) && !empty($portfolio_url) && $show_title){
                $portfolio_list .= '<h2 class="nk-portfolio-title nk-post-title h4"><a href="'.esc_url($portfolio_url).'">'.esc_html($title).'</a></h2>';
            }
            $portfolio_list .= '<div class="nk-post-meta">';
            $portfolio_list .= '<div class="nk-post-meta-right">';
            if (get_comments() && $show_comments_count){
                $portfolio_list .= '<a class="nk-post-comments-count" href="'.esc_url($portfolio_url.'#comments').'">'.number_format_i18n(get_comments_number()).'</a>';
            }
            if($show_likes && function_exists('sociality')) {
                $portfolio_list .= sociality()->likes()->get_likes(get_the_ID(), 'portfolio');
            }
            $portfolio_list .= '</div>';
            if(isset($published_date) && !empty($published_date) && $show_date){
                $portfolio_list .= '<div class="nk-post-date">'.esc_html($published_date).'</div>';
            }
            $portfolio_list .= '</div>';
            $portfolio_list .= '</div>';
            $portfolio_list .= '</div>';
        endwhile;
        wp_reset_postdata();
        //Set Filter
        if($filter && !empty($filter_values) && isset($filter_values) && is_array($filter_values)){
            foreach($filter_values as $key=>$filter_value){
                $filter_values[$key]=trim($filter_value);
            }
            $filter_values = array_unique($filter_values);
            $result .= '<ul class="nk-isotope-filter">';
            $result .= '<li class="active" data-filter="*">All</li>';
            foreach($filter_values as $key=>$filter_value){
                $result .= '<li data-filter="'.esc_attr(trim($filter_value)).'">'.esc_html(trim($filter_value)).'</li>';
            }
            $result .= '</ul>';
        }

        /**
         * Work with printing posts
         */
        if($cross){
            $result .= '<div class="container mnt-60">';
        }
        $result .= '<div class="'.khaki_sanitize_class($class).'">';
        $result .= $portfolio_list;
        $result .= '</div>';
        $result .= '<div class="clearfix"></div>';
        ob_start();
        if (khaki_nk_check($pagination)) {
            khaki_posts_navigation($portfolio_query);
            if ($pagination == 'infinite' || $pagination == 'load_more') {
                nk_infinite_scroll_init($portfolio_query);
            }
        }
        $result .= ob_get_contents();
        ob_end_clean();
        if($cross) {
            $result .= '</div>';
        }
        return $result;
    }
endif;

add_action('init', 'vc_nk_portfolio_list', 100);
if (!function_exists('vc_nk_portfolio_list')) :
    function vc_nk_portfolio_list()
    {
        if (function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map(array(
                'name' => esc_html__('nK Portfolio List', 'khaki-core'),
                'base' => 'nk_portfolio_list',
                'controls' => 'full',
                'category' => 'nK',
                'icon' => 'icon-nk icon-nk-posts-list',
                'params' => array_merge(array(
                    /**
                     * General
                     */
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Number of Columns", 'khaki-core'),
                        "param_name" => "columns",
                        "value" => 3,
                        "description" => "Enter an integer from 1 to 3",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Recent Posts Count", 'khaki-core'),
                        "param_name" => "count",
                        "value" => 5,
                        "description" => "",
                    ),
                    array(
                        'type'       => 'attach_image',
                        'heading'    => esc_html__('No Image', 'khaki-core'),
                        'param_name' => 'no_image',
                        'description' => ''
                    ),
                    array(
                        'param_name'  => 'cross',
                        'heading'     => esc_html__('Cross', 'khaki-core'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        'param_name'  => 'filter',
                        'heading'     => esc_html__('Use Filter', 'khaki-core'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Pagination", 'khaki-core'),
                        "param_name" => "pagination",
                        "value" => array(
                            esc_html__("No Pagination", 'khaki-core') => "",
                            esc_html__("Simple Pagination", 'khaki-core') => true,
                            esc_html__("Load More button", 'khaki-core') => 'load_more',
                            esc_html__("Infinite Scroll", 'khaki-core') => 'infinite'
                        ),
                        "description" => ""
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Custom Classes", 'khaki-core'),
                        "param_name" => "class",
                        "value" => "",
                        "description" => "",
                    ),

                    /**
                     * Items
                     */
                    array(
                        'type'       => 'dropdown',
                        "group" => esc_html__("Items", 'khaki-core'),
                        'heading'    => esc_html__('Style', 'khaki-core'),
                        'param_name' => 'style',
                        'std'        => '1',
                        'value'      => array(
                            esc_html__('Disabled', 'khaki-core')  => false,
                            esc_html__('Style 1', 'khaki-core')  => '1',
                            esc_html__('Style 1a', 'khaki-core')  => '1-a',
                            esc_html__('Style 2', 'khaki-core')  => '2',
                            esc_html__('Style 3', 'khaki-core')  => '3',
                            esc_html__('Style 4', 'khaki-core')  => '4',
                            esc_html__('Style 5', 'khaki-core')  => '5',
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'dropdown',
                        "group" => esc_html__("Items", 'khaki-core'),
                        'heading'    => esc_html__('Content Vertical Align', 'khaki-core'),
                        'param_name' => 'content_vertical_align',
                        'std'        => 'center',
                        'value'      => array(
                            esc_html__('Top', 'khaki-core')  => 'top',
                            esc_html__('Center', 'khaki-core')  => 'center',
                            esc_html__('Bottom', 'khaki-core')  => 'bottom',
                        ),
                        'description' => ''
                    ),
                    array(
                        'param_name'  => 'no_effect',
                        "group" => esc_html__("Items", 'khaki-core'),
                        'heading'     => esc_html__('No Hover Effect', 'khaki-core'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        'param_name'  => 'hovered',
                        "group" => esc_html__("Items", 'khaki-core'),
                        'heading'     => esc_html__('Hovered', 'khaki-core'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        'param_name'  => 'global_link',
                        "group" => esc_html__("Items", 'khaki-core'),
                        'heading'     => esc_html__('Use Global Link', 'khaki-core'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        'param_name'  => 'show_eye_icon',
                        "group" => esc_html__("Items", 'khaki-core'),
                        'heading'     => esc_html__('Show Eye Icon', 'khaki-core'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        'param_name'  => 'show_link_icon',
                        "group" => esc_html__("Items", 'khaki-core'),
                        'heading'     => esc_html__('Show Link Icon', 'khaki-core'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        'param_name'  => 'show_likes',
                        "group" => esc_html__("Items", 'khaki-core'),
                        'heading'     => esc_html__('Show Likes', 'khaki-core'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                        'std'         => true
                    ),
                    array(
                        'param_name'  => 'show_date',
                        "group" => esc_html__("Items", 'khaki-core'),
                        'heading'     => esc_html__('Show Date', 'khaki-core'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                        'std'         => true
                    ),
                    array(
                        'param_name'  => 'show_title',
                        "group" => esc_html__("Items", 'khaki-core'),
                        'heading'     => esc_html__('Show Title', 'khaki-core'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                        'std'         => true
                    ),
                    array(
                        'param_name'  => 'show_comments_count',
                        "group" => esc_html__("Items", 'khaki-core'),
                        'heading'     => esc_html__('Show Comments Count', 'khaki-core'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                        'std'         => true
                    ),
                    /**
                     * Query
                     */
                    array(
                        'type' => 'autocomplete',
                        'heading' => esc_html__('Narrow data source', 'khaki-core'),
                        "group" => esc_html__("Query", 'khaki-core'),
                        'param_name' => 'taxonomies',
                        'settings' => array(
                            'multiple' => true,
                            'min_length' => 1,
                            'groups' => true,
                            // In UI show results grouped by groups, default false
                            'unique_values' => true,
                            // In UI show results except selected. NB! You should manually check values in backend, default false
                            'display_inline' => true,
                            // In UI show results inline view, default false (each value in own line)
                            'delay' => 100,
                            // delay for search. default 500
                            'auto_focus' => true,
                            // auto focus input, default true
                            'values' => khaki_get_portfolio_terms()
                        ),
                        'description' => esc_html__('Enter categories, tags or custom taxonomies.', 'khaki-core'),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Data source relation", 'khaki-core'),
                        "group" => esc_html__("Query", 'khaki-core'),
                        "param_name" => "taxonomies_relation",
                        "value" => array(
                            "OR", "AND"
                        ),
                        "std" => "OR"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Exclude IDs", 'khaki-core'),
                        "group" => esc_html__("Query", 'khaki-core'),
                        "param_name" => "exclude_ids",
                        "description" => esc_html__("Type here the posts, pages, etc. IDs you want to use separated by coma. ex: 23,24,25", 'khaki-core'),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Order By", 'khaki-core'),
                        "group" => esc_html__("Query", 'khaki-core'),
                        "param_name" => "orderby",
                        "value" => array(
                            esc_html__("Date", 'khaki-core') => 'post_date',
                            esc_html__("Title", 'khaki-core') => 'title',
                            esc_html__("ID", 'khaki-core') => 'id',
                            esc_html__("Post In", 'khaki-core') => 'post__in',
                        ),
                        "std" => "post_date",
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Order", 'khaki-core'),
                        "group" => esc_html__("Query", 'khaki-core'),
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
