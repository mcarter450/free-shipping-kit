<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.kahoycrafts.com
 * @since      1.0.0
 *
 * @package    Free_Shipping_Kit
 * @subpackage Free_Shipping_Kit/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Free_Shipping_Kit
 * @subpackage Free_Shipping_Kit/public
 * @author     Mike Carter <mike@kahoycrafts.com>
 */
class Free_Shipping_Kit_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Storage folder
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	const PLUGIN_STORAGE_FOLDER = '/freeshippingkit_files';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Custom FREE shipping label
	 *
	 * @since    1.0.0
	 * @param string $label
	 * @param object $method
	 * @return string 	Label text
	 */
	public function shipping_method_full_label($label, $method) {

		if ( $method->method_id == 'flat_rate' && $method->get_cost() == 0 ) {

			$show_custom_label = get_option( 'fskit_show_custom_label' );
			$freeshipping_label = get_option( 'fskit_freeshipping_label' );

			if ( isset($show_custom_label) and $show_custom_label == 'yes' ) {
				return !empty($freeshipping_label) ? $freeshipping_label : 'FREE shipping';
			}
		}

		return $label;

	}

	/**
	 * Hide shipping rates when free shipping is available at product level.
	 *
	 * @since    1.0.0
	 * @param array $rates Array of rates found for the package.
	 * @return array 	Array of rates
	 */
	public function woocommerce_package_rates($rates, $package) {

		$hide_tablerate_shipping = get_option( 'fskit_hide_tablerate_shipping' );

		if ( isset($hide_tablerate_shipping) and $hide_tablerate_shipping == 'yes' ) {

			$free = 0;
			$flat_rate_id = null;
			$is_table_rate = 0;
			foreach ( $rates as $rate_id => $rate ) {
				if ($rate->method_id == 'flat_rate') {
					$flat_rate_id = $rate_id;
					if ($rate->cost == 0) $free = 1;
				} elseif ($rate->method_id != 'local_pickup') {
					$is_table_rate = 1;
					if ($free == 1) {
						unset($rates[$rate_id]);
					}
				}
			}

			if ( !$free && $is_table_rate && $flat_rate_id ) {
				unset($rates[$flat_rate_id]);
			}
		}

		return $rates;

	}


	/**
	 * @since    1.0.0
	 * @param array $classes
	 * @param object $product
	 * @return 	array 	Array of classes
	 */
	function product_post_class( $classes, $product ) {

		$free_shipping = get_post_meta( $product->id, '_product_free_shipping_badge', true );
		if (isset($free_shipping) and $free_shipping == 'yes') {
			$classes[] = 'free-shipping-badge';
		}
		return $classes;
		
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		if ( class_exists( 'WooCommerce' ) && (is_shop() || is_product() || is_product_category()) ) {
			wp_enqueue_style( $this->plugin_name, content_url() . self::PLUGIN_STORAGE_FOLDER .'/free-shipping-kit-public.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		if ( class_exists( 'WooCommerce' ) && (is_shop() || is_product() || is_product_category()) ) {
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/free-shipping-kit-public.js', array( 'jquery' ), $this->version, true );
		}
		
	}

}
