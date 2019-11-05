<?php
/**
 * nK Playlist
 *
 * Example:
 * [nk_playlist method='files' tracks='13, true, https://khaki/playlist/album-4/ | 14, false, https://khaki/playlist/album-1/ | ...' class='nk-audio-playlist-dark']
 * or
 * [nk_playlist method='playlist' post_id='23']
 * 1. explanations: tracks options works only if you have selected method='files'
 * 2. tracks option value divided | symbol
 * 3. each part of the value can contain 3 fields:
 * - file id (only audio)
 * - permit the user to download the file (true or false)
 * - link to buy track
 * 4. All fields should be divided , symbol
 */

add_shortcode('nk_playlist', 'nk_playlist');
if (!function_exists('nk_playlist')) :
    function nk_playlist($atts, $content = null)
    {//define ul block ID. ID attribute needs to automatically detect playlist after page reload
        global $nk_playlist_id;
        if(!$nk_playlist_id) {
            $nk_playlist_id = 0;
        }
        $nk_playlist_id++;
        extract(shortcode_atts(array(
            'method' => 'playlist',
            'text_color' => 'dark-1',
            'post_id' => '',
            'tracks' => '',
            'dark_style' => '',
            'class' => ''
        ), $atts));
        $result = '';
        // additional classname for custom styles VC
        $class .= khaki_get_css_tab_class($atts);
        $class .= ' nk-audio-playlist';
        if(khaki_nk_check($dark_style)){
            $class .= ' nk-audio-playlist-dark';
        }
        if (khaki_nk_check($text_color)) {
            $class .= ' text-' . $text_color;
        }
        if(isset($method) && $method == 'playlist' && isset($post_id) && is_numeric($post_id)){
            $playlist_tracks = khaki_get_theme_mod('playlist_tracks', true, $post_id);
            $tracks = array();
            foreach($playlist_tracks as $key=>$track){
                $tracks[$key]['audio'] = $track['track']['id'];
                $tracks[$key]['download'] = $track['downloading'];
                $tracks[$key]['buy_link'] = $track['buy_link'];
            }
        } elseif(isset($method) && $method == 'files'){
            if (khaki_nk_check($tracks) && function_exists('vc_param_group_parse_atts')) {
                $tracks = vc_param_group_parse_atts($tracks);
            } elseif (khaki_nk_check($tracks)) {
                $tracks_array = explode("|", $tracks);
                $tracks = array();
                foreach ($tracks_array as $key_track => $track) {
                    $track_array = explode(",", $track);
                    foreach ($track_array as $key_field => $field) {
                        $field = trim($field);
                        switch ($key_field) {
                            case 0:
                                $tracks[$key_track]['audio'] = $field;
                                break;
                            case 1:
                                $tracks[$key_track]['download'] = $field;
                                break;
                            case 2:
                                $tracks[$key_track]['buy_link'] = $field;
                                break;
                        }
                    }
                }
            }
        }

        if (khaki_nk_check($tracks) && is_array($tracks) && !empty($tracks)) {
            //define flag for show player
            global $enablePlayer;
            $enablePlayer = true;
            $link_pattern = '|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i';
            $result .= '<ul class="'.khaki_sanitize_class($class).'" id="playlist-'.esc_attr($nk_playlist_id).'">';
            foreach ($tracks as $track) {
                if (isset($track['audio']) && !empty($track['audio'])) {
                    if (is_numeric($track['audio'])) {
                        $meta_audio = get_post_meta($track['audio'], '_wp_attachment_metadata', true);
                        $album = isset($meta_audio['album']) ? $meta_audio['album'] : '';
                        $track_length = isset($meta_audio['length_formatted']) ? $meta_audio['length_formatted'] : '';
                        $url = wp_get_attachment_url($track['audio']);
                        $media_title = get_the_title($track['audio']);
                    }
                    if (preg_match($link_pattern, $url))
                        $result .= '<li data-src="' . esc_url($url) . '">';
                    if (isset($media_title) || isset($album)) {
                        $result .= '<div class="nk-audio-playlist-title">
                                        <strong>' . esc_html($album) . '</strong> ' . esc_html((isset($media_title) && isset($album)) ? ' - ' : '') . esc_html(isset($media_title) ? $media_title : '') . '
                                    </div>';
                    }
                    if ((isset($track['download']) && $track['download'] != false) || (isset($track['buy_link']) && preg_match($link_pattern, $track['buy_link']))) {
                        $result .= '<div class="nk-audio-playlist-buttons">';
                        if (isset($track['buy_link']) && preg_match($link_pattern, $track['buy_link'])) {
                            $result .= '<a href="' . esc_url($track['buy_link']) . '" target="_blank">
                                            <span class="ion-bag"></span>
                                        </a>';
                        }
                        if (isset($track['download']) && $track['download'] != false) {
                            $result .= '<a href="' . esc_url($url) . '" download>
                                            <span class="fa fa-download"></span>
                                        </a>';
                        }
                        $result .= '</div>';
                    }
                    if (isset($track_length) && !empty($track_length)) {
                        $result .= '<div class="nk-audio-playlist-duration">'.esc_html($track_length).'</div>';
                    }
                    $result .= '</li>';
                }
            }
            $result .= '</ul>';
        }
        return $result;
    }
endif;


add_action('after_setup_theme', 'vc_nk_playlist');
if (!function_exists('vc_nk_playlist')) :
    function vc_nk_playlist()
    {
        //add all playlist posts for show in post_id option
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'playlist',
        );
        $posts = new WP_Query($args);
        $post_list = array();
        foreach ($posts->posts as $post) {
            $post_list[$post->post_title] = $post->ID;
        }
        if (function_exists('vc_map')) {
            /* Register shortcode with Visual Composer */
            vc_map(array(
                'name' => esc_html__('nK Playlist', 'khaki-shortcodes'),
                'base' => 'nk_playlist',
                'controls' => 'full',
                'category' => 'nK',
                'icon' => 'icon-nk',
                'params' => array_merge(array(
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Add Method', 'khaki-shortcodes'),
                        'param_name' => 'method',
                        'std' => 'playlist',
                        'value' => array(
                            esc_html__('Playlist', 'khaki-shortcodes') => 'playlist',
                            esc_html__('Audio Files', 'khaki-shortcodes') => 'files',
                        ),
                        'description' => esc_html__('select the add method', 'khaki-shortcodes')
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Select Playlist', 'khaki-shortcodes'),
                        'param_name' => 'post_id',
                        'value' => $post_list,
                        'dependency' => array(
                            'element' => 'method',
                            'value' => 'playlist'
                        )
                    ),
                    array(
                        'type' => 'param_group',
                        'heading' => esc_html__('Audio Files', 'khaki-shortcodes'),
                        'value' => '',
                        'param_name' => 'tracks',
                        'params' => array(
                            array(
                                "type" => "awb_attach_audio",
                                "param_name" => "audio",
                                "heading" => esc_html__("Add Audio File", 'khaki-shortcodes'),
                                "edit_field_class" => "vc_col-sm-4",
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Buy Link', 'khaki-shortcodes'),
                                'param_name' => 'buy_link',
                                'value' => '',
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => esc_html__('Allow Download', 'khaki-shortcodes'),
                                'param_name' => 'download',
                                'value' => array('' => true)
                            ),

                        ),
                        'dependency' => array(
                            'element' => 'method',
                            'value' => 'files'
                        )
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => esc_html__('Dark Style', 'khaki-shortcodes'),
                        'param_name' => 'dark_style',
                        'value' => array('' => true)
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Text Color', 'khaki-shortcodes'),
                        'param_name' => 'text_color',
                        'std'        => 'dark-1',
                        'value'      => khaki_get_colors(),
                        'description' => ''
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Custom Classes', 'khaki-shortcodes'),
                        'param_name' => 'class',
                        'value' => '',
                        'description' => '',
                    )
                ), khaki_get_css_tab())
            ));
        }
    }
endif;