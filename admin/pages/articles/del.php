<?php
namespace App;
require $_SERVER['DOCUMENT_ROOT'] . '/loader.php'; 
if(!isset($_SESSION['user'])) { redirect('/admin/login'); }

$data = $_GET['id'];
if( isset($data) && count($data) != 0 ) {
	Controllers\Admin\Post::delete($data);
	redirect('/admin/articles/main');
}





