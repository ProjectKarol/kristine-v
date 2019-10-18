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
get_template_part('/template-parts/header/single');
$post_type = get_post_type();
if (!$post_type) {
    $post_type = 'page';
}
//use acf settings (return true or null)
$acf_meta = khaki_get_theme_mod('page_meta_custom', true);
$acf_sidebar = khaki_get_theme_mod('sidebar_page_custom', true);
$acf_content = khaki_get_theme_mod('content_page_custom', true);
$acf_header = khaki_get_theme_mod('page_header_custom', true);

$custom_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_list', $acf_sidebar);
$show_custom_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_show', $acf_sidebar);
$custom_sidebar_side = khaki_get_theme_mod('sidebar_' . $post_type . '_side', $acf_sidebar);

$col_class = 'col-12';

if ($show_custom_sidebar && $custom_sidebar && is_active_sidebar($custom_sidebar)) {
    if (isset($custom_sidebar_side) && $custom_sidebar_side === 'both') {
        $col_class = 'col-lg-6';
    } else {
        $col_class = 'col-lg-8';
    }
}

?>
    <div class="<?php echo khaki_sanitize_class(khaki_get_theme_mod('single_page_boxed', $acf_content) ? 'container' : 'container-fluid'); ?>">
        <div class="row">
            <div class="<?php echo khaki_sanitize_class($col_class); ?>">
                <?php if(khaki_get_theme_mod('single_page_paddings', $acf_content)):?>
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
                <?php if(khaki_get_theme_mod('single_page_paddings', $acf_content)):?>
                    <div class="nk-gap-4"></div>
                <?php endif;?>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
<?php
get_footer();
