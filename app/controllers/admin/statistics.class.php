<?php

namespace App\Controllers\Admin;

class Statistics {
	public static function view_all_orders() {
		$DB = new \App\Core\DB;
		$query ='SELECT COUNT(*) AS count FROM orders WHERE order_status = \'success\'';
		$view_all_orders = $DB->query($query);
		$result = array();
		while( $row = mysqli_fetch_assoc($view_all_orders))
		{
			array_push($result, $row);
		}
		return $result;
	}
	public static function view_all_sum_orders() {
		$DB = new \App\Core\DB;
		$query ='SELECT SUM(qq) as summ FROM (SELECT (SELECT SUM(oitem_price * oitem_count) FROM order_items WHERE oitem_order_id = order_id) as qq FROM orders WHERE order_status = \'success\') ta';
		$view_all_sum_orders = $DB->query($query);
		$result = array();
		while( $row = mysqli_fetch_assoc($view_all_sum_orders))
		{
			array_push($result, $row);
		}
		return $result;
	}

	public static function view_cur_orders() {
		$curentMonth = date('m', time());
		$curentYear = date('Y', time());
		$DB = new \App\Core\DB;
		$query ='SELECT COUNT(*) AS count FROM orders WHERE order_status = \'success\' AND order_date > ' . strtotime("01.$curentMonth.$curentYear");
		$view_all_orders = $DB->query($query);
		$result = array();
		while( $row = mysqli_fetch_assoc($view_all_orders))
		{
			array_push($result, $row);
		}
		return $result;
	}
	public static function view_cur_sum_orders() {
		$curentMonth = date('m', time());
		$curentYear = date('Y', time());
		$DB = new \App\Core\DB;
		$query ='SELECT SUM(qq) as summ FROM (SELECT (SELECT SUM(oitem_price * oitem_count) FROM order_items WHERE oitem_order_id = order_id) as qq FROM orders WHERE order_status = \'success\' AND order_date > ' . strtotime("01.$curentMonth.$curentYear") . ') ta';
		$view_all_sum_orders = $DB->query($query);
		$result = array();
		while( $row = mysqli_fetch_assoc($view_all_sum_orders))
		{
			array_push($result, $row);
		}
		return $result;
	}

	private static function getMonthName($num) {
		switch($num) {
			case 1: return 'Январь';
			case 2: return 'Февраль';
			case 3: return 'Март';
			case 4: return 'Апрель';
			case 5: return 'Май';
			case 6: return 'Июнь';
			case 7: return 'Июль';
			case 8: return 'Август';
			case 9: return 'Сентябрь';
			case 10: return 'Октябрь';
			case 11: return 'Ноябрь';
			case 12: return 'Декабрь';
			default: return 'NULL';
		}
		
	} 



	public static function getChartData () {
		$labels = array();
		$data1 = array();
		$data = array();
		$curentMonth = date('m', time());
		$curentYear = date('Y', time());
		for ($i = 0; $i < 6; $i++ ) { 
			array_push($labels, self::getMonthName($curentMonth));
			array_push($data1, strtotime("01.$curentMonth.$curentYear"));
			$curentMonth--;
			if ( $curentMonth == 0 ) { $curentYear--; $curentMonth = 12; }
		}
		$query = 'SELECT chart_label, SUM(chart_data) AS chart_data FROM (SELECT \'m1\' AS chart_label, (SELECT SUM(oitem_price * oitem_count) FROM order_items WHERE oitem_order_id = order_id) AS chart_data FROM `orders` WHERE order_status = \'success\' AND order_date > ' . $data1[0] . ' UNION ALL SELECT \'m2\' AS chart_label, (SELECT SUM(oitem_price * oitem_count) FROM order_items WHERE oitem_order_id = order_id) AS chart_data FROM `orders` WHERE order_status = \'success\' AND order_date > ' . $data1[1] . ' AND order_date <= ' . $data1[0] . ' UNION ALL SELECT \'m3\' AS chart_label, (SELECT SUM(oitem_price * oitem_count) FROM order_items WHERE oitem_order_id = order_id) AS chart_data FROM `orders` WHERE order_status = \'success\' AND order_date > ' . $data1[2] . ' AND order_date <= ' . $data1[1] . ' UNION ALL SELECT \'m4\' AS chart_label, (SELECT SUM(oitem_price * oitem_count) FROM order_items WHERE oitem_order_id = order_id) AS chart_data FROM `orders` WHERE order_status = \'success\' AND order_date > ' . $data1[3] . ' AND order_date <= ' . $data1[2] . ' UNION ALL SELECT \'m5\' AS chart_label, (SELECT SUM(oitem_price * oitem_count) FROM order_items WHERE oitem_order_id = order_id) AS chart_data FROM `orders` WHERE order_status = \'success\' AND order_date > ' . $data1[4] . ' AND order_date <= ' . $data1[3] . ' UNION ALL SELECT \'m6\' AS chart_label, (SELECT SUM(oitem_price * oitem_count) FROM order_items WHERE oitem_order_id = order_id) AS chart_data FROM `orders` WHERE order_status = \'success\' AND order_date > ' . $data1[5] . ' AND order_date <= ' . $data1[4] . ') chart_table GROUP BY chart_label';
		
		$DB = new \App\Core\DB;

		$response = $DB->query($query);
		$result = array();
		while( $row = mysqli_fetch_assoc($response)) {
			array_push($result, $row);
		}

		$data_m1 = 0;
		$data_m2 = 0;
		$data_m3 = 0;
		$data_m4 = 0;
		$data_m5 = 0;
		$data_m6 = 0;

		foreach ( $result as $item ) {
			if ( $item['chart_label'] == 'm1' ) { $data_m1 = $item['chart_data']; }
			else if ( $item['chart_label'] == 'm2' ) { $data_m2 = $item['chart_data']; }
			else if ( $item['chart_label'] == 'm3' ) { $data_m3 = $item['chart_data']; }
			else if ( $item['chart_label'] == 'm4' ) { $data_m4 = $item['chart_data']; }
			else if ( $item['chart_label'] == 'm5' ) { $data_m5 = $item['chart_data']; }
			else if ( $item['chart_label'] == 'm6' ) { $data_m6 = $item['chart_data']; }
		}

		$data = array($data_m1, $data_m2, $data_m3, $data_m4, $data_m5, $data_m6);
		return array(
			'labels' => array_reverse($labels),
			'data' => array_reverse($data)
		);
	}

}