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

function register_woo_price_range() {
    global $wp, $wp_the_query;

        // if ( ! is_post_type_archive( 'product' ) && ! is_tax( get_object_taxonomies( 'product' ) ) ) {
        //     return;
        // }


        $min_price = isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : '';
        $max_price = isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : '';
        echo $min_price;
        echo $max_price;
        // Find min and max price in current result set
        $prices = get_filtered_price();
        $min    = floor( $prices->min_price );
        $max    = ceil( $prices->max_price );

        if ( $min === $max ) {
            return;
        }

        echo $args['before_widget'];
        $widgetID = 'widget_'.$args['widget_id'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        $form_action = get_page_base_url();

        /*if ( '' === get_option( 'permalink_structure' ) ) {
            $all_price_link = remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
        } else {
            $all_price_link = preg_replace( '%\/page/[0-9]+%', '', home_url( trailingslashit( $wp->request ) ) );
        }*/

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
        <ul>
            <li><a href="<?php echo  esc_url($all_price_link);?>"><?php _e('All price','devvn-pricefilter');?></a></li>
            <?php
            $diff = $min;
            $range = !empty( $instance['range'] ) ? intval($instance['range']) : 20000;
            while($diff < $max):
                $diff2 = $diff + $range - 1;
                if($diff2 >= $max) $diff2 = $max;
                $form_action = add_query_arg(
                    array(
                        'min_price' => $diff,
                        'max_price' => $diff2
                    ),
                    $form_action
                );
                $count_post = get_count_post($diff,$diff2);
                echo "count post : ";
                echo $count_post;
                ?>
                <li class="wc-layered-nav-term <?php if($min_price == $diff && $max_price == $diff2):?>active<?php endif;?>">
                    <a href="<?php echo esc_url($form_action);?>"><?php echo devvn_price($diff) . ' - ' . devvn_price($diff2);?></a><span class="count">(<?php echo $count_post;?>)</span>
                </li>
                <?php
                $diff = $diff + $range;
            endwhile;?>
        </ul>
        <?php
        var_dump($args);
        echo $args['after_widget'];
}
add_action( 'init', 'register_woo_price_range' );
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
    print_r($wpdb->get_row( $sql ));
    return $wpdb->get_row( $sql );
}
function get_page_base_url() {
    if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
        $link = home_url();
    } elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) ) {
        $link = get_post_type_archive_link( 'product' );
    } elseif ( is_product_category() ) {
        $link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
    } elseif ( is_product_tag() ) {
        $link = get_term_link( get_query_var( 'product_tag' ), 'product_tag' );
    } else {
        $queried_object = get_queried_object();
        $link = get_term_link( $queried_object->slug, $queried_object->taxonomy );
    }

    // Min/Max
    if ( isset( $_GET['min_price'] ) ) {
        $link = add_query_arg( 'min_price', wc_clean( $_GET['min_price'] ), $link );
    }

    if ( isset( $_GET['max_price'] ) ) {
        $link = add_query_arg( 'max_price', wc_clean( $_GET['max_price'] ), $link );
    }

    // Orderby
    if ( isset( $_GET['orderby'] ) ) {
        $link = add_query_arg( 'orderby', wc_clean( $_GET['orderby'] ), $link );
    }

    /**
     * Search Arg.
     * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
     */
    if ( get_search_query() ) {
        $link = add_query_arg( 's', rawurlencode( htmlspecialchars_decode( get_search_query() ) ), $link );
    }

    // Post Type Arg
    if ( isset( $_GET['post_type'] ) ) {
        $link = add_query_arg( 'post_type', wc_clean( $_GET['post_type'] ), $link );
    }

    // Min Rating Arg
    if ( isset( $_GET['rating_filter'] ) ) {
        $link = add_query_arg( 'rating_filter', wc_clean( $_GET['rating_filter'] ), $link );
    }

    // All current filters
    if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) {
        foreach ( $_chosen_attributes as $name => $data ) {
            $filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );
            if ( ! empty( $data['terms'] ) ) {
                $link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
            }
            if ( 'or' == $data['query_type'] ) {
                $link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
            }
        }
    }

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
        )
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
function devvn_price($price, $args = array()){
    extract( apply_filters( 'wc_price_args', wp_parse_args( $args, array(
        'ex_tax_label'       => false,
        'currency'           => '',
        'decimal_separator'  => wc_get_price_decimal_separator(),
        'thousand_separator' => wc_get_price_thousand_separator(),
        'decimals'           => wc_get_price_decimals(),
        'price_format'       => get_woocommerce_price_format(),
    ) ) ) );

    $negative        = $price < 0;
    $price           = apply_filters( 'raw_woocommerce_price', floatval( $negative ? $price * -1 : $price ) );
    $price           = apply_filters( 'formatted_woocommerce_price', number_format( $price, $decimals, $decimal_separator, $thousand_separator ), $price, $decimals, $decimal_separator, $thousand_separator );

    if ( apply_filters( 'woocommerce_price_trim_zeros', false ) && $decimals > 0 ) {
        $price = wc_trim_zeros( $price );
    }

    $formatted_price = ( $negative ? '-' : '' ) . sprintf( $price_format, '<span class="woocommerce-Price-currencySymbol">' . get_woocommerce_currency_symbol( $currency ) . '</span>', $price );
    $return          = '<span class="woocommerce-Price-amount amount">' . $formatted_price . '</span>';

    if ( $ex_tax_label && wc_tax_enabled() ) {
        $return .= ' <small class="woocommerce-Price-taxLabel tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
    }

    return apply_filters( 'devvn_price', $return, $price, $args );
}
