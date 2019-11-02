/*!-----------------------------------------------------------------
  Name: Khaki - HTML Multi-Concept Template
  Version: 1.1.0
  Author: _nK
  Website: https://nkdev.info
  Purchase: https://nkdev.info
  Support: https://nk.ticksy.com
  License: You must have a valid license purchased only from ThemeForest (the above link) in order to legally use the theme for your project.
  Copyright 2016.
-------------------------------------------------------------------*/
;(function() {
'use strict';

/*------------------------------------------------------------------

  Theme Options

-------------------------------------------------------------------*/
var $wooButtons = jQuery('<div style="display: none;">').appendTo('body');
var options = {
    enableSearchAutofocus: khakiInitOptions.enableSearchAutofocus == 1,
    enableActionLikeAnimation: khakiInitOptions.enableActionLikeAnimation == 1,
    enableShortcuts: khakiInitOptions.enableShortcuts == 1,
    enableMouseParallax: khakiInitOptions.enableMouseParallax == 1,
    scrollToAnchorSpeed: khakiInitOptions.scrollToAnchorSpeed,
    parallaxSpeed: khakiInitOptions.parallaxSpeed,
    navigationHoverEffect: 4,

    templates: {
        secondaryNavbarBackItem: khakiInitOptions.secondaryNavbarBackItem,

        likeAnimationLiked: khakiInitOptions.likeAnimationLiked,
        likeAnimationDisliked: khakiInitOptions.likeAnimationDisliked,

        plainVideoIcon: '<span class="nk-video-icon"><span class="' + khakiInitOptions.plainVideoIcon + ' pl-5"></span></span>',
        // plainVideoLoadIcon: ...,
        // fullscreenVideoClose: ...,
        gifIcon: '<span class="nk-gif-icon"><span class="' + khakiInitOptions.gifIcon + '"></span></span>',

        // quickViewPortfolio: ...,
        // quickViewStore: ...,
        // quickViewCloseIcon: ...,

        // audioPlaylistButton: ...,
        // audioPlainButton: ...,

        instagram: false,
        instagramLoadingText: false,
        instagramFailText: false,
        instagramApiPath: false,

        twitter: false,
        twitterLoadingText: false,
        twitterFailText: false,
        twitterApiPath: false,

        countdown: '<div>\n                <span>%D</span>\n                '+khakiInitOptions.days+'\n            </div>\n            <div>\n                <span>%H</span>\n                '+khakiInitOptions.hours+'\n            </div>\n            <div>\n                <span>%M</span>\n                '+khakiInitOptions.minutes+'\n            </div>\n            <div>\n                <span>%S</span>\n                '+khakiInitOptions.seconds+'\n            </div>'
    },

    shortcuts: {
        toggleSearch: khakiInitOptions.toggleSearch,
        showSearch: khakiInitOptions.showSearch,
        closeSearch: khakiInitOptions.closeSearch,

        toggleShare: khakiInitOptions.toggleShare,
        showShare: khakiInitOptions.showShare,
        closeShare: khakiInitOptions.closeShare,

        closeFullscreenVideo: khakiInitOptions.closeFullscreenVideo,

        closeQuckView: khakiInitOptions.closeQuckView,

        audioPlayerPlayPause: khakiInitOptions.audioPlayerPlayPause,
        audioPlayerPlay: khakiInitOptions.audioPlayerPlay,
        audioPlayerPause: khakiInitOptions.audioPlayerPause,
        audioPlayerForward: khakiInitOptions.audioPlayerForward,
        audioPlayerBackward: khakiInitOptions.audioPlayerBackward,
        audioPlayerVolumeUp: khakiInitOptions.audioPlayerVolumeUp,
        audioPlayerVolumeDown: khakiInitOptions.audioPlayerVolumeDown,
        audioPlayerMute: khakiInitOptions.audioPlayerMute,
        audioPlayerLoop: khakiInitOptions.audioPlayerLoop,
        audioPlayerShuffle: khakiInitOptions.audioPlayerShuffle,
        audioPlayerPlaylist: khakiInitOptions.audioPlayerPlaylist,
        audioPlayerPin: khakiInitOptions.audioPlayerPin,

        postLike: khakiInitOptions.postLike,
        postDislike: khakiInitOptions.postDislike,
        postScrollToComments: khakiInitOptions.postScrollToComments,

        toggleSideLeftNavbar: khakiInitOptions.toggleSideLeftNavbar,
        openSideLeftNavbar: khakiInitOptions.openSideLeftNavbar,
        closeSideLeftNavbar: khakiInitOptions.closeSideLeftNavbar,

        toggleSideRightNavbar: khakiInitOptions.toggleSideRightNavbar,
        openSideRightNavbar: khakiInitOptions.openSideRightNavbar,
        closeSideRightNavbar: khakiInitOptions.closeSideRightNavbar,

        toggleFullscreenNavbar: khakiInitOptions.toggleFullscreenNavbar,
        openFullscreenNavbar: khakiInitOptions.openFullscreenNavbar,
        closeFullscreenNavbar: khakiInitOptions.closeFullscreenNavbar
    },
    events: {
        actionHeart: function actionHeart(params) {},
        actionLike: function actionLike(params) {},

        quickViewOpen: function quickViewOpen($quickView) {},
        beforeQuickViewClose: function beforeQuickViewClose($quickView) {},
        quickViewClosed: function quickViewClosed($quickView) {},
        beforeQuickViewLoad: function beforeQuickViewLoad($frameDoc) {
            // check if woocommerce added product and reload page
            var $addedToCart = $frameDoc.find('.nk-quick-view-added-to-cart').length;
            if ($addedToCart) {
                Khaki.closeQuickView();
                window.location = window.location;
                return;
            }

            // remove WP admin bar
            var $bodyWithBar = $frameDoc.find('body.admin-bar');
            if ($bodyWithBar.length) {
                $bodyWithBar.removeClass('admin-bar');
                $frameDoc.find('#wpadminbar').remove();
                $frameDoc.find('html').css('margin-top', '0 !important');
            }

            // click on add to cart
            $frameDoc.find('form.nk-product-addtocart:not([data-product_variations])').on('submit', function (e) {
                var serialize = jQuery(this).serializeArray();
                var serializeObj = {};
                for (var item in serialize) {
                    if (item && typeof serialize[item] !== 'undefined') {
                        var name = serialize[item].name === 'add-to-cart' ? 'product_id' : serialize[item].name;
                        serializeObj['data-' + name] = serialize[item].value;
                    }
                }

                // clone button from page to emulate click
                var $btn = jQuery('a[data-product_id="' + serializeObj['data-product_id'] + '"]').clone();
                if ($btn.length) {
                    $btn.appendTo($wooButtons);
                    $btn.attr(serializeObj);
                    $btn.click();
                    Khaki.closeQuickView();
                    e.preventDefault();
                }
            });
        },
        quickViewLoad: function quickViewLoad($frameDoc) {
        },
        quickViewLoaded: function quickViewLoaded($frameDoc) {}
    }
};

if (typeof Khaki !== 'undefined') {
    Khaki.setOptions(options);
    Khaki.init();
}
}());
