<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="main-seach">
<div class="row">
	<div class="col-md-3">
  		sfsdf
  </div>
  <div class="col-md-3">
		<form class="elementor-search-form" role="search"  method="get">
			<div class="elementor-search-form__container">
					<input placeholder="Search..." class="elementor-search-form__input" type="search" name="s" title="Search" value="">
					<button class="elementor-search-form__submit" type="submit">
								<i class="fa fa-search" aria-hidden="true"></i>
						</button>
			</div>
		</form>
	</div>
  <div class="col-md-3">
	<div class="form-group row">
		<label for="" class="col-sm-3 col-form-label">Sắp sếp theo :</label>
		<div class="col-sm-9">
			<form class="woocommerce-ordering" method="get">
				<select name="orderby" class="orderby">
					<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
						<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
					<?php endforeach; ?>
				</select>
				<input type="hidden" name="paged" value="1" />
				<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
			</form>
		</div>
	</div>
	</div>
	<div class="col-md-3">
		<div class="form-group row">
			<label for="" class="col-sm-3 col-form-label">Khoảng giá :</label>
			<div class="col-sm-9">
				<form class="woocommerce-ordering" method="get">
					<select name="orderby" class="orderby">
						<option value="0">Chọn khoảng giá</option>
						<option value="duoi1tr">Dưới 100.000 VND</option>
						<option value="2">Trên  100.000 VND</option>
					</select>
					<input type="hidden" name="paged" value="1" />
				</form>
			</div>
	</div>
</div>
</div>
<?php echo ListSanPham(); ?>