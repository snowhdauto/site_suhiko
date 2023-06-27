<?php

namespace App\Controllers\Admin;

class Image {
	public static function load($file) {
		$uploaddir = '/uploads/';
		$file_name = hash('md5', time() . basename($file['name']));
		$file_type = explode(".", basename($file['name']));
		$file_type = $file_type[ count($file_type) - 1 ];
		$uploadfile = $uploaddir . $file_name . "." . $file_type;
		if ( !move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $uploadfile) ) {
			return false;
		}
		return $uploadfile;
	}
}