<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package khaki
 */

get_header(); ?>
    <div class="nk-header-title nk-header-title-full nk-header-title-parallax nk-header-title-parallax-opacity">
        <div class="bg-image op-6">
            <?php
            echo khaki_get_image( khaki_get_theme_mod('not_found_image'), 'khaki_1920x1080', false, array(
                'class' => 'jarallax-img',
            ) );
            ?>
        </div>
        <div class="nk-header-table">
            <div class="nk-header-table-cell">
                <div class="container">
                    <div class="nk-header-text">
                        <div class="nk-gap-4"></div>
                        <div class="container">
                            <div class="text-center">
                                <h3 class="nk-title-back op-2"><?php echo esc_html__("Error 404", 'khaki'); ?></h3>
                                <h2 class="nk-title display-4"><?php echo esc_html__("Page Not Found", 'khaki'); ?></h2>
                                <div class="nk-title-sep-icon">
                                    <span class="icon"><span class="ion-md-flame"></span></span>
                                </div>

                                <div class="row">
                                    <div class="col-md-8 offset-md-2">
                                        <div class="nk-gap"></div>
                                        <?php if (khaki_get_theme_mod('not_found_show_text')): ?>
                                            <p class="lead"><?php echo esc_html__("The page you are looking for no longer exists. Perhaps you can return back to the site’s homepage and see if you can find what you are looking for.", 'khaki'); ?></p>
                                        <?php endif; ?>
                                        <?php if (khaki_get_theme_mod('not_found_show_text') && khaki_get_theme_mod('not_found_show_home_button')): ?>
                                            <div class="nk-gap-1"></div>
                                        <?php endif; ?>
                                        <?php if (khaki_get_theme_mod('not_found_show_home_button')): ?>
                                           <a href="<?php echo esc_url(home_url('/'));?>" class="nk-btn nk-btn-lg nk-btn-rounded nk-btn-color-white text-dark-1"><span class="icon"><span class="ion-ios-home"></span></span> <?php echo esc_html__("Go to Homepage", 'khaki'); ?></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="nk-gap-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Header Title -->
<?php
get_footer();
