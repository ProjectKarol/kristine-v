<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package khaki
 */

if (!function_exists('khaki_posts_navigation')) :
    /**
     * Display navigation to next/previous set of posts when applicable.
     *
     * @todo Remove this function when WordPress 4.3 is released.
     */
    function khaki_posts_navigation($query = null)
    {
        if ($query == null) {
            $queryName = isset($GLOBALS['yp_query']) ? 'yp_query' : 'wp_query';

            // Don't print empty markup if there's only one page.
            if ($GLOBALS[$queryName]->max_num_pages < 1) {
                return;
            }

            $query = $GLOBALS[$queryName];
        }
        $page_links = paginate_links(apply_filters('nk_pagination_args', array(
            'base' => esc_url_raw(str_replace(999999999, '%#%', remove_query_arg('add-to-cart', get_pagenum_link(999999999, false)))),
            'format' => '',
            'add_args' => '',
            'current' => max(1, get_query_var('page'), get_query_var('paged')),
            'total' => $query->max_num_pages,
            'prev_text' => '<span class="nk-icon-arrow-left"></span>',
            'next_text' => '<span class="nk-icon-arrow-right"></span>',
            'type' => 'array',
            'end_size' => 3,
            'mid_size' => 3
        )));
        if (!is_array($page_links)) {
            return;
        } else {
            $page_prev_or_next_links = $page_links;
            $prev_link = array_shift($page_prev_or_next_links);
            $next_link = array_pop($page_prev_or_next_links);
        }

        ?>
        <div class="nk-pagination nk-pagination-left">

            <nav>
                <?php foreach ($page_links as $cur) : ?>
                    <?php
                    if ((strpos($cur, 'prev page-numbers') === false) && (strpos($cur, 'next page-numbers') === false)):
                        if (strpos($cur, 'current') !== false):
                            $cur = str_replace('page-numbers current', khaki_sanitize_class('nk-pagination-current'), $cur);
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

        </div>
        <?php
    }
endif;

if (!function_exists('khaki_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function khaki_posted_on($get = false, $showDate = true, $showByline = true)
    {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
        }

        $time_string = sprintf($time_string,
            esc_attr(get_the_date('c')),
            esc_html(get_the_date())
        );

        $posted_on = '<span class="posted-on">' . sprintf(esc_html_x('%s %s', 'post date', 'khaki'), '<span class="fa fa-calendar"></span>', $time_string) . '</span>';

        $byline = '<span class="byline"> ' .
            sprintf(esc_html_x('by %s', 'post author', 'khaki'), '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>') .
            '</span>';

        if ($get) {
            return ($showDate ? wp_kses( $posted_on, khaki_allowed_html() ) : '') . ($showByline ? wp_kses( $byline, khaki_allowed_html() ) : '');
        } else {
            echo ($showDate ? wp_kses( $posted_on, khaki_allowed_html() ) : '') . ($showByline ? wp_kses( $byline, khaki_allowed_html() ) : '');
        }
    }
endif;
if (!function_exists('khaki_post_tags')) :
    /**
     * Prints HTML with post tags
     */
    function khaki_post_tags($comments_cnt_show = false, $likes_show = false, $views_cnt_show = false)
    {
        $posttags = get_the_tags();
        $tags_string = '';
        if ($posttags) {

            foreach ($posttags as $tag) {
                $tags_string .= '<a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a> ';

            }
        }
            $tags_string = sprintf(
                esc_html__('%s', 'khaki'),
                $tags_string
            ); // WPCS: XSS OK
            $likes_and_comments = '';
            if ($comments_cnt_show || $likes_show) {
                $likes_and_comments .= '<div class="nk-post-meta-right">';
            }
            if ($comments_cnt_show) {
                $likes_and_comments .= '<a class="nk-post-comments-count" href="#comments">' . get_comments_number(get_the_ID()) . '</a>';
            }
            if($views_cnt_show) {
                if (function_exists('pvc_get_post_views')){
                    $viewed_post = pvc_get_post_views();
                    $likes_and_comments .= '<span class="nk-views"><span class="ion-ios-eye"></span><span class="num">&nbsp;'.$viewed_post.'</span></span>';
                }
            }
            if ($likes_show && function_exists('sociality')) {
                $likes_and_comments .= sociality()->likes()->get_likes(get_the_ID(), 'post');
            }
            if ($comments_cnt_show || $likes_show) {
                $likes_and_comments .= '</div>';
            }
            echo ' <div class="nk-post-meta">
                    '.$likes_and_comments.'
                        <div class="nk-post-tags">&nbsp;' . $tags_string . '</div>
                        </div>';

    }
endif;
if (!function_exists('khaki_read_more')) :
    /**
     * Prints HTML with post tags
     */
    function khaki_read_more()
    {
        printf(
            '<a href="%s" class="btn read-more float-left">%s</a>',
            esc_url(get_permalink()),
            esc_html__('Read More', 'khaki')
        ); // WPCS: XSS OK
    }
endif;

if (!function_exists('khaki_entry_footer')) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function khaki_entry_footer()
    {
        edit_post_link(esc_html__('Edit', 'khaki'), '<div class="edit-link float-right">', '</div><div class="clearfix"></div>');
    }
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
if (!function_exists('khaki_categorized_blog')) :
    function khaki_categorized_blog()
    {
        if (false === ($all_the_cool_cats = get_transient('khaki_categories'))) {
            // Create an array of all the categories that are attached to posts.
            $all_the_cool_cats = get_categories(array(
                'fields' => 'ids',
                'hide_empty' => 1,
                // We only need to know if there is more than one category.
                'number' => 2,
            ));

            // Count the number of categories that are attached to the posts.
            $all_the_cool_cats = count($all_the_cool_cats);

            set_transient('khaki_categories', $all_the_cool_cats);
        }

        if ($all_the_cool_cats > 1) {
            // This blog has more than 1 category so khaki_categorized_blog should return true.
            return true;
        } else {
            // This blog has only 1 category so khaki_categorized_blog should return false.
            return false;
        }
    }
endif;
/**
 * Flush out the transients used in khaki_categorized_blog.
 */
if (!function_exists('khaki_category_transient_flusher')) :
    function khaki_category_transient_flusher()
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        // Like, beat it. Dig?
        delete_transient('khaki_categories');
    }
endif;

add_action('edit_category', 'khaki_category_transient_flusher');
add_action('save_post', 'khaki_category_transient_flusher');

if (!function_exists('khaki_comment_text')) :
    function khaki_comment_text($text = null)
    {
        if ($text == null) {
            $text = get_comment_text();
        }
        return wp_kses_post($text);
    }
endif;

if (!function_exists('khaki_show_media_extra_attachment_fields')) :
    function khaki_show_media_extra_attachment_fields($form_fields, $post)
    {
        $form_fields['link'] = array(
            'label' => 'Link',
            'input' => 'text',
            'value' => get_post_meta($post->ID, 'link', true),
            'helps' => 'This property is used only in the posts or in nk_images_carousel shortcode',
        );
        return $form_fields;
    }
endif;

if (!function_exists('khaki_save_media_extra_attachment_fields')) :
    function khaki_save_media_extra_attachment_fields($post, $attachment)
    {
        if (isset($attachment['link']))
            update_post_meta($post['ID'], 'link', $attachment['link']);
        return $post;
    }
endif;
add_filter('attachment_fields_to_edit', 'khaki_show_media_extra_attachment_fields', 10, 2);
add_filter('attachment_fields_to_save', 'khaki_save_media_extra_attachment_fields', 10, 2);

/**
 * Display navigation to next/previous set of posts comments when applicable.
 */
if (!function_exists('khaki_posts_comments_navigation')) :
    function khaki_posts_comments_navigation()
    {
        $paginate_comments_links = paginate_comments_links(array(
            'echo' => false,
            'prev_text' => '<span class="nk-icon-arrow-left"></span>',
            'next_text' => '<span class="nk-icon-arrow-right"></span>',
            'type' => 'array',
            'end_size' => 3,
            'mid_size' => 3));
        if (!is_array($paginate_comments_links)) {
            return;
        } else {
            $page_prev_or_next_links = $paginate_comments_links;
            $prev_link = array_shift($page_prev_or_next_links);
            $next_link = array_pop($page_prev_or_next_links);
        }
        ?>
        <div class="nk-pagination nk-pagination-left">
            <?php if (isset($prev_link)): ?>
                <?php if (strpos($prev_link, 'prev page-numbers') !== false): ?>
                    <?php echo(str_replace('prev page-numbers', khaki_sanitize_class('nk-pagination-prev'), $prev_link)); ?>
                <?php else: ?>
                    <a href="#"
                       class="nk-pagination-prev <?php echo khaki_sanitize_class(strpos($prev_link, 'current') !== false ? 'disabled' : ''); ?>">
                        <span class="nk-icon-arrow-left"></span>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
            <nav>
                <?php foreach ($paginate_comments_links as $cur) : ?>
                    <?php
                    if ((strpos($cur, 'prev page-numbers') === false) && (strpos($cur, 'next page-numbers') === false)):
                        if (strpos($cur, 'current') !== false):
                            $cur = str_replace('page-numbers current', khaki_sanitize_class('nk-pagination-current'), $cur);
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
                       class="nk-pagination-next <?php echo khaki_sanitize_class(strpos($next_link, 'current') !== false ? 'disabled' : ''); ?>">
                        <span class="nk-icon-arrow-right"></span>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php
    }
endif;
