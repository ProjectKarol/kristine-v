<?php
//extract the types of posts and get format content on post-lists
$format = get_post_format();
$format_content = '';
if (isset($format)) {
    switch ($format) {
        case 'video':
            $video_path = khaki_get_theme_mod('content_post_video', true);
            $thumbnail_path = khaki_get_theme_mod('content_post_video_thumbnail', true);
            $thumbnail_size = khaki_get_theme_mod('content_post_video_thumbnail_size', true);
            if (filter_var($video_path, FILTER_VALIDATE_URL)) {
                $format_content .= '<div class="nk-plain-video" data-video="' . esc_url($video_path) . '"';
            }
            if (filter_var($thumbnail_path, FILTER_VALIDATE_URL) && isset($thumbnail_size)) {
                $attachment = khaki_get_attachment($thumbnail_path, $thumbnail_size);
                if (isset($attachment['src'])) {
                    $format_content .= ' data-video-thumb="' . $attachment['src'] . '"';
                }
            }
            if (filter_var($video_path, FILTER_VALIDATE_URL)) {
                $format_content .= '></div>';
            }
            break;
        case 'gallery':
            $gallery_array = khaki_get_theme_mod('content_post_gallery', true);
            if (isset($gallery_array) && is_array($gallery_array)) {
                $preview_image_size = khaki_get_theme_mod('content_post_gallery_preview_image_size', true);
                $show_arrows = khaki_get_theme_mod('content_post_gallery_show_arrows', true);
                $data_autoplay = khaki_get_theme_mod('content_post_gallery_data_autoplay', true);
                $data_dots = khaki_get_theme_mod('content_post_gallery_data_dots', true);
                $no_margin = khaki_get_theme_mod('content_post_gallery_no_margin', true);

                $images_carousel = '[nk_images_carousel images="';
                $count_gallery_array = count($gallery_array);
                foreach ($gallery_array as $key => $gallery_item) {
                    if (isset($gallery_item['id'])) {
                        if ($key > 0) {
                            $images_carousel .= ', ';
                        }
                        $images_carousel .= $gallery_item['id'];
                    }
                }
                $images_carousel .= '"';

                if (!empty($preview_image_size)) {
                    $images_carousel .= ' images_size="' . $preview_image_size . '"';
                }
                if (!empty($show_arrows)) {
                    $images_carousel .= ' show_arrows="' . $show_arrows[0] . '"';
                }
                if (!empty($data_autoplay)) {
                    $images_carousel .= ' autoplay="' . $data_autoplay . '"';
                }
                if (!empty($data_dots)) {
                    $images_carousel .= ' show_dots="' . $data_dots[0] . '"';
                }
                if (!empty($no_margin)) {
                    $images_carousel .= ' no_margin="' . $no_margin[0] . '"';
                }

                $images_carousel .= ' style="3"';

                $images_carousel .= ' all_visible="true"';

                $images_carousel .= ' on_click="popup"';
                $images_carousel .= ']';
                $format_content = do_shortcode($images_carousel);
            }
            break;
        case 'audio':
            $audio_array = khaki_get_theme_mod('content_post_audio_file', true);
            $image_path = khaki_get_theme_mod('content_post_audio_image', true);
            if($image_path == ''){
                $image_path = get_post_thumbnail_id(get_the_ID());
            }
            $attachment_resolution = khaki_get_theme_mod('archive_attachment_resolution');
            $attachment = khaki_get_attachment($image_path, $attachment_resolution);
            $image_content = $audio_content = '';
            if (!empty($attachment) && is_array($attachment)) {
                if ($attachment['alt']) {
                    $alt = esc_attr($attachment['alt']);
                } else {
                    $alt = esc_attr(get_bloginfo('name'));
                }
                $image_content = '<img class="nk-img-stretch" src="' . esc_url($attachment['src']) . '" alt="' . $alt . '">';
            }
            if (isset($audio_array) && is_array($audio_array)) {
                $meta_audio = get_post_meta($audio_array['ID'], '_wp_attachment_metadata', true);
                $artist = isset($meta_audio['artist']) ? $meta_audio['artist'] : '';
                $track_length = isset($meta_audio['length_formatted']) ? $meta_audio['length_formatted'] : '';
                $track_name = isset($audio_array['title']) ? $audio_array['title'] : '';
                $track_url = filter_var($audio_array['url'], FILTER_VALIDATE_URL) ? $audio_array['url'] : '';
                if (!empty($track_url)) {
                    $info_track = '';
                    if (!empty($artist) || !empty($track_name)) {
                        $info_track = '<div class="nk-audio-plain-title">';
                        if (!empty($artist)) {
                            $info_track .= '<strong>' . esc_html($artist) . '</strong> - ';
                        }
                        if (!empty($track_name)) {
                            $info_track .= $track_name;
                        }
                        $info_track .= '<div class="nk-audio-progress">
                                                          <div class="nk-audio-progress-current"></div>
                                                       </div>';
                        $info_track .= '</div>';
                    }
                    $info_track .= '<div class="nk-audio-plain-duration">' . esc_attr(!empty($track_length) ? $track_length : '') . '</div>';

                    $audio_content = '<div>';
                    $audio_content .= '<div class="nk-audio-plain nk-audio-plain-dark" data-src="' . esc_url($track_url) . '">';
                    $audio_content .= $info_track;
                    $audio_content .= '</div>';
                    $audio_content .= '</div>';
                }
            }
            if (!empty($image_content) || !empty($audio_content)) {
                $format_content = '<div class="nk-post-audio">';
                $format_content .= '<a href="' . esc_url(get_permalink()) . '">';
                $format_content .= $image_content;
                $format_content .= '</a>';
                $format_content .= $audio_content;
                $format_content .= '</div>';
            }
            break;
        case 'image':
            $image_id = get_post_thumbnail_id(get_the_ID());
            $attachment_resolution = khaki_get_theme_mod('archive_attachment_resolution');
            $attachment = khaki_get_attachment($image_id, $attachment_resolution);
            if (!empty($attachment) && is_array($attachment)) {
                if ($attachment['alt']) {
                    $alt = esc_attr($attachment['alt']);
                } else {
                    $alt = esc_attr(get_bloginfo('name'));
                }
                $format_content = '<a href="' . esc_url(get_permalink()) . '">';
                $format_content .= '<img class="nk-img-stretch" src="' . esc_url($attachment['src']) . '" alt="' . esc_attr($alt) . '">';
                $format_content .= '</a>';
            }
            break;
        case 'quote':
            $quote_message = khaki_get_theme_mod('content_post_quote_message', true);
            if (isset($quote_message) && !empty($quote_message)) {
                $quote_author = khaki_get_theme_mod('content_post_quote_author', true);
                $quote_icon_color = khaki_get_theme_mod('content_post_quote_icon_color', true);
                $quote_background_image = khaki_get_theme_mod('content_post_quote_background_image', true);
                $quote_size_image = khaki_get_theme_mod('content_post_quote_image_size', true);
                $quote_link = khaki_get_theme_mod('content_post_quote_link', true);

                $block_quotes = '[nk_block_quote style="2" ';
                if (isset($quote_author) && !empty($quote_author)) {
                    $block_quotes .= 'author="' . $quote_author . '" ';
                }
                if (isset($quote_icon_color) && !empty($quote_icon_color)) {
                    $block_quotes .= 'icon_color="' . $quote_icon_color . '" ';
                }
                if (isset($quote_link) && !empty($quote_link)) {
                    $block_quotes .= 'link="' . $quote_link . '" ';
                }
                $block_quotes .= 'class="nk-post-quote-bg-'.get_the_ID().'"';
                $block_quotes .= ']' . $quote_message . '[/nk_block_quote]';
                $format_content = do_shortcode($block_quotes);

                $quote_bg_attachment = khaki_get_attachment($quote_background_image, $quote_size_image);
                if ($quote_bg_attachment && $quote_bg_attachment['src']) {
                    $format_content .= '<style>.nk-post-quote-bg-'.get_the_ID().' {
                                            background-image: url("' . $quote_bg_attachment['src'] . '");
                                            background-position: 50% 50%;
                                            background-size: cover;
                                        }</style>';
                }
            }
            break;
        case 'standard':
            $format_content = '';
            break;
    }
}

if ($format_content != ''):
    echo wp_kses( $format_content, khaki_allowed_html() );
elseif(!is_single()):
    $attachment_resolution = khaki_get_theme_mod('archive_attachment_resolution');
    $attachment = (khaki_get_attachment(get_post_thumbnail_id(get_the_ID()), $attachment_resolution)); ?>
    <?php if (isset($attachment['src'])): ?>
        <a href="<?php echo esc_url(get_permalink()) ?>"><img
                src="<?php echo esc_url($attachment['src']); ?>"
                alt="<?php echo esc_attr($attachment['alt']); ?>" class="nk-img-stretch"></a>
    <?php endif;
endif; ?>