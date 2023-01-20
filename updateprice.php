<?php
/**
 * Plugin Name: Override Price Before Add to Cart
 * Description: This plugin overrides the price of a specific product with ID 1415 before it's added to the cart.
 * Version: 1.0
 * Author: Your Name
 * License: GPL2
 */

// Check if WooCommerce is active
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    add_action( 'woocommerce_before_calculate_totals', 'override_price_before_add_to_cart' );
    function override_price_before_add_to_cart( $cart ) {
        // Loop through the cart items
        foreach ( $cart->get_cart() as $cart_item ) {
            // Check if the product ID is 1415
            if ( $cart_item['product_id'] == 1415 ) {
                // Get the new price from the API
                $api_url = 'https://sea-turtle-app-wogoo.ondigitalocean.app/price-config';
                $headers = array(
                    'Content-Type' => 'application/json',
                    'Authentication' => 'france1917',
                );
                $response = wp_remote_get( $api_url, array( 'headers' => $headers ) );
                $api_response = json_decode( wp_remote_retrieve_body( $response ), true );
                $new_price = $api_response['price'];

                // Set the price of the product in the cart session
                $cart_item['data']->set_price($new_price);
            }
        }
    }
}
