class productPage {
	constructor() {
		this.alert();
	}
	alert() {
		let wocommeceButton = document.getElementsByClassName(
			'single_add_to_cart_button'
		);

		if ( wocommeceButton.classList.contains( 'wc-variation-selection-needed' ) ) {
			this.alert( 'working' );
		}
	}
}

export default productPage;
