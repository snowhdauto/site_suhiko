<?php

namespace App\Controllers\User;

class Ingredient {
	public static function getByItem($id) {
		$DB = new \App\Core\DB;
		$categoryJSON = json_encode($DB->get('items_ingredients', ['iingr_id AS ingredient_id', '(SELECT ingr_name FROM ingredients WHERE ingr_id = iingr_ingredient_id) AS ingredient_name', 'iingr_removeble AS ingredient_removeble'], 'iingr_item_id = ' . $id));
		return json_decode($categoryJSON);
	}
}