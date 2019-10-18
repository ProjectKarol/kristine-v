<?php $post_type = get_post_type(); ?>
<?php
$acf_content = khaki_get_theme_mod('content_' . $post_type . '_custom', true);
$position_meta = khaki_get_theme_mod($post_type . '_position_meta', $acf_content);
$container_class = 'nk-events-item-details';
$container_class .= khaki_get_theme_mod($post_type . '_style', true) == 'half' && $position_meta !== 'header' && $position_meta !== 'out header' ? ' nk-events-item-details-vertical' : '';
$container_class .= $position_meta == 'before content' ? ' nk-events-item-details-before-cont' : '';
$container_class .= $position_meta == 'after content' ? ' nk-events-item-details-after-cont' : '';
$event_date = explode('|', khaki_get_theme_mod('event_date', true));
$location = khaki_get_theme_mod('event_location', true);
$price = khaki_get_theme_mod('event_price', true);
?>
<ul class="<?php echo khaki_sanitize_class($container_class); ?>">
    <?php if (isset($event_date) && !empty($event_date) && is_array($event_date)): ?>
        <li><span
                class="icon ion-ios-calendar"></span> <?php echo esc_html(array_shift($event_date) . ' ' . array_pop($event_date)); ?>
        </li>
    <?php endif; ?>
    <?php if (isset($location) && !empty($location)): ?>
        <li><span class="icon ion-ios-navigate"></span> <?php echo esc_html($location); ?></li>
    <?php endif; ?>
    <?php if (isset($price) && !empty($price)): ?>
        <li><span class="icon fa fa-ticket"></span> <?php echo esc_html($price); ?></li>
    <?php endif; ?>
</ul>
