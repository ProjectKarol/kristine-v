<?php
/**
 * nK Posts Fullscreen List
 */

add_shortcode('nk_posts_fullscreen_list', 'nk_posts_fullscreen_list');
if (!function_exists('nk_posts_fullscreen_list')) :
    function nk_posts_fullscreen_list($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "preview_description_type" => 'false',
            "preview_description_trim_cnt" => 15,
            "no_image" => "",
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
        $class .= ' nk-fullpage';
        $posts_query = new WP_Query($query_opts);
        $result = '<div class="'.khaki_sanitize_class($class).'">';
        while ($posts_query->have_posts()) : $posts_query->the_post();

            //Attachment
            $resolution = 'khaki_1920x1080';
            $attachment_src = '';
            $attachment = khaki_get_attachment(get_post_thumbnail_id(get_the_ID()), $resolution);
            if (!empty($attachment) && is_array($attachment)) {
                $attachment_src = $attachment['src'];
            } else {
                if(isset($no_image) && !empty($no_image)){
                    $attachment = khaki_get_attachment($no_image, $resolution);
                    if(!empty($attachment) && is_array($attachment)){
                        $attachment_src = $attachment['src'];
                    }
                } else{
                    $attachment_src = get_template_directory_uri() . '/assets/images/no-image.jpg';
                }
            }
            $result .= '<div id="post-'.get_the_ID().'" class="'.implode(' ', get_post_class('nk-fullpage-item')).'" style="background-image: url('."'".esc_url($attachment_src)."'".');">';
            $result .= '<div>';
            $result .= '<div class="container">';
            $result .= '<div class="nk-portfolio-text-box">';

            //Post link
            $post_url = esc_url(get_permalink());

            //Title
            $title = get_the_title();
            if(isset($title) && !empty($title)) {
                $result .= '<h2 class="nk-portfolio-title h3">';
                if(isset($post_url) && !empty($post_url)) {
                    $result .= '<a href="'.esc_url($post_url).'">';
                }
                $result .= esc_html($title);
                if(isset($post_url) && !empty($post_url)) {
                    $result .= '</a>';
                }
                $result .= '</h2>';
            }

            //Published Date
            $published_date = get_the_time(esc_html__('F j, Y', 'khaki-core'));
            if(isset($title) && !empty($title)) {
                $result .= '<div class="nk-portfolio-links">'.esc_html($published_date).'</div>';
            }
            $result .= '<div class="nk-gap"></div>';
            if ($preview_description_type == 'excerpt' && $preview_description_trim_cnt > 0) {
                $result .= khaki_excerpt_max_charlength($preview_description_trim_cnt, true);
            } elseif ($preview_description_type == 'more') {
                $result .= get_the_content();
            }
            $result .= '<div class="nk-gap"></div>';

            if(isset($post_url) && !empty($post_url)) {
                $result .= '<div class="text-dark-1">';
                $result .= '<a href="'.esc_url($post_url).'" class="nk-btn nk-btn-sm nk-btn-effect-2-right nk-btn-circle nk-btn-outline nk-btn-color-dark-4">';
                $result .= '<span>'.esc_html__('More Info', 'khaki-core').'</span>';
                $result .= '<span class="icon"><span class="ion-ios-arrow-forward"></span></span>';
                $result .= '</a>';
                $result .= '</div>';
            }
            $result .= '</div>';
            $result .= '</div>';
            $result .= '</div>';
            $result .= '</div>';
        endwhile;
        wp_reset_postdata();
        $result .= '</div>';
        return $result;
    }
endif;

add_action('init', 'vc_nk_posts_fullscreen_list', 100);
if (!function_exists('vc_nk_posts_fullscreen_list')) :
    function vc_nk_posts_fullscreen_list()
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
        $post_types_list[] = array("custom_query", esc_html__("Custom Query", 'khaki-core'));
        $post_types_list[] = array("ids", esc_html__("List of IDs", 'khaki-core'));

        if (function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map(array(
                'name' => esc_html__('nK Posts Fullscreen List', 'khaki-core'),
                'base' => 'nk_posts_fullscreen_list',
                'controls' => 'full',
                'category' => 'nK',
                'icon' => 'icon-nk icon-nk-posts-list',
                'params' => array_merge(array(
                    /**
                     * General
                     */
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
                        "type" => "dropdown",
                        "heading" => esc_html__("Preview Description Type", 'khaki-core'),
                        "param_name" => "preview_description_type",
                        "value" => array(
                            esc_html__("Disabled", 'khaki-core') => 'false',
                            esc_html__("Excerpt", 'khaki-core') => 'excerpt',
                            esc_html__("Use more tag", 'khaki-core') => 'more',
                        ),
                        "description" => ""
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Trim to a words", 'khaki-core'),
                        "param_name" => "preview_description_trim_cnt",
                        "value" => 15,
                        "description" => esc_html__("cut in the number of words", 'khaki-core'),
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
                        "heading" => esc_html__("Custom Classes", 'khaki-core'),
                        "param_name" => "class",
                        "value" => "",
                        "description" => "",
                    ),


                    /**
                     * Query
                     */
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Data source", 'khaki-core'),
                        "group" => esc_html__("Query", 'khaki-core'),
                        "param_name" => "post_type",
                        "value" => $post_types_list,
                        "std" => "post",
                        "description" => esc_html__("Select content type", 'khaki-core')
                    ),
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
                            'values' => khaki_get_terms()
                        ),
                        'description' => esc_html__('Enter categories, tags or custom taxonomies.', 'khaki-core'),
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
                        "heading" => esc_html__("Data source relation", 'khaki-core'),
                        "group" => esc_html__("Query", 'khaki-core'),
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
                        "heading" => esc_html__("IDs", 'khaki-core'),
                        "group" => esc_html__("Query", 'khaki-core'),
                        "param_name" => "ids",
                        "description" => esc_html__("Type here the posts, pages, etc. IDs you want to use separated by coma. ex: 23,24,25", 'khaki-core'),
                        "dependency" => array(
                            "element" => "post_type",
                            "value" => array("ids"),
                        ),
                    ),
                    array(
                        "type" => "textarea_safe",
                        "heading" => esc_html__("Custom Query", 'khaki-core'),
                        "group" => esc_html__("Query", 'khaki-core'),
                        "param_name" => "custom_query",
                        "description" => sprintf(esc_html__("Build custom query according to %s.", 'khaki-core'), "<a href='http://codex.wordpress.org/Function_Reference/query_posts'>WordPress Codex</a>"),
                        "dependency" => array(
                            "element" => "post_type",
                            "value" => array("custom_query"),
                        ),
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
