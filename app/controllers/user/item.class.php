<?php

namespace App\Controllers\User;

class Item {
	public static function getItems($category, $orderBy = false, $limit = false, $offset = false) {
		# # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
		#                                                         #
		#               ДАЖЕ НЕ ПЫТАЙСЯ ЭТО ПОНЯТЬ                #
		#     Ты убьёшь кучу времени и сил... Зачем тебе это?     #
		#                                                         #
		# # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
		$DB = new \App\Core\DB;
		$catList = array(); $catArr = array(); $sizeList = array();
		$where = 'item_deleted = 0';
		if ( $category != 'all' ) { 
			$catArr = Category::getCategoryByName($category); 
			if ( !$catArr ) { return array(); } 
			$where .= ' AND item_category_id = ' . $catArr->category_id; 
			$catList = false; 
		} 
		$result = $DB->get('items', ['*'], $where, $orderBy, $limit, $offset); 
		if ( !$result ) { return array(); } 
		for ( $i = 0; $i < count($result); $i++ ) {
			if ( $catList !== false ) {
				$catIndex = array_search($result[$i]['item_category_id'], array_column($catList, 'category_id'));
				if ( $catIndex !== false ) { $result[$i]['item_category'] = $catList[$catIndex]; }
				else { 
					$tempCat = (array)Category::getCategoryByID($result[$i]['item_category_id']); 
					array_push($catList, $tempCat); 
					$result[$i]['item_category'] = $tempCat; 
				}
			}
			else { $result[$i]['item_category'] = $catArr; }
			unset($result[$i]['item_category_id']);
			$result[$i]['item_ingredients'] = Ingredient::getByItem($result[$i]['item_id']);
			$result[$i]['item_sizes'] = array();

			for ( $j = 1; $j <= 4; $j++ ) {
				if ( !($result[$i]['item_size' . $j . '_id'] == 0 || $result[$i]['item_size' . $j . '_id'] == NULL) ) {
					$sizeIndex = array_search($result[$i]['item_size' . $j . '_id'], array_column($sizeList, 'size_id'));
					if ( $sizeIndex !== false ) { 
						$tempSizeInfo = $sizeList[$sizeIndex];
						$tempSizeInfo['size_price'] = $result[$i]['item_size' . $j . '_cost'];
						array_push($result[$i]['item_sizes'], $tempSizeInfo); 
					} 
					else {
						$tempSizeInfo = array(
							'size_id' => $result[$i]['item_size' . $j . '_id'],
							'size_value' => $DB->get('sizes', ['size_value'], 'size_id = ' . $result[$i]['item_size' . $j . '_id'])[0]['size_value']
						);
						array_push($sizeList, $tempSizeInfo); 
						$tempSizeInfo['size_price'] = $result[$i]['item_size' . $j . '_cost'];
						array_push($result[$i]['item_sizes'], $tempSizeInfo);
					}
				}
				unset($result[$i]['item_size' . $j . '_id']); unset($result[$i]['item_size' . $j . '_cost']);
			}
		}
		$postsJSON = json_encode($result);
		return json_decode($postsJSON);
	}

	public static function getItemsCount($category) {
		$DB = new \App\Core\DB;
		$where = 'WHERE item_deleted = 0';
		if ( $category != 'all' ) {
			$catArr = Category::getCategoryByName($category);
			if ( !$catArr ) { return '0'; }
			$where .= ' AND item_category_id = ' . $catArr->category_id;
		}
		$DBResult = mysqli_fetch_assoc($DB->query('SELECT COUNT(item_id) AS count FROM items ' . $where));
		return $DBResult['count'];
	}
}