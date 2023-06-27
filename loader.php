<?php
namespace App;
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/config.php';

if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
   $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
   header('HTTP/1.1 301 Moved Permanently');
   header('Location: ' . $location);
   exit;
}

if ( IS_DEBUG ) {
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
}
require $_SERVER['DOCUMENT_ROOT'] . '/function.php';

spl_autoload_register(function($class) {
	$ds = DIRECTORY_SEPARATOR;
	$filename = $_SERVER['DOCUMENT_ROOT'] . $ds . strtolower(str_replace('\\', $ds, $class)) . '.class.php';
	if( file_exists($filename) === false ) {
		return;
	}
	require($filename);
});

if( isset($_SESSION['user']) ){
	Controllers\Admin\Authorization::updateInfo($_SESSION['user']['user_id']);
}

if( isset($_COOKIE['cart']) ) {
	$DB = new Core\DB;
	$cartItems = json_decode($_COOKIE['cart']);
	if ( count($cartItems) > 0 ) {
		$cartItemsID = array();
		foreach($cartItems as $item) {
			array_push($cartItemsID, 'item_id = ' . $item->item_id);
		}
		$where = 'item_deleted = 0 AND (' . implode(' OR ', $cartItemsID) . ')';
		$res = $DB->get('items', ['item_id'], $where);
		if ( $res ) {
			$res = array_column($res, 'item_id');
		}
		$arrLen = count($cartItems);
		for ( $i = 0; $i < $arrLen; $i++ ) {
			if ( array_search($cartItems[$i]->item_id, $res) === false ) {
				unset($cartItems[$i]);
			}
		}
		$cart = array();
		foreach( $cartItems as $item ) {
			array_push($cart, $item);
		}
		$_COOKIE['cart'] = json_encode($cart);

	}
}
else {
	$_COOKIE['cart'] = '[]';
}