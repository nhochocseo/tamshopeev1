<?php        
    $price = get_post_meta( get_the_ID(), '_regular_price', true) != null ? number_format( get_post_meta( get_the_ID(), '_regular_price', true), $decimals, $decimal_separator, $thousand_separator ) : "";
    $sale = get_post_meta( get_the_ID(), '_sale_price', true);
    $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";;
    $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' );
    ?>

<li class="product-type-simple block-product col-md-3">
    <ul class="woo-entry-inner clr product-inner">
        <li class="image-wrap">
            <div class="woo-entry-image clr canfix">
                <a href="the_permalink()" class="woocommerce-LoopProduct-link no-lightbox">
                    <img src="<?php echo $url ?>" />
                </a>
                <a href="#" id="product_id_<?php echo get_the_ID(); ?>" class="owp-quick-view" data-product_id="<?php echo get_the_ID(); ?>"><i class="icon-eye"></i></a>
            </div>
        </li>
        <li class="title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
        <div class="content-product">
            <li class="inner-price">
                <span class="price">
                    <span class="woocommerce-Price-amount amount"><?php echo $price; ?><span class="woocommerce-Price-currencySymbol">₫</span></span>
                </span>
            </li>
            <li class="btn-wrap clr cart-product">
                <a href="<?php echo $link; ?>/?add-to-cart=<?php echo get_the_ID(); ?>" data-quantity="1" class="product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo get_the_ID(); ?>" data-product_sku="" aria-label="Add “<?php the_title(); ?>” to your cart" rel="nofollow">
                    <span class="elementor-button-icon" data-counter="5"><i class="eicon" aria-hidden="true"></i></span>
                </a>
            </li>
        </div>
    </ul>
</li>
