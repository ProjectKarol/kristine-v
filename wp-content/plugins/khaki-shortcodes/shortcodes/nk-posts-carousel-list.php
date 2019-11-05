<?php
/**
 * nK Posts Carousel List
 */

add_shortcode('nk_posts_carousel_list', 'nk_posts_carousel_list');
if (!function_exists('nk_posts_carousel_list')) :
    function nk_posts_carousel_list($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "style" => "3",
            "no_margin" => "",
            "all_visible" => "",
            "preview_description_type" => 'false',
            "preview_description_trim_cnt" => 15,
            "autoplay" => 0,
            "no_image" => "",
            "cell_align" => "center",
            "thumbnail_resolution"  =>"full",
            "data_size" => 1,
            "size" => "",
            "show_navigation" => "",
            "navigate_position" => "before",
            "post_type" => "post",
            "taxonomies" => "",
            "taxonomies_relation" => "OR",
            "ids" => "",
            "custom_query" => "",
            "exclude_ids" => "",
            'orderby' => 'post_date',
            'order' => 'DESC',
            "count" => 5,
            "class" => ""
        ), $atts));

        /**
         * Set Up Query
         */

        $query_opts = array(
            'showposts' => intval($count),
            'posts_per_page' => intval($count),
            'paged' => 0,
            'order' => $order
        );

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

        // Exclude IDs
        $exclude_ids = explode(",", $exclude_ids);
        if ($exclude_ids) {
            $query_opts['post__not_in'] = $exclude_ids;
        }

        // IDs
        if ($post_type == 'ids') {
            $ids = explode(",", $ids);
            $query_opts['post_type'] = 'any';
            $query_opts['post__in'] = $ids;
        } // Custom Query
        else if ($post_type == 'custom_query') {
            $tmp_arr = array();
            parse_str(html_entity_decode($custom_query), $tmp_arr);
            $query_opts = array_merge($query_opts, $tmp_arr);
        } else {
            // Taxonomies
            $taxonomies = $taxonomies ? explode(",", $taxonomies) : array();
            if (!empty($taxonomies)) {
                $all_terms = khaki_get_terms();
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
            $query_opts['post_type'] = $post_type;
        }

        /**
         * Work with printing posts
         */
        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);

        if(khaki_nk_check($style)) {
            $class .= ' nk-carousel-' . $style;
        }
        if (khaki_nk_check($size)) {
            $class .= ' nk-carousel-x' . $size;
        }
        if (khaki_nk_check($no_margin)) {
            $class .= ' nk-carousel-no-margin';
        }
        if (khaki_nk_check($all_visible)) {
            $class .= ' nk-carousel-all-visible';
        }

        $posts_query = new WP_Query($query_opts);
        $attributes = '';
        if (khaki_nk_check($autoplay)) {
            $attributes .= ' data-autoplay="' . esc_attr($autoplay) . '"';
        }
        if (khaki_nk_check($data_size)) {
            $attributes .= ' data-size="' . esc_attr($data_size) . '"';
        }
        if(khaki_nk_check($cell_align)){
            $attributes .= ' data-cell-align="'.esc_attr($cell_align).'"';
        }

        $result = '<div class="'.khaki_sanitize_class($class).'"' . $attributes . '>';
        $navigation = '';
            if($show_navigation){
                $navigation .= '<div class="container">';
                $navigation .= '<div class="nk-gap-3"></div>';
                $navigation .= '<div class="nk-carousel-prev">';
                $navigation .= '<div class="nk-carousel-arrow-name"></div>';
                $navigation .= esc_html__('Previous', 'khaki-shortcodes');
                $navigation .= '<span class="nk-icon-arrow-left"></span>';
                $navigation .= '</div>';
                $navigation .= '<div class="nk-carousel-next">';
                $navigation .= '<div class="nk-carousel-arrow-name"></div>';
                $navigation .= esc_html__('Next', 'khaki-shortcodes');
                $navigation .= '<span class="nk-icon-arrow-right"></span>';
                $navigation .= '</div>';
                $navigation .= '<div class="nk-carousel-current">';
                $navigation .= '<h3 class="nk-carousel-name h4"></h3>';
                $navigation .= '<div class="nk-carousel-links"></div>';
                $navigation .= '</div>';
                $navigation .= '<div class="nk-gap-3"></div>';
                $navigation .= '</div>';
                if(isset($navigate_position) && $navigate_position == 'before'){
                    $result .= $navigation;
                }
            }
            $result .= '<div class="nk-carousel-inner">';
            while ($posts_query->have_posts()) : $posts_query->the_post();
                $alt = $attachment_src = '';

                //Post link
                $post_url = esc_url(get_permalink());

                //Attachment
                $resolution = 'khaki_1920x1080';
                if(isset($thumbnail_resolution) && !empty($thumbnail_resolution)){
                    $resolution = $thumbnail_resolution;
                }
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
                            $alt = esc_attr__('No Image', 'khaki-shortcodes');
                            $attachment_src = $attachment['src'];
                        }
                    } else{
                        $alt = esc_attr__('No Image', 'khaki-shortcodes');
                        $attachment_src = get_template_directory_uri() . '/assets/images/no-image.jpg';
                    }
                }

                //Published Date
                $published_date = get_the_time(esc_html__('F j, Y', 'khaki-shortcodes'));

                //Title
                $title = get_the_title();

                if(isset($style) && $style == '3'){
                    $result .= '<div id="post-'.get_the_ID().'" class="'.implode(' ', get_post_class()).'">';
                    $result .= '<div class="nk-image-box-1 nk-no-effect nk-portfolio-item">';

                    if(isset($post_url) && !empty($post_url)){
                        $result .= '<a href="'.esc_url($post_url).'" class="nk-image-box-link nk-portfolio-quick-view"></a>';
                    }
                    if(isset($attachment_src) && !empty($attachment_src)){
                        $result .= '<img class="nk-portfolio-image" src="'.esc_url($attachment_src).'" alt="'.$alt.'">';
                    }
                    if(isset($title) && !empty($title)) {
                        $result .= '<h2 class="nk-portfolio-title nk-carousel-item-name">';
                        if(isset($post_url) && !empty($post_url)) {
                            $result .= '<a href="'.esc_url($post_url).'" class="nk-portfolio-quick-view">';
                        }
                        $result .= esc_html($title);
                        if(isset($post_url) && !empty($post_url)) {
                            $result .= '</a>';
                        }
                        $result .= '</h2>';
                    }
                    if(isset($title) && !empty($title)) {
                        $result .= '<div class="nk-portfolio-sub-title nk-carousel-item-links">'.esc_html($published_date).'</div>';
                    }
                    $result .= '</div>';
                    $result .= '</div>';
                }

                if(isset($style) && ($style == '1' || $style == '2')){
                    $result .= '<div><div class="p-10">';
                    $result .= '<div id="post-'.get_the_ID().'" class="'.implode(' ', get_post_class('nk-blog-post mb-0')).'">';
                    if(isset($attachment_src) && !empty($attachment_src)){

                        if(isset($post_url) && !empty($post_url)) {
                            $result .= '<a href="'.esc_url($post_url).'">';
                        }

                        $result .= '<img class="nk-img-stretch" src="'.esc_url($attachment_src).'" alt="'.$alt.'">';

                        if(isset($post_url) && !empty($post_url)) {
                            $result .= '</a>';
                        }
                        $result .= '<div class="nk-gap"></div>';
                    }
                    if(isset($title) && !empty($title)) {
                        $result .= '<h2 class="nk-post-title h5">';
                        if(isset($post_url) && !empty($post_url)) {
                            $result .= '<a href="'.esc_url($post_url).'">';
                        }
                        $result .= esc_html($title);
                        if(isset($post_url) && !empty($post_url)) {
                            $result .= '</a>';
                        }
                        $result .= '</h2>';
                    }
                        $result .= '<div class="nk-post-text">';
                        if ($preview_description_type == 'excerpt' && $preview_description_trim_cnt > 0) {
                            $result .= khaki_excerpt_max_charlength($preview_description_trim_cnt, true);
                        } elseif ($preview_description_type == 'more') {
                            $result .= get_the_content();
                        }
                        $result .= '</div>';
                    $result .= '</div>';
                    $result .= '</div></div>';
                }

            endwhile;
            wp_reset_postdata();
            $result .= '</div>';
            if($show_navigation && isset($navigate_position) && $navigate_position == 'after'){
                $result .= $navigation;
            }
        $result .= '</div>';
        return $result;
    }
endif;

add_action('init', 'vc_nk_posts_carousel_list', 100);
if (!function_exists('vc_nk_posts_carousel_list')) :
    function vc_nk_posts_carousel_list()
    {
        // post types list
        $post_types = get_post_types(array());
        $post_types_list = array();
        if (is_array($post_types) && !empty($post_types)) {
            foreach ($post_types as $post_type) {
                if ($post_type !== "revision" && $post_type !== "nav_menu_item") {
                    $label = ucfirst($post_type);
                    $post_types_list[] = array($post_type, $label);
                }
            }
        }
        $post_types_list[] = array("custom_query", esc_html__("Custom Query", 'khaki-shortcodes'));
        $post_types_list[] = array("ids", esc_html__("List of IDs", 'khaki-shortcodes'));

        if (function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map(array(
                'name' => esc_html__('nK Posts Carousel List', 'khaki-shortcodes'),
                'base' => 'nk_posts_carousel_list',
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
                        "type"        => "textfield",
                        "heading"     => esc_html__("Autoplay", 'khaki-shortcodes'),
                        "param_name"  => "autoplay",
                        "value"       => "0",
                        "description" => esc_html__("Type integer value in ms", 'khaki-shortcodes')
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Photo Size', 'khaki-shortcodes'),
                        'param_name' => 'thumbnail_resolution',
                        'std'        => 'full',
                        'value'      => khaki_get_image_sizes(),
                        'description' => '',
                    ),
                    array(
                        "type"        => "checkbox",
                        "heading"     => esc_html__('No Margin Between Slides', 'khaki-shortcodes'),
                        "param_name"  => "no_margin",
                        "value"       => array( "" => true ),
                    ),
                    array(
                        "type"        => "checkbox",
                        "heading"     => esc_html__('All Visible', 'khaki-shortcodes'),
                        "description" => esc_html__('By default non-active slides semi-transparent, this option removed transparency.', 'khaki-shortcodes'),
                        "param_name"  => "all_visible",
                        "value"       => array( "" => true ),
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Style', 'khaki-shortcodes'),
                        'param_name' => 'style',
                        'std'        => false,
                        'value'      => array(
                            esc_html__('Default', 'khaki-shortcodes') => false,
                            esc_html__('Style 1', 'khaki-shortcodes') => '1',
                            esc_html__('Style 2', 'khaki-shortcodes') => '2',
                            esc_html__('Style 3', 'khaki-shortcodes') => '3'
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Size', 'khaki-shortcodes'),
                        'param_name' => 'size',
                        'std'        => false,
                        'value'      => array(
                            esc_html__('Default', 'khaki-shortcodes') => false,
                            esc_html__('X1', 'khaki-shortcodes') => '1',
                            esc_html__('X2', 'khaki-shortcodes') => '2',
                            esc_html__('X3', 'khaki-shortcodes') => '3',
                            esc_html__('X4', 'khaki-shortcodes') => '4',
                        ),
                        'dependency' => array(
                            'element'    => 'style',
                            'value'      => array('2')
                        ),
                        'description' => ''
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Data Size", 'khaki-shortcodes'),
                        "param_name" => "data_size",
                        "value" => 1,
                        "description" => "Enter the content compression ratio",
                    ),
                    array(
                        'param_name'  => 'show_navigation',
                        'heading'     => esc_html__('Show Navigation', 'khaki-shortcodes'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Navigate Position", 'khaki-shortcodes'),
                        "param_name" => "navigate_position",
                        "value" => array(
                            esc_html__("Before Carousel", 'khaki-shortcodes') => 'before',
                            esc_html__("After Carousel", 'khaki-shortcodes') => 'after',
                        ),
                        "std" => "before",
                        "dependency" => array(
                            'element'    => 'show_navigation',
                            'not_empty'  => true
                        ),
                    ),
                    array(
                        'type'       => 'attach_image',
                        'heading'    => esc_html__('No Image', 'khaki-shortcodes'),
                        'param_name' => 'no_image',
                        'description' => ''
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Cell Align', 'khaki-shortcodes'),
                        'param_name' => 'cell_align',
                        'std'        => false,
                        'value'      => array(
                            esc_html__('Center', 'khaki-shortcodes') => 'center',
                            esc_html__('Left', 'khaki-shortcodes') => 'left',
                            esc_html__('Right', 'khaki-shortcodes') => 'right'
                        ),
                        'description' => ''
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Preview Description Type", 'khaki-shortcodes'),
                        "param_name" => "preview_description_type",
                        "value" => array(
                            esc_html__("Disabled", 'khaki-shortcodes') => 'false',
                            esc_html__("Excerpt", 'khaki-shortcodes') => 'excerpt',
                            esc_html__("Use more tag", 'khaki-shortcodes') => 'more',
                        ),
                        "description" => "",
                        'dependency' => array(
                            'element'    => 'style',
                            'value'      => array('2')
                        ),
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Trim to a words", 'khaki-shortcodes'),
                        "param_name" => "preview_description_trim_cnt",
                        "value" => 15,
                        "description" => esc_html__("cut in the number of words", 'khaki-shortcodes'),
                        'dependency' => array(
                            'element' => 'preview_description_type',
                            'value_not_equal_to' => array(
                                'false',
                                'more',
                            ),
                        ),
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
                        "type" => "dropdown",
                        "heading" => esc_html__("Data source", 'khaki-shortcodes'),
                        "group" => esc_html__("Query", 'khaki-shortcodes'),
                        "param_name" => "post_type",
                        "value" => $post_types_list,
                        "std" => "post",
                        "description" => esc_html__("Select content type", 'khaki-shortcodes')
                    ),
                    array(
                        'type' => 'autocomplete',
                        'heading' => esc_html__('Narrow data source', 'khaki-shortcodes'),
                        "group" => esc_html__("Query", 'khaki-shortcodes'),
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
                            'values' => khaki_get_terms()
                        ),
                        'description' => esc_html__('Enter categories, tags or custom taxonomies.', 'khaki-shortcodes'),
                        'dependency' => array(
                            'element' => 'post_type',
                            'value_not_equal_to' => array(
                                'ids',
                                'custom_query',
                            ),
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Data source relation", 'khaki-shortcodes'),
                        "group" => esc_html__("Query", 'khaki-shortcodes'),
                        "param_name" => "taxonomies_relation",
                        "value" => array(
                            "OR", "AND"
                        ),
                        "std" => "OR",
                        'dependency' => array(
                            'element' => 'post_type',
                            'value_not_equal_to' => array(
                                'ids',
                                'custom_query',
                            ),
                        ),
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("IDs", 'khaki-shortcodes'),
                        "group" => esc_html__("Query", 'khaki-shortcodes'),
                        "param_name" => "ids",
                        "description" => esc_html__("Type here the posts, pages, etc. IDs you want to use separated by coma. ex: 23,24,25", 'khaki-shortcodes'),
                        "dependency" => array(
                            "element" => "post_type",
                            "value" => array("ids"),
                        ),
                    ),
                    array(
                        "type" => "textarea_safe",
                        "heading" => esc_html__("Custom Query", 'khaki-shortcodes'),
                        "group" => esc_html__("Query", 'khaki-shortcodes'),
                        "param_name" => "custom_query",
                        "description" => sprintf(esc_html__("Build custom query according to %s.", 'khaki-shortcodes'), "<a href='http://codex.wordpress.org/Function_Reference/query_posts'>WordPress Codex</a>"),
                        "dependency" => array(
                            "element" => "post_type",
                            "value" => array("custom_query"),
                        ),
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Exclude IDs", 'khaki-shortcodes'),
                        "group" => esc_html__("Query", 'khaki-shortcodes'),
                        "param_name" => "exclude_ids",
                        "description" => esc_html__("Type here the posts, pages, etc. IDs you want to use separated by coma. ex: 23,24,25", 'khaki-shortcodes'),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Order By", 'khaki-shortcodes'),
                        "group" => esc_html__("Query", 'khaki-shortcodes'),
                        "param_name" => "orderby",
                        "value" => array(
                            esc_html__("Date", 'khaki-shortcodes') => 'post_date',
                            esc_html__("Title", 'khaki-shortcodes') => 'title',
                            esc_html__("ID", 'khaki-shortcodes') => 'id',
                            esc_html__("Post In", 'khaki-shortcodes') => 'post__in',
                        ),
                        "std" => "post_date",
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