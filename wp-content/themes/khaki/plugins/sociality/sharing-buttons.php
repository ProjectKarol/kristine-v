<?php
/**
 * Sharing Buttons
 */

$icons = sociality()->settings()->get_option('socials','sociality_sharing', array(
    'facebook'    => 'facebook',
    'twitter'     => 'twitter',
    'google_plus' => 'google_plus',
    'pinterest'   => 'pinterest'
));
$show_counters = sociality()->settings()->get_option('show_counters','sociality_sharing', true);
$url = get_the_permalink();
$title = get_the_title();

?>
<div class="sociality-share nk-share-icons" data-url="<?php echo esc_url($url); ?>" data-title="<?php echo esc_attr($title); ?>" data-counters="<?php echo $show_counters ? 'true' : 'false'; ?>">
    <?php
    foreach($icons as $icon) {
        switch ($icon) {
            case 'facebook':
                ?>
                <div class="sociality-share-button nk-share-icon" title="<?php esc_attr_e('Share page on Facebook', 'khaki')?>" data-share="facebook">
                    <span class="fab fa-facebook"></span>
                    <span class="sociality-share-counter"></span>
                </div>
                <?php
                break;
            case 'twitter':
                ?>
                <div class="sociality-share-button nk-share-icon" title="<?php esc_attr_e('Share page on Twitter', 'khaki')?>" data-share="twitter">
                    <span class="fab fa-twitter"></span>
                    <span class="sociality-share-counter"></span>
                </div>
                <?php
                break;
            case 'google_plus':
                ?>
                <div class="sociality-share-button nk-share-icon" title="<?php esc_attr_e('Share page on Google+', 'khaki')?>" data-share="google_plus">
                    <span class="fab fa-google-plus"></span>
                    <span class="sociality-share-counter"></span>
                </div>
                <?php
                break;
            case 'pinterest':
                $media = get_the_post_thumbnail_url(null, 'full');
                ?>
                <div class="sociality-share-button nk-share-icon" title="<?php esc_attr_e('Share page on Pinterest', 'khaki')?>" data-share="pinterest" data-media="<?php echo esc_url($media); ?>">
                    <span class="fab fa-pinterest"></span>
                    <span class="sociality-share-counter"></span>
                </div>
                <?php
                break;
            case 'vkontakte':
                ?>
                <div class="sociality-share-button nk-share-icon" title="<?php esc_attr_e('Share page on VK', 'khaki')?>" data-share="vkontakte">
                    <span class="socicon-vkontakte"></span>
                    <span class="sociality-share-counter"></span>
                </div>
                <?php
                break;
        }
    }
    ?>
</div>
