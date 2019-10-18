<?php $post_type = get_post_type(); ?>
<?php
$acf_content = khaki_get_theme_mod('content_' . $post_type . '_custom', true);
$container_class = 'nk-portfolio-item-details';
$container_class .= khaki_get_theme_mod($post_type . '_style', true) == 'half' && khaki_get_theme_mod($post_type . '_position_meta', $acf_content) !== 'header' ? ' nk-portfolio-item-details-vertical' : '';
$container_class .= khaki_get_theme_mod($post_type . '_position_meta', $acf_content) == 'before content' ? ' nk-portfolio-item-details-before-cont' : '';
$container_class .= khaki_get_theme_mod($post_type . '_position_meta', $acf_content) == 'after content' ? ' nk-portfolio-item-details-after-cont' : '';
?>
<ul class="<?php echo khaki_sanitize_class($container_class);?>">
    <li><span
            class="icon ion-ios-calendar"></span> <?php $time_string = get_the_time(esc_html__('F j, Y ', 'khaki'));
        echo esc_html( $time_string ); ?></li>
    <?php $posttags = get_the_terms(get_the_ID(), 'tag-portfolio');
    ?>
    <?php if ( $posttags && is_array( $posttags ) && ! empty( $posttags ) ): ?>
        <li><span class="icon ion-md-pricetags"></span>
            <?php foreach ($posttags as $key => $tag) {
                if ($key != count($posttags) - 1) {
                    echo esc_html( $tag->name . ', ' );
                } else {
                    echo esc_html( $tag->name );
                }
            } ?>
        </li>
    <?php endif; ?>
    <?php $group = khaki_get_theme_mod($post_type . '_group', true); ?>
    <?php if (isset($group) && !empty($group)): ?>
        <li><span class="icon ion-ios-person"></span> <?php echo esc_html($group); ?></li>
    <?php endif; ?>
    <?php $global_link = khaki_get_theme_mod($post_type . '_global_link', true); ?>
    <?php if (isset($global_link) && !empty($global_link)): ?>
        <li>
            <span class="icon ion-md-globe"></span>
            <a href="<?php echo esc_url($global_link); ?>"><?php echo esc_html($global_link); ?></a>
        </li>
    <?php endif; ?>
    <li>
        <?php
        if (function_exists('sociality')) {
            echo sociality()->likes()->get_likes(get_the_ID(), 'portfolio');
        }
        ?>
    </li>
</ul>
