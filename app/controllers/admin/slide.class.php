<?php

namespace App\Controllers\Admin;

class Slide {
	public static function add($data, $image) {
		$slide_name = $data['slide_name'];
		$slide_date = time();
		$slide_image = $image;
		$slide_link = $data['slide_link'] ;
		$slide_deleted = 0;


		$DB = new \App\Core\DB;
		
		$result = $DB->insert('slides', array(
			array('slide_name', htmlspecialchars($slide_name)),
			array('slide_image', $slide_image),
			array('slide_link', $slide_link),
			array('slide_date', $slide_date),
			array('slide_deleted', $slide_deleted),
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
				'message' => 'Слайд добавлен.'
			);
		}
	}
	public static function delete($data) {
		$where = 'slide_id = '.$data;
		$DB = new \App\Core\DB;
		$result = $DB->update('slides', $where,array(
			array('slide_deleted', 1),
		));
	}
	public static function view() {
		$DB = new \App\Core\DB;
		$where = 'slide_deleted = 0';
		$categoryJSON = json_encode($DB->get('slides', ['*'],$where));
		return json_decode($categoryJSON);
	}

}