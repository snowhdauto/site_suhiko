<?php namespace App; ?>
<div class="menu_item" data-item-id="<?php echo $item->item_id; ?>">
	<div class="menu_item_content">
		
		<?php if ( strlen($item->item_prefix) > 0 ): ?>
		<div class="menu_item_prefix">
			<span><? echo $item->item_prefix; ?></span>
		</div>
		<?php endif; ?>
		<img src="<?php echo $item->item_image; ?>" alt="<?php echo $item->item_name; ?>">
		<div class="menu_item_title">
			<h3><?php echo $item->item_name; ?></h3>
			<span class="main-btn menu_item_info"><i class="fas fa-info"></i></span>
		</div>
		<p class="menu_item_ingredients">
			<?php 
			if ( $item->item_category->category_value != 'pizza' ) { 
				echo $item->item_description; 
			} 
			else {
				if ( count($item->item_ingredients) > 0 ) {
					$echoIngr = '';
					$tempIngr = true;
					foreach ( $item->item_ingredients as $ingredient ) {

						$ingrName = $ingredient->ingredient_name;
						if ( $tempIngr ) { $ingrName = ucfirst($ingredient->ingredient_name); $tempIngr = false; }
						if ( $ingredient->ingredient_removeble ) {
							$echoIngr .= '<span class="changing" data-ingredient-id="' . $ingredient->ingredient_id . '">' . $ingrName . '</span>, ';
						}
						else {
							$echoIngr .= '<span>' . $ingrName . '</span>, ';
						}
					}
					echo substr($echoIngr, 0, -2) . '.';
				}
			}
			?>
		</p>
		<?php if ( count($item->item_sizes) > 0 ): ?>
		<div class="menu_item_sizes <?php echo((count($item->item_sizes) == 1) ? 'hidden' : '');?>">
			<h4>Размер</h4>
			<div>
				<?php 
					$temp = false;
					foreach ( $item->item_sizes as $size ) {
						if ( !$temp ) { 
							echo '<span class="active" data-size="' . $size->size_id . '" data-price="' . $size->size_price . '" title="Размер ' . $size->size_value . ' ' . $item->item_category->category_unit . '">' . $size->size_value . '</span>';
							$temp = true; 
						}
						else {
							echo '<span data-size="' . $size->size_id . '" data-price="' . $size->size_price . '" title="Размер ' . $size->size_value . ' ' . $item->item_category->category_unit . '">' . $size->size_value . '</span>';
						}
					}
				?>
			</div>
		</div>
		<?php endif; ?>
		<?php if ( strlen($item->item_dough) > 0 && $item->item_category->category_value == 'pizza' ): ?>
		<div class="menu_item_doughs">
			<h4>Тесто</h4>
			<div>
				<?php 
					if ( $item->item_dough == 'all' ) { echo '<span class="active" data-value="standart" title="Стандартное тесто">Стандартное</span><span data-value="slim" title="Тонкое тесто">Тонкое</span>'; }
					elseif ( $item->item_dough == 'standart' ) { echo '<span class="active" data-value="standart" title="Стандартное тесто">Стандартное</span>'; }
					elseif ( $item->item_dough == 'slim' ) { echo '<span data-value="slim" class="active" title="Тонкое тесто">Тонкое</span>'; }
				?>
			</div>
		</div>
		<?php endif; ?>
		<div class="menu_item_footer">
			<h2 class="menu_item_price"><span><?php echo $item->item_sizes[0]->size_price; ?></span><i class="fas fa-ruble-sign"></i></h2>
			<?php
			$dough = '';
			if ( strlen($item->item_dough) > 0 && $item->item_category->category_value == 'pizza' ) {
				if ( $item->item_dough == 'all' ||  $item->item_dough == 'standart' ) { $dough = 'standart'; }
				elseif ( $item->item_dough == 'slim' ) { $dough = 'slim'; }
			}
			$itemCartCount = Controllers\User\Cart::checkCartItem(array(
				'item_id' => $item->item_id,
				'size_id' => $item->item_sizes[0]->size_id,
				'deleted' => array(),
				'dough' => $dough,
			));
			if ( $itemCartCount != false && $itemCartCount > 0 ):
			?>
			<div class="menu_item_count"><a class="main-btn" style="padding: 10px 19px;" data-menuitem-change="-1">-</a> <span><?php echo $itemCartCount; ?></span> <a class="main-btn" style="padding: 10px 19px;" data-menuitem-change="1">+</a></div>
			<?php else: ?>
			<a class="main-btn" data-menuitem-add style="padding: 10px 19px;">Добавить</a> 
			<?php endif; ?>
		</div>
	</div>

	<div class="menu_item_description hidden">
		<span class="menu_item_description_close"><i class="far fa-times"></i></span>
		<h3><?php echo $item->item_name; ?></h3>
		<p><?php echo $item->item_description; ?></p>
	</div>
</div>
