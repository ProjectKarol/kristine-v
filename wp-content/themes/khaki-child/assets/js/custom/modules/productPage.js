class productPage {
	constructor() {
		this.alert();
	}
	alert() {
		let wocommeceButton = document.getElementsByClassName(
			'single_add_to_cart_button'
		);
		var html = document.getElementsByClassName(
			'woocommerce-product-gallery__image--placeholder'
		)[0].innerHTML;

		jQuery( '.reset_variations' ).click( function() {

			// document.getElementsByClassName(
			// 	'woocommerce-product-gallery__image--placeholder'
			// )[0].innerHTML = html;
			// location.reload();
		});

		console.log( 'HTML ', html );
		jQuery( document ).ready( function( $ ) {
			$( document ).on( 'click', '.attachment-shop_single', function() {
				var src = $( this ).attr( 'src' );

				$(
					'li.woocommerce-product-gallery__image:first-child .attachment-shop_single'
				).attr( 'src', src );
				$( this ).addClass( 'wmvi-selected' );
			});
		});

		if ( wocommeceButton.classList.contains( 'wc-variation-selection-needed' ) ) {
			this.alert( 'working' );
		}

		alert( 'test' );
	}
}

export default productPage;
