<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.kahoycrafts.com
 * @since             1.0.0
 * @package           Free_Shipping_Kit
 *
 * @wordpress-plugin
 * Plugin Name:       Free Shipping Kit
 * Plugin URI:        https://www.kahoycrafts.com/free-shipping-kit
 * Description:       Display a FREE Shipping badge on WooCommerce product category and detail pages.
 * Version:           1.0.2
 * Author:            Mike Carter
 * Author URI:        https://www.kahoycrafts.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       free-shipping-kit
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'FREE_SHIPPING_KIT_VERSION', '1.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-free-shipping-kit-activator.php
 */
function activate_free_shipping_kit() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-free-shipping-kit-activator.php';
	Free_Shipping_Kit_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-free-shipping-kit-deactivator.php
 */
function deactivate_free_shipping_kit() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-free-shipping-kit-deactivator.php';
	Free_Shipping_Kit_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_free_shipping_kit' );
register_deactivation_hook( __FILE__, 'deactivate_free_shipping_kit' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-free-shipping-kit.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_free_shipping_kit() {

	$plugin = new Free_Shipping_Kit();
	$plugin->run();

}
run_free_shipping_kit();
