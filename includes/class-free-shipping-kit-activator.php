<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.kahoycrafts.com
 * @since      1.0.0
 *
 * @package    Free_Shipping_Kit
 * @subpackage Free_Shipping_Kit/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Free_Shipping_Kit
 * @subpackage Free_Shipping_Kit/includes
 * @author     Mike Carter <mike@kahoycrafts.com>
 */
class Free_Shipping_Kit_Activator {

	/**
	 * Plugin storage folder location
	 */
	const PLUGIN_STORAGE_FOLDER = WP_CONTENT_DIR . '/freeshippingkit_files';

	/**
	 * Create plugin storage folder
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		$css = <<<CSS
 /**
  * Generated CSS file please override these styles instead
  */
.free-shipping {
    display: inline-block;
    background-color: #d1dfe4;
    color: #12232E;
    font-size: 1rem;
    font-weight: 600;
    letter-spacing: -.02em;
    margin-left: 10px;
    padding: 0px 7px;
    border-radius: 5px;
}
CSS;

		if ( !is_dir(self::PLUGIN_STORAGE_FOLDER) ) {
			mkdir(self::PLUGIN_STORAGE_FOLDER);
		}

		if ( file_exists(self::PLUGIN_STORAGE_FOLDER .'/free-shipping-kit-public.css') ) {
			file_put_contents(self::PLUGIN_STORAGE_FOLDER .'/free-shipping-kit-public.css', $css);
		}
		elseif ( touch(self::PLUGIN_STORAGE_FOLDER .'/free-shipping-kit-public.css') ) {
			file_put_contents(self::PLUGIN_STORAGE_FOLDER .'/free-shipping-kit-public.css', $css);
		}

	}

}
