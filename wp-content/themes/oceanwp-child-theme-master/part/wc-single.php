<?php        
    $price = get_post_meta( get_the_ID(), '_regular_price', true);
    $sale = get_post_meta( get_the_ID(), '_sale_price', true);
    ?>

<li class="product-type-simple">
    <ul class="woo-entry-inner clr ahihi">
        <li class="image-wrap alulu">
            <div class="woo-entry-image clr canfix">
                <a href="http://localhost:8080/tamshopeev1/product/san-pham-1-copy-3/" class="woocommerce-LoopProduct-link no-lightbox">
                    <img width="355" height="351" src="http://localhost:8080/tamshopeev1/wp-content/uploads/2019/04/website-tam-trang-chu-355x351.png" class="woo-entry-image-main" alt="sản phẩm 1 (Copy)" itemprop="image" srcset="http://localhost:8080/tamshopeev1/wp-content/uploads/2019/04/website-tam-trang-chu-355x351.png 355w, http://localhost:8080/tamshopeev1/wp-content/uploads/2019/04/website-tam-trang-chu-100x100.png 100w" sizes="(max-width: 355px) 100vw, 355px">
                </a>
                <a href="#" id="product_id_413" class="owp-quick-view" data-product_id="413"><i class="icon-eye"></i></a>
            </div><!-- .woo-entry-image -->
        </li>
        <li class="title">
            <a href="http://localhost:8080/tamshopeev1/product/san-pham-1-copy-3/"><?php the_title(); ?></a>
        </li>
        <li class="inner">
            <span class="price"><span class="woocommerce-Price-amount amount"><?php echo $price; ?><span class="woocommerce-Price-currencySymbol">₫</span></span></span>
        </li>
        <li class="btn-wrap clr">
            <a href="/tamshopeev1/trang-tri-theo-mua/?min_price=90000&amp;max_price=100000&amp;add-to-cart=413" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="413" data-product_sku="" aria-label="Add “sản phẩm 1 (Copy)” to your cart" rel="nofollow">Add to cart</a>
        </li>
    </ul>
</li>