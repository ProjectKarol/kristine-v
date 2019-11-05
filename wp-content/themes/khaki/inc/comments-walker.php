<?php

add_filter( 'comment_form_fields', 'khaki_move_comment_field_to_bottom' );
if (!function_exists('khaki_move_comment_field_to_bottom')):
    function khaki_move_comment_field_to_bottom( $fields ) {
        $comment_field = $fields['comment'];
        unset( $fields['comment'] );
        $fields['comment'] = $comment_field;
        return $fields;
    }
endif;

/** COMMENTS WALKER */
class khaki_walker_comment extends Walker_Comment
{

    // init classwide variables
    var $tree_type = 'comment';
    var $db_fields = array('parent' => 'comment_parent', 'id' => 'comment_ID');

    /** CONSTRUCTOR
     * You'll have to use this if you plan to get to the top of the comments list, as
     * start_lvl() only goes as high as 1 deep nested comments */
    function __construct()
    { ?>

        <!--<ul class="comments-list">-->

    <?php }

    /** START_LVL
     * Starts the list before the CHILD elements are added. */
    function start_lvl(&$output, $depth = 0, $args = array())
    {
        $GLOBALS['comment_depth'] = $depth + 1; ?>

        <!--<ul class="child-comment">-->

    <?php }

    /** END_LVL
     * Ends the children list of after the elements are added. */
    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $GLOBALS['comment_depth'] = $depth + 1; ?>

        <!-- /.children -->

    <?php }

    /** START_EL */
    function start_el(&$output, $comment, $depth = 0, $args = Array(), $id = 0)
    {
        $depth++;
        $GLOBALS['comment_depth'] = $depth;
        $GLOBALS['comment'] = $comment;
        $parent_class = (empty($args['has_children']) ? '' : 'parent'); ?>

        <div <?php comment_class($parent_class . ' nk-comment'); ?> id="comment-<?php comment_ID() ?>">

        <div class="nk-comment-avatar">
            <?php echo($args['avatar_size'] != 0 ? get_avatar($comment, $args['avatar_size']) : ''); ?>
        </div>
        <div class="nk-comment-meta">
            <div class="nk-comment-name h5"><?php echo get_comment_author_link(); ?></div>
            <div class="nk-comment-date">
                <?php comment_date(); ?>
                <?php edit_comment_link('(Edit)'); ?>

                <div class="nk-comment-reply"><?php
                    comment_reply_link(array_merge($args, array(
                        'add_below' => isset($args['add_below']) ? $args['add_below'] : 'comment',
                        'depth' => $depth,
                        'max_depth' => $args['max_depth'],
                        'reply_text' => sprintf(esc_html__('%s Reply', 'khaki'), '<span class="ion-ios-undo"></span>')
                    )), $comment->comment_ID);
                    ?>
                </div>
                <?php
                if (function_exists('sociality')) {
                    echo sociality()->likes()->get_likes(get_comment_ID(), 'comment');
                }
                ?>
            </div>
        </div>
        <p>
            <?php if (!$comment->comment_approved) : ?>
                <em class="comment-awaiting-moderation"><?php esc_html_e("Your comment is awaiting moderation.", 'khaki');?></em>
            <?php else:
                echo khaki_comment_text();
                ?>
            <?php endif; ?>
        </p>
        <div class="comment-cont clearfix"></div>
    <?php }

    function end_el(&$output, $comment, $depth = 0, $args = array())
    { ?>

        </div><!-- /#comment-' . get_comment_ID() . ' -->

    <?php }

    /** DESTRUCTOR
     * I'm just using this since we needed to use the constructor to reach the top
     * of the comments list, just seems to balance out nicely:) */
    function __destruct()
    { ?>

        <!-- /#comment-list -->

    <?php }
}
