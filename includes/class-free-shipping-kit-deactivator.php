<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://www.kahoycrafts.com
 * @since      1.0.0
 *
 * @package    Free_Shipping_Kit
 * @subpackage Free_Shipping_Kit/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Free_Shipping_Kit
 * @subpackage Free_Shipping_Kit/includes
 * @author     Mike Carter <mike@kahoycrafts.com>
 */
class Free_Shipping_Kit_Deactivator {

	/**
	 * Remove all created or registered options.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		delete_option( 'fskit_txt_color' );
		delete_option( 'fskit_bg_color' );
		delete_option( 'fskit_hide_tablerate_shipping' );
		delete_option( 'fskit_show_custom_label' );
		delete_option( 'fskit_freeshipping_label' );

	}

}
