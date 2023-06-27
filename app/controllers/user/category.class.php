<?php

namespace App\Controllers\User;

class Category {
	public static function getCategories() {
		$DB = new \App\Core\DB;
		$categoryJSON = json_encode($DB->get('categories', ['*'], 'category_deleted = 0'));
		return json_decode($categoryJSON);
	}

	public static function getCategoriesCount() {
		$DB = new \App\Core\DB;
		$DBResult = mysqli_fetch_assoc($DB->query('SELECT COUNT(category_id) AS count FROM categories WHERE category_deleted = 0'));
		return $DBResult['count'];
	}

	public static function getCategoryByID($id) {
		$DB = new \App\Core\DB;
		
		$result = $DB->get('categories', ['*'], 'category_id = ' . $id);
		if ( !$result ) { return false; }
		$categoryJSON = json_encode($result[0]);

		return json_decode($categoryJSON);
	}

	public static function getCategoryByName($name) {
		$DB = new \App\Core\DB;
		
		$result = $DB->get('categories', ['*'], 'category_value = \'' . $name . '\'');
		if ( !$result ) { return false; }
		$categoryJSON = json_encode($result[0]);

		return json_decode($categoryJSON);
	}
}