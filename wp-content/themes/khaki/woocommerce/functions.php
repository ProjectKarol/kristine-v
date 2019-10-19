<?php
// WooCommerce is active
if (!class_exists('WooCommerce')) {
    return;
}

add_action(
    'woocommerce_before_main_content',
    'khaki_woocommerce_wrapper_start',
    10
);
add_action(
    'woocommerce_after_main_content',
    'khaki_woocommerce_wrapper_end',
    10
);

if (!function_exists('khaki_woocommerce_wrapper_start')):
    function khaki_woocommerce_wrapper_start()
    {
        echo '<section id="main">';
    }
endif;
if (!function_exists('khaki_woocommerce_wrapper_end')):
    function khaki_woocommerce_wrapper_end()
    {
        echo '</section>';
    }
endif;

add_action('after_setup_theme', 'khaki_woocommerce_support');
if (!function_exists('khaki_woocommerce_support')):
    function khaki_woocommerce_support()
    {
        add_theme_support('woocommerce');
    }
endif;

//remove based woocommerce breadcrumbs
remove_action(
    'woocommerce_before_main_content',
    'woocommerce_breadcrumb',
    20,
    0
);

// remove the default link
remove_action(
    'woocommerce_before_shop_loop_item',
    'woocommerce_template_loop_product_link_open',
    10,
    2
);
remove_action(
    'woocommerce_before_shop_loop_item',
    'woocommerce_template_loop_product_link_close',
    10,
    2
);

// remove the default loop picture
remove_action(
    'woocommerce_before_shop_loop_item_title',
    'woocommerce_template_loop_product_thumbnail',
    10,
    2
);

// remove the default title output
remove_action(
    'woocommerce_shop_loop_item_title',
    'woocommerce_template_loop_product_title',
    10,
    2
);

// add the action
remove_action(
    'woocommerce_after_single_product_summary',
    'woocommerce_output_related_products',
    20,
    2
);
remove_action(
    'woocommerce_after_single_product_summary',
    'woocommerce_upsell_display',
    15,
    2
);

add_action(
    'woocommerce_before_shop_loop_item_title',
    'khaki_shop_loop_item_thumbnail',
    10,
    2
);
if (!function_exists('khaki_shop_loop_item_thumbnail')):
    function khaki_shop_loop_item_thumbnail()
    {
        global $post, $product;
        $hover_style = $alt = $attachment_src = '';
        $size = apply_filters(
            'single_product_archive_thumbnail_size',
            'shop_catalog'
        );
        $attachment_id = get_post_thumbnail_id();
        $gallery_ids = $product->get_gallery_image_ids();
        $hover_attachment_src = khaki_get_theme_mod(
            'woocommerce_hover_image',
            true,
            $post->ID
        );
        $product_link = get_permalink();

        if ($hover_attachment_src !== null) {
            $hover_style =
                ' class="nk-product-image" style="background-image: url(' .
                "'" .
                esc_url($hover_attachment_src) .
                "'" .
                ');"';
        }

        $result =
            '<a href="' . esc_url($product_link) . '"' . $hover_style . '>';

        if (is_numeric($attachment_id) && $attachment_id !== null) {
            $attachment = khaki_get_attachment($attachment_id, $size);
            $attachment_src = $attachment['src'];
            $alt = $attachment['alt'];
        } elseif (
            !empty($gallery_ids) &&
            is_array($gallery_ids) &&
            isset($gallery_ids[0])
        ) {
            $attachment = khaki_get_attachment($gallery_ids[0], $size);
            $attachment_src = $attachment['src'];
            $alt = $attachment['alt'];
        } else {
            $attachment_src = wc_placeholder_img_src();
            $alt = esc_html__('No Image', 'khaki');
        }

        $result .=
            '<img src="' .
            esc_url($attachment_src) .
            '" alt="' .
            esc_attr($alt) .
            '" class="nk-img-stretch">';

        $result .= '</a>';

        echo wp_kses($result, khaki_allowed_html());
    }
endif;

if (!function_exists('khaki_filter_woocommerce_get_price_html_from_to')):
    function khaki_filter_woocommerce_get_price_html_from_to(
        $price,
        $from,
        $to,
        $instance
    ) {
        $price = '<div class="nk-product-price">';
        $price .= is_numeric($to) ? wc_price($to) : $to;
        $price .=
            '&nbsp;<del><sub>' .
            (is_numeric($from) ? wc_price($from) : $from) .
            '</sub></del>';
        $price .= '</div>';
        return $price;
    }
endif;
add_filter(
    'woocommerce_get_price_html_from_to',
    'khaki_filter_woocommerce_get_price_html_from_to',
    10,
    4
);

// define the khaki_shop_thumbnail_or_gallery callback
if (!function_exists('khaki_shop_thumbnail_or_gallery')):
    function khaki_shop_thumbnail_or_gallery($show_gallery = false)
    {
        global $post, $product;
        $size = apply_filters(
            'single_product_large_thumbnail_size',
            'shop_single'
        );
        $thumb_size = apply_filters(
            'single_product_small_thumbnail_size',
            'shop_thumbnail'
        );
        $lightbox_en = true;
        $popup_class = $lightbox_en ? ' nk-popup-gallery' : '';
        $big_size = 'khaki_1920x1080';
        $result = '';
        // show gallery on shop page
        if (is_shop() || is_product_category() || is_product_tag()) {
            $show_gallery = true;
        }
        $attachment_ids = $show_gallery
            ? $product->get_gallery_image_ids()
            : '';
        if (empty($attachment_ids) || !is_array($attachment_ids)) {
            $attachment_ids = array();
        }
        if (has_post_thumbnail()) {
            array_unshift($attachment_ids, get_post_thumbnail_id());
        }
        echo '<div class="woocommerce-product-gallery woocommerce-product-gallery--without-images images">';
        echo '<div class="woocommerce-product-gallery__wrapper">';
        echo '<div class="woocommerce-product-gallery__image--placeholder">';
        if (count($attachment_ids) > 1) {
            $result .= '<div class="nk-product-carousel">';
            $result .= '<div class="nk-product-carousel-thumbs">';
            $result .= '<div>';
            foreach ($attachment_ids as $key => $id) {
                $active_image = false;
                if ($key == 0) {
                    $active_image = true;
                }
                $result .= khaki_get_woo_product_gallery_thumb_item(
                    $id,
                    $thumb_size,
                    $active_image,
                    $lightbox_en
                );
            }
            $result .= '</div>';
            $result .= '</div>';
            $result .= '<div class="nk-carousel-3" data-size="1">';
            $result .=
                '<div class="nk-carousel-inner' .
                khaki_sanitize_class($popup_class) .
                '">';
            foreach ($attachment_ids as $id) {
                $result .= khaki_get_woo_product_gallery_item(
                    $id,
                    $size,
                    $big_size,
                    $lightbox_en
                );
            }
            $result .= '</div>';
            $result .= '</div>';
            $result .= '</div>';
        } elseif (
            count($attachment_ids) > 0 &&
            is_numeric($attachment_ids[0])
        ) {
            $result .=
                '<div class="' . khaki_sanitize_class($popup_class) . '">';
            $result .= khaki_get_woo_product_gallery_item(
                $attachment_ids[0],
                $size,
                $big_size,
                $lightbox_en
            );
            $result .= '</div>';
        } elseif (wc_placeholder_img_src()) {
            $result .= wc_placeholder_img($size);
        }
        echo wp_kses($result, khaki_allowed_html());
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
endif;

// define the khaki_get_woo_product_gallery_item function for get gallery items
if (!function_exists('khaki_get_woo_product_gallery_item')):
    function khaki_get_woo_product_gallery_item(
        $id,
        $size,
        $big_size,
        $lightbox_en = false
    ) {
        $result = '';
        if (is_numeric($id)) {
            $attachement = khaki_get_attachment($id, $size);
            $attachement_big = khaki_get_attachment($id, $big_size);
            if (!empty($attachement) && is_array($attachement)) {
                $result .= '<div><div>';
                if (
                    !empty($attachement_big) &&
                    is_array($attachement_big) &&
                    $lightbox_en
                ) {
                    $result .=
                        '<a href="' .
                        esc_url($attachement_big['src']) .
                        '" class="nk-gallery-item woocommerce-product-gallery__image" data-size="' .
                        esc_attr($attachement_big['width']) .
                        'x' .
                        esc_attr($attachement_big['height']) .
                        '">';
                }
                $result .=
                    '<img src="' .
                    esc_url($attachement['src']) .
                    '" alt="' .
                    esc_attr(
                        ($attachement['alt']
                                ? $attachement['alt']
                                : $attachement['title'])
                            ? $attachement['title']
                            : ''
                    ) .
                    '" class="wp-post-image">';
                if (
                    !empty($attachement_big) &&
                    is_array($attachement_big) &&
                    $lightbox_en
                ) {
                    $result .= '</a>';
                }
                $result .= '</div></div>';
            }
        }
        return $result;
    }
endif;

// define the khaki_get_woo_product_gallery_thumb_item function for get gallery thumbs items
if (!function_exists('khaki_get_woo_product_gallery_thumb_item')):
    function khaki_get_woo_product_gallery_thumb_item(
        $id,
        $size,
        $active_image = false
    ) {
        $result = '';
        if (is_numeric($id)) {
            $thumb = khaki_get_attachment($id, $size);
            if (!empty($thumb) && is_array($thumb)) {
                $result .= '<div';
                $result .= $active_image ? ' class="active"' : '';
                $result .= '>';
                $result .=
                    '<img src="' .
                    esc_url($thumb['src']) .
                    '" alt="' .
                    esc_url($thumb['alt']) .
                    '">';
                $result .= '</div>';
            }
        }
        return $result;
    }
endif;

// add output categories on detail product before title
add_action(
    'woocommerce_single_product_summary',
    'khaki_woocommerce_template_single_categories',
    2
);

if (!function_exists('khaki_woocommerce_template_single_categories')):
    function khaki_woocommerce_template_single_categories()
    {
        global $post, $product;
        $result = '';
        $categories = wc_get_product_category_list($product->get_id());
        if (isset($categories) && !empty($categories)) {
            $result .= '<div class="nk-product-category">';
            $result .= sprintf(esc_html__('In %s', 'khaki'), $categories);
            $result .= '</div>';
        }
        echo wp_kses($result, khaki_allowed_html());
    }
endif;
remove_action(
    'woocommerce_single_product_summary',
    'woocommerce_template_single_price',
    10,
    0
);

// change default button checkout text
add_filter(
    'woocommerce_order_button_text',
    'khaki_woocommerce_order_button_text'
);
if (!function_exists('khaki_woocommerce_order_button_text')):
    function khaki_woocommerce_order_button_text()
    {
        return esc_html__('Place Order', 'khaki');
    }
endif;

// clear cart
add_action('wp_loaded', 'khaki_woocommerce_clear_cart', 20);
if (!function_exists('khaki_woocommerce_clear_cart')):
    function khaki_woocommerce_clear_cart()
    {
        global $woocommerce;
        if (
            isset($_GET['_wpnonce']) &&
            isset($_GET['clear-cart']) &&
            wp_verify_nonce($_GET['_wpnonce'], 'empty_cart')
        ) {
            $woocommerce->cart->empty_cart();
            $referer = wp_get_referer()
                ? remove_query_arg(
                    array('clear-cart', '_wpnonce'),
                    wp_get_referer()
                )
                : wc_get_cart_url();
            wp_safe_redirect($referer);
            exit();
        }
    }
endif;

// add adjacent pagination before content
add_action(
    'woocommerce_adjacent_pagination_before',
    'khaki_woocommerce_adjacent_pagination_before'
);
if (!function_exists('khaki_woocommerce_adjacent_pagination_before')):
    function khaki_woocommerce_adjacent_pagination_before()
    {
        if (
            is_single() &&
            khaki_get_theme_mod('single_woocommerce_adjacent_pagination') &&
            khaki_get_theme_mod(
                'single_woocommerce_adjacent_pagination_style'
            ) == 'static' &&
            khaki_get_theme_mod(
                'single_woocommerce_adjacent_pagination_position'
            ) == 'before'
        ) {
            if (!khaki_get_theme_mod('woocommerce_header_show')) {
                echo '<div class="nk-gap-5"></div>';
            }
            get_template_part('/template-parts/pagination', 'static');
            echo '<div class="nk-gap-2"></div>';
        }
    }
endif;

// add adjacent pagination after content
add_action(
    'woocommerce_adjacent_pagination_after',
    'khaki_woocommerce_adjacent_pagination_after'
);
if (!function_exists('khaki_woocommerce_adjacent_pagination_after')):
    function khaki_woocommerce_adjacent_pagination_after()
    {
        if (
            is_single() &&
            khaki_get_theme_mod('single_woocommerce_adjacent_pagination') &&
            khaki_get_theme_mod(
                'single_woocommerce_adjacent_pagination_style'
            ) == 'static' &&
            khaki_get_theme_mod(
                'single_woocommerce_adjacent_pagination_position'
            ) == 'after'
        ) {
            echo '<div class="nk-gap-2"></div>';
            get_template_part('/template-parts/pagination', 'static');
        }
    }
endif;

//Add * to placeholder value is set required attr. Redefine json wc_address_i18n_params var for address-i18n.js
add_filter(
    'woocommerce_get_script_data',
    'khaki_filter_add_required_star_to_placeholder',
    10,
    2
);
if (!function_exists('khaki_filter_add_required_star_to_placeholder')) {
    function khaki_filter_add_required_star_to_placeholder($handle, $data)
    {
        if ('wc-address-i18n' == $data) {
            $locale_array = json_decode($handle['locale']);
            if (
                isset($locale_array) &&
                !empty($locale_array) &&
                is_array($locale_array)
            ) {
                foreach ($locale_array as $set_list) {
                    foreach ($set_list as $value) {
                        if (
                            isset($value->required) &&
                            isset($value->placeholder) &&
                            $value->required &&
                            strripos($value->placeholder, '*') === false
                        ) {
                            $value->placeholder = $value->placeholder . ' *';
                        }
                    }
                }
            }
            $handle['locale'] = json_encode($locale_array);
        }

        return $handle;
    }
}

// Cart Page fixed. Add cross-sells template output after totals shipping block
remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
add_action(
    'woocommerce_cart_collaterals',
    'woocommerce_cross_sell_display',
    20
);

// Subcategories
remove_action(
    'woocommerce_before_subcategory',
    'woocommerce_template_loop_category_link_open',
    10,
    2
);
remove_action(
    'woocommerce_after_subcategory',
    'woocommerce_template_loop_category_link_close',
    10,
    2
);

remove_action(
    'woocommerce_shop_loop_subcategory_title',
    'woocommerce_template_loop_category_title',
    10,
    1
);
add_action(
    'woocommerce_shop_loop_subcategory_title',
    'khaki_template_loop_category_title',
    10,
    1
);
if (!function_exists('khaki_template_loop_category_title')) {
    function khaki_template_loop_category_title($category)
    {
        ?>
<h2 class="nk-product-title h5 text-center">
    <a href="<?php echo get_term_link($category, 'product_cat'); ?>">
        <?php
        echo esc_html($category->name);

        if ($category->count > 0) {
            echo apply_filters(
                'woocommerce_subcategory_count_html',
                ' <sup>(' . $category->count . ')</sup>',
                $category
            );
        }?>
    </a>
</h2>
<?php
    }
}

remove_action(
    'woocommerce_before_subcategory_title',
    'woocommerce_subcategory_thumbnail',
    10,
    1
);
add_action(
    'woocommerce_before_subcategory_title',
    'khaki_subcategory_thumbnail',
    10,
    1
);
if (!function_exists('khaki_subcategory_thumbnail')) {
    function khaki_subcategory_thumbnail($category)
    {
        $small_thumbnail_size = apply_filters(
            'subcategory_archive_thumbnail_size',
            'shop_catalog'
        );
        $thumbnail_id = get_woocommerce_term_meta(
            $category->term_id,
            'thumbnail_id',
            true
        );
        $product_link = get_term_link($category, 'product_cat');

        $result = '<a href="' . esc_url($product_link) . '">';

        if ($thumbnail_id) {
            $attachment = khaki_get_attachment(
                $thumbnail_id,
                $small_thumbnail_size
            );
            $attachment_src = $attachment['src'];
            $alt = $attachment['alt'];
        } else {
            $attachment_src = wc_placeholder_img_src($small_thumbnail_size);
            $alt = esc_html__('No Image', 'khaki');
        }

        $result .=
            '<img src="' .
            esc_url($attachment_src) .
            '" alt="' .
            esc_attr($alt) .
            '" class="nk-img-stretch">';

        $result .= '</a>';

        echo wp_kses($result, khaki_allowed_html());
    }
}

// Fixed WooCommerce shortcodes output.
add_action(
    'woocommerce_shortcode_before_recent_products_loop',
    'khaki_woocommerce_shortcode_before_products_loop',
    10
);
add_action(
    'woocommerce_shortcode_before_featured_products_loop',
    'khaki_woocommerce_shortcode_before_products_loop',
    10
);
add_action(
    'woocommerce_shortcode_before_products_loop',
    'khaki_woocommerce_shortcode_before_products_loop',
    10
);
add_action(
    'woocommerce_shortcode_before_product_cat_loop',
    'khaki_woocommerce_shortcode_before_products_loop',
    10
);
add_action(
    'woocommerce_shortcode_before_sale_products_loop',
    'khaki_woocommerce_shortcode_before_products_loop',
    10
);
add_action(
    'woocommerce_shortcode_before_top_rated_products_loop',
    'khaki_woocommerce_shortcode_before_products_loop',
    10
);
add_action(
    'woocommerce_shortcode_before_best_selling_products_loop',
    'khaki_woocommerce_shortcode_before_products_loop',
    10
);
add_action(
    'woocommerce_shortcode_before_product_attribute_loop',
    'khaki_woocommerce_shortcode_before_products_loop',
    10
);
if (!function_exists('khaki_woocommerce_shortcode_before_products_loop')) {
    function khaki_woocommerce_shortcode_before_products_loop()
    {
        echo '<div class="nk-store">';
    }
}
add_action(
    'woocommerce_shortcode_after_recent_products_loop',
    'khaki_woocommerce_shortcode_after_products_loop',
    10
);
add_action(
    'woocommerce_shortcode_after_featured_products_loop',
    'khaki_woocommerce_shortcode_after_products_loop',
    10
);
add_action(
    'woocommerce_shortcode_after_products_loop',
    'khaki_woocommerce_shortcode_after_products_loop',
    10
);
add_action(
    'woocommerce_shortcode_after_product_cat_loop',
    'khaki_woocommerce_shortcode_after_products_loop',
    10
);
add_action(
    'woocommerce_shortcode_after_sale_products_loop',
    'khaki_woocommerce_shortcode_after_products_loop',
    10
);
add_action(
    'woocommerce_shortcode_after_top_rated_products_loop',
    'khaki_woocommerce_shortcode_after_products_loop',
    10
);
add_action(
    'woocommerce_shortcode_after_best_selling_products_loop',
    'khaki_woocommerce_shortcode_after_products_loop',
    10
);
add_action(
    'woocommerce_shortcode_after_product_attribute_loop',
    'khaki_woocommerce_shortcode_after_products_loop',
    10
);
if (!function_exists('khaki_woocommerce_shortcode_after_products_loop')) {
    function khaki_woocommerce_shortcode_after_products_loop()
    {
        echo '</div>';
    }
}
