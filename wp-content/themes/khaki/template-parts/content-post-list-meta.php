<?php
//template part for output post meta
?>
    <div class="nk-post-meta-right">
        <?php if (get_comments()) : ?>
            <a class="nk-post-comments-count"
               href="<?php echo esc_url(get_permalink()) ?>#comments"><?php echo number_format_i18n(get_comments_number()) ?></a>
        <?php endif; ?>
        <?php $acf_meta = khaki_get_theme_mod('post_meta_custom', true, get_the_ID()); ?>
        <?php if (khaki_get_theme_mod('single_post_meta_like_show', $acf_meta) && function_exists('sociality')) {
            echo sociality()->likes()->get_likes(get_the_ID(), 'post');
        } ?>
    </div>
    <div class="nk-post-date">
        <?php
        echo get_the_time(esc_html__('F j, Y ', 'khaki')); ?> <span class="nk-post-by"><?php esc_html_e('by', 'khaki'); ?> <a
                href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))) ?>"><?php echo esc_html(get_the_author()); ?></a></span>
    </div>