import $ from 'jquery';

class Search {

	// 1. describe and create/initiate our object
	constructor() {
		this.addSearchHTML();
		this.resultsDiv = $( '#search-overlay__results' );
		this.openButton = $( '.js-search-trigger' );
		this.closeButton = $( '.search-overlay__close' );
		this.searchOverlay = $( '.search-overlay' );
		this.searchField = $( '#search-term' );
		this.events();
		this.isOverlayOpen = false;
		this.isSpinnerVisible = false;
		this.previousValue;
		this.typingTimer;
	}

	// 2. events
	events() {
		this.openButton.on( 'click', this.openOverlay.bind( this ) );
		this.openButton.on( 'touchstart', this.openOverlay.bind( this ) );
		this.closeButton.on( 'click', this.closeOverlay.bind( this ) );
		this.closeButton.on( 'touchstart', this.closeOverlay.bind( this ) );
		$( document ).on( 'keydown', this.keypressDispatcher.bind( this ) );
		this.searchField.on( 'keyup', this.typinLoginc.bind( this ) );
	}

	// 3. methods (function, action...)
	typinLoginc() {
		if ( this.searchField.val() != this.previousValue ) {
			clearTimeout( this.typingTimer );
			if ( this.searchField.val() ) {
				if ( ! this.isSpinnerVisible ) {
					this.resultsDiv.html( '<div class="spinner-loader"></div>' );
					this.isSpinnerVisible = true;
				}
				this.typingTimer = setTimeout( this.getResults.bind( this ), 750 );
			} else {
				this.resultsDiv.html( '' );
				this.isSpinnerVisible = false;
			}
		}

		this.previousValue = this.searchField.val();
	}

	getResults() {
		$.getJSON(
			kristine.root_url +
				'/wp-json/kristine/v1/search?term=' +
				this.searchField.val(),
			results => {
				this.resultsDiv.html( `
			<div class="seach-grid-result">
			<div class="post-type-result"><h2>Products</h2>${
	results.product_arr.length ?
		'<div class="model-list">' :
		`<p>Product not found. <a href="${
			kristine.root_url
					  }/catalog"><br>View All Products</a></p>`
}
						  ${results.product_arr
		.map(
			item => `<article class="status-publish has-post-thumbnail entry"><header class="entry-header"></header><div class="entry-content clearfix">
			<figure>
			<a href="${item.link}" class="model-img"><img src="${item.image}" alt="${
	item.title
}"></a>
					<a href="${item.link}">
					</a>
				</figure>

			<h2 class="entry-title" itemprop="headline"><a class="entry-title-link" rel="bookmark" href="${
	item.link
}">${item.title}</a></h2>
			</div><footer class="entry-footer"></footer></article>`
		)
		.join( '' )}
									${results.posts_arr.length ? '</div>' : ''}</div>

			<div class="post-type-result"><h2>News</h2>${
	results.posts_arr.length ?
		'<ul class="link-list min-list">' :
		`<p>No news matches that search. <a href="${
			kristine.root_url
					  }/news"><br>View all news</a></p>`
}
									  ${results.posts_arr
		.map(
			item =>
				`<li><a href="${item.link}">${item.title}</a></li>`
		)
		.join( '' )}
									${results.posts_arr.length ? '</ul>' : ''}</div>
			</div>
			` );
			}
		);
	}

	keypressDispatcher( e ) {
		if (
			83 == e.keyCode &&
			! this.isOverlayOpen &&
			! $( 'input', 'textarea' ).is( 'focus' )
		) {

			//this.openOverlay();
		}
		if ( 27 == e.keyCode && this.isOverlayOpen ) {
			this.closeOverlay();
		}
	}

	openOverlay() {
		this.searchOverlay.addClass( 'search-overlay--active' );
		$( 'body' ).addClass( 'body-no-scroll' );
		this.searchField.val( '' );
		setTimeout( () => this.searchField.focus(), 301 );

		this.isOverlayOpen = true;
	}

	closeOverlay() {
		this.searchOverlay.removeClass( 'search-overlay--active' );
		$( 'body' ).removeClass( 'body-no-scroll' );

		this.isOverlayOpen = false;
	}

	addSearchHTML() {
		$( 'body' ).append( `
<div class="search-overlay">
<div class="search-overlay__top">
<div class="container">
	<i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
	<input type="text" class="search-term" placeholder="Search ....?" id="search-term">
	<div class="search-overlay__close">
	<i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
	</div>
</div>
</div>
<div class="container">
	<div id="search-overlay__results"></div>
</div>
</div>
<?php
` );
	}
}

export default Search;
