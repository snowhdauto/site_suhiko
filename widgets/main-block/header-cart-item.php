<?php 
$deleted = array();
foreach( array_column($item_deleted, 'ingredient_id') as $id ) {
	array_push($deleted, (int)$id);
}
$item = htmlspecialchars(json_encode(array(
	'item_id' => $item_id,
	'size_id' => $cart_item_size['size_id'],
	'dough' => $cart_item_dough,
	'deleted' => $deleted
)));
?>
<div class="cart_item" data-item="<?php echo $item; ?>">
	<div class="ci_temp">
		<img src="<?php echo $item_image; ?>" alt="<?php echo $item_name; ?>">
		<div>
			<h2 class="cart_item_title"><?php echo $item_name; ?></h2>
			<div class="cart_item_info">
				<?php
					$doughSTR = '';
					if ( strlen($cart_item_dough) > 0 && $item_category['category_value'] == 'pizza' ) {
						if ( $cart_item_dough == 'standart' ) { $doughSTR =  'Стандартное тесто,'; }
						elseif ( $cart_item_dough == 'slim' ) { $doughSTR =  'Тонкое тесто,'; }
					}
				?>
				<p><?php echo($doughSTR); ?> <?php echo( ($doughSTR == '') ? 'Р' : 'р' ); ?>азмер <?php echo($cart_item_size['size_value'] . ' ' . $item_category['category_unit']); ?></p>
				<p>
					<?php 
						if ( isset($item_deleted) ) {
							foreach ($item_deleted as $item) {
								echo('<span class="deleted">' . $item['ingredient_name'] . '</span>');
							}
						}
					?>
				</p>
			</div>
		</div>
		<div style="flex: 1; text-align: right; min-width: 200px;">
			<div style="display: inline-block; text-align: right;">
				<h2 class="cart_item_price"><span><?php echo($cart_item_size['size_price'] * $cart_item_count); ?></span><i class="fas fa-ruble-sign"></i></h2>
				<div class="cart_item_count">
					<a class="main-btn" data-cartitem-change="-1" style="padding: 10px 19px;">-</a> 
					<span><?php echo $cart_item_count; ?></span> 
					<a class="main-btn" data-cartitem-change="1" style="padding: 10px 19px;">+</a>
				</div>
			</div>
		</div>
	</div>
</div>