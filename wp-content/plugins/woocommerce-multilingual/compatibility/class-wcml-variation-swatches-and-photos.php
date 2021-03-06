<?php

/**
 * Compatibility class for Variation Swatches and Photos plugin
 */
class WCML_Variation_Swatches_And_Photos {

	/** @var SitePress */
	private $sitepress;

	function __construct( SitePress $sitepress ) {
		$this->sitepress = $sitepress;
	}

	public function add_hooks() {
		add_action( 'wcml_after_duplicate_product_post_meta', array(
			$this,
			'sync_variation_swatches_and_photos'
		), 10, 3 );
	}

	/**
	 * Synchronize Variation Swatches and Photos
	 *
	 * @param int $original_product_id Original product ID.
	 * @param int $trnsl_product_id Translated product ID.
	 * @param array $data Product data.
	 */
	public function sync_variation_swatches_and_photos( $original_product_id, $trnsl_product_id, $data = false ) {

		$atts = maybe_unserialize( get_post_meta( $original_product_id, '_swatch_type_options', true ) );

		if ( ! is_array( $atts ) ) {
			return;
		}

		$lang = $this->sitepress->get_language_for_element( $trnsl_product_id, 'post_product' );
		$tr_atts = $atts;

		$original_product_post = get_post( $original_product_id );

		$original_product_taxonomies = get_object_taxonomies( $original_product_post );

		$original_product_terms = get_terms( $original_product_taxonomies );

		if ( is_array( $original_product_terms ) ) {

			remove_filter( 'get_term', array( $this->sitepress, 'get_term_adjust_id' ), 1 );

			foreach ( $atts as $att_name => $att_opts ) {

				$attributes_hashed_names = array_keys( $att_opts['attributes'] );

				foreach ( $original_product_terms as $original_product_term ) {
					$original_product_term_slug_md5 = md5( $original_product_term->slug );

					if ( in_array( $original_product_term_slug_md5, $attributes_hashed_names, true ) ) {

						$translated_product_term_id = apply_filters( 'wpml_object_id', $original_product_term->term_id, $original_product_term->taxonomy, false, $lang );

						$translated_product_term = get_term( $translated_product_term_id, $original_product_term->taxonomy );

						if ( isset( $translated_product_term->slug ) ) {

							$translated_product_term_slug_md5 = md5( $translated_product_term->slug );

							$tr_atts[ $att_name ]['attributes'][ $translated_product_term_slug_md5 ] = $tr_atts[ $att_name ]['attributes'][ $original_product_term_slug_md5 ];

							unset( $tr_atts[ $att_name ]['attributes'][ $original_product_term_slug_md5 ] );
						}
					}
				}
			}

			add_filter( 'get_term', array( $this->sitepress, 'get_term_adjust_id' ), 1, 1 );

		}

		update_post_meta( $trnsl_product_id, '_swatch_type_options', $tr_atts ); // Meta gets overwritten.
	}

}
