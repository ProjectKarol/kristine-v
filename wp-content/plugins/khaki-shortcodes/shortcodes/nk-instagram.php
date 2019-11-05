<?php


/**
 * nK Instagram
 *
 * Example:
 * [nk_instagram count="6"]
 */
add_shortcode('nk_instagram', 'nk_instagram');
if (!function_exists('nk_instagram')) :
    function nk_instagram($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "count" => 6,
            "columns_size"=> 2,
            "gap" => false,
            "photo_quality"=> 'thumbnail',
            "class" => ''
        ), $atts));

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);
        $class .= ' nk-instagram row multi-column';
        $column_class = 'col-4 col-md-2';
        // Get the images from Instagram.
        nk_theme()->instagram()->set_data(array(
            'access_token' => khaki_get_theme_mod('instagram_access_token'),
            'user_id' => khaki_get_theme_mod('instagram_user_id'),
            'cachetime' => khaki_get_theme_mod('instagram_cachetime')
        ));
        $instagram = nk_theme()->instagram()->get_instagram($count);

        if(khaki_nk_check($columns_size) && is_numeric($columns_size)){
            $column_class = 'col-4 col-md-'.$columns_size;
        }

        $result = '';
        if (!nk_theme()->instagram()->has_error() && !empty($instagram)) {
            for ($i = 0; $i < $count; $i++) {
                $item = $instagram[$i];
                if (isset($item)) {
                    $photo_url = $item->images->thumbnail->url;
                    switch($photo_quality){
                        case 'low_resolution':
                            $photo_url = $item->images->low_resolution->url;
                            break;
                        case 'standard_resolution':
                            $photo_url = $item->images->standard_resolution->url;
                            break;
                    }
                    $result .= '<div class="'.khaki_sanitize_class($column_class).'">
                            <a href="' . esc_url($item->link) . '" class="db" target="_blank">
                                <img class="nk-img-stretch" src="' . esc_url($photo_url) . '" alt="">
                            </a>
                        </div>';
                } else break;
            }
        } else if (nk_theme()->instagram()->has_error()) {
            $result = nk_theme()->instagram()->get_error()->message;
        }

        if(khaki_nk_check($gap)){
            $class .= ' sm-gap vertical-gap';
        } else{
            $class .= ' no-gutters';
        }

        return '<div class="' . khaki_sanitize_class($class) . '">' . $result . '</div>';
    }
endif;


add_action( 'after_setup_theme', 'vc_nk_instagram' );
if ( ! function_exists( 'vc_nk_instagram' ) ) :
    function vc_nk_instagram() {
        if(function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name' => esc_html__('nK Instagram', 'khaki-shortcodes'),
                'base' => 'nk_instagram',
                'controls' => 'full',
                'category' => 'nK',
                'icon'     => 'icon-nk icon-nk-instagram',
                'params' => array_merge(array(
                    array(
                        'type' => 'custom',
                        'param_name' => 'hidden_description',
                        'heading' => esc_html__("Note", 'khaki-shortcodes'),
                        'description' => esc_html__("Before use, you need to configure access to Instagram here - ", 'khaki-shortcodes') . '<a target="_blank" href="' . esc_url(admin_url('customize.php?autofocus[section]=khaki_instagram')) . '">' . esc_html(admin_url('customize.php?autofocus[section]=khaki_instagram')) . '</a>',
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Count', 'khaki-shortcodes'),
                        'param_name'  => 'count',
                        'value'       => 6,
                        'description' => '',
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Column Size', 'khaki-shortcodes'),
                        'param_name'  => 'columns_size',
                        'value'       => 2,
                        'description' => '',
                    ),
                    array(
                        'param_name'  => 'gap',
                        'heading'     => esc_html__('Gap', 'khaki-shortcodes'),
                        'type'        => 'checkbox',
                        'value'       => array( '' => true ),
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Photo Quality', 'khaki-shortcodes'),
                        'param_name' => 'photo_quality',
                        'std'        => 'thumbnail',
                        'value'      => array(
                            esc_html__('Thumbnail', 'khaki-shortcodes')  => 'thumbnail',
                            esc_html__('Low', 'khaki-shortcodes')  => 'low_resolution',
                            esc_html__('Standard', 'khaki-shortcodes')  => 'standard_resolution'
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