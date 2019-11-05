<!-- START: Footer -->
<?php
$post_type = get_post_type();
if (!$post_type) {
    $post_type = 'page';
}
if ($post_type == 'product') {
    $post_type = 'woocommerce';
}
$acf_footer = khaki_get_theme_mod($post_type . '_custom_footer', true);

$footer_background_image = khaki_get_theme_mod('footer_background_image');
$footer_logo = khaki_get_theme_mod('footer_logo');
$footer_text = khaki_get_theme_mod('footer_text');
$side_buttons_link_button = khaki_get_theme_mod('side_buttons_link_button');
if (!class_exists('Kirki')) {
    $footer_logo = get_template_directory_uri() . '/assets/images/logo-3.svg';
    $footer_text = '<a href="https://nkdev.info/" target="_blank">nK</a> &copy; 2018. All rights reserved';
    $side_buttons_link_button = '#';
}
?>
<?php if (khaki_get_theme_mod('footer_show', $acf_footer)): ?>
    <?php
    //defend additional classes
    $footerAdditionalClasses = "";
    if (khaki_get_theme_mod('footer_parallax')) {
        $footerAdditionalClasses .= " nk-footer-parallax";
    }
    if (khaki_get_theme_mod('footer_parallax_opacity')) {
        $footerAdditionalClasses .= " nk-footer-parallax-opacity";
    }
    if (khaki_get_theme_mod('footer_parallax_blur')) {
        $footerAdditionalClasses .= " nk-footer-parallax-blur";
    }
    ?>
    <footer
        class="nk-footer<?php if ($footerAdditionalClasses) echo khaki_sanitize_class($footerAdditionalClasses); ?>">

        <?php if ($footer_background_image): ?>
            <div class="bg-image">
                <?php
                echo khaki_get_image( $footer_background_image, 'khaki_1920x1080', false, array(
                    'class' => 'jarallax-img',
                ) );
                ?>
            </div>
        <?php endif; ?>

        <div<?php echo ' class="' . khaki_sanitize_class('container') . '"'; ?>>

            <?php if (khaki_get_theme_mod('footer_show_logo')): ?>
                <div class="nk-gap-5"></div>
            <?php endif; ?>
            <?php $logo = khaki_get_attachment($footer_logo); ?>
            <?php if ($logo && khaki_get_theme_mod('footer_show_logo')): ?>
                <div class="nk-footer-logo">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <img src="<?php echo esc_url($logo['src']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>"
                             width="<?php echo esc_attr(khaki_get_theme_mod('footer_logo_width')); ?>">
                    </a>
                </div>
            <?php endif; ?>
            <?php
            $footer_widget_col_one_size = khaki_get_theme_mod('footer_widget_col_one_size');
            $footer_widget_col_two_size = khaki_get_theme_mod('footer_widget_col_two_size');
            $footer_widget_col_three_size = khaki_get_theme_mod('footer_widget_col_three_size');
            $footer_widget_col_four_size = khaki_get_theme_mod('footer_widget_col_four_size');
            $footer_sidebar_one_row = khaki_get_theme_mod('footer_sidebar_one_row');
            $footer_sidebar_two_row = khaki_get_theme_mod('footer_sidebar_two_row');
            $footer_sidebar_three_row = khaki_get_theme_mod('footer_sidebar_three_row');
            $footer_sidebar_four_row = khaki_get_theme_mod('footer_sidebar_four_row');

            $footerAdditionalClasses = "row";
            $footerAdditionalClasses .= " vertical-gap";
            if (khaki_get_theme_mod('footer_row_align_items_center')) {
                $footerAdditionalClasses .= " align-items-center";
            }
            ?>
            <?php if ((is_active_sidebar($footer_sidebar_one_row) && $footer_widget_col_one_size > 0) || (is_active_sidebar($footer_sidebar_two_row) && $footer_widget_col_two_size > 0) || (is_active_sidebar($footer_sidebar_three_row) && $footer_widget_col_three_size > 0) || (is_active_sidebar($footer_sidebar_four_row) && $footer_widget_col_four_size > 0)): ?>
                <div class="nk-gap-4"></div>
                <div class="<?php echo khaki_sanitize_class(trim($footerAdditionalClasses));?>">
                    <?php if (is_active_sidebar($footer_sidebar_one_row) && $footer_widget_col_one_size > 0): ?>
                        <div
                            class="<?php echo khaki_sanitize_class('col-lg-' . $footer_widget_col_one_size); ?>">
                            <?php dynamic_sidebar($footer_sidebar_one_row); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (is_active_sidebar($footer_sidebar_two_row) && $footer_widget_col_two_size > 0): ?>
                        <div
                            class="<?php echo khaki_sanitize_class('col-lg-' . $footer_widget_col_two_size); ?>">
                            <?php dynamic_sidebar($footer_sidebar_two_row); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (is_active_sidebar($footer_sidebar_three_row) && $footer_widget_col_three_size > 0): ?>
                        <div
                            class="<?php echo khaki_sanitize_class('col-lg-' . $footer_widget_col_three_size); ?>">
                            <?php dynamic_sidebar($footer_sidebar_three_row); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (is_active_sidebar($footer_sidebar_four_row) && $footer_widget_col_four_size > 0): ?>
                        <div
                            class="<?php echo khaki_sanitize_class('col-lg-' . $footer_widget_col_four_size); ?>">
                            <?php dynamic_sidebar($footer_sidebar_four_row); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if (khaki_get_theme_mod('footer_show_logo')): ?>
                <div class="nk-gap-5"></div>
                <?php else: ?>
                <div class="nk-gap-4"></div>
            <?php endif; ?>

        </div>
        <?php if (isset($footer_text) && !empty($footer_text)): ?>
            <div class="nk-copyright">
                <div class="container text-center">
                    <?php echo wp_kses_post($footer_text); ?>
                </div>
            </div>
        <?php endif; ?>
    </footer>
<?php endif; ?>
<!-- END: Footer -->

</div>
<?php
//output post type pagination
get_template_part('/template-parts/pagination', 'fixed'); ?>

<?php  $audio_player_active_playlist = khaki_get_theme_mod('audio_player_active_playlist');?>
<?php global $enablePlayer; ?>
<?php if ($enablePlayer || $audio_player_active_playlist): ?>
    <!--
       START: Audio Player

       Additional Classes:
           nk-audio-player-autoplay
           nk-audio-player-pin
    -->
    <div class="nk-audio-player-main nk-audio-player-pin">
        <div class="container">
            <div class="nk-audio-inner">
                <div class="nk-audio-controls">
                    <div class="nk-audio-prev">
                        <span class="ion-ios-rewind"></span>
                    </div>
                    <div class="nk-audio-play-pause">
                        <div class="nk-audio-play">
                            <span class="ion-ios-play ml-3"></span>
                        </div>
                        <div class="nk-audio-pause">
                            <span class="ion-ios-pause"></span>
                        </div>
                    </div>
                    <div class="nk-audio-next">
                        <span class="ion-ios-fastforward"></span>
                    </div>
                </div>
                <div class="nk-audio-title">
                    <div>
                    </div>
                </div>
                <div class="nk-audio-time"></div>
                <!-- Volume controller will be automatically removed on iOs devices, because of limitation of volume control -->
                <div class="nk-audio-volume">
                    <div class="nk-audio-volume-icon">
                        <div class="nk-audio-volume-icon-muted">
                            <span class="ion-md-volume-off"></span>
                        </div>
                        <div class="nk-audio-volume-icon-small">
                            <span class="ion-md-volume-mute"></span>
                        </div>
                        <div class="nk-audio-volume-icon-half">
                            <span class="ion-md-volume-low"></span>
                        </div>
                        <div class="nk-audio-volume-icon-full">
                            <span class="ion-md-volume-high"></span>
                        </div>
                    </div>
                    <div class="nk-audio-volume-inner">
                        <div class="nk-audio-volume-current"></div>
                    </div>
                </div>
                <div class="nk-audio-settings">
                    <div class="nk-audio-loop" title="<?php esc_attr_e('Loop', 'khaki');?>">
                        <span class="ion-md-infinite"></span>
                    </div>
                    <div class="nk-audio-shuffle" title="<?php esc_attr_e('Shuffle', 'khaki');?>">
                        <span class="ion-ios-shuffle"></span>
                    </div>
                    <div class="nk-audio-playlist" title="<?php esc_attr_e('Show/Hide Playlist', 'khaki');?>">
                        <span class="ion-md-list-box"></span>
                    </div>
                    <div class="nk-audio-pin" title="<?php esc_attr_e('Pin/Unpin Player', 'khaki');?>">
                        <span class="fas fa-thumbtack"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="nk-audio-progress">
            <div class="nk-audio-progress-current"></div>
        </div>
        <div class="nk-audio-player-playlist">
            <div class="nano">
                <div class="nano-content">
                    <ul class="nk-audio-player-playlist-inner"></ul>
                </div>
            </div>
        </div>
    </div>
    <div class="nk-side-buttons nk-side-buttons-left d-md-none">
        <ul>
            <li><a href="#" class="nk-audio-pin"><span class="ion-ios-musical-notes"></span></a></li>
        </ul>
    </div>
    <!-- END: Audio Player -->
<?php endif; ?>
<?php $audio_player_show = khaki_get_theme_mod('audio_player_show');?>
<?php if($audio_player_show):?>
    <?php if(isset($audio_player_active_playlist) && is_numeric($audio_player_active_playlist) && $audio_player_active_playlist != 0):?>
           <?php
           $playlist_tracks = khaki_get_theme_mod('playlist_tracks', true, $audio_player_active_playlist);
           $tracks = array();
           foreach($playlist_tracks as $key=>$track){
               $tracks[$key]['audio'] = $track['track']['id'];
               $tracks[$key]['download'] = $track['downloading'];
               $tracks[$key]['buy_link'] = $track['buy_link'];
           }
           ?>
        <?php if (isset($tracks) && is_array($tracks) && !empty($tracks)):?>
            <?php
            //define flag for show player
            global $enablePlayer;
            $enablePlayer = true;
            $link_pattern = '|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i';
            ?>
        <ul class="nk-audio-playlist nk-audio-playlist-hidden active">
            <?php foreach ($tracks as $track):?>
                <?php  if (isset($track['audio']) && !empty($track['audio'])):?>
                    <?php
                    if (is_numeric($track['audio'])) {
                        $meta_audio = get_post_meta($track['audio'], '_wp_attachment_metadata', true);
                        $album = isset($meta_audio['album']) ? $meta_audio['album'] : '';
                        $track_length = isset($meta_audio['length_formatted']) ? $meta_audio['length_formatted'] : '';
                        $url = wp_get_attachment_url($track['audio']);
                        $media_title = get_the_title($track['audio']);
                        $downloadable = 'false';
                        $purchase = false;
                        if(isset($track['download']) && $track['download'] != false){
                            $downloadable = 'true';
                        }
                        if(isset($track['buy_link']) && preg_match($link_pattern, $track['buy_link'])){
                            $purchase = true;
                        }
                    }?>
                    <?php  if (preg_match($link_pattern, $url)):?>
                        <li data-src="<?php echo esc_url($url);?>" data-downloadable="<?php echo esc_attr($downloadable);?>" <?php echo $purchase ? 'data-purchase-url="'.esc_url($track['buy_link']).'"' : '';?>>
                            <?php
                            if (isset($media_title) || isset($album)):
                                $result .= '<div class="nk-audio-playlist-title">
                                        <strong>' . esc_html($album) . '</strong> ' . esc_html((isset($media_title) && isset($album)) ? ' - ' : '') . esc_html(isset($media_title) ? $media_title : '') . '
                                    </div>';
                            ?>
                            <div class="nk-audio-playlist-title">
                                <strong><?php echo esc_html($album);?></strong> <?php echo esc_html((isset($media_title) && isset($album)) ? ' - ' : '') . esc_html(isset($media_title) ? $media_title : '');?>
                            </div>
                            <?php endif;?>
                            <?php
                            if ((isset($track['download']) && $track['download'] != false) || (isset($track['buy_link']) && preg_match($link_pattern, $track['buy_link']))) {
                                echo '<div class="nk-audio-playlist-buttons">';
                                if (isset($track['buy_link']) && preg_match($link_pattern, $track['buy_link'])) {
                                    echo '<a href="' . esc_url($track['buy_link']) . '" target="_blank"><span class="ion-md-cart"></span></a>';
                                }
                                if (isset($track['download']) && $track['download'] != false) {
                                    echo '<a href="' . esc_url($url) . '" download><span class="fa fa-download"></span></a>';
                                }
                                echo '</div>';
                            }
                            if (isset($track_length) && !empty($track_length)) {
                                $result .= '<div class="nk-audio-playlist-duration">'.esc_html($track_length).'</div>';
                            }
                            ?>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach;?>
        </ul>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>
<!-- START: Side Buttons -->
<?php if (khaki_get_theme_mod('side_buttons_show_link_button') || khaki_get_theme_mod('side_buttons_show_scroll_top')): ?>
    <?php
    $side_buttons_additional_classes = 'nk-side-buttons';
    if (khaki_get_theme_mod('side_buttons_visible')):
        $side_buttons_additional_classes .= ' nk-side-buttons-visible';
    endif;
    $side_buttons_light = khaki_get_theme_mod('side_buttons_light') ? 'bg-white text-dark-1' : '';
    ?>
    <div class="<?php echo khaki_sanitize_class($side_buttons_additional_classes); ?>">
        <ul>
            <?php if (khaki_get_theme_mod('side_buttons_show_link_button')): ?>
                <li>
                    <a href="<?php echo esc_url($side_buttons_link_button); ?>"
                       target="_blank" class="<?php echo khaki_sanitize_class($side_buttons_light);?>"><span class="ion-md-cart"></span></a>
                </li>
            <?php endif; ?>
            <?php if (khaki_get_theme_mod('side_buttons_show_scroll_top')): ?>
                <?php $side_buttons_light .= ' nk-scroll-top';?>
                <li><span class="<?php echo khaki_sanitize_class($side_buttons_light);?>"><span class="ion-ios-arrow-up"></span></span></li>
            <?php endif; ?>
        </ul>
    </div>
<?php endif; ?>
<!-- END: Side Buttons -->

<?php if ( khaki_get_theme_mod( 'main_navigation_show_search') ) :
    $search_class = 'nk-search';
    if ( khaki_get_theme_mod( 'main_navigation_search_light' ) ) {
      $search_class .= ' nk-search-light';
    }
    ?>
    <!-- START: Search -->
    <div class="<?php echo khaki_sanitize_class( $search_class );?>">
        <div class="container">
            <form action="<?php echo esc_url(home_url('/')); ?>">
                <fieldset class="form-group nk-search-field">
                    <input type="text" class="form-control" id="searchInput"
                           placeholder="<?php esc_html_e('Search...', 'khaki'); ?>" name="s">
                    <label for="searchInput"><span class="ion-ios-search"></span></label>
                </fieldset>
            </form>
        </div>
    </div>
    <!-- END: Search -->
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
