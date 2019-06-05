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
				echo do_shortcode('[elementor-template id="963"]');
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
					<div class="row">
						<div class="col-md-7">
							<a class="layout1" onclick="layout1_click()">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/img/layout1.png" width="" height="" alt="" />
							</a>
							<a class="layout2" onclick="layout2_click()">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/img/layout2.png" width="" height="" alt="" />
							</a>
						</div>
						<div class="col-md-5">
							<div class="main-cart elementor-element elementor-element-6f9cd7e toggle-icon--cart-medium elementor-menu-cart--items-indicator-bubble elementor-menu-cart--show-divider-yes elementor-menu-cart--show-remove-button-yes elementor-menu-cart--buttons-inline elementor-widget elementor-widget-woocommerce-menu-cart">
								<div class="elementor-widget-container">
									<div class="elementor-menu-cart__wrapper" style="opacity: 1;">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="search-container">
					<!-- <input type="text" placeholder="Search.." name="search" id="searchproduct">
					<button type="submit" class="seach-product"  onclick="select_change_search(document.getElementById('searchproduct').value, '<?php echo $urldata; ?>',1);">Seach</button> -->
					
				<div class="box">
					<div class="container-3">
						<span class="icon"><i class="fa fa-search"></i></span>
						<input type="search" id="searchproduct" placeholder="Search..." />
						<button type="submit" class="seach-product"  onclick="select_change_search(document.getElementById('searchproduct').value, '<?php echo $urldata; ?>',1);">Seach</button>
					</div>
				</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group row">
					<label for="" class="col-sm-4 col-form-label lab-custom">Sắp sếp theo :</label>
					<div class="col-sm-7 custom-select-order">
						<select name="orderby" class="orderby" onchange="select_change_order(this.value, '<?php echo $urldata; ?>',1);">
						<option value="0">Chọn kiểu sắp sếp</option>
							<option value="ASC">Giá thấp đến cao</option>
							<option value="DESC">Giá từ cao xuống thấp</option>
						</select>
					</div>
				</div>
				</div>
				<div class="col-md-3">
					<div class="form-group row">
						<label for="" class="col-sm-4 col-form-label lab-custom">Khoảng giá :</label>
						<div class="col-sm-7 custom-select-order">
							<select name="orderby" class="orderby"  onchange="select_change_price(this.value, '<?php echo $urldata; ?>',1);">
								<option value="0">Chọn khoảng giá</option>
								<option value="0-100000">100.000 VND trở xuống</option>
								<option value="100000-99999999999999999999">100.000 VND trở nên</option>
							</select>
							<input type="hidden" name="paged" value="1" />
						</div>
				</div>
			</div>
		</div>
		<div class="container-product col-md-12 layout1 woocommerce " id="container-product">
			<?php echo ListSanPham(); ?>
		</div>
		<div class="header-tag">
			<span class="title">
				Tìm kiếm nhiều nhất
			</span>
		</div>
		<?php $terms = get_terms(array('taxonomy' => 'product_tag', 'hide_empty' => false)); ?>
			<div class="product-tags">
				<?php foreach ( $terms as $term ) { ?>
					<a href="<?php echo get_term_link( $term->term_id, 'product_tag' ); ?> " rel="tag"><?php echo $term->name; ?></a>
				<?php } ?>
		</div>
	</div>
	</div>
</div>
<?php get_footer(); ?>