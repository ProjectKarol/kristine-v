<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package khaki
 */

get_header();
get_template_part('/template-parts/header/archive');
?>
    <div
        class="<?php echo khaki_sanitize_class(khaki_get_theme_mod('archive_boxed') ? 'container' : 'container-fluid'); ?>">
        <div class="nk-gap-4"></div>
        <?php if (khaki_get_theme_mod('archive_show_title', true)): ?>
            <?php
            if(is_front_page()){
                echo '<h1 class="nk-title">';
                echo wp_get_document_title();
                echo '</h1>';
            }else{
                the_archive_title('<h1 class="nk-title">', '</h1>');
            } ?>
        <?php endif; ?>
        <?php
        $pagination = khaki_get_theme_mod('archive_pagination', true);
        $class = '';
        if (isset($pagination) && $pagination === 'infinite') {
            $class .= ' nk-infinite-scroll-container';
        }
        if (isset($pagination) && $pagination === 'load_more') {
            $class .= ' nk-load-more-container';
        }
        $style = khaki_get_theme_mod('archive_list_style_content', true);
        $columns = khaki_get_theme_mod('archive_list_columns_content', true);
        $simple_view = khaki_get_theme_mod('archive_simple_view');
        $show_continue_button =  khaki_get_theme_mod('archive_show_continue_button');
        $preview_description_type = khaki_get_theme_mod('archive_preview_description_type_content', true);
        $preview_description_trim_cnt = khaki_get_theme_mod('archive_preview_description_trim_cnt', true);
        if ($style == 'classic' && $columns > 1 && $columns <= 3) {
            $class .= ' nk-blog-isotope nk-isotope nk-isotope-gap nk-isotope-' . $columns . '-cols';
        } else {
            $class .= ' nk-blog-list';
        }
            if (have_posts()) :?>
            <div class="<?php echo khaki_sanitize_class($class); ?>">
               <?php /* Start the Loop */
                while (have_posts()) : the_post();
                    ?>
                    <?php if($style == 'classic' && $columns>1 && $columns<=3):
                        echo '<div class="nk-isotope-item news-one">';
                    endif;
                    ?>
                    <div id="post-<?php the_ID(); ?>" <?php post_class('nk-blog-post'.(($columns<=1 || $columns=='') ? ' news-one' : ''));?>>
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
                                    echo wp_kses( $post_list_preview, khaki_allowed_html() );
                                    echo '</div>';
                                }else{
                                    $content_class = 'col-lg-12';
                                }
                                ?>
                                <div class="<?php echo khaki_sanitize_class($content_class);?>">
                                    <div class="nk-post-meta nk-post-meta-top pb-0">
                                        <div class="nk-post-date nk-post-meta-right">
                                            <?php $time_string = get_the_time(esc_html__('F j, Y ', 'khaki'));
                                            echo esc_html($time_string); ?>
                                            <span class="nk-post-by"><?php esc_html_e('by', 'khaki'); ?>
                                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))) ?>">
                                                    <?php echo esc_html(get_the_author()); ?>
                                                </a>
                                    </span>
                                        </div>
                                    </div>

                                    <?php get_template_part('template-parts/content', 'post-list-category'); ?>

                                    <?php get_template_part('template-parts/content', 'post-list-title'); ?>

                                    <?php if(!$simple_view):?>
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
                                    <?php if($show_continue_button):?>
                                    <div class="nk-post-continue text-left">
                                        <a href="<?php echo esc_url(get_permalink()) ?>" class="link-effect-4">
                                            <?php esc_html_e('Continue Reading', 'khaki'); ?>
                                            <span class="ion-ios-arrow-round-forward"></span>
                                        </a>
                                    </div>
                                    <?php endif;?>
                                </div>
                            </div>
                        <?php elseif($style == 'classic'):?>

                            <?php get_template_part('template-parts/content', 'post-list-category'); ?>

                            <?php get_template_part('template-parts/content', 'post-list-title'); ?>

                            <?php if(!$simple_view):?>
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
                            <?php if(!$simple_view):?>
                                <?php if($show_continue_button):?>
                                <div class="nk-post-continue">
                                    <a href="<?php echo esc_url(get_permalink()) ?>" class="link-effect-4">
                                        <?php esc_html_e('Continue Reading', 'khaki'); ?>
                                        <span class="ion-ios-arrow-round-forward"></span>
                                    </a>
                                </div>
                                <?php endif;?>
                                <div class="nk-post-meta">
                                    <?php get_template_part('template-parts/content', 'post-list-meta'); ?>
                                </div>
                            <?php endif; ?>


                        <?php endif; ?>
                    </div>
                    <?php if($style == 'classic' && $columns>1 && $columns<=3):
                        echo '</div>';
                    endif;?>
                    <?php endwhile;?>
        </div>
            <?php else :
                get_template_part('template-parts/content', 'none');
            endif; ?>
        <div class="clearfix"></div>
        <?php if ($pagination) {
            khaki_posts_navigation();

            if ($pagination == 'infinite' || $pagination == 'load_more') {
                nk_infinite_scroll_init();
            }
        } ?>

        <div class="nk-gap-4"></div>
        <div class="nk-gap-3"></div>

    </div>
<?php
get_footer();
