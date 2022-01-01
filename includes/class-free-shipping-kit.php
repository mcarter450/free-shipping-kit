<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.kahoycrafts.com
 * @since      1.0.0
 *
 * @package    Free_Shipping_Kit
 * @subpackage Free_Shipping_Kit/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Free_Shipping_Kit
 * @subpackage Free_Shipping_Kit/includes
 * @author     Mike Carter <mike@kahoycrafts.com>
 */
class Free_Shipping_Kit {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Free_Shipping_Kit_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( defined( 'FREE_SHIPPING_KIT_VERSION' ) ) {
			$this->version = FREE_SHIPPING_KIT_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'free-shipping-kit';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Free_Shipping_Kit_Loader. Orchestrates the hooks of the plugin.
	 * - Free_Shipping_Kit_i18n. Defines internationalization functionality.
	 * - Free_Shipping_Kit_Admin. Defines all hooks for the admin area.
	 * - Free_Shipping_Kit_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-free-shipping-kit-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-free-shipping-kit-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-free-shipping-kit-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-free-shipping-kit-public.php';

		$this->loader = new Free_Shipping_Kit_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Free_Shipping_Kit_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Free_Shipping_Kit_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		if ( is_admin() ) {

			$plugin_admin = new Free_Shipping_Kit_Admin( $this->get_plugin_name(), $this->get_version() );

			$tab = esc_html($_GET['tab']);
			$page = esc_html($_GET['page']);
			$section = esc_html($_GET['section']);

			if ($page == 'wc-settings' and $tab == 'shipping' and $section == 'fskit') {
				$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
				$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
			}

			$this->loader->add_filter( 'woocommerce_get_sections_shipping', $plugin_admin, 'fskit_add_section', 10, 2 );
			$this->loader->add_filter( 'woocommerce_get_settings_shipping', $plugin_admin, 'fskit_all_settings', 10, 2 );
			$this->loader->add_filter( 'plugin_action_links_'. $this->plugin_name .'/'. $this->plugin_name .'.php', $plugin_admin, 'fskit_settings_link', 10, 2 );
			$this->loader->add_action( 'woocommerce_product_options_shipping', $plugin_admin, 'woocommerce_product_custom_fields', 10, 1);
			$this->loader->add_action('woocommerce_process_product_meta', $plugin_admin, 'woocommerce_product_custom_fields_save', 10, 1);
		}

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Free_Shipping_Kit_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_filter( 'woocommerce_package_rates', $plugin_public, 'woocommerce_package_rates', 1000, 2 );
		$this->loader->add_filter( 'woocommerce_cart_shipping_method_full_label', $plugin_public, 'shipping_method_full_label', 10, 2 );
		$this->loader->add_filter( 'woocommerce_post_class', $plugin_public, 'product_post_class', 10, 2);

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Free_Shipping_Kit_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
