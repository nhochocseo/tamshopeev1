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
require_once("functions/function.php");
function oceanwp_child_enqueue_parent_style() {
	// Dynamically get version number of the parent stylesheet (lets browsers re-cache your stylesheet when you update your theme)
	$theme   = wp_get_theme( 'OceanWP' );
	$version = $theme->get( 'Version' );
	// Load the stylesheet
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'oceanwp-style' ), $version );
    wp_enqueue_style( 'child-style-bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.css', array( 'oceanwp-style' ), $version );
    wp_enqueue_style( 'child-style-css', get_stylesheet_directory_uri() . '/css/style.css', array( 'oceanwp-style' ), $version );
<<<<<<< HEAD
    wp_enqueue_style( 'child-style-cssssss', get_stylesheet_directory_uri() . '/css/custom.css', array( 'oceanwp-style' ), $version );

    wp_enqueue_script( 'custom', get_stylesheet_directory_uri() . '/js/custom.js', array ( 'jquery' ), 1.1, true);

=======
    
    wp_enqueue_script( 'custom', get_stylesheet_directory_uri() . '/js/custom.js', array ( 'jquery' ), 1.1, true);
	
>>>>>>> 868a74934b09db7af4146f41dc8467ffc3ad919f
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

function register_woo_price_range() {
    global $wp, $wp_the_query;
        // Find min and max price in current result set
        $prices = get_filtered_price();
        $min    = floor( $prices->min_price );
        $max    = ceil( $prices->max_price );

        if ( $min === $max ) {
            return;
        }
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        $form_action = get_page_base_url();
        //if($min_price || $max_price) {
            $all_price_link = remove_query_arg(array('min_price','max_price'),$form_action);
        //}

        /**
         * Adjust max if the store taxes are not displayed how they are stored.
         * Min is left alone because the product may not be taxable.
         * Kicks in when prices excluding tax are displayed including tax.
         */
        if ( wc_tax_enabled() && 'incl' === get_option( 'woocommerce_tax_display_shop' ) && ! wc_prices_include_tax() ) {
            $tax_classes = array_merge( array( '' ), WC_Tax::get_tax_classes() );
            $class_max   = $max;

            foreach ( $tax_classes as $tax_class ) {
                if ( $tax_rates = WC_Tax::get_rates( $tax_class ) ) {
                    $class_max = $max + WC_Tax::get_tax_total( WC_Tax::calc_exclusive_tax( $max, $tax_rates ) );
                }
            }

            $max = $class_max;
        }
        ?>
        <?php
        echo $args['after_widget'];
}
// add_action( 'init', 'register_woo_price_range' );
function get_filtered_price() {
    global $wpdb, $wp_the_query;

    $args       = $wp_the_query->query_vars;
    $tax_query  = isset( $args['tax_query'] ) ? $args['tax_query'] : array();
    $meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();

    if ( ! empty( $args['taxonomy'] ) && ! empty( $args['term'] ) ) {
        $tax_query[] = array(
            'taxonomy' => $args['taxonomy'],
            'terms'    => array( $args['term'] ),
            'field'    => 'slug',
        );
    }

    foreach ( $meta_query + $tax_query as $key => $query ) {
        if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
            unset( $meta_query[ $key ] );
        }
    }

    $meta_query = new WP_Meta_Query( $meta_query );
    $tax_query  = new WP_Tax_Query( $tax_query );

    $meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
    $tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

    $sql  = "SELECT min( FLOOR( price_meta.meta_value ) ) as min_price, max( CEILING( price_meta.meta_value ) ) as max_price FROM {$wpdb->posts} ";
    $sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
    $sql .= " 	WHERE {$wpdb->posts}.post_type IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_post_type', array( 'product' ) ) ) ) . "')
                AND {$wpdb->posts}.post_status = 'publish'
                AND price_meta.meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
                AND price_meta.meta_value > '' ";
    $sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

    if ( $search = WC_Query::get_main_search_query_sql() ) {
        $sql .= ' AND ' . $search;
    }
    $sql = apply_filters( 'woocommerce_price_filter_sql', $sql, $meta_query_sql, $tax_query_sql );
    return $wpdb->get_row( $sql );
}
function get_page_base_url() {
    $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";;
    return $link;
}

function get_count_post($min_price = '', $max_price = ''){
    echo $min_price;
    if(!$max_price) return false;
    global $wp_the_query;
    $old_query       = $wp_the_query->query_vars;
    $args = array(
        'post_type' => array('product'),
        'post_status'   =>  'publish',
        'posts_per_page'    =>  -1,
        'meta_query' => array(
            array(
                'key' => '_price',
                'value' => array($min_price, $max_price),
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            )
<<<<<<< HEAD
        )        
=======
        )
        // 'meta_query' => array(
        //     'relation' => 'OR',
        //     array(
        //         array(
        //             'key' => '_price',
        //             'value' => 10,
        //             'compare' => '>=',
        //             'type' => 'NUMERIC'
        //         ),
        //         array(
        //             'key' => '_price',
        //             'value' => 15,
        //             'compare' => '<=',
        //             'type' => 'NUMERIC'
        //         )
        //     ),
        //     array(
        //         array(
        //             'key' => '_sale_price',
        //             'value' => 10,
        //             'compare' => '>=',
        //             'type' => 'NUMERIC'
        //         ),
        //         array(
        //             'key' => '_sale_price',
        //             'value' => 15,
        //             'compare' => '<=',
        //             'type' => 'NUMERIC'
        //         )
        //     )
        // )
>>>>>>> 868a74934b09db7af4146f41dc8467ffc3ad919f
    );
    $tax_query  = isset( $old_query['tax_query'] ) ? $old_query['tax_query'] : array();
    if ( version_compare( WC_VERSION, '3.0.0', '>=' ) ) {
        $tax_query[] = array(
            'taxonomy' => 'product_visibility',
            'field' => 'name',
            'terms' => 'exclude-from-catalog',
            'operator' => 'NOT IN',
        );
    } else {
        $args['meta_query'][] = array(
            'key' => '_visibility',
            'value' => array( 'catalog', 'visible' ),
            'compare' => 'IN'
        );
    }
    if(is_tax()){
        if ( ! empty( $old_query['taxonomy'] ) && ! empty( $old_query['term'] ) ) {
            $tax_query[] = array(
                'taxonomy' => $old_query['taxonomy'],
                'terms'    => array( $old_query['term'] ),
                'field'    => 'slug',
            );
        }
    }
    $args['tax_query']  = $tax_query;
    $myposts = get_posts($args);
    return count($myposts);
}
function get_data_post($min_price = '', $max_price = ''){
    if(!$max_price) return false;

    $post_type  = 'product';
    $args  		= array(
        'post_type'        => $post_type,
        'post_status'      => 'publish',
        'posts_per_page'   => 12,
        'paged'          => $paged,
        'meta_query' => array(
            array(
                'key' => '_price',
                'value' => array($min_price, $max_price),
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            )
        )
    );
    $query 		= new WP_Query( $args );
    return $query;
}
function get_data_post_order($order,$paged){
    $post_type  = 'product';
    $args  		= array(
        'post_type'     => 'product',
        'posts_per_page' => -1,
        'order' => $order,
        'orderby' => 'meta_value_num',
        'meta_key' => '_price',
        'meta_query' => array(
            array(
            'key'       => '_price',
            'compare'   => '=',
            'type'      => 'NUMERIC',
            )
        ),
        'posts_per_page'   => 12,
        'paged'          => $paged,
    );
    $query 		= new WP_Query( $args );
    return $query;

}
function get_seach_data_post($key,$paged){
    $post_type  = 'product';
        $args  		= array(
            's'                => $key,
            'post_type'        => $post_type,
            'post_status'      => 'publish',
            'posts_per_page'   => 12,
            'paged'          => $paged,
        );
		$query 		= new WP_Query( $args );
		$output 	= '';

		// Icons
		if ( is_RTL() ) {
			$icon = 'left';
		} else {
			$icon = 'right';
		}

		if ( $query->have_posts() ) {

<<<<<<< HEAD
			$output .= '<div class="main-product">';
=======
			$output .= '<div class="main-product">';			
>>>>>>> 868a74934b09db7af4146f41dc8467ffc3ad919f
				while( $query->have_posts() ) : $query->the_post();
                $output .=  get_template_part( 'part/wc', 'single' );
				endwhile;
            $output .= '</div>';
<<<<<<< HEAD

		} else {
			$output .= get_template_part( 'part/wc', 'datanull' );
=======
		
		} else {			
			$output .= get_template_part( 'part/wc', 'datanull' );			
>>>>>>> 868a74934b09db7af4146f41dc8467ffc3ad919f
        }
        pagination_bar($query,$paged,'seach',$key);
		wp_reset_query();
        echo $output;
		die();
}
function get_all_data_postv1($paged){
    $post_type  = 'product';
    $args  		= array(
        'post_type'        => $post_type,
        'post_status'      => 'publish',
        'posts_per_page'   => 12,
        'orderby' => 'date',
        'order' => 'desc',
        'paged'          => $paged,
    );
    $query 		= new WP_Query( $args );
    return $query;
}
function ListSanPham() {
    global $wp_query;
    global $post; // Call global $post variable
    global $woocommerce;
    $currency = get_woocommerce_currency_symbol();
    $min_price = isset( $_POST['min_price'] ) ? esc_attr( $_POST['min_price'] ) : '';
    $max_price = isset( $_POST['max_price'] ) ? esc_attr( $_POST['max_price'] ) : '';
    $orderby = isset( $_POST['orderby'] ) ? esc_attr( $_POST['orderby'] ) : '';
    $keyseach = isset( $_POST['keyseach'] ) ? esc_attr( $_POST['keyseach'] ) : '';
    $paged = isset( $_POST['paged'] ) ? esc_attr( $_POST['paged'] ) : 1;
    register_woo_price_range();
    $type = 'price';
    $datakey = $min_price + '-' + $max_price;
    $data = get_data_post($min_price,$max_price);
    if(!$min_price || !$max_price) {
        $type = 'all';
        $data = get_all_data_postv1($paged);
    }
    if($orderby) {
        $type = 'order';
        $datakey = $orderby;
        $data = get_data_post_order($orderby,$paged);
    }
    if($keyseach) {
        $type = 'seach';
        $datakey = $keyseach;
        $data = get_seach_data_post($keyseach,$paged);
    }
    if(!$data) {
        get_template_part( 'part/wc', 'datanull' );
    }
<<<<<<< HEAD

    if ( $data->have_posts() ) {

        echo '<ul class="main-product products oceanwp-row clr">';
            while( $data->have_posts() ) : $data->the_post();
                get_template_part( 'part/wc', 'single' );
            endwhile;
        echo '</ul>';
        pagination_bar($data,$paged,$type,$datakey);
        wp_reset_query();
    } else {
        get_template_part( 'part/wc', 'datanull' );
=======
    
    if ( $data->have_posts() ) {

        echo '<div class="main-product">';			
            while( $data->have_posts() ) : $data->the_post();
                get_template_part( 'part/wc', 'single' );
            endwhile;
        echo '</div>';
        pagination_bar($data,$paged,$type,$datakey);
        wp_reset_query();
    } else {			
        get_template_part( 'part/wc', 'datanull' );			
>>>>>>> 868a74934b09db7af4146f41dc8467ffc3ad919f
    }
}

    function pagination_bar( $custom_query,$paged,$type,$datakey ) {
        $urldata =  esc_url( home_url( '/data-trang-tri-theo-mua' ) );
        $total_pages = $custom_query->max_num_pages;
        $big = 999999999; // need an unlikely integer
        if($total_pages > 1) {
            $current_page = max(1, get_query_var('paged'));
            echo "<div class='paging'>";
            for ($i=1; $i <= $total_pages; $i++) {
            ?>
                <?php if($type == 'all') { ?>
                    <a class="btn <?php if($i == 1) { echo 'active';} ?>" id="page-<?php echo $i ?>" onclick="load_all_data('<?php echo $urldata; ?>',<?php echo $i ?>);"><?php echo $i ?></a>
                <?php } ?>
                <?php if($type == 'order') { ?>
                    <a class="btn <?php if($i == 1) { echo 'active';} ?>" id="page-<?php echo $i ?>" onclick="select_change_order('<?php echo $datakey; ?>','<?php echo $urldata; ?>',<?php echo $i ?>);"><?php echo $i ?></a>
                <?php } ?>
                <?php if($type == 'seach') { ?>
                    <a class="btn <?php if($i == 1) { echo 'active';} ?>" id="page-<?php echo $i ?>" onclick="select_change_search('<?php echo $datakey; ?>','<?php echo $urldata; ?>',<?php echo $i ?>);"><?php echo $i ?></a>
                <?php } ?>
                <?php if($type == 'price') { ?>
                    <a class="btn <?php if($i == 1) { echo 'active';} ?>" id="page-<?php echo $i ?>" onclick="select_change_price('<?php echo $datakey; ?>','<?php echo $urldata; ?>',<?php echo $i ?>);"><?php echo $i ?></a>
                <?php } ?>
            <?php }
            echo "</div>";
        }
    }

    function CountProduct() {
<<<<<<< HEAD

=======
        
>>>>>>> 868a74934b09db7af4146f41dc8467ffc3ad919f
    }
    ?>
