<?php
namespace App;
$countAllOrders = Controllers\User\Cart::getCartCount();
$items = Controllers\User\Cart::getCart();
?>
<div class="cart">
	<div class="cart_btn">
		<div class="cart_btn_count"><?php echo $countAllOrders; ?></div>
		<i class="fa<?php echo( ($countAllOrders > 0) ? 's' : 'r' ); ?> fa-shopping-cart"></i>
	</div>
	<div class="cart_container hidden">
		<div class="cart_container_header">
			<h2><span class="cart_btn_close"><i class="far fa-times"></i></span> Корзина</h2>
		</div>
		<div class="sb-container cart_container_content">
			<?php 
			$price = 0;
			if ( $countAllOrders > 0 ) {
				foreach ( $items as $item) {
					echo template_render('/widgets/main-block/header-cart-item.php', $item); 
					$price += ($item['cart_item_size']['size_price'] * $item['cart_item_count']);
				}
			}
			?>
		</div>
		<div class="cart_container_footer <?php echo(( $countAllOrders > 0 ) ? '' : 'hidden');?>">
			<h2><span><?php echo $price; ?></span><i class="fas fa-ruble-sign"></i></h2>
			<a href="/order" class="main-btn">Оформить заказ</a>
		</div>
	</div>
</div>