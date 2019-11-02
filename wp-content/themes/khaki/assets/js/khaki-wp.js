(function ($) {
    // fixed carousel inside full-width-row when row resized
    $(document).on('vc-full-width-row', function (e, rows, a, b, c) {
        var args = Array.prototype.slice.call(arguments, 1);
        if (args.length) {
            $rows = $(args);

            var $carousels = $rows.find('.nk-carousel-inner');
            if ($carousels.length && typeof $carousels.flickity !== 'undefined') {
                $carousels.flickity('resize');
            }
        }
    });
$(document).on( 'tinymce-editor-init', function( event, editor) {
    if ((editor.id == 'bbp_reply_content' || editor.id == 'bbp_topic_content' || editor.id == 'bbp_forum_content') && editor.dom) {
        var body = editor.dom.select('body');
        if (typeof body[0] !== 'undefined') {
            body[0].style.backgroundColor = "#e9e9e9";
            body[0].style.color = "black";
            body[0].style.margin = "0px";
            body[0].style.padding = "0px";
            var css = 'a { color: #b56d19;}',
                head = editor.dom.doc.head || editor.dom.doc.getElementsByTagName('head')[0],
                style = editor.dom.doc.createElement('style');
            style.type = 'text/css';
            if (style.styleSheet){
                style.styleSheet.cssText = css;
            } else {
                style.appendChild(editor.dom.doc.createTextNode(css));
            }
            head.appendChild(style);
        }
    }
});

//Called when woocommerce finishes the adding to cart process and produce fragments with the new data
    $( document.body ).on( "added_to_cart", function( event, fragments, cart_hash, $thisbutton ){
        var smallCart;
        var countContainer = $('#khaki_small_cart_count');
        $.each( fragments, function(name, item) {
            smallCart = $(item).find('.khaki_hide_small_cart');
        });
        if(smallCart !== undefined){
            //remove small cart modal container
            $('.nk-widget-store-cart').html(smallCart.html());
            if(smallCart.attr('data-cart-count') > 0){
                countContainer.removeClass('fade out');
                countContainer.addClass('fade show');
            }
            countContainer.text(smallCart.attr('data-cart-count'));
        }
        //hide add to cart button
        $('.added_to_cart').prev('.add_to_cart_button').hide();
    });

    $( document.body ).on( "wc_fragments_loaded wc_fragments_refreshed", function(){
        var countContainer = $('#khaki_small_cart_count');
        $('#khaki_small_cart div').addClass('widget_shopping_cart_content');
        var smallCart =  $('.nk-widget-store-cart .widget_shopping_cart_content .khaki_hide_small_cart');
        if(smallCart.length){
            //remove small cart modal container
            $('.nk-widget-store-cart').html(smallCart.html());
            if(smallCart.attr('data-cart-count') > 0){
                countContainer.removeClass('fade out');
                countContainer.addClass('fade show');
            }
            countContainer.text(smallCart.attr('data-cart-count'));
        }

        // fixed widget buttons
        var widgetSmallCartButtons = $('.nk-widget.woocommerce.widget_shopping_cart .woocommerce-mini-cart__buttons.buttons a');
        widgetSmallCartButtons.removeClass('button');
        widgetSmallCartButtons.addClass('nk-btn nk-btn-sm nk-btn-circle nk-btn-color-dark-1');
    });
    $(document.body).on('country_to_state_changed', function (event, country, wrapper) {
        var statebox   = wrapper.find( '#calc_shipping_state' );
        if(!statebox.parent().is('#billing_state_field')){
            statebox.addClass('form-control');
        }else{
            statebox.addClass('form-control');
        }
        $('#calc_shipping_state_field .select2.select2-container.select2-container--default').css('display', 'none')

        // fixed for billing_state_field and shipping_state_field
        wrapper.find( '#billing_state_field input#billing_state, #shipping_state_field input#shipping_state, #calc_shipping_state, #calc_shipping_city' ).addClass('form-control');
    });
    $( document ).on('change input', 'div.woocommerce > form .cart_item :input', function () {
        $('#khaki-cart-update').removeClass('khaki-shadow-button');

    });
    $(document.body).on('updated_cart_totals', function () {
        $('#khaki-cart-update').addClass('khaki-shadow-button');
    });

    // fixed notice and error message output for woocommerce account page
    $('#khaki-woocommerce-account-content').children('.nk-gap-4:eq(0)').after($('.woocommerce-error, .woocommerce-message, .woocommerce-info'));

    // add top padding when disabled header and main navigation is opaque
    var $padding = false;
    var $content = $('.nk-main .row:eq(0) > div');
    var $headerNotOpaq = $('.nk-header:not(.nk-header-opaque)');
    var $page = $('article.page');
    var $headerTitle = $('.nk-header-title');
    var $underHeaderCrumbs = $('.nk-main > .nk-breadcrumbs');
    var $thereIsGaps = $page.length && $page.prev('.nk-gap-4').length;

    // fix for woocommerce pages with shortcodes
    if ($page.length && !$thereIsGaps) {
        $content = $page.find('.woocommerce:eq(0) > .row > div');
        $thereIsGaps = $content.length;
    }

    function updateTopContentPadding () {
        $padding.height($headerNotOpaq[0].getBoundingClientRect().height);
    }
    if (!$headerTitle.length && $headerNotOpaq.length && (!$page.length || $thereIsGaps)) {
        // generate paddings
        if ($underHeaderCrumbs.length) {
            $padding = $('<div>').insertBefore($underHeaderCrumbs);
        } else {
            $content.each(function () {
                var $newPadding = $('<div>');
                var $isSidebar = $(this).children('.nk-sidebar');

                // is sidebar
                if ($isSidebar.length) {
                    $newPadding.addClass('d-none d-md-block').prependTo($isSidebar);
                } else {
                    $newPadding.prependTo($(this));
                }

                $padding = $padding ? $padding.add($newPadding) : $newPadding;
            });
        }
        Khaki.debounceResize(updateTopContentPadding);
        updateTopContentPadding();
    }
    // WooCommerce layered nav widgets fixed
    $('.nk-widget.woocommerce ul').addClass('nk-widget-categories');
    $('.nk-widget.woocommerce.widget_layered_nav ul .wc-layered-nav-term span.count').addClass('nk-widget-categories-count');

    // WooCommerce prevent review without rating
    $('body').on( 'click', '#respond #submit', function() {
        if(typeof wc_single_product_params === 'undefined'){
            return;
        }

        var $rating = $( this ).closest( '#respond' ).find( '.nk-rating' );
        var $form = $( this ).closest( 'form' );
        var formData = $form.serializeArray();
        var rating  = false;

        for(var k = 0; k < formData.length; k++){
            if(formData[k].name === 'rating'){
                rating = formData[k].value;
                break;
            }
        }

        if ( $rating.length > 0 && !rating && wc_single_product_params.review_rating_required === 'yes' ) {
            window.alert( wc_single_product_params.i18n_required_rating_text );

            return false;
        }
    });

    // fixed top social menu link classes
    $('.khaki_top_icons_menu ul.nk-nav li a').addClass('nk-contact-icon');

    // fixed modal login with ajax container if show errors
    $(document).on('lwa_login lwa_remember lwa_register', function (e, data, $form) {
        $form.closest('.nk-sign-form').height('');
    });

    // fixed BBPress form inputs
    $('#bbp_forum_type_select.bbp_dropdown, #bbp_forum_status_select.bbp_dropdown, #bbp_forum_visibility_select.bbp_dropdown').addClass('form-control');

    function debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    };

    function setMarginToNavbar( marginTop, scrollTop ) {
        var transition = 'margin-top .2s ease 0s, .2s transform,.2s visibility';

        $('.nk-header, .nk-navbar-side, .nk-share-place, .nk-nav-toggler-right, .nk-page-border-t').css( {
            marginTop:  marginTop,
            transition: transition,
        } );

        if ( ( ! $('.nk-contacts-top').length || $('.nk-navbar-fixed').length ) &&  marginTop  >= 0 ) {
            $('.nk-navbar-top').css( {
                'margin-top':  marginTop,
                'transition': transition
            } );
        }
        if ( $('.nk-contacts-top').length > 0 && ( scrollTop <= marginTop || scrollTop === 0 ) ) {
            $('.nk-navbar-top').css( {
                'margin-top':  '0',
                'transition': transition
            } );
        }
    }

    // Fixed sticky if set admin-bar
    $( document ).ready(function() {
        if ($('#wpadminbar').length){
            var reindexMarginToAdminBar = debounce(function() {
                $heightAdminBar = $('#wpadminbar').height();
                $scrollTop = $(window).scrollTop();
                setMarginToNavbar($heightAdminBar, $scrollTop);
                if ($(window).scrollTop() >= $heightAdminBar) {
                    if ($('#wpadminbar').css('position') == 'absolute') {
                        setMarginToNavbar('0', $scrollTop);
                    } else {
                        setMarginToNavbar($heightAdminBar, $scrollTop);
                    }
                } else {
                    setMarginToNavbar($heightAdminBar - $scrollTop, $scrollTop);
                }
            }, 250);

            $(window).on( 'resize scroll orientationchange', reindexMarginToAdminBar );
            reindexMarginToAdminBar();
        }
    });
})(jQuery);
