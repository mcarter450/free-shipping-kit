(function( $ ) {
	'use strict';

	const { __, _x, _n, sprintf } = wp.i18n;

	jQuery(document).ready(function($) {

		/**
		 * Append free shipping badge to products that have a free_shipping tag
		 */
		var $product_price = $('.entry.product.free-shipping-badge .price');
		if ( $product_price.length ) {
			$product_price.append('<span class="free-shipping">'+ __('Free Shipping', 'free-shipping-kit') +'</span>');
		}

	});

})( jQuery );
