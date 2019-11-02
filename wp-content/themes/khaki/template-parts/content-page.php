<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package khaki
 */
$acf_content = khaki_get_theme_mod('content_page_custom', true);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if (khaki_get_theme_mod('single_page_content_show_title', $acf_content)): ?>
        <header class="entry-header">
            <h1 class="entry-title">
                <?php
                $custom_title = khaki_get_theme_mod('single_page_content_custom_title', $acf_content);
                echo $custom_title ? esc_html($custom_title) : get_the_title();
                ?>
            </h1>
        </header><!-- .entry-header -->
    <?php endif; ?>
    <div class="entry-content">
        <?php
        the_content();

        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'khaki'),
            'after' => '</div>',
        ));
        ?>
    </div><!-- .entry-content -->
</article><!-- #post-## -->
