<?php        
    $price = get_post_meta( get_the_ID(), '_regular_price', true) != null ? number_format( get_post_meta( get_the_ID(), '_regular_price', true), $decimals, $decimal_separator, $thousand_separator ) : "";
    $sale = get_post_meta( get_the_ID(), '_sale_price', true);
    $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";;
    ?>

<li class="product-type-simple">
    <ul class="woo-entry-inner clr ahihi">
        <li class="image-wrap alulu">
            <div class="woo-entry-image clr canfix">
                <a href="the_permalink()" class="woocommerce-LoopProduct-link no-lightbox">
                    <img width="355" height="351" src="http://localhost:8080/tamshopeev1/wp-content/uploads/2019/04/website-tam-trang-chu-355x351.png" class="woo-entry-image-main" alt="sản phẩm 1 (Copy)" itemprop="image" srcset="http://localhost:8080/tamshopeev1/wp-content/uploads/2019/04/website-tam-trang-chu-355x351.png 355w, http://localhost:8080/tamshopeev1/wp-content/uploads/2019/04/website-tam-trang-chu-100x100.png 100w" sizes="(max-width: 355px) 100vw, 355px">
                </a>
                <a href="#" id="product_id_413" class="owp-quick-view" data-product_id="413"><i class="icon-eye"></i></a>
            </div><!-- .woo-entry-image -->
        </li>
        <li class="title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
        <li class="inner">
            <span class="price"><span class="woocommerce-Price-amount amount"><?php echo $price; ?><span class="woocommerce-Price-currencySymbol">₫</span></span></span>
        </li>
        <li class="btn-wrap clr">
            <a href="<?php echo $link; ?>/?add-to-cart=<?php echo get_the_ID(); ?>" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo get_the_ID(); ?>" data-product_sku="" aria-label="Add “<?php the_title(); ?>” to your cart" rel="nofollow">Add to cart</a>
        </li>
    </ul>
</li>