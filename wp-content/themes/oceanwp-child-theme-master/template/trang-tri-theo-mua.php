<?php
/*
 Template Name: Trang trí theo mùa
 */
get_header();
?>
<?php get_header(); ?>
<?php
	$urldata =  esc_url( home_url( '/data-trang-tri-theo-mua/' ) );
?>
<div class="container-custom">
	<div class="row">
		<div class="col-md-2">
			<!-- <?php wp_nav_menu( array(
				'theme_location' => 'main-nav', // tên location cần hiển thị
				'container' => 'nav', // thẻ container của menu
				'container_class' => 'main-nav', //class của container
				'menu_class' => 'menu clearfix' // class của menu bên trong
			) ); ?> -->
			<?php echo do_shortcode( '[elementor-template id="919"]' ); ?>
		</div>
		<div class="col-md-10">
			<?php
				echo do_shortcode('[rev_slider alias="home-slide"]');
			?>
		</div>
	</div>
	<div class="row">
	<div class="col-md-2">
		<?php echo do_shortcode( '[elementor-template id="906"]' ); ?>
	</div>
	<div class="col-md-10">
		<div class="header-product">
			<?php echo do_shortcode( '[elementor-template id="916"]' ); ?>
		</div>
		<div class="main-seach">
			<div class="row">
				<div class="col-md-3">	
					<div class="main car elementor-element elementor-element-6f9cd7e toggle-icon--cart-medium elementor-menu-cart--items-indicator-bubble elementor-menu-cart--show-divider-yes elementor-menu-cart--show-remove-button-yes elementor-menu-cart--buttons-inline elementor-widget elementor-widget-woocommerce-menu-cart" data-id="6f9cd7e" data-element_type="widget" data-widget_type="woocommerce-menu-cart.default">
						<div class="elementor-widget-container">
							<div class="elementor-menu-cart__wrapper" style="opacity: 1;">
								<div class="elementor-menu-cart__container elementor-lightbox">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="search-container form-group row">
					<input type="text" placeholder="Search.." name="search" id="searchproduct">
					<button type="submit" class="seach-product"  onclick="select_change_search(document.getElementById('searchproduct').value, '<?php echo $urldata; ?>');">Seach</button>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group row">
					<label for="" class="col-sm-3 col-form-label">Sắp sếp theo :</label>
					<div class="col-sm-9">
						<!-- <form class="woocommerce-ordering" method="POST"> -->
								<select name="orderby" class="orderby" onchange="select_change_order(this.value, '<?php echo $urldata; ?>');">
								<option value="0">Chọn kiểu sắp sếp</option>
									<option value="DESC">Giá thấp đến cao</option>
									<option value="ASC">Giá từ cao xuống thấp</option>
								</select>
						<!-- </form> -->
					</div>
				</div>
				</div>
				<div class="col-md-3">
					<div class="form-group row">
						<label for="" class="col-sm-3 col-form-label">Khoảng giá :</label>
						<div class="col-sm-9">
							<!-- <form class="woocommerce-ordering" method="POST"> -->
								<select name="orderby" class="orderby"  onchange="select_change_price(this.value, '<?php echo $urldata; ?>');">
									<option value="0">Chọn khoảng giá</option>
									<option value="0-1000000">Dưới 100.000 VND</option>
									<option value="1000000-99999999999999999999">Trên  100.000 VND</option>
								</select>
								<input type="hidden" name="paged" value="1" />
							<!-- </form> -->
						</div>
				</div>
			</div>
		</div>
		<div class="container-product col-md-12" id="container-product">
			<?php echo ListSanPham(); ?>
		</div>
	</div>
	</div>
</div>
<?php get_footer(); ?>