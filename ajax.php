<?php 

namespace App; 

require $_SERVER['DOCUMENT_ROOT'] . '/loader.php';

header("Content-Type: application/json; charset=utf-8");

function checkIsset( $var ) {
	if( isset($var) ) { 
		return $var;
	}
	return false;
}
// function checkString( $var ) {
// 	if( isset($var) ) { 
// 		if( is_string($var) ) { 
// 			return $var;
// 		}
// 	}
// 	return false;
// }

$DB = new Core\DB;

if ( isset($_POST['action']) ) {
	if ( $_POST['action'] == 'getCart' ) {
		$countAllOrders = Controllers\User\Cart::getCartCount();
		$items = Controllers\User\Cart::getCart();
	
		if ( $countAllOrders > 0 ) {
			foreach ( $items as $item) {
				echo template_render('/widgets/main-block/header-cart-item.php', $item); 
			}
		}
		exit();
	}

	if ( $_POST['action'] == 'getItems' ) {
		$limit = checkIsset($_POST['limit']);
		$offset = checkIsset($_POST['offset']);
		$category = checkIsset($_POST['category']);

		$items = Controllers\User\Item::getItems($category, array('item_date', 'DESC'), $limit, $offset);
		$html = '';
		foreach ($items as $item) {
			$html .= template_render('/widgets/index-menu-item.php', ['item' => $item]); 
		}
		exit(json_encode(array(
			'status' => 'success',
			'text' => $html,
			'count' => count($items),
		)));
	}

	if ( $_POST['action'] == 'getPosts' ) {
		$limit = checkIsset($_POST['limit']);
		$offset = checkIsset($_POST['offset']);
		$type = checkIsset($_POST['type']);

		$items = Controllers\User\Post::getPosts($type, array('article_date', 'DESC'), $limit, $offset);
		$html = '';
		foreach ($items as $item) {
			$html .= template_render('/widgets/article-block.php', [
				'article' => $item,
			]); 
		}
		exit(json_encode(array(
			'status' => 'success',
			'text' => $html,
			'count' => count($items),
		)));
	}

	if ( $_POST['action'] == 'getOrderInfo' ) {
		$id = checkIsset($_POST['id']);
		if(!isset($_SESSION['user'])) { 
			exit(json_encode(array(
				'status' => 'error',
				'text' => 'Fatal error'
			)));
		}

		$order = $DB->get('orders', ['*'], 'order_id = ' . $id);
		if ( !$order ) {
			exit(json_encode(array(
				'status' => 'error',
				'text' => 'Fatal error'
			)));
		}
		else { $order = $order[0]; }

		exit(json_encode(array(
			'status' => 'success',
			'text' => 'Данные получены',
			'data' => $order
		)));
	}

	if ( $_POST['action'] == 'getOrderItems' ) {
		$id = checkIsset($_POST['id']);
		if(!isset($_SESSION['user'])) { 
			exit(json_encode(array(
				'status' => 'error',
				'text' => 'Fatal error'
			)));
		}

		$order_items = $DB->get('order_items', ['*'], 'oitem_order_id = ' . $id);
		if ( !$order_items ) {
			exit(json_encode(array(
				'status' => 'error',
				'text' => 'Fatal error'
			)));
		}

		exit(json_encode(array(
			'status' => 'success',
			'text' => 'Данные получены',
			'data' => $order_items
		)));
	}

	if ( $_POST['action'] == 'changeOrderStatus' ) {
		$id = checkIsset($_POST['id']);
		$new = checkIsset($_POST['new']);
		if(!isset($_SESSION['user'])) { 
			exit(json_encode(array(
				'status' => 'error',
				'text' => 'Fatal error'
			)));
		}

		$orders = $DB->update('orders', 'order_id = ' . $id, array(
			array('order_status', $new)
		));
		
		if ( !$orders ) {
			exit(json_encode(array(
				'status' => 'error',
				'text' => 'Fatal error'
			)));
		}

		exit(json_encode(array(
			'status' => 'success',
			'text' => 'Статус изменён'
		)));
	}

	if ( $_POST['action'] == 'newOrders' ) {
		$date = checkIsset($_POST['date']);
		if(!isset($_SESSION['user'])) { 
			exit(json_encode(array(
				'status' => 'error',
				'text' => 'Fatal error'
			)));
		}

		$orders = $DB->get('orders', ['*', '(SELECT SUM(oitem_count * oitem_price) FROM order_items WHERE oitem_order_id = order_id) AS order_summ'], 'order_date > ' . $date, ['order_date', 'DESC']);
		
		exit(json_encode(array(
			'status' => 'success',
			'text' => 'Данные получены ',
			'data' => $orders
		)));
	}
}

exit(json_encode(array(
	'status' => 'error',
	'text' => 'Fatal error'
)));