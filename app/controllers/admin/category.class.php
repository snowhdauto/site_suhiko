<?php

namespace App\Controllers\Admin;

class Category {
	public static function add($data) {
		$category_value_ru = $data['category_value_ru'];
		$category_unit = $data['category_unit'];
		$category_value = translit($category_value_ru);


		$DB = new \App\Core\DB;
		
		$result = $DB->insert('categories', array(
			array('category_value', $category_value),
			array('category_unit', htmlspecialchars($category_unit)),
			array('category_value_ru', $category_value_ru),
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
				'message' => 'Категория добавлена.'
			);
		}
	}
	public static function delete($data) {
		$DB = new \App\Core\DB;

		$items = $DB->get('items', ['item_id'], 'item_category_id = '. $data);
		$ids = array();

		foreach ( $items as $item ) {
			array_push($ids, 'item_id = ' . $item['item_id']);
		}
		$DB->update('items', implode(' OR ', $ids), array(
			array('item_deleted', 1)
		));

		$DB->update('categories', 'category_id = ' . $data, array(
			array('category_deleted', 1)
		));
		//$result = $DB->query('DELETE FROM categories WHERE category_id = ' . $data);
	}
	public static function view() {
		$DB = new \App\Core\DB;
		$categoryJSON = json_encode($DB->get('categories', ['*'], 'category_deleted = 0'));
		return json_decode($categoryJSON);
	}
}