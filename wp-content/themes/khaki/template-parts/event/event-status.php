<?php
$title = get_the_title(get_the_ID());
$status_sales = khaki_get_theme_mod('event_status_sales', true);
$product_type = khaki_get_theme_mod('event_product_type', true);
$post_type = get_post_type();
$acf_content = khaki_get_theme_mod('content_' . $post_type . '_custom', true);
$acf_header = khaki_get_theme_mod($post_type . '_header_custom', true);
$container_buy_class = 'nk-event-button';
$container_buy = $button_color ='';
if(isset($color)){
    $button_color .= ' nk-btn-color-'.$color;
}
switch ($status_sales) {
    case 'sold_out':
        $container_buy_class .= ' nk-event-button-sold';
        $container_buy = esc_html__('Sold Out', 'khaki');
        break;
    case 'buy':
        $purchase_link = khaki_get_theme_mod('event_link_to_purchase', true);
        if (isset($purchase_link) && !empty($purchase_link)) {
            if(!isset($color)){
                $button_color .= ' nk-btn-color-dark-4';
            }
            $container_buy = '<div class="nk-gap"></div>
                                <a href="' . esc_url($purchase_link) . '"
                                   class="nk-btn nk-btn-sm nk-btn-effect-2-right nk-btn-outline nk-btn-circle '.khaki_sanitize_class($button_color).'">
                                    <span>' . esc_html__('Buy', 'khaki') . ' ' . esc_html($product_type) . '</span>
                                    <span class="icon"><span class="fa fa-ticket"></span></span>
                                </a>';
        }
        break;
    case 'buy_on_date':
        $current_time = current_time(esc_html__('j F Y', 'khaki'));
        $date_purchase = khaki_get_theme_mod('event_date_purchase', true);
        if (strtotime($current_time) >= strtotime($date_purchase)) {
            $purchase_link = khaki_get_theme_mod('event_link_to_purchase', true);
            if (isset($purchase_link) && !empty($purchase_link)) {
                if(!isset($color)){
                    $button_color .= ' nk-btn-color-white';
                }
                $container_buy = '<div class="nk-gap"></div>
                                <a href="' . esc_url($purchase_link) . '"
                                   class="nk-btn nk-btn-sm nk-btn-effect-2-right nk-btn-outline nk-btn-circle '.khaki_sanitize_class($button_color).'">
                                    <span>' . esc_html__('Buy', 'khaki') . ' ' . esc_html($product_type) . '</span>
                                    <span class="icon"><span class="fa fa-ticket"></span></span>
                                </a>';
            }
            break;
        } else {
            $date_purchase = date('j F', strtotime($date_purchase));
            if (isset($date_purchase) && !empty($date_purchase)) {
                $container_buy = esc_html__('Buy on', 'khaki') . ' ' . esc_html($date_purchase);
            }
        }
        break;
}
?>
<?php if (((khaki_get_theme_mod($post_type . '_show_title', $acf_content) && isset($title)) || (isset($container_buy) && !empty($container_buy))) && is_single()): ?>
    <!-- START: Header Title -->
    <div class="nk-box">
            <div class="nk-gap-4"></div>
            <?php if (khaki_get_theme_mod($post_type . '_detail_show_title', $acf_content)): ?>
                <h1 class="nk-title">
                    <?php
                    $custom_title = khaki_get_theme_mod($post_type . '_content_custom_title', $acf_content);
                    echo $custom_title ? esc_html($custom_title) : $title;
                    ?>
                </h1>
            <?php endif; ?>
            <div class="nk-header-text">
                <?php echo wp_kses( $container_buy, khaki_allowed_html() ); ?>
            </div>
    </div>
    <!-- END: Header Title -->
    <?php elseif(is_archive() || is_page()):?>
    <div class="<?php echo khaki_sanitize_class($container_buy_class) ?>">
        <?php echo wp_kses( $container_buy, khaki_allowed_html() ); ?>
    </div>
<?php endif; ?>
