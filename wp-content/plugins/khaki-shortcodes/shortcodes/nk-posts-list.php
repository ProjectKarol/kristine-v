<?php
/**
 * nK Posts List
 *
 * Example:
 * [nk_posts_list post_type="post" ids="" exclude_ids="" custom_query="" taxonomies="" count="5" pagination="false" boxed="false"]
 */

add_shortcode('nk_posts_list', 'nk_posts_list');
if (!function_exists('nk_posts_list')) :
    function nk_posts_list($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "style" => 'classic',
            "simple_view" => false,
            "spacing_between_news" => 65,
            "title_looks_like" => false,
            "columns" => 1,
            "preview_description_type" => 'false',
            "preview_description_trim_cnt" => 15,
            "post_type" => "post",
            "taxonomies" => "",
            "taxonomies_relation" => "OR",
            "ids" => "",
            "custom_query" => "",
            "exclude_ids" => "",
            'orderby' => 'post_date',
            'order' => 'DESC',
            "count" => 5,
            "pagination" => false, // false, true, 'load_more', 'infinite'
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
            'paged' => $paged,
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

        if ($pagination === 'infinite') {
            $class .= ' nk-infinite-scroll-container';
        }
        if ($pagination === 'load_more') {
            $class .= ' nk-load-more-container';
        }

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);

        if($style == 'classic' && $columns>1 && $columns<=3){
            $class .=' nk-blog-isotope nk-isotope nk-isotope-gap nk-isotope-'.$columns.'-cols';
        }else{
            $class.=' nk-blog-list';
        }
        $before = $after = '';

        ob_start();
        echo wp_kses_post($before);

        ?>
        <div class="<?php echo khaki_sanitize_class($class); ?>"> <?php
            $yp_query = new WP_Query($query_opts);
            $counter = 0;
            while ($yp_query->have_posts()) : $yp_query->the_post();
                //get_template_part('template-parts/content');
                ?>
                <?php if($style == 'classic' && $columns>1 && $columns<=3):
                   echo '<div class="nk-isotope-item news-one">';
                endif;
                ?>
                <?php
                $style_spacing_between_news = '';
                if(khaki_nk_check($spacing_between_news) && is_numeric($spacing_between_news)){
                    $style_spacing_between_news = ' style="margin-bottom:'.esc_attr($spacing_between_news).'px"';
                }
                ?>
                <div id="post-<?php the_ID(); ?>" <?php post_class('nk-blog-post'.(($columns<=1 || $columns=='') ? ' news-one' : ''));?><?php echo $style_spacing_between_news;?>>
                    <?php if($style == 'list'):?>
                    <div class="row vertical-gap">
                        <?php
                        ob_start();
                        get_template_part('template-parts/content', 'post-list-preview');
                        $post_list_preview = trim(ob_get_contents());
                        ob_end_clean();
                        $content_class = 'col-lg-7';
                        if($post_list_preview){
                            echo '<div class="col-lg-5">';
                            echo $post_list_preview;
                            echo '</div>';
                        }else{
                            $content_class = 'col-lg-12';
                        }
                        ?>
                        <div class="<?php echo khaki_sanitize_class($content_class);?>">
                            <div class="nk-post-meta nk-post-meta-top pb-0">
                                <div class="nk-post-date nk-post-meta-right">
                                    <?php $time_string = get_the_time(esc_html__('F j, Y ', 'khaki-shortcodes'));
                                    echo $time_string; ?>
                                    <span class="nk-post-by"><?php esc_html_e('by', 'khaki-shortcodes'); ?>
                                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))) ?>">
                                            <?php echo esc_html(get_the_author()); ?>
                                        </a>
                                    </span>
                                </div>
                            </div>

                            <?php get_template_part('template-parts/content', 'post-list-category'); ?>

                            <?php the_title(sprintf('<h2 class="nk-post-title '.khaki_sanitize_class($title_looks_like).'"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>');?>
                            <?php
                            //template part for output post description
                            $format = get_post_format();
                            ?>
                            <?php if ($preview_description_type != 'false' && $format!='quote'): ?>
                                <div class="nk-post-text">
                                    <?php
                                    if ($preview_description_type == 'excerpt' && $preview_description_trim_cnt > 0) {
                                        khaki_excerpt_max_charlength($preview_description_trim_cnt);
                                    } elseif ($preview_description_type == 'more') {
                                        the_content();
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>

                            <div class="nk-post-continue text-left">
                                <a href="<?php echo esc_url(get_permalink()) ?>"><?php esc_html_e('Continue Reading', 'khaki-shortcodes'); ?>
                                    <span class="ion-ios-arrow-thin-right"></span></a>
                            </div>
                        </div>
                    </div>
                    <?php elseif($style == 'classic'):?>
                    <?php get_template_part('template-parts/content', 'post-list-category'); ?>

                    <?php the_title(sprintf('<h2 class="nk-post-title '.khaki_sanitize_class($title_looks_like).'"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>');?>

                    <?php if(!khaki_nk_check($simple_view)):?>
                    <?php get_template_part('template-parts/content', 'post-list-preview');?>
                    <?php endif;?>
                    <?php
                    //template part for output post description
                    $format = get_post_format();
                    ?>
                    <?php if ($preview_description_type != 'false' && $format!='quote'): ?>
                        <div class="nk-post-text">
                            <?php
                            if ($preview_description_type == 'excerpt' && $preview_description_trim_cnt > 0) {
                                khaki_excerpt_max_charlength($preview_description_trim_cnt);
                            } elseif ($preview_description_type == 'more') {
                                the_content();
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                        <?php if(!khaki_nk_check($simple_view)):?>
                        <div class="nk-post-continue">
                            <a href="<?php echo esc_url(get_permalink()) ?>"><?php esc_html_e('Continue Reading', 'khaki-shortcodes'); ?>
                                <span class="ion-ios-arrow-thin-right"></span></a>
                        </div>
                        <div class="nk-post-meta">
                            <?php get_template_part('template-parts/content', 'post-list-meta'); ?>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php if($style == 'classic' && $columns>1 && $columns<=3):
                    echo '</div>';
                endif;
                ?>
                <?php
            endwhile;
            ?>
        </div>

        <div class="clearfix"></div>
        <?php if (khaki_nk_check($pagination)) {
        khaki_posts_navigation($yp_query);

        if ($pagination == 'infinite' || $pagination == 'load_more') {
            nk_infinite_scroll_init($yp_query);
        }
    } ?>
        <div class="nk-gap-4"></div>
        <div class="nk-gap-3"></div>
        <?php echo wp_kses_post($after); ?>

        <?php
        wp_reset_postdata();

        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }
endif;


add_action('init', 'vc_nk_posts_list', 100);
if (!function_exists('vc_nk_posts_list')) :
    function vc_nk_posts_list()
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
                'name' => esc_html__('nK Posts List', 'khaki-shortcodes'),
                'base' => 'nk_posts_list',
                'controls' => 'full',
                'category' => 'nK',
                'icon' => 'icon-nk icon-nk-posts-list',
                'params' => array_merge(array(
                    /**
                     * General
                     */
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Style", 'khaki-shortcodes'),
                        "param_name" => "style",
                        "value" => array(
                            esc_html__("Classic", 'khaki-shortcodes') => "classic",
                            esc_html__("List", 'khaki-shortcodes') => 'list',
                        ),
                        "description" => ""
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Number of Columns", 'khaki-shortcodes'),
                        "param_name" => "columns",
                        "value" => 1,
                        "description" => "Enter an integer from 1 to 3",
                        'dependency' => array(
                            'element' => 'style',
                            'value_not_equal_to' => array(
                                'list'
                            ),
                        ),
                    ),
                    array(
                        'param_name'  => 'simple_view',
                        'heading'     => esc_html__('Simple View', 'khaki-shortcodes'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                        'dependency' => array(
                            'element' => 'style',
                            'value_not_equal_to' => array(
                                'list'
                            ),
                        ),
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Title Looks Like', 'khaki-shortcodes'),
                        'param_name' => 'title_looks_like',
                        'std'        => 'h3',
                        'value'      => array(
                            esc_html__('disabled', 'khaki-shortcodes')  => false,
                            esc_html__('h1', 'khaki-shortcodes')  => 'h1',
                            esc_html__('h2', 'khaki-shortcodes')  => 'h2',
                            esc_html__('h3', 'khaki-shortcodes')  => 'h3',
                            esc_html__('h4', 'khaki-shortcodes')  => 'h4',
                            esc_html__('h5', 'khaki-shortcodes')  => 'h5',
                            esc_html__('h6', 'khaki-shortcodes')  => 'h6',
                            esc_html__('display-1', 'khaki-shortcodes')  => 'display-1',
                            esc_html__('display-2', 'khaki-shortcodes')  => 'display-2',
                            esc_html__('display-3', 'khaki-shortcodes')  => 'display-3',
                            esc_html__('display-4', 'khaki-shortcodes')  => 'display-4',
                        ),
                        'description' => ''
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Spacing Between News", 'khaki-shortcodes'),
                        "param_name" => "spacing_between_news",
                        "value" => 65,
                        "description" => esc_html__("Add margin bottom for all news elements", 'khaki-shortcodes'),
                    ),
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
                        "type" => "dropdown",
                        "heading" => esc_html__("Preview Description Type", 'khaki-shortcodes'),
                        "param_name" => "preview_description_type",
                        "value" => array(
                            esc_html__("Disabled", 'khaki-shortcodes') => 'false',
                            esc_html__("Excerpt", 'khaki-shortcodes') => 'excerpt',
                            esc_html__("Use more tag", 'khaki-shortcodes') => 'more',
                        ),
                        "description" => ""
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
                ), khaki_get_css_tab()
                )
            ));
        }
    }
endif;