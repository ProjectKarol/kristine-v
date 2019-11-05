<?php
/**
 * nK Images Carousel
 *
 * Example:
 * [nk_images_carousel images="12,53,18" images_size="khaki_1280x720_crop" on_click="popup" autoplay="0" show_arrows="false" show_dots="false" no_margin="false" all_visible="false" style="1" size=""]
 */

add_shortcode('nk_images_carousel', 'nk_images_carousel');
if (!function_exists('nk_images_carousel')) :
    function nk_images_carousel($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "images" => "",
            "images_size" => "khaki_1280x720_crop",
            "on_click" => "popup",
            "autoplay" => 0,
            "show_arrows" => "",
            "show_dots" => "",
            "no_margin" => "",
            "all_visible" => "",
            "style" => "1",
            "size" => "",
            "class" => "",
        ), $atts));

        if (!khaki_nk_check($images)) {
            return '';
        }

        // classes for carousel container
        if($style == 2 || $style == 3) {
            $class .= 'nk-carousel-' . $style;
        } else {
            $class .= 'nk-carousel';
        }
        if (khaki_nk_check($size)) {
            $class .= ' nk-carousel-x' . $size;
        }
        if (khaki_nk_check($no_margin)) {
            $class .= ' nk-carousel-no-margin';
        }
        if (khaki_nk_check($all_visible)) {
            $class .= ' nk-carousel-all-visible';
        }

        // attributes for carousel container
        $attributes = '';
        if (khaki_nk_check($show_arrows)) {
            $attributes .= ' data-arrows="true"';
        }
        if (khaki_nk_check($autoplay)) {
            $attributes .= ' data-autoplay="' . esc_attr($autoplay) . '"';
        }
        if (khaki_nk_check($show_dots)) {
            $attributes .= ' data-dots="true"';
        }
        $attributes .= ' data-size="1"';

        // prepare images
        $ar_images = explode(',', $images);
        $images_str = '';
        foreach ($ar_images as $image_id) {
            $attachment = khaki_get_attachment($image_id, $images_size);

            if (khaki_nk_check($attachment)) {
                $image_on_click_link = false;
                $image = '<img src="' . esc_url($attachment['src']) . '" alt="' . esc_attr($attachment['alt']) . '" class="' . ($style != 3 ? 'nk-img-fit' : '') . '">';

                // popup image
                $data_size = '';
                if ($on_click == 'popup') {
                    $image_on_click_link = $attachment['src'];
                    $popup_attachment = khaki_get_attachment($image_id, '1920x1080');

                    if(khaki_nk_check($popup_attachment)) {
                        $image_on_click_link = $popup_attachment['src'];
                        if ($popup_attachment['width'] && $popup_attachment['height']) {
                            $data_size = ' data-size="' . esc_attr($popup_attachment['width']) . 'x' . esc_attr($popup_attachment['height']) . '"';
                        }
                    }
                }

                // custom link
                if ($on_click == 'custom') {
                    $image_on_click_link = get_post_meta($image_id, 'link', true);
                }

                // prepare image container
                if ($image_on_click_link) {
                    $image = '<a href="' . esc_url($image_on_click_link) . '" class="nk-gallery-item"' . $data_size . '>' . $image . '</a>';
                } else {
                    $image = '<div class="nk-gallery-item">' . $image . '</div>';
                }

                $images_str .= '<div><div>
                                    ' . $image . '
                                </div></div>';
            }
        }

        $gallery_class = '';
        if($on_click == 'popup'){
            $gallery_class=' nk-popup-gallery';
        }

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);

        return '<div class="' . khaki_sanitize_class($class) . '"' . $attributes . '>
                    <div class="'.khaki_sanitize_class('nk-carousel-inner'.$gallery_class).'">
                    ' . $images_str . '
                    </div>
                </div>';
    }
endif;

add_action( 'after_setup_theme', 'vc_nk_images_carousel' );
if ( ! function_exists( 'vc_nk_images_carousel' ) ) :
    function vc_nk_images_carousel() {
        if(function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name' => esc_html__('nK Images Carousel', 'khaki-shortcodes'),
                'base' => 'nk_images_carousel',
                'controls' => 'full',
                'category' => 'nK',
                'icon'     => 'icon-nk icon-nk-images-carousel',
                'params' => array_merge(array(
                    array(
                        'type'        => 'attach_images',
                        'heading'     => esc_html__('Select Images', 'khaki-shortcodes'),
                        'param_name'  => 'images',
                        'admin_label' => true,
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Images Size', 'khaki-shortcodes'),
                        'param_name' => 'images_size',
                        'std'        => 'khaki_1280x720_crop',
                        'value'      => khaki_get_image_sizes(),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('On Click', 'khaki-shortcodes'),
                        'param_name' => 'on_click',
                        'std'        => 'popup',
                        'value'      => array(
                            esc_html__('Disable', 'khaki-shortcodes') => false,
                            esc_html__('Popup', 'khaki-shortcodes') => 'popup',
                            esc_html__('Custom Link', 'khaki-shortcodes') => 'custom'
                        ),
                        'description' => esc_html__('Custom Link option works only with Link property in Media Uploader', 'khaki-shortcodes'),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Autoplay', 'khaki-shortcodes'),
                        'param_name'  => 'autoplay',
                        'value'       => 0,
                        "description" => esc_html__("Type integer value in ms", 'khaki-shortcodes')
                    ),
                    array(
                        'type'        => 'checkbox',
                        'heading'     => esc_html__('Show Arrows', 'khaki-shortcodes'),
                        'param_name'  => 'show_arrows',
                        'value'       => array( '' => true )
                    ),
                    array(
                        'type'        => 'checkbox',
                        'heading'     => esc_html__('Show Dots', 'khaki-shortcodes'),
                        'param_name'  => 'show_dots',
                        'value'       => array( '' => true )
                    ),
                    array(
                        'type'        => 'checkbox',
                        'heading'     => esc_html__('No Margin Between Slides', 'khaki-shortcodes'),
                        'param_name'  => 'no_margin',
                        'value'       => array( '' => true )
                    ),
                    array(
                        'type'        => 'checkbox',
                        'heading'     => esc_html__('All Visible', 'khaki-shortcodes'),
                        "description" => esc_html__('By default non-active slides semi-transparent, this option removed transparency.', 'khaki-shortcodes'),
                        'param_name'  => 'all_visible',
                        'value'       => array( '' => true )
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Style', 'khaki-shortcodes'),
                        'param_name' => 'style',
                        'std'        => '1',
                        'value'      => array(
                            esc_html__('Style 1', 'khaki-shortcodes') => '1',
                            esc_html__('Style 2', 'khaki-shortcodes') => '2',
                            esc_html__('Style 3', 'khaki-shortcodes') => '3'
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Size', 'khaki-shortcodes'),
                        'param_name' => 'size',
                        'std'        => false,
                        'value'      => array(
                            esc_html__('Default', 'khaki-shortcodes') => false,
                            esc_html__('X1', 'khaki-shortcodes') => '1',
                            esc_html__('X2', 'khaki-shortcodes') => '2',
                            esc_html__('X3', 'khaki-shortcodes') => '3',
                            esc_html__('X4', 'khaki-shortcodes') => '4',
                            esc_html__('X5', 'khaki-shortcodes') => '5',
                        ),
                        'dependency' => array(
                            'element'    => 'style',
                            'value'      => array('2')
                        ),
                        'description' => ''
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Custom Classes', 'khaki-shortcodes'),
                        'param_name'  => 'class',
                        'value'       => '',
                        'description' => '',
                    )
                ), khaki_get_css_tab())
            ) );
        }
    }
endif;