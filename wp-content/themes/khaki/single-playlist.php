<?php
/**
 * The template for displaying all custom(playlist) posts.
 *
 * @link https://codex.wordpress.org/Post_Types
 *
 * @package khaki
 */
global $post;
get_header();
get_template_part('/template-parts/header/custom');
$post_type = get_post_type();
$acf_header = khaki_get_theme_mod($post_type . '_header_custom', true);
$acf_content = khaki_get_theme_mod('content_' . $post_type . '_custom', true);

$resolution = 'khaki_600x600';
$first_column_class = 'col-md-4';
$second_column_class = 'col-md-8';
$attachment = khaki_get_attachment(get_post_thumbnail_id(get_the_ID()), $resolution);
$buy_link = khaki_get_theme_mod('playlist_buy_link', true);
$price = khaki_get_theme_mod('playlist_price', true);
$playlist = khaki_get_theme_mod('playlist_tracks', true);
$rotate = khaki_get_theme_mod('playlist_rotate', $acf_content);

if(isset($rotate) && $rotate){
    $first_column_class .= ' order-md-2';
}

$acf_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_custom', true);
$custom_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_list', $acf_sidebar);
$show_custom_sidebar = khaki_get_theme_mod('sidebar_' . $post_type . '_show', $acf_sidebar);
$custom_sidebar_side = khaki_get_theme_mod('sidebar_' . $post_type . '_side', $acf_sidebar);

$col_class = 'col-12';

if ($show_custom_sidebar && $custom_sidebar && is_active_sidebar($custom_sidebar)) {
    if (isset($custom_sidebar_side) && $custom_sidebar_side === 'both') {
        $col_class = 'col-lg-6';
    } else {
        $col_class = 'col-lg-8';
    }
}

$class = 'nk-box';
$playlist_background_color = khaki_get_theme_mod($post_type . '_background_color', true);
$playlist_text_color = khaki_get_theme_mod($post_type . '_text_color', true);
if(isset($playlist_background_color)){
    $class .= ' bg-custom-playlist-color';
}
if(isset($playlist_text_color)){
    $class .= ' text-custom-playlist-color';
}
?>
<?php while (have_posts()) : the_post(); ?>
    <div class="<?php echo khaki_sanitize_class($class);?>">
        <div
            class="<?php echo khaki_sanitize_class(khaki_get_theme_mod('playlist_inner_boxed', $acf_content) ? 'container' : 'container-fluid'); ?>">
            <div class="row">
                <div class="<?php echo khaki_sanitize_class($col_class); ?>">
            <?php if (khaki_get_theme_mod($post_type . '_detail_show_title', $acf_content)): ?>
                <div class="bg-dark-1 text-white">
                    <div class="nk-gap-5"></div>
                    <h1 class="display-4 nk-title">
                        <?php
                        $custom_title = khaki_get_theme_mod($post_type . '_content_custom_title', $acf_content);
                        echo $custom_title ? esc_html($custom_title) : get_the_title();
                        ?>
                    </h1>
                    <h2 class="nk-sub-title text-white mb-0"> <?php $time_string = get_the_time(esc_html__('F j, Y ', 'khaki'));
                        echo esc_html($time_string); ?></h2>
                    <div class="nk-gap-3"></div>
                </div>
            <?php else: ?>
                <div class="nk-gap-3"></div>
            <?php endif; ?>
            <div class="row vertical-gap">
    <?php if ((isset($attachment) && !empty($attachment) && is_array($attachment)) || (isset($buy_link) && !empty($buy_link))): ?>
                <div class="<?php echo khaki_sanitize_class($first_column_class);?>">
                    <?php if (isset($attachment) && !empty($attachment) && is_array($attachment)): ?>
                        <img class="nk-img-fit" src="<?php echo esc_url($attachment['src']); ?>"
                             alt="<?php echo esc_attr($attachment['alt']); ?>">
                    <?php endif; ?>
                    <div class="nk-gap-1"></div>
                    <?php the_content(); ?>
                    <div class="nk-gap-1"></div>
                    <?php if (isset($buy_link) && !empty($buy_link)): ?>
                        <a href="<?php echo esc_url($buy_link); ?>"
                           class="nk-btn nk-btn-effect-2-right nk-btn-outline nk-btn-color-white nk-btn-circle">
                            <span><?php echo esc_html__('Buy', 'khaki'); ?> <?php echo isset($price) && !empty($price) ? esc_html($price) : ''; ?></span>
                            <span class="icon"><span class="ion-md-cart"></span></span>
                        </a>
                    <?php endif; ?>
                </div>
        <?php else:?>
        <?php $second_column_class = 'col-md-12';?>
    <?php endif; ?>
                <?php if(isset($playlist) && !empty($playlist) && is_array($playlist)):?>
                    <?php
                    global $enablePlayer;
                    $enablePlayer = true;
                    ?>

                <div class="<?php echo khaki_sanitize_class($second_column_class);?>">
                    <!--
                        START: Playlist

                        Available classes:
                            nk-audio-playlist-hidden
                            nk-audio-playlist-dark
                            active

                        ID attribute needs to automatically detect playlist after page reload
                     -->
                    <ul class="nk-audio-playlist nk-audio-playlist-dark" id="playlist-<?php echo get_the_ID(); ?>">
                        <?php
                        foreach ($playlist as $track):
                            $meta_audio = get_post_meta($track['track']['ID'], '_wp_attachment_metadata', true);
                            $album = isset($meta_audio['album']) ? $meta_audio['album'] : '';
                            $track_length = isset($meta_audio['length_formatted']) ? $meta_audio['length_formatted'] : '';
                            ?>
                            <li data-src="<?php echo esc_url($track['track']['url']);?>">
                                <div class="nk-audio-playlist-title">
                                    <strong><?php echo esc_html($album);?></strong> - <?php echo esc_html($track['track']['title']);?>
                                </div>
                                <?php if((isset($track['buy_link']) && !empty($track['buy_link'])) || (isset($track['downloading']) && !empty($track['downloading']) && $track['downloading'])): ?>
                                <div class="nk-audio-playlist-buttons">
                                    <?php if(isset($track['buy_link']) && !empty($track['buy_link'])): ?>
                                    <a href="<?php echo esc_url($track['buy_link']);?>" target="_blank">
                                        <span class="ion-md-cart"></span>
                                    </a>
                                    <?php endif; ?>
                                    <?php if(isset($track['downloading']) && !empty($track['downloading']) && $track['downloading'] && isset($track['track']['url']) && !empty($track['track']['url'])): ?>
                                    <a href="<?php echo esc_url($track['track']['url']);?>" download>
                                        <span class="fa fa-download"></span>
                                    </a>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                                <div class="nk-audio-playlist-duration">
                                    <?php echo esc_html($track_length);?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <!-- END: Playlist  -->
                </div>

                <?php endif; ?>
            </div>
            <div class="nk-gap-4"></div>
        </div>
        <?php get_sidebar(); ?>
    </div>
        </div>

    </div>
<?php endwhile; // End of the loop.?>
<?php get_footer();
