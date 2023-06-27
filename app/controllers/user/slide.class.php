<?php

namespace App\Controllers\User;

class Slide {
	public static function getSlides() {
		$DB = new \App\Core\DB;
		$categoryJSON = json_encode($DB->get('slides', ['*'], 'slide_deleted = 0'));
		return json_decode($categoryJSON);
	}

	public static function getSlidesCount() {
		$DB = new \App\Core\DB;
		$DBResult = mysqli_fetch_assoc($DB->query('SELECT COUNT(slide_id) AS count FROM slides'));
		return $DBResult['count'];
	}
}