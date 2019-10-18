<?php
// bbPress is active
if (!class_exists('bbPress')) {
    return;
}

/**
 *  Enabling tinymce editor
 */
if(khaki_get_theme_mod('bbpress_tinymce')):
    if (!function_exists('khaki_bbp_enable_visual_editor')):
        function khaki_bbp_enable_visual_editor( $args = array() ) {
            $args['tinymce'] = true;
            return $args;
        }
    endif;
    add_filter( 'bbp_after_get_the_content_parse_args', 'khaki_bbp_enable_visual_editor' );
endif;

/**
 *  Filter change subscribe button styles
 */
if (!function_exists('khaki_filter_bbp_get_forum_subscribe_link')):
    // define the bbp_get_topic_favorite_link callback
    function khaki_filter_bbp_get_forum_subscribe_link( $retval, $r ) {
        $retval = str_replace('subscription-toggle', 'nk-btn nk-btn-color-black nk-btn-color-hover-dark-4', $retval);
        return $retval;
    };
endif;
add_filter( 'bbp_get_forum_subscribe_link', 'khaki_filter_bbp_get_forum_subscribe_link', 10, 2 );
add_filter( 'bbp_get_topic_subscribe_link', 'khaki_filter_bbp_get_forum_subscribe_link', 10, 2 );
/**
 *  Filter change favorite button styles
 */
if (!function_exists('khaki_filter_bbp_get_topic_favorite_link')):
    // define the bbp_get_topic_favorite_link callback
    function khaki_filter_bbp_get_topic_favorite_link( $retval, $r ) {
        $result = apply_filters('bbp_get_forum_favorite_link', $retval, $r);
        //redefined subscribe styles
        if (!empty($result)) {
            $result = str_replace('favorite-toggle', 'nk-btn nk-btn-md nk-btn-rounded', $result);
        }
        return $result;
    };
endif;
add_filter( 'bbp_get_topic_favorite_link', 'khaki_filter_bbp_get_topic_favorite_link', 10, 2 );
/**
 *  Filter change default container of textareas
 */
if (!function_exists('khaki_filter_bbp_get_the_content')):
    function khaki_filter_bbp_get_the_content($output, $args, $post_content)
    {
        return '<div class="nk-bbpress-editor">' . $output . '</div><div class="nk-gap"></div>';
    }
endif;
add_filter('bbp_get_the_content', 'khaki_filter_bbp_get_the_content', 10, 3);
/**
 *  Filter change default container of dropdowns
 */
if (!function_exists('khaki_filter_bbp_get_dropdown')):
    function khaki_filter_bbp_get_dropdown($retval, $r)
    {
        return '<div class="nk-bbpress-dropdown">' . $retval . '</div><div class="nk-gap"></div>';
    }
endif;
add_filter('bbp_get_dropdown', 'khaki_filter_bbp_get_dropdown', 10, 2);
add_filter('bbp_get_form_topic_type_dropdown', 'khaki_filter_bbp_get_dropdown', 10, 2);
add_filter('bbp_get_form_topic_status_dropdown', 'khaki_filter_bbp_get_dropdown', 10, 2);
/**
 *  Redefined notice and error messages. Add supported nk_info_box shortcode
 */
if (!function_exists('khaki_bbp_template_notices')):
    add_action('khaki_bbp_template_notices', 'khaki_bbp_template_notices');
    function khaki_bbp_template_notices()
    {

        // Bail if no notices or errors
        if (!bbp_has_errors())
            return;

        // Define local variable(s)
        $errors = $messages = array();

        // Get bbPress
        $bbp = bbpress();

        // Loop through notices
        foreach ($bbp->errors->get_error_codes() as $code) {

            // Get notice severity
            $severity = $bbp->errors->get_error_data($code);

            // Loop through notices and separate errors from messages
            foreach ($bbp->errors->get_error_messages($code) as $error) {
                if ('message' === $severity) {
                    $messages[] = $error;
                } else {
                    $errors[] = $error;
                }
            }
        }

        // Display errors first...
        if (!empty($errors)) : ?>
            <?php foreach ($errors as $error):
                echo '<div class="nk-info-box bg-danger"><div class="nk-info-box-icon"><span class="ion-ios-alert"></span></div>' . html_entity_decode($error) . '</div>';
            endforeach; ?>
        <?php endif;

        // ...and messages last
        if (!empty($messages)) : ?>
            <?php foreach ($messages as $message):
                echo '<div class="nk-info-box bg-main-1"><div class="nk-info-box-icon"><span class="ion-ios-information-circle"></span></div>' . html_entity_decode($message) . '</div>';
            endforeach; ?>
        <?php endif;
    }
endif;
/**
 *  Redefined notice of user update. Add supported nk_info_box shortcode
 */
add_action('khaki_bbp_template_notices', 'khaki_bbp_notice_edit_user_success');
if (!function_exists('khaki_bbp_notice_edit_user_success')):
    function khaki_bbp_notice_edit_user_success()
    {
        if (isset($_GET['updated']) && (bbp_is_single_user() || bbp_is_single_user_edit())){
            echo '<div class="nk-info-box bg-main-1"><div class="nk-info-box-icon"><span class="ion-ios-information-circle"></span></div>' . esc_html__('User updated.', 'khaki') . '</div>';
        }
    }
endif;
/**
 *  Redefined notice of have user super admin privileges
 */
add_action('khaki_bbp_template_notices', 'khaki_bbp_notice_edit_user_is_super_admin', 2);
if (!function_exists('khaki_bbp_notice_edit_user_is_super_admin')):
    function khaki_bbp_notice_edit_user_is_super_admin()
    {
        if (is_multisite() && (bbp_is_single_user() || bbp_is_single_user_edit()) && current_user_can('manage_network_options') && is_super_admin(bbp_get_displayed_user_id())) {
            echo '<div class="nk-info-box bg-main-1"><div class="nk-info-box-icon"><span class="ion-ios-information-circle"></span></div>' . bbp_is_user_home() || bbp_is_user_home_edit() ? esc_html__('You have super admin privileges.', 'khaki') : esc_html__('This user has super admin privileges.', 'khaki') . '</div>';
        }
    }
endif;
/**
 *  Filter change default status-closed class
 */
if (!function_exists('khaki_filter_bbp_get_topic_class')):
// define the callback class function, redefined status-closed class and other bbpress standard classes
    function khaki_filter_bbp_get_topic_class($classes, $topic_id)
    {
        if (!array_search('status-publish', $classes) || array_search('bbp-forum-status-closed', $classes)) {
            $classes[] = 'nk-forum-locked';
        }
        return $classes;
    }
endif;
add_filter('bbp_get_topic_class', 'khaki_filter_bbp_get_topic_class', 10, 2);
add_filter('bbp_get_forum_class', 'khaki_filter_bbp_get_topic_class', 10, 2);
/**
 *  Filter change returned data pagination format
 */
    if (!function_exists('khaki_bb_pagination')) :
        function khaki_bb_pagination($args)
        {
            $args['type'] = 'array';
            return $args;
        }
    endif;
add_filter('bbp_topic_pagination', 'khaki_bb_pagination');
add_filter('bbp_replies_pagination', 'khaki_bb_pagination');
add_filter('bbp_search_results_pagination', 'khaki_bb_pagination');
/**
 *  Full redefined default bbpress pagination
 */
if (!function_exists('khaki_bb_output_pagination')):
    function khaki_bb_output_pagination($page_links = null)
    {
        if ($page_links == null) {
            return;
        }
        ?>
        <div class="clearfix"></div>
        <?php if (is_array($page_links)): ?>
        <div class="nk-pagination nk-pagination-left">
            <?php foreach ($page_links as $key => $cur) : ?>
                <?php if (strpos($cur, 'prev page-numbers') !== false && $key == 0): ?>
                    <?php
                    $prev = str_replace('&larr;', '<span class="nk-icon-arrow-left"></span>', $cur);
                    echo str_replace('prev page-numbers', 'nk-pagination-prev', $prev);
                    ?>
                    <nav>
                <?php elseif ($key == 0): ?>
                    <a href="#" class="nk-pagination-prev disabled">
                        <span class="nk-icon-arrow-left"></span>
                    </a>
                    <nav>
                <?php endif; ?>
                <?php if (strpos($cur, 'next page-numbers') == false && strpos($cur, 'prev page-numbers') == false): ?>
                    <?php echo str_replace('page-numbers current', 'nk-pagination-current-white', $cur); ?>
                <?php endif; ?>
                <?php if (strpos($cur, 'next page-numbers') !== false && $key > 0): ?>
                    </nav>
                    <?php
                    $next = str_replace('&rarr;', '<span class="nk-icon-arrow-right"></span>', $cur);
                    echo str_replace('next page-numbers', 'nk-pagination-next', $next);
                    ?>
                <?php elseif
                (count($page_links) - 1 == $key
                ): ?>
                    </nav>
                    <a href="#" class="nk-pagination-next disabled">
                        <span class="nk-icon-arrow-right"></span>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif;
    }
endif;
/**
 *  Filter change returned layout freshness links
 */
if (!function_exists('khaki_filter_bbp_get_forum_freshness_link')):
// define the bbp_get_forum_freshness_link callback
    function khaki_filter_bbp_get_forum_freshness_link($anchor, $forum_id, $time_since)
    {
        //copy bbp_get_forum_freshness_link method
        $result = '';
        $active_id = bbp_get_forum_last_active_id($forum_id);
        $link_url = $title = '';
        if (empty($active_id))
            $active_id = bbp_get_forum_last_reply_id($forum_id);

        if (empty($active_id))
            $active_id = bbp_get_forum_last_topic_id($forum_id);

        if (bbp_is_topic($active_id)) {
            $link_url = bbp_get_forum_last_topic_permalink($forum_id);
            $title = bbp_get_forum_last_topic_title($forum_id);
        } elseif (bbp_is_reply($active_id)) {
            $link_url = bbp_get_forum_last_reply_url($forum_id);
            $title = bbp_get_forum_last_reply_title($forum_id);
        }
        if (isset($title) && !empty($title)) {
            $result .= '<div class="nk-forum-activity-title" title="' . $title . '">';
            if (isset($link_url) && !empty($link_url)) {
                $result .= '<a href="' . esc_url($link_url) . '">';
            }
            $result .= $title;
            if (isset($link_url) && !empty($link_url)) {
                $result .= '</a>';
            }
            $result .= '</div>';
        }
        if (isset($time_since) && !empty($time_since)) {
            $result .= '<div class="nk-forum-activity-date">';
            $result .= $time_since;
            $result .= '</div>';
        }
        if (isset($result) && !empty($result)) {
            $result = $result;
        } else {
            $result = $anchor;
        }
        return $result;
    }
endif;
add_filter('bbp_get_forum_freshness_link', 'khaki_filter_bbp_get_forum_freshness_link', 10, 3);
/**
 *  Filter change returned layout member since date
 */
add_action('bbp_theme_after_topic_author_details', 'khaki_bbp_add_since_date');
add_action('bbp_theme_after_reply_author_details', 'khaki_bbp_add_since_date');
if (!function_exists('khaki_bbp_add_since_date')):
    function khaki_bbp_add_since_date()
    { ?>
        <div class="nk-forum-topic-author-since">
            <?php printf(esc_html__('Member since: %s', 'khaki'),
                date(get_option('date_format'), strtotime(get_the_author_meta('user_registered')))
            ); ?>
        </div>
    <?php }
endif;
/**
 *  Filter clears the returned admin links string of delimiters '|'
 */
if (!function_exists('khaki_bbp_get_admin_links')):
    function khaki_bbp_get_admin_links($retval, $r, $args)
    {
        $retval = str_replace(' | ', '', $retval);
        return $retval;
    }
endif;
add_filter('bbp_get_reply_admin_links', 'khaki_bbp_get_admin_links', 10, 3);
add_filter('bbp_get_topic_admin_links', 'khaki_bbp_get_admin_links', 10, 3);
/**
 *  Filter redefined returned layout admin links and add icons
 */
if (!function_exists('khaki_filter_bbp_reply_admin_links')):
function khaki_filter_bbp_reply_admin_links($array, $r_id)
{
    $pattern="/>(?:.*)</";
    if (isset($array['edit']) && !empty($array['edit'])) {
        $result=array();
        preg_match($pattern, $array['edit'], $result);
        $array['edit'] = '<span class="nk-forum-action-btn">' . preg_replace($pattern, '><span class="ion-edit"></span' .$result[0] , $array['edit']) . '</span>';
    }
    if (isset($array['spam']) && !empty($array['spam'])) {
        $result=array();
        preg_match($pattern, $array['spam'], $result);
        $array['spam'] = '<span class="nk-forum-action-btn">' . preg_replace($pattern, '><span class="fa fa-flag"></span' . $result[0] , $array['spam']) . '</span>';
    }
    if (isset($array['move']) && !empty($array['move'])) {
        $result=array();
        preg_match($pattern, $array['move'], $result);
        $array['move'] = '<span class="nk-forum-action-btn">' . preg_replace($pattern, '><span class="ion-arrow-move"></span' . $result[0] , $array['move']) . '</span>';
    }
    if (isset($array['reply']) && !empty($array['reply'])) {
        $result=array();
        preg_match($pattern, $array['reply'], $result);
        $array['reply'] = '<span class="nk-forum-action-btn">' . preg_replace($pattern, '><span class="fa fa-reply"></span' . $result[0], $array['reply']) . '</span>';
    }
    if (isset($array['trash']) && !empty($array['trash'])) {
        $result=array();
        preg_match($pattern, $array['trash'], $result);
        $array['trash'] = '<span class="nk-forum-action-btn">' . preg_replace($pattern, '><span class="fa fa-trash"></span' . $result[0], $array['trash']) . '</span>';
    }
    if (isset($array['split']) && !empty($array['split'])) {
        $result=array();
        preg_match($pattern, $array['split'], $result);
        $array['split'] = '<span class="nk-forum-action-btn">' . preg_replace($pattern, '><span class="fa fa-columns"></span' . $result[0], $array['split']) . '</span>';
    }
    if (isset($array['merge']) && !empty($array['merge'])) {
        $result=array();
        preg_match($pattern, $array['merge'], $result);
        $array['merge'] = '<span class="nk-forum-action-btn">' . preg_replace($pattern, '><span class="fa fa-compress"></span' . $result[0], $array['merge']) . '</span>';
    }
    if (isset($array['stick']) && !empty($array['stick'])) {
        $result=array();
        preg_match($pattern, $array['stick'], $result);
        $array['stick'] = '<span class="nk-forum-action-btn">' . preg_replace($pattern, '><span class="fa fa-sticky-note-o"></span' . $result[0], $array['stick']) . '</span>';
    }
    if (isset($array['close']) && !empty($array['close'])) {
        $result=array();
        preg_match($pattern, $array['close'], $result);
        $array['close'] = '<span class="nk-forum-action-btn">' . preg_replace($pattern, '><span class="ion-ios-lock"></span' .$result[0], $array['close']) . '</span>';
    }
    if (isset($array['open']) && !empty($array['open'])) {
        $result=array();
        preg_match($pattern, $array['open'], $result);
        $array['open'] = '<span class="nk-forum-action-btn">' . preg_replace($pattern, '><span class="ion-unlocked"></span' . $result[0], $array['open']) . '</span>';
    }
    return $array;
}
endif;
add_filter('bbp_reply_admin_links', 'khaki_filter_bbp_reply_admin_links', 10, 2);
add_filter('bbp_topic_admin_links', 'khaki_filter_bbp_reply_admin_links', 10, 2);
/**
* Filter redefined returned bbpress breadcrumbs. Ignored empty crumbs and not show on screen
* */
if(!function_exists('khaki_filter_bbp_get_breadcrumb')):
    function khaki_filter_bbp_get_breadcrumb($trail, $crumbs, $r){
        $result='';
        foreach($crumbs as $crumb){
            if(preg_match('#>(.+?)<#is',$crumb)){//not show crumb if empty text crumbs
                $result.='<li>'.$crumb.'</li>';
            }
        }
        return $result;
    }
endif;
add_filter('bbp_get_breadcrumb', 'khaki_filter_bbp_get_breadcrumb', 10, 3);

if(!function_exists('khaki_bbp_get_reply_author_avatar')):
    function khaki_bbp_get_reply_author_avatar($reply_id = 0){

        $result = '';

        if($reply_id == 0){
            $reply_id = bbp_get_reply_id();
        }

        $author_url = bbp_get_reply_author_url( $reply_id );

        if(isset($author_url)){
            $result .='<a href="'.esc_url($author_url).'">';
        }

        $result .= bbp_get_reply_author_avatar($reply_id, 80);

        if(isset($author_url)){
            $result .='</a>';
        }

        return apply_filters( 'khaki_bbp_get_reply_author_avatar', $result, $reply_id, $author_url );
    }
endif;
