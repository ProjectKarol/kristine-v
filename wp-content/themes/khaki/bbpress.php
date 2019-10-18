<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package khaki
 */

get_header();
get_template_part('/template-parts/header/bbpress');
?>
<?php if (get_the_title() && khaki_get_theme_mod('bbpress_show_title', false)): ?>
    <!-- START: Header Title -->
    <div class="nk-gap-4"></div>
    <div class="nk-box">
        <div class="container">
            <h1 class="nk-title">
                <?php bbp_reply_topic_title();?>
            </h1>
        </div>
    </div>
    <!-- END: Header Title -->
<?php endif;?>
<div class="<?php echo khaki_sanitize_class(khaki_get_theme_mod('bbpress_inner_boxed', false) ? 'container' : 'container-fluid'); ?>">
        <div class="row">
            <div class="col-12">
                <?php if(!bbp_is_single_user()):?>
                <div class="nk-gap-4"></div>
                <?php endif;?>
                <?php
                while (have_posts()) : the_post();

                    get_template_part('template-parts/content', 'page');

                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;

                endwhile; // End of the loop.
                ?>
                <?php if(!bbp_is_single_user()):?>
                    <div class="nk-gap-4"></div>
                <?php endif;?>
            </div>
        </div>

    </div>

<?php
get_footer();
