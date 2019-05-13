<?php
/*
 Template Name: Trang trí theo mùa
 */
get_header();
?>
<?php get_header(); ?>
<?php $urldata =  esc_url( home_url( '/data-trang-tri-theo-mua/' ) ); ?>
<div class="main-seach">
<div class="row">
	<div class="col-md-3">
  		sfsdf
  </div>
  <div class="col-md-3">
    <div class="search-container">
        <input type="text" placeholder="Search.." name="search">
        <button type="submit" class="seach-product"  onchange="select_change_seach(this.value, '<?php echo $urldata; ?>');">Seach</button>
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

<div class="container-product" id="container-product">
    <?php echo ListSanPham(); ?>
</div>
<?php get_footer(); ?>