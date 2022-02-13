(function( $ ) {
	'use strict';

	const { __, _x, _n, sprintf } = wp.i18n;

	function get_cart_preview_template(labels) {

		var html = `
		<div class="fskit-cart-preview cart_totals calculated_shipping">
			<div class="preview-container">
				<h2>${labels[0]}</h2>
				<table cellspacing="0" class="shop_table shop_table_responsive">
				<tbody>
					<tr class="woocommerce-shipping-totals shipping">
					<th>${labels[1]}</th>
					<td>
						<ul class="woocommerce-shipping-methods">
							<li>
								<input type="radio" disabled="disabled" class="shipping_method" checked="checked">
								<label id="free_shipping_label">${labels[2]}</label>
							</li>
							<li class="hide-in-preview">
								<input type="radio" disabled="disabled" class="shipping_method">
								<label>${labels[3]}: <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>4.30</bdi></span></label>
							</li>
							<li class="hide-in-preview">
								<input type="radio" disabled="disabled" class="shipping_method">
								<label>${labels[4]}: <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>7.95</bdi></span></label>
							</li>
							<li>
								<input type="radio" disabled="disabled" class="shipping_method">
								<label>${labels[5]}: <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>5.00</bdi></span></label>
							</li>
						</ul>
						<p class="woocommerce-shipping-destination">
						${labels[6]} <strong>${labels[7]}</strong>.</p>
					</td>
					</tr>
				</tbody>
				</table>
			</div>
		</div>`;

		return html;

	}

	function get_button_preview_template(labels) {
		return `<div class="fskit-preview"><span class="free-shipping">${labels[0]}</span></div>`;
	}

	jQuery(document).ready(function($) {

		var labels = [
			__('Cart (Example Preview)', 'free-shipping-kit'),
			__('Shipping', 'free-shipping-kit'),
			__('Flat rate', 'free-shipping-kit'),
			__('USPS (First-Class Package)', 'free-shipping-kit'),
			__('USPS (Priority Mail)', 'free-shipping-kit'),
			__('Local pickup', 'free-shipping-kit'),
			__('Shipping to', 'free-shipping-kit'),
			__('Beverly Hills, CA 90210', 'free-shipping-kit')
		];

		var cart_preview_html = get_cart_preview_template(labels);


		labels = [
			__('Free Shipping', 'free-shipping-kit')
		];

		var button_preview_html = get_button_preview_template(labels);

		/**
		 * Additional markup for free shipping badge preview and cart simulation
		 */
		$('#fskit-description').next('table').after(cart_preview_html);
		$('#fskit-description').after(button_preview_html);
		
		$('#fskit_hide_tablerate_shipping').on('change', function(e) {
			var $hide_in_preview = $('.fskit-cart-preview .hide-in-preview');
			if ( $(this).is(":checked") ) {
				$hide_in_preview.hide();
			} else {
				$hide_in_preview.show();
			}
		});

		$('#fskit_show_custom_label').on('change', function(e) {
			var $freeshipping_label = $('#fskit_freeshipping_label');
			if ( $(this).is(":checked") ) {
				$freeshipping_label.prop('disabled', false);
				var label = $('#fskit_freeshipping_label').val() || __('Free Shipping', 'free-shipping-kit');
				$('#free_shipping_label').text(label);
			} else {
				$freeshipping_label.prop('disabled', true);
				$('#free_shipping_label').text( __('Flat rate', 'free-shipping-kit') );
			}
		});

		/**
		 * Initialize cart preview widget
		 */
		(function() {

			var $hide_in_preview = $('.fskit-cart-preview .hide-in-preview');
			if ( $('#fskit_hide_tablerate_shipping').is(":checked") ) {
				$hide_in_preview.hide();
			} else {
				$hide_in_preview.show();
			}

			var label = $('#fskit_freeshipping_label').val() || __('FREE shipping', 'free-shipping-kit');

			if ( !$('#fskit_show_custom_label').is(":checked") ) {
				$('#fskit_freeshipping_label').prop('disabled', true);
				$('#fskit_freeshipping_label').val(label);
			} else {
				$('#fskit_freeshipping_label').val(label);
				$('#free_shipping_label').text(label);
			}

		})();
		
		// Timeout reference
		var timeout;

		$('#fskit_freeshipping_label').on('keyup', function(e) {
			var label = $(this).val();
			clearTimeout(timeout);
			timeout = setTimeout(function() {
				$('#free_shipping_label').text(label);
			}, 500);
		})

		/**
		 * Timeout for text color event
		 */
		setTimeout(function() {
			var color = $('#fskit_txt_color').iris('color') || '#12232E';
			$('.free-shipping').css('color', color);
			$('#fskit_txt_color').iris({
			    change: function(event, ui) {
			        // event = standard jQuery event, produced by whichever control was changed.
			        // ui = standard jQuery UI object, with a color member containing a Color.js object
			        var color = ui.color.toString();
			        $(this).prev('.colorpickpreview').css( 'background-color', color );

			        $('.free-shipping').css( 'color', color );
			    }
			}); 
		}, 1000);

		/**
		 * Timeout for background color event
		 */
		setTimeout(function() {
			var color = $('#fskit_bg_color').iris('color') || '#d1dfe4';
			$('.free-shipping').css('background-color', color);
			$('#fskit_bg_color').iris({
		    	change: function(event, ui) {
			        // event = standard jQuery event, produced by whichever control was changed.
			        // ui = standard jQuery UI object, with a color member containing a Color.js object
			        var color = ui.color.toString();
			        $(this).prev('.colorpickpreview').css( 'background-color', color );

			        $('.free-shipping').css( 'background-color', color );
			    }
			}); 
		}, 1000);

	});

})( jQuery );

