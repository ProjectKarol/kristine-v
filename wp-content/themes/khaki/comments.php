<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package khaki
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div class="nk-comments" id="comments">

    <?php
    // You can start editing here -- including this comment!
    if (have_comments()) : ?>
        <h3 class="nk-title h4">
            <?php
            esc_html_e('Comments', 'khaki');
            ?>
        </h3>
        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through? ?>

            <?php khaki_posts_comments_navigation(); ?>

        <?php endif; // Check for comment navigation. ?>
        <div class="nk-gap"></div>
        <div class="clearfix"></div>
        <?php
        wp_list_comments(array(
            'walker' => new khaki_walker_comment(),
            'short_ping' => true,
            'avatar_size' => 60
        ));
        ?>
        <!-- .comment-list -->

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through? ?>
            <div class="nk-gap-2"></div>

            <?php khaki_posts_comments_navigation(); ?>

            <div class="nk-gap-3"></div>
            <?php
        endif; // Check for comment navigation.

    endif; // Check for have_comments().


    // If comments are closed and there are comments, let's leave a little note, shall we?
    if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>

        <p class="no-comments"><?php esc_html_e('Comments are closed.', 'khaki'); ?></p>
        <?php
    endif;
    $commenter = wp_get_current_commenter();
    $required_fields = array(
        'email' => array(
            'req_class' => get_option('require_name_email') ? " required" : '',
            'req_placeholder' => get_option('require_name_email') ? " *" : '',
        ),
        'author' => array(
            'req_class' => get_option('require_name_author') ? " required" : '',
            'req_placeholder' => get_option('require_name_author') ? " *" : '',
        ),
        'url' => array(
            'req_class' => get_option('require_name_url') ? " required" : '',
            'req_placeholder' => get_option('require_name_url') ? " *" : '',
        ),
    );

    comment_form(array(
        'title_reply' => '<h3 id="reply-title" class="nk-title h4">' . esc_html__('Post your comment', 'khaki') . '<small><a rel="nofollow" id="cancel-comment-reply-link" href="#respond" style="display:none;"> ' . esc_html__('Cancel reply', 'khaki') . '</a></small></h3>',
        'comment_notes_before' => '',
        'fields' => array(
            'email' => '<div class="row vertical-gap">
				<div class="col-md-4">
					<input type="email" class="' . khaki_sanitize_class('form-control' . $required_fields['email']['req_class']) . '" name="email"
						   placeholder="' . esc_html__('Email', 'khaki') . $required_fields['email']['req_placeholder'] . '" value="' . esc_attr($commenter['comment_author_email']) .
                '">
				</div>',
            'author' => '<div class="col-md-4">
					<input type="text" class="' . khaki_sanitize_class('form-control' . $required_fields['author']['req_class']) . '" name="author"
						   placeholder="' . esc_html__('Name', 'khaki') . $required_fields['author']['req_placeholder'] . '" value="' . esc_attr($commenter['comment_author']) .
                '">
				</div>',
            'url' => '<div class="col-md-4">
					<input type="url" class="' . khaki_sanitize_class('form-control' . $required_fields['url']['req_class']) . '" name="url" placeholder="' . esc_html__('Website', 'khaki') . $required_fields['url']['req_placeholder'] . '" value="' . esc_attr($commenter['comment_author_url']) .
                '">
				</div>
			</div>'
        ),
        'class_submit' => 'hidden button',
        'class_form' => 'nk-form nk-form-style-1',
        'comment_field' => '<div class="nk-gap-1"></div>
                                <textarea class="form-control required" name="comment" rows="5" placeholder="' . esc_html__('Comment', 'khaki') . ' *"
										  aria-required="true"></textarea>
			<div class="nk-gap-1"></div>
			<div class="nk-form-response-success"></div>
			<div class="nk-form-response-error"></div>',
        'comment_notes_after' => '<button type="submit" class="nk-btn nk-btn-effect-2-right nk-btn-color-dark-1"><span>' . esc_html__('Reply', 'khaki') . '</span><span class="icon"><span class="ion-ios-undo"></span></span></button>'
    ));

    ?>
</div><!-- #comments -->
