<?php
// Add Shortcode
function custom_shortcode()
{
	ob_start(); ?>

<div class="homeslider">
    <div class="abs_content mod">
        <div class="container-fluid">
            <div class="row main-border">
                <?php if (ICL_LANGUAGE_CODE == 'en'): ?>
                <div class="col-xs-1 col-md-3 col-lg-4 main--brdr main-brd-left">
                    <a href="https://www.kristine-v.loc/product-category/masks/">
                        <h3>Masks</h3>
                    </a>
                    <a href="https://www.kristine-v.loc/product-category/harness/">
                        <h3>Harness</h3>
                    </a>
                    <a href="https://www.kristine-v.loc/product-category/belts/">
                        <h3>Belts</h3>
                    </a>
                </div>
                <?php elseif (ICL_LANGUAGE_CODE == 'pl'): ?>
                <div class="col-xs-1 col-md-3 col-lg-4 main--brdr main-brd-left">
                    <a href="https://www.kristine-v.loc/pl/kategoria-produktu/maski/">
                        <h3>Maski</h3>
                    </a>
                    <a href="https://www.kristine-v.loc/pl/kategoria-produktu/szelki/">
                        <h3>Szelki</h3>
                    </a>
                    <a href="https://www.kristine-v.loc/pl/kategoria-produktu/pasy/">
                        <h3>Pasy</h3>
                    </a>
                </div>
                <?php endif; ?>
                <div class="col-xs-12 col-md-6 col-lg-4 main-border--img heder-sentence">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/title.svg" class="img-fluid mx-auto">
                    <div id="typed-strings" style="display: none;">

                        <span></span>
                        <span></span>

                        <span></span>

                    </div>
                    <div class="typed-wrapper">
                        <h2 id="typed" class="typed"></h2>
                    </div>

                    <!-- Typed -->
                    <script>
                    (function($) {
                        jQuery(document).ready(function() {

                            // Typed
                            var typed = new Typed('#typed', {
                                stringsElement: '#typed-strings',
                                typeSpeed: 100,
                                backSpeed: 50,
                                backDelay: 4000,
                                loop: true,
                                showCursor: false
                            });

                        });
                    })(jQuery);
                    </script>


                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo-slider-transparent.png"
                        class="img-fluid ownsecret">
                </div>
                <?php if (ICL_LANGUAGE_CODE == 'pl'): ?>
                <div class="col-xs-1 col-md-3 col-lg-4 main--brdr main-brd-right">
                    <a href="https://www.kristine-v.loc/pl/kategoria-produktu/chokery/">
                        <h3>Chokery</h3>
                    </a>
                    <a href="https://www.kristine-v.loc/pl/kategoria-produktu/bransoletki/">
                        <h3>Bransoletki</h3>
                    </a>
                    <a href="https://www.kristine-v.loc/pl/kategoria-produktu/rekawiczki/">
                        <h3>Rękawiczki</h3>
                    </a>
                </div>
                <?php elseif (ICL_LANGUAGE_CODE == 'en'): ?>
                <div class="col-xs-1 col-md-3 col-lg-4 main--brdr main-brd-right">
                    <a href="https://www.kristine-v.loc/product-category/chokers/">
                        <h3>Chokers</h3>
                    </a>
                    <a href="https://www.kristine-v.loc/product-category/braslets/">
                        <h3>Braslets</h3>
                    </a>
                    <a href="https://www.kristine-v.loc/product-category/gloves/">
                        <h3>Gloves</h3>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<?php return ob_get_clean();
}
add_shortcode('homepage', 'custom_shortcode');
