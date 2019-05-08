<?php
/**
 * Child theme functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Text Domain: oceanwp
 * @link http://codex.wordpress.org/Plugin_API
 *
 */

/**
 * Load the parent style.css file
 *
 * @link http://codex.wordpress.org/Child_Themes
 */
function oceanwp_child_enqueue_parent_style() {
	// Dynamically get version number of the parent stylesheet (lets browsers re-cache your stylesheet when you update your theme)
	$theme   = wp_get_theme( 'OceanWP' );
	$version = $theme->get( 'Version' );
	// Load the stylesheet
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'oceanwp-style' ), $version );
	wp_enqueue_style( 'child-style-bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.css', array( 'oceanwp-style' ), $version );
	
}
add_action( 'wp_enqueue_scripts', 'oceanwp_child_enqueue_parent_style' );


// Ngan auto update
define( 'AUTOMATIC_UPDATER_DISABLED', true );

//chinh font Editor
add_editor_style('css/custom-editor.css');

add_filter('woocommerce_catalog_orderby', 'wc_customize_product_sorting');

function wc_customize_product_sorting($sorting_options){
    $sorting_options = array(
        'menu_order' => __( 'Chọn sắp sếp', 'woocommerce' ),
        'popularity' => __( 'Sắp sếp theo mức độ phổ biến', 'woocommerce' ),
        'rating'     => __( 'Sắp sếp theo thứ hạng trung bình', 'woocommerce' ),
        'date'       => __( 'Sắp sếp theo mới nhất', 'woocommerce' ),
        'price'      => __( 'Sắp sếp theo giá: thấp -> cao', 'woocommerce' ),
        'price-desc' => __( 'Sắp sếp theo giá: cao -> thấp', 'woocommerce' ),
    );

    return $sorting_options;
}

