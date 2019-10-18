<?php
$post_type = get_post_type();
if (!$post_type) {
    $post_type = 'page';
}
if($post_type == 'product'){
    $post_type = 'woocommerce';
}
$acf_content = khaki_get_theme_mod('content_post_custom', true);
?>
    <?php
    $next_post = get_next_post();
    $previous_post = get_previous_post();
    ?>
    <!-- START: posts nav -->
    <div class="nk-page-nav-3">
        <div class="container">
            <?php if (!empty($previous_post)): ?>
                <a href="<?php echo esc_url(get_permalink($previous_post->ID)); ?>"
                   class="nk-page-nav-prev">
                    <div class="nk-page-nav-title"><?php echo esc_html( $previous_post->post_title ); ?></div>
                    Previous
                    <span class="nk-icon-arrow-left"></span>
                </a>
            <?php endif; ?>
            <?php if (!empty($next_post)): ?>
                <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>"
                   class="nk-page-nav-next">
                    <div class="nk-page-nav-title"><?php echo esc_html( $next_post->post_title ); ?></div>
                    Next
                    <span class="nk-icon-arrow-right"></span>
                </a>
            <?php endif; ?>
            <?php if (khaki_get_theme_mod('single_' . $post_type . '_adjacent_pagination_grid_link') != 'disabled'): ?>
                <?php
                $grid_link = null;
                if (khaki_get_theme_mod('single_' . $post_type . '_adjacent_pagination_grid_link') == 'post-list' || khaki_get_theme_mod('single_' . $post_type . '_adjacent_pagination_grid_link') == 'product-list') {
                    if($post_type == 'portfolio'){
                        $grid_link = get_post_type_archive_link($post_type);
                    } elseif($post_type == 'woocommerce') {
                        $grid_link = get_post_type_archive_link('product');
                    } else {
                            $list_page_id = get_option('page_for_posts', false);
                            if($list_page_id >0){
                                $grid_link = get_permalink($list_page_id);
                            }else{
                                $grid_link = get_post_type_archive_link($post_type);
                            }
                    }

                } elseif (khaki_get_theme_mod('single_' . $post_type . '_adjacent_pagination_grid_link') == 'custom'){
                    $grid_link = khaki_get_theme_mod('single_' . $post_type . '_adjacent_pagination_grid_custom_link');
                }
                ?>
                <?php if (!empty($grid_link)): ?>
                    <a href="<?php echo esc_url($grid_link); ?>" class="nk-page-nav-grid">
                        <span class="ion-md-apps"></span>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    <!-- END: posts nav -->
