<?php
    add_theme_support( 'menus' );
    register_nav_menus(
        array(
                'main-nav' => 'Menu Đứng'
        )
    );
    add_filter( 'add_to_cart_text', 'woo_custom_product_add_to_cart_text' );            // < 2.1
    add_filter( 'woocommerce_product_add_to_cart_text', 'woo_custom_product_add_to_cart_text' );  // 2.1 +
    
    function woo_custom_product_add_to_cart_text() {
    
        return __( 'Mua ngay', 'woocommerce' );
    
    }
    /*View Cart*/
    function sm_text_view_cart_strings( $translated_text, $text, $domain ) {
        switch ( $translated_text ) {
            case 'View cart' :
                $translated_text = __( 'Xem chi tiết', 'woocommerce' );
                break;
        }
        return $translated_text;
    }
    add_filter( 'gettext', 'sm_text_view_cart_strings', 20, 3 );
    /**
* Change WP Menu Cart "View your shopping cart" text
*/
add_filter('wpmenucart_fulltitle', 'wpmenucart_view_cart_text' );
add_filter('wpmenucart_viewcarttext', 'wpmenucart_view_cart_text' );
function wpmenucart_view_cart_text ( $text ) {
    $text = 'View your shopping bag';
    return $text;
}
    
?>