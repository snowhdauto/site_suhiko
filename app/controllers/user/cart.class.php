<?php

namespace App\Controllers\User;

class Cart {
	public static function getCart() {
		$DB = new \App\Core\DB;
		if ( isset($_COOKIE['cart']) ) {
			$cartItems = json_decode($_COOKIE['cart']);
			# $itemsIDWhere = array();
			# foreach ( $cartItems as $item ) {
			# 	array_push($itemsIDWhere, 'item_id = ' . $item->item_id);
			# }
			# $itemsInfo = $DB->get('items', ['*'], 'item_deleted = 0 AND ('.implode(' OR ', $itemsIDWhere).')'); 
			$itemsInfo = $DB->get('items', ['*'], 'item_deleted = 0'); 
			if ( !$itemsInfo ) { return array(); } 

			$catList = array(); $catArr = array();
			for ( $i = 0; $i < count($itemsInfo); $i++ ) {
				if ( $catList !== false ) {
					$catIndex = array_search($itemsInfo[$i]['item_category_id'], array_column($catList, 'category_id'));
					if ( $catIndex !== false ) { $itemsInfo[$i]['item_category'] = $catList[$catIndex]; }
					else { 
						$tempCat = (array)Category::getCategoryByID($itemsInfo[$i]['item_category_id']); 
						array_push($catList, $tempCat); 
						$itemsInfo[$i]['item_category'] = $tempCat; 
					}
				}
				else { $itemsInfo[$i]['item_category'] = $catArr; }
				unset($itemsInfo[$i]['item_category_id']);

				$sizeList = array();
				$itemsInfo[$i]['item_sizes'] = array();

				for ( $j = 1; $j <= 4; $j++ ) {
					if ( !($itemsInfo[$i]['item_size' . $j . '_id'] == 0 || $itemsInfo[$i]['item_size' . $j . '_id'] == NULL) ) {
						$sizeIndex = array_search($itemsInfo[$i]['item_size' . $j . '_id'], array_column($sizeList, 'size_id'));
						if ( $sizeIndex !== false ) { array_push($itemsInfo[$i]['item_sizes'], $sizeList[$sizeIndex]); } 
						else {
							$tempSizeInfo = array(
								'size_id' => $itemsInfo[$i]['item_size' . $j . '_id'],
								'size_price' => $itemsInfo[$i]['item_size' . $j . '_cost'],
								'size_value' => $DB->get('sizes', ['size_value'], 'size_id = ' . $itemsInfo[$i]['item_size' . $j . '_id'])[0]['size_value']
							);
							array_push($sizeList, $tempSizeInfo); array_push($itemsInfo[$i]['item_sizes'], $tempSizeInfo);
						}
					}
					unset($itemsInfo[$i]['item_size' . $j . '_id']); unset($itemsInfo[$i]['item_size' . $j . '_cost']);
				}
			}
			
			$itemIngrDeletedIDs = array();
			for ( $i = 0; $i < count($cartItems); $i++ ) {
				$itemIngrDeletedIDs = array_merge($itemIngrDeletedIDs, $cartItems[$i]->deleted);
			}
			$itemIngrDeletedIDs = array_unique($itemIngrDeletedIDs);
			for ( $i = 0; $i < count($itemIngrDeletedIDs); $i++ ) {
				$itemIngrDeletedIDs[$i] = 'ingr_id = ' . $itemIngrDeletedIDs[$i];
			}
			$itemIngrDeletedArr = $DB->get('ingredients', ['ingr_id AS ingredient_id', 'ingr_name AS ingredient_name'], implode(' OR ', $itemIngrDeletedIDs));
			
			$cartItemsInfo = array();

			for ( $i = 0; $i < count($cartItems); $i++ ) {
				$tempItem = array();
				$itemIndex = array_search($cartItems[$i]->item_id, array_column($itemsInfo, 'item_id'));
				if( $itemIndex !== false ) {
					$tempItem = $itemsInfo[$itemIndex];

					if ( $cartItems[$i]->dough == '' ) {
						$tempItem['cart_item_dough'] = '';
					}
					else if ( $cartItems[$i]->dough == 'standart' || $cartItems[$i]->dough == 'slim' ) {
						$tempItem['cart_item_dough'] = $cartItems[$i]->dough;
					}
					else {
						$tempItem['cart_item_dough'] = '';
					}
					unset($tempItem['item_dough']);

					$tempSize = 'false';

					foreach ( $tempItem['item_sizes'] as $size ) {
						if ( $size['size_id'] == $cartItems[$i]->size_id ) {
							$tempSize = $size;
						}
					}
					
					if ( $tempSize ) {
						$tempItem['cart_item_size'] = $tempSize;
						unset($tempItem['item_sizes']);

						$tempItem['cart_item_count'] = $cartItems[$i]->count;
						$tempItem['item_deleted'] = array();
						// Deleted Ingredients
						foreach ( $cartItems[$i]->deleted as $deletedID ){
							$ingrIndex = array_search($deletedID, array_column($itemIngrDeletedArr, 'ingredient_id'));
							if ( $ingrIndex !== false ) {
								array_push($tempItem['item_deleted'], $itemIngrDeletedArr[$ingrIndex]);
							}
						}
						array_push($cartItemsInfo, $tempItem);
					}
				}
			}
		}
		return $cartItemsInfo;
	}

	public static function checkCartItem($item) {
		$count = 0;
		if ( isset($_COOKIE['cart']) ) {
			$cartItems = json_decode($_COOKIE['cart']);
			foreach ( $cartItems as $cartItem ) {
				if ( $cartItem->item_id == $item['item_id'] &&  $cartItem->size_id == $item['size_id'] &&  $cartItem->deleted == $item['deleted'] &&  $cartItem->dough == $item['dough'] ) {
					$count = $cartItem->count;
				}
			}
		}
		else {
			return false;
		}
		return $count > 0 ? $count : false;
	}

	public static function getCartCount() {
		$res = 0;
		if ( isset($_COOKIE['cart']) ) {
			foreach( json_decode($_COOKIE['cart']) as $item ) {
				$res += $item->count;
			}
		}
		return $res;
	}
}