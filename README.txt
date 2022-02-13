=== Free Shipping Kit ===
Contributors: mcarter76
Donate link: https://www.kahoycrafts.com/wordpress-plugin-donation/
Tags: free shipping badge, woocommerce free shipping, free shipping, flat rate shipping, per product free shipping, product based free shipping, e-commerce
Requires at least: 5.6
Tested up to: 5.9
Requires PHP: 7.0
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display a per product FREE Shipping badge on WooCommerce product category and detail pages.

== Description ==

This plugin was designed to address the inability of similar free shipping plugins, to assign a free shipping badge at the product level. 

There are several existing options for assigning free shipping based on the cart subtotal, but I wanted a convenient way to integrate a free shipping badge with a simple flat-rate based free shipping class. This is similar to the free shipping options available in marketplaces like Etsy where the shipping costs are factored into the price of the item. This also works well for lightweight items, where the shipping cost is less significant.

This plugin allows a user to do the following:

- Configure a "Free Shipping" badge for display in WooCommerce product category and detail pages
- Optionally hide other "paid" shipping methods in cart or checkout pages whenever free shipping is available
- Adjust text shown for a flat-rate based "Free Shipping" method in cart or checkout pages

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `free-shipping-kit.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to the settings page: WooCommerce > Settings > Shipping > Free Shipping Kit
1. Configure the free shipping badge and all optional settings
1. Navigate to the "Shipping" tab of any product and enable the "Free Shipping badge"
1. Be sure to configure a "Free shipping" class and shipping zones
1. Assign the newly created "Free shipping" class to all intended products
1. **The base shipping cost must be zero as well as the shipping class cost for free shipping to function correctly

== Frequently Asked Questions ==

= Can the styles for the FREE shipping badge be overridden =

Yes, please feel free (pun intended?) to override the .free-shipping class in a custom stylesheet or via the "Additional CSS" section of the appearance editor.

= What if my cart contains products that have both free and non-free shipping =

The shipping cost will be greater than zero and the "Free shipping" label is not displayed.

= What about the freeshippingkit_files directory =

This folder is used for caching dynamic stylesheets and is removed during deactivation.

== Screenshots ==

1. Main Settings in WooCommerce.
2. Main Settings (Cart Configuration) in WooCommerce.
3. Product Settings.
4. Example Flat Rate Settings.

== Changelog ==

= 1.0.1 - 2022-01-13 =
* Add correct text domain and spanish translations
* Improve template logic for admin screen

= 1.0.0 - 2021-12-30 =
* First release!
