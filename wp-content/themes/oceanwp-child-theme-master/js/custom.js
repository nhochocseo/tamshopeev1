function select_change_order(parent, url, page) {
    var ajaxurl = url;
    var data = {
        'action': 'POST',
        'paged': page,
        'orderby': parent
    };

    jQuery.post(ajaxurl, data, function(response) {
        document.getElementById("container-product").innerHTML = response;
        var pageid = '#page-' + page;
        jQuery('.paging .btn').removeClass("active");
        jQuery(pageid).addClass("active");
    });
};

function load_all_data(url, page) {
    var ajaxurl = url;
    var data = {
        'action': 'POST',
        'paged': page,
    };
    jQuery.post(ajaxurl, data, function(response) {
        document.getElementById("container-product").innerHTML = response;
        if (!page) {
            page = 1;
        }
        var pageid = '#page-' + page;
        jQuery('.paging .btn').removeClass("active");
        jQuery(pageid).addClass("active");
    });
};

function select_change_price(parent, url, page) {
    var ajaxurl = url;
    var data = parent.split('-');
    var min_price = data[data.length - data.length];
    var max_price = data[data.length - 1];
    var data = {
        'action': 'POST',
        'paged': page,
        'min_price': min_price,
        'max_price': max_price
    };
    jQuery.post(ajaxurl, data, function(response) {
        document.getElementById("container-product").innerHTML = response;
        var pageid = '#page-' + page;
        jQuery('.paging .btn').removeClass("active");
        jQuery(pageid).addClass("active");
    });

};

function select_change_search(parent, url, page) {
    var ajaxurl = url;
    var data = {
        'action': 'POST',
        'paged': page,
        'keyseach': parent,
    };
    jQuery.post(ajaxurl, data, function(response) {
        document.getElementById("container-product").innerHTML = response;

        var pageid = '#page-' + page;
        jQuery('.paging .btn').removeClass("active");
        jQuery(pageid).addClass("active");
    });
};

function layout1_click() {
    jQuery('#container-product').addClass('layout1');
    jQuery('#container-product').removeClass('layout2');
};

function layout2_click() {
    jQuery('#container-product').addClass('layout2');
    jQuery('#container-product').removeClass('layout1');
};
jQuery(document).ready(function() {
    jQuery('.main-cart a').attr("href", "http://tamnguyenshop.vn/cart-page/");
    jQuery('.main-cart a').addClass("none");
});
jQuery("#tabsanphammoi .elementor-heading-title").on('click', function(event) {
    load_all_data('https://tamnguyenshop.vn/data-trang-tri-theo-mua', 1);
});