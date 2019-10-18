"use strict";

jQuery(document).ready(function () {
  // fix for admin bar
  if (jQuery('#wpadminbar')[0]) {//jQuery( '.site-header' ).css( 'top', '32px' );
    //jQuery( 'topbar' ).css( 'top', '352px' );
  }
});
"use strict";

jQuery(function ($) {
  // Show Hello Bar after 200px
  $(document).on('scroll', function () {
    if (15 > $(document).scrollTop()) {
      //change value when you want it to appear
      //	$( '.hello-bar' ).fadeIn();
      $('.site-header').removeClass('fixed-site-header');
    } else {
      //	$( '.hello-bar' ).fadeOut();
      $('.site-header').addClass('fixed-site-header');
    }
  });
});