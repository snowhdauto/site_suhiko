<?php

namespace App\Controllers\Admin;

class Item {
	private static function getSizeId($category, $value) {
		$DB = new \App\Core\DB;
		$result = $DB->get('sizes', ['*'], 'size_value = ' . $value .' AND size_category_id = ' . $category);
		if ( count($result) > 0 ) {
			return (int)$result[0]['size_id'];
		}
		$DB->insert('sizes', array(
			array('size_value', $value),
			array('size_category_id', $category),
		));
		$result = $DB->get('sizes', ['*'], 'size_value = ' . $value .' AND size_category_id = ' . $category);
		return (int)$result[0]['size_id'];
	}

	public static function add($data, $image) {
		$item_name = $data['item_name'];
		$item_description = $data['item_description'];
		$item_category_id = $data['item_category'];

		$item_size1_id = 0; $item_size1_cost = 0;
		$item_size2_id = 0; $item_size2_cost = 0;
		$item_size3_id = 0; $item_size3_cost = 0;
		$item_size4_id = 0; $item_size4_cost = 0;

		$item_size1_id = self::getSizeId($item_category_id, $data['item_size']['value'][0]);
		$item_size1_cost = (float)$data['item_size']['price'][0];

		if ( count($data['item_size']['price']) >= 2) {
			$item_size2_id = self::getSizeId($item_category_id, $data['item_size']['value'][1]);
			$item_size2_cost = (float)$data['item_size']['price'][1];
		}

		if ( count($data['item_size']['price']) >= 3) {
			$item_size3_id = self::getSizeId($item_category_id, $data['item_size']['value'][2]);
			$item_size3_cost = (float)$data['item_size']['price'][2];
		}


		if ( count($data['item_size']['price']) >= 4) {
			$item_size4_id = self::getSizeId($item_category_id, $data['item_size']['value'][3]);
			$item_size4_cost = (float)$data['item_size']['price'][3];
		}

		$item_dough = $data['item_dough'];
		$item_prefix = $data['item_prefix'];


		$DB = new \App\Core\DB;
		
		$result = $DB->insert('items', array(
			array('item_name', htmlspecialchars($item_name)),
			array('item_description', htmlspecialchars($item_description)),
			array('item_image', $image),
			array('item_category_id', $item_category_id),
			array('item_size1_id', $item_size1_id),
			array('item_size1_cost', $item_size1_cost),
			array('item_size2_id', $item_size2_id),
			array('item_size2_cost', $item_size2_cost),
			array('item_size3_id', $item_size3_id),
			array('item_size3_cost', $item_size3_cost),
			array('item_size4_id', $item_size4_id),
			array('item_size4_cost', $item_size4_cost),
			array('item_dough', $item_dough),
			array('item_prefix', htmlspecialchars($item_prefix)),
			array('item_date', time()),
			array('item_deleted', 0),
		));
		
		if ( !$result ) {
			return array(
				'status' => 'error',
				'message' => 'Ошибка.'
			);
		}
		else{
			return array(
				'status' => 'succes',
				'message' => 'Новость добавлена.'
			);
		}
	}

	public static function edit($data, $image) {
		$item_id = $data['id'];
		$item_name = $data['item_name'];
		$item_description = $data['item_description'];
		$item_category_id = $data['item_category'];

		$item_size1_id = 0; $item_size1_cost = 0;
		$item_size2_id = 0; $item_size2_cost = 0;
		$item_size3_id = 0; $item_size3_cost = 0;
		$item_size4_id = 0; $item_size4_cost = 0;

		$item_size1_id = self::getSizeId($item_category_id, $data['item_size']['value'][0]);
		$item_size1_cost = (float)$data['item_size']['price'][0];

		if ( count($data['item_size']['price']) >= 2) {
			$item_size2_id = self::getSizeId($item_category_id, $data['item_size']['value'][1]);
			$item_size2_cost = (float)$data['item_size']['price'][1];
		}

		if ( count($data['item_size']['price']) >= 3) {
			$item_size3_id = self::getSizeId($item_category_id, $data['item_size']['value'][2]);
			$item_size3_cost = (float)$data['item_size']['price'][2];
		}


		if ( count($data['item_size']['price']) >= 4) {
			$item_size4_id = self::getSizeId($item_category_id, $data['item_size']['value'][3]);
			$item_size4_cost = (float)$data['item_size']['price'][3];
		}

		$item_dough = $data['item_dough'];
		$item_prefix = $data['item_prefix'];


		$DB = new \App\Core\DB;
		
		$result = $DB->update('items', ('item_id = ' . $item_id), array(
			array('item_name', htmlspecialchars($item_name)),
			array('item_description', htmlspecialchars($item_description)),
			array('item_image', $image),
			array('item_category_id', $item_category_id),
			array('item_size1_id', $item_size1_id),
			array('item_size1_cost', $item_size1_cost),
			array('item_size2_id', $item_size2_id),
			array('item_size2_cost', $item_size2_cost),
			array('item_size3_id', $item_size3_id),
			array('item_size3_cost', $item_size3_cost),
			array('item_size4_id', $item_size4_id),
			array('item_size4_cost', $item_size4_cost),
			array('item_dough', $item_dough),
			array('item_prefix', htmlspecialchars($item_prefix)),
		));
		
		if ( !$result ) {
			return array(
				'status' => 'error',
				'message' => 'Ошибка.'
			);
		}
		else{
			return array(
				'status' => 'succes',
				'message' => 'Новость добавлена.'
			);
		}
	}

	public static function get() {
		$DB = new \App\Core\DB;
		$where = 'item_deleted = 0';
		$result = $DB->get('items', ['*', '(SELECT category_value_ru FROM categories WHERE category_id = item_category_id) AS category_name'], $where, ['	item_date', 'DESC']);
		$postsJSON = json_encode($result);
		return json_decode($postsJSON);
	}

	public static function getOne($id) {
		$DB = new \App\Core\DB;
		$where = 'item_deleted = 0 AND item_id = ' . $id;
		$result = $DB->get('items', ['*', '(SELECT size_value FROM sizes WHERE size_id = item_size1_id) AS item_size1_value', '(SELECT size_value FROM sizes WHERE size_id = item_size2_id) AS item_size2_value', '(SELECT size_value FROM sizes WHERE size_id = item_size3_id) AS item_size3_value', '(SELECT size_value FROM sizes WHERE size_id = item_size4_id) AS item_size4_value'], $where, ['	item_date', 'DESC']);
		$postsJSON = json_encode($result);
		return json_decode($postsJSON);
	}
	
	public static function delete($data) {
		$where = 'item_id = '.$data;
		$DB = new \App\Core\DB;
		$result = $DB->update('items', $where,array(
			array('item_deleted', 1),
		));
	}
}