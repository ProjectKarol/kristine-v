<?php
/**
 * Created by PhpStorm.
 */
?>
<?php
$post_type = get_post_type();
if (!$post_type) {
    $post_type = 'page';
}
if($post_type == 'product'){
    $post_type = 'woocommerce';
}
$acf_content = khaki_get_theme_mod('content_' . $post_type . '_custom', true);
?>
<?php if (is_single() && khaki_get_theme_mod('single_' . $post_type . '_adjacent_pagination', $acf_content) && khaki_get_theme_mod('single_' . $post_type . '_adjacent_pagination_style', $acf_content)!='static'): ?>
    <!-- START: posts nav -->
    <?php
    $next_post = get_next_post();
    $previous_post = get_previous_post();
    $no_post_image = '';
    ?>
    <div
        class="nk-page-nav<?php echo khaki_sanitize_class(khaki_get_theme_mod('single_' . $post_type . '_adjacent_pagination_style', $acf_content) == 'fixed-2' ? '-2' : '') ?>">
        <?php if (!empty($previous_post)): ?>
            <?php
            $previous_post_attachment = get_post_thumbnail_id($previous_post->ID);
            ?>
            <?php if (khaki_get_theme_mod('single_' . $post_type . '_adjacent_pagination_style', $acf_content) == 'fixed'): ?>
                <a href="<?php echo esc_url(get_permalink($previous_post->ID)); ?>" class="nk-page-nav-prev">
                    <div class="icon">
                        <span class="ion-ios-arrow-back"></span>
                    </div>
                    <div class="nk-page-nav-title"><?php echo esc_html( $previous_post->post_title ); ?></div>
                    <?php if ($previous_post_attachment != null || $no_post_image != ''): ?>
                        <?php $ar_prev_attachment = khaki_get_attachment($previous_post_attachment, 'khaki_300x300'); ?>
                        <div class="nk-page-nav-img">
                            <div
                                style="background-image: url('<?php echo esc_url($ar_prev_attachment['src'] ? $ar_prev_attachment['src'] : $no_post_image); ?>');"></div>
                        </div>
                    <?php endif; ?>
                </a>
            <?php elseif (khaki_get_theme_mod('single_' . $post_type . '_adjacent_pagination_style', $acf_content) == 'fixed-2'): ?>
                <div class="nk-page-nav-prev">
                    <div class="icon">
                        <span class="ion-ios-arrow-back"></span>
                    </div>
                    <?php if ($previous_post_attachment != null || $no_post_image != ''): ?>
                        <?php $ar_prev_attachment = khaki_get_attachment($previous_post_attachment, 'khaki_300x300'); ?>
                        <div class="nk-page-nav-img">
                            <img
                                src="<?php echo esc_url($ar_prev_attachment['src'] ? $ar_prev_attachment['src'] : $no_post_image); ?>"
                                alt="<?php echo esc_attr($ar_prev_attachment['alt'] ? $ar_prev_attachment['alt'] : $previous_post->post_title); ?>">
                        </div>
                    <?php endif; ?>
                    <div class="nk-page-nav-title">
                        <?php
                        $category = get_the_category($previous_post->ID);
                        if($post_type == 'woocommerce'){
                            $category = get_the_terms( $previous_post->ID, 'product_cat' );
                        }
                        ?>
                        <?php if(isset($category) && !empty($category)):?>
                        <div class="nk-product-category mt-0">
                            <?php esc_html_e('In', 'khaki'); ?> <span><?php echo $post_type == 'woocommerce' ? esc_html( $category[0]->name ) : esc_html( $category[0]->cat_name ); ?></span>
                        </div>
                        <?php endif; ?>
                        <h5 class="nk-product-title mb-0">
                            <a href="<?php echo esc_url(get_permalink($previous_post->ID)); ?>"><?php echo esc_html( $previous_post->post_title ); ?></a>
                        </h5>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="nk-page-nav-prev disabled">
                <div class="icon">
                    <span class="ion-ios-arrow-back"></span>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($next_post)): ?>
            <?php $next_post_attachment = get_post_thumbnail_id($next_post->ID); ?>
            <?php if (khaki_get_theme_mod('single_' . $post_type . '_adjacent_pagination_style', $acf_content) == 'fixed'): ?>
                <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" class="nk-page-nav-next">
                    <div class="icon">
                        <span class="ion-ios-arrow-forward"></span>
                    </div>
                    <div class="nk-page-nav-title"><?php echo esc_html( $next_post->post_title ); ?></div>

                    <?php if ($next_post_attachment != null || $no_post_image != ''): ?>
                        <?php $ar_next_attachment = khaki_get_attachment($next_post_attachment, 'khaki_300x300'); ?>
                        <div class="nk-page-nav-img">
                            <div
                                style="background-image: url('<?php echo esc_url($ar_next_attachment['src'] ? $ar_next_attachment['src'] : $no_post_image); ?>');"></div>
                        </div>
                    <?php endif; ?>
                </a>
            <?php elseif (khaki_get_theme_mod('single_' . $post_type . '_adjacent_pagination_style', $acf_content) == 'fixed-2'): ?>
                <div class="nk-page-nav-next">
                    <div class="icon">
                        <span class="ion-ios-arrow-forward"></span>
                    </div>
                    <?php if ($next_post_attachment != null || $no_post_image != ''): ?>
                        <?php $ar_next_attachment = khaki_get_attachment($next_post_attachment, 'khaki_300x300'); ?>
                        <div class="nk-page-nav-img">
                            <img
                                src="<?php echo esc_url($ar_next_attachment['src'] ? $ar_next_attachment['src'] : $no_post_image); ?>"
                                alt="<?php echo esc_attr($ar_next_attachment['alt'] ? $ar_next_attachment['alt'] : $next_post->post_title); ?>">
                        </div>
                    <?php endif; ?>
                    <div class="nk-page-nav-title">
                        <?php
                        $category = get_the_category($next_post->ID);
                        if($post_type == 'woocommerce'){
                            $category = get_the_terms( $next_post->ID, 'product_cat' );
                        }
                        ?>
                        <div class="nk-product-category mt-0">
                            <?php esc_html_e('In', 'khaki'); ?> <span><?php echo $post_type == 'woocommerce' ? esc_html( $category[0]->name ) : esc_html( $category[0]->cat_name ); ?></span>
                        </div>
                        <h5 class="nk-product-title mb-0">
                            <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>"><?php echo esc_html( $next_post->post_title ); ?></a>
                        </h5>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="nk-page-nav-next disabled">
                <div class="icon">
                    <span class="ion-ios-arrow-forward"></span>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <!-- END: posts nav -->
<?php endif; ?>
