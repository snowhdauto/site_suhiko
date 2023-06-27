<?php

namespace App\Controllers\Admin;

class Orders {
	public static function view() {
		$DB = new \App\Core\DB;
		$categoryJSON = json_encode($DB->get('orders', ['*', '(SELECT SUM(oitem_count * oitem_price) FROM order_items WHERE oitem_order_id = order_id) AS order_summ'], false, ['order_date', 'DESC']));
		return json_decode($categoryJSON);
	}
}