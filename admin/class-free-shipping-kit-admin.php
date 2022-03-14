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

		$sections['fskit'] = __( 'Free Shipping Kit', 'free-shipping-kit' );
		return $sections;
		
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
			'name'   => __( 'Free Shipping Kit Settings', 'free-shipping-kit' ), 
			'type'   => 'title', 
			'desc'   => __( 'The following options are used to configure the free shipping badge and all optional settings', 'free-shipping-kit' ), 
			'id'     => 'fskit' 
		);
		$settings[] = array(
			'name'   => __( 'Text color', 'free-shipping-kit' ),
			'id'     => 'fskit_txt_color',
			'type'   => 'color',
			'css'    => 'max-width:100px;',
		);
		$settings[] = array(
			'name'   => __( 'Background color', 'free-shipping-kit' ),
			'id'     => 'fskit_bg_color',
			'type'   => 'color',
			'css'    => 'max-width:100px;',
		);
		$settings[] = array(
			'name'   => __( 'Shipping Methods', 'free-shipping-kit' ),
			'id'     => 'fskit_hide_tablerate_shipping',
			'type'   => 'checkbox',
			'desc'   => __( 'Hide paid shipping methods when item has free shipping', 'free-shipping-kit' ),
		);
		$settings[] = array(
			'name'   => __( 'Custom Label', 'free-shipping-kit' ),
			'id'     => 'fskit_show_custom_label',
			'type'   => 'checkbox',
			'desc'   => __( 'Show custom "FREE shipping" label in cart', 'free-shipping-kit' ),
		);
		$settings[] = array(
			'name'   => __( 'Free Shipping Label', 'free-shipping-kit' ),
			'id'     => 'fskit_freeshipping_label',
			'type'   => 'text',
			'desc'   => __( 'Label text shown for free shipping method', 'free-shipping-kit' ),
		);
		
		$settings[] = array( 'type' => 'sectionend', 'id' => 'fskit' );

		return $settings;

	}

	/**
	 * Add settings link to plugins page
	 *
	 * @since    1.0.0
	 * @param array $links
	 * @return array 	Links
	 */
	public function fskit_settings_link( $links ) {

		$link = '<a href="' .
			admin_url( 'admin.php?page=wc-settings&tab=shipping&section=fskit' ) .
			'">' . __('Settings') . '</a>';

		array_unshift($links, $link);

		return $links;

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
	            'label' => __('Free Shipping badge', 'free-shipping-kit'),
	            'desc_tip' => true,
	            'description' => __('Display a Free Shipping badge on all category and product pages', 'free-shipping-kit'),
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

	    if ( isset( $_POST['_product_free_shipping_badge'] ) ) {
	    	update_post_meta( $post_id, '_product_free_shipping_badge', sanitize_key( $_POST['_product_free_shipping_badge'] ) );
		}

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/free-shipping-kit-admin.js', array( 'wp-i18n', 'jquery' ), $this->version, false );

		wp_set_script_translations( $this->plugin_name, 'free-shipping-kit', plugin_dir_path( __DIR__ ) . 'languages/' );

	}

}
