class productPage {
	constructor() {
		this.alert();
		this.openGalery = document.querySelector( '.nk-product-carousel-thumbs' );
		this.events();
	}

	//events
	events() {
		this.openGalery.on( 'click', this.eventFire.bind( this ) );
	}

	alert() {
		let wocommeceButton = document.getElementsByClassName(
			'single_add_to_cart_button'
		);

		if ( wocommeceButton.classList.contains( 'wc-variation-selection-needed' ) ) {
			this.alert( 'working' );
		}
	}

	eventFire( el, etype ) {
		alert( 'test', el );
		if ( el.fireEvent ) {
			el.fireEvent( 'on' + etype );
		} else {
			let evObj = document.createEvent( 'Events' );
			evObj.initEvent( etype, true, false );
			el.dispatchEvent( evObj );
		}
	}
}

export default productPage;
