<?php


/**
 * nK Twitter
 *
 * Example:
 * [nk_twitter count="3"]
 */

add_shortcode('nk_twitter', 'nk_twitter');
if (!function_exists('nk_twitter')) :
    function nk_twitter($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "count" => 3,
            "class" => ''
        ), $atts));

        $result = '';

        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);
        $class .= ' nk-twitter-list';
        // Get the tweets from Twitter.
        nk_theme()->twitter()->set_data(array(
            'consumer_key' => khaki_get_theme_mod('twitter_consumer_key'),
            'consumer_secret' => khaki_get_theme_mod('twitter_consumer_secret'),
            'access_token' => khaki_get_theme_mod('twitter_access_token'),
            'access_token_secret' => khaki_get_theme_mod('twitter_access_token_secret'),
            'cachetime' => khaki_get_theme_mod('twitter_cache_time')
        ));
        $tweets = nk_theme()->twitter()->get_tweets($count, khaki_get_theme_mod('twitter_show_replies'));

        if (!nk_theme()->twitter()->has_error() && !empty($tweets)) {
            foreach ($tweets as $tweet) {
                if ($tweet) {
                    $result .= '<div class="nk-twitter">
                                    <span class="nk-twitter-icon fa fa-twitter"></span>
                                    <div class="nk-twitter-date">
                                        <span>' . $tweet->date_formatted . '</span>
                                    </div>
                                    <div class="nk-twitter-text">
                                        ' . $tweet->text_entitled . '
                                    </div>     
                                </div>';
                }
            }
        } else if (nk_theme()->twitter()->has_error()) {
            $result = nk_theme()->twitter()->get_error()->message;
        }

        return '<div class="' . khaki_sanitize_class(trim($class)) . '" data-twitter-count="' . esc_attr($count) . '">' . $result . '</div>';
    }
endif;


add_action( 'after_setup_theme', 'vc_nk_twitter' );
if ( ! function_exists( 'vc_nk_twitter' ) ) :
    function vc_nk_twitter() {
        if(function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map( array(
                'name' => esc_html__('nK Twitter', 'khaki-core'),
                'base' => 'nk_twitter',
                'controls' => 'full',
                'category' => 'nK',
                'icon'     => 'icon-nk icon-nk-twitter',
                'params' => array_merge(array(
                    array(
                        'type'        => 'cusrom',
                        'param_name'  => 'note',
                        'heading'     => esc_html__('Note', 'khaki-core'),
                        'description' => esc_html__("Before use, you need to configure access to Twitter here - ", 'khaki-core') . '<a target="_blank" href="' . esc_url(admin_url('customize.php?autofocus[section]=khaki_twitter')) . '">' . esc_html(admin_url('customize.php?autofocus[section]=khaki_twitter')) . '</a>',
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Count', 'khaki-core'),
                        'param_name'  => 'count',
                        'value'       => '3',
                        'description' => '',
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Custom Classes', 'khaki-core'),
                        'param_name'  => 'class',
                        'value'       => '',
                        'description' => '',
                    )
                ), khaki_get_css_tab())
            ) );
        }
    }
endif;
