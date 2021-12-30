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
	 * Plugin storage folder location
	 */
	const PLUGIN_STORAGE_FOLDER = WP_CONTENT_DIR . '/freeshippingkit_files';

	/**
	 * Remove all created or registered options.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		delete_option( 'fskit_txt_color' );
		delete_option( 'fskit_bg_color' );
		delete_option( 'fskit_hide_tablerate_shipping' );
		delete_option( 'fskit_freeshipping_label' );

		if ( is_dir(self::PLUGIN_STORAGE_FOLDER) ) {
			if ( file_exists(self::PLUGIN_STORAGE_FOLDER .'/free-shipping-kit-public.css') ) {
				unlink(self::PLUGIN_STORAGE_FOLDER .'/free-shipping-kit-public.css');
			}

			rmdir(self::PLUGIN_STORAGE_FOLDER);
		}

	}

}
