<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.kahoycrafts.com
 * @since      1.0.0
 *
 * @package    Free_Shipping_Kit
 * @subpackage Free_Shipping_Kit/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Free_Shipping_Kit
 * @subpackage Free_Shipping_Kit/admin
 * @author     Mike Carter <mike@kahoycrafts.com>
 */
class Free_Shipping_Kit_Admin {

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
	 * Plugin storage folder location
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	const PLUGIN_STORAGE_FOLDER = WP_CONTENT_DIR . '/freeshippingkit_files';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Add section to WooCommerce shipping settings
	 *
	 * @since    1.0.0
	 * @param array Sections
	 * @return array Sections
	 */
	public function fskit_add_section( $sections ) {
		$sections['fskit'] = __( 'Free Shipping Kit', 'woocommerce' );
		return $sections;
		
	}

	/**
	 * Shipping settings saved hook
	 *
	 * Cache user styles to disk
	 *
	 * @since    1.0.0
	 */
	public function fskit_settings_saved() {

		$txt_color = $_POST['fskit_txt_color'] ?: '#12232E'; 
		$bg_color = $_POST['fskit_bg_color'] ?: '#d1dfe4';

 		$css = <<<CSS
 /**
  * Generated CSS file please override these styles instead
  */
.free-shipping {
    display: inline-block;
    background-color: %s;
    color: %s;
    font-size: 1rem;
    font-weight: 600;
    letter-spacing: -.02em;
    margin-left: 10px;
    padding: 0px 7px;
    border-radius: 5px;
}
CSS;

		$css = sprintf($css, $bg_color, $txt_color);

		if ( file_exists(self::PLUGIN_STORAGE_FOLDER .'/free-shipping-kit-public.css') ) {
			file_put_contents(self::PLUGIN_STORAGE_FOLDER .'/free-shipping-kit-public.css', $css);
		}
		elseif ( touch(self::PLUGIN_STORAGE_FOLDER .'/free-shipping-kit-public.css') ) {
			file_put_contents(self::PLUGIN_STORAGE_FOLDER .'/free-shipping-kit-public.css', $css);
		}
	}

	/**
	 * Add section to WooCommerce shipping settings
	 *
	 * @since    1.0.0
	 * @param array $settings
	 * @param string $current_section
	 * @return array Settings
	 */
	public function fskit_all_settings( $settings, $current_section ) {
		/**
		 * Check the current section is what we want
		 **/
		if ( $current_section != 'fskit' ) {
			return $settings; // If not, return the standard settings
		}

		$settings = array();
		// Add Title to the Settings
		$settings[] = array( 
			'name'   => __( 'Free Shipping Kit Settings', 'woocommerce' ), 
			'type'   => 'title', 
			'desc'   => __( 'The following options are used to configure the free shipping badge and all optional settings', 'woocommerce' ), 
			'id'     => 'fskit' 
		);
		$settings[] = array(
			'name'   => __( 'Text color', 'woocommerce' ),
			'id'     => 'fskit_txt_color',
			'type'   => 'color',
			'css'    => 'max-width:100px;',
		);
		$settings[] = array(
			'name'   => __( 'Background color', 'woocommerce' ),
			'id'     => 'fskit_bg_color',
			'type'   => 'color',
			'css'    => 'max-width:100px;',
		);
		$settings[] = array(
			'name'   => __( 'Shipping Methods', 'woocommerce' ),
			'id'     => 'fskit_hide_tablerate_shipping',
			'type'   => 'checkbox',
			'desc'   => __( 'Hide paid shipping methods when item has free shipping', 'woocommerce' ),
		);
		$settings[] = array(
			'name'   => __( 'Custom Label', 'woocommerce' ),
			'id'     => 'fskit_show_custom_label',
			'type'   => 'checkbox',
			'desc'   => __( 'Show custom label in cart instead of ugly "Flat rate" text', 'woocommerce' ),
		);
		$settings[] = array(
			'name'   => __( 'Free Shipping Label', 'woocommerce' ),
			'id'     => 'fskit_freeshipping_label',
			'type'   => 'text',
			'desc'   => __( 'Label text shown for free shipping method', 'woocommerce' ),
		);
		
		$settings[] = array( 'type' => 'sectionend', 'id' => 'fskit' );

		return $settings;

	}

	/**
	 * Render custom product fields
	 *
	 * @since    1.0.0
	 */
	public function woocommerce_product_custom_fields() {

		global $woocommerce, $post;

		echo '<div class="product_free_shipping_badge">';

		woocommerce_wp_checkbox(
	        array(
	            'id' => '_product_free_shipping_badge',
	            'label' => __('Free Shipping badge', 'woocommerce'),
	            'desc_tip' => true,
	            'description' => __('Display a Free Shipping badge on all category and product pages', 'woocommerce'),
	        )
	    );

		echo '</div>';

	}

	/**
	 * Save free shipping badge setting
	 *
	 * @since    1.0.0
	 * @param integer $post_id
	 */
	public function woocommerce_product_custom_fields_save( $post_id ) {

	    $free_shipping_badge_checkbox = $_POST['_product_free_shipping_badge'];
	    update_post_meta($post_id, '_product_free_shipping_badge', $free_shipping_badge_checkbox);

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/free-shipping-kit-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/free-shipping-kit-admin.js', array( 'jquery' ), $this->version, false );

	}

}
