<?php

namespace App\Controllers\User;

class Order {
	private static function checkRequred($data, $name) {
		if ( isset( $data ) ) { 
			if( $data == '' ) {
				return array(
					'status' => 'error',
					'message' => 'Поле "' . $name . '" обязательно для заполнения.'
				);
			}
		}
		else {
			return array(
				'status' => 'error',
				'message' => 'Поле "' . $name . '" обязательно для заполнения.'
			);
		}
		return $data;
	}
	private static function checkLength($data, $name, $minLength, $maxLength) {
		if ( isset($data) ) {
			if( strlen($data) < $minLength ) {
				return array(
					'status' => 'error',
					'message' => 'Поле "' . $name . '" слишком короткое.'
				);
			}
			if( strlen($data) > $maxLength ) {
				return array(
					'status' => 'error',
					'message' => 'Поле "' . $name . '" слишком длинное.'
				);
			}
		}
		else {
			return '';
		}
		return $data;
	}
	private static function checkValid($data, $name, $minLength, $maxLength) {
		if( $minLength > 0) {
			$var = self::checkRequred($data, $name);
			if ( is_array($var) ) { return $var; }
		}
		$var = self::checkLength($data, $name, $minLength, $maxLength);
		return $var;
	}
	
	public static function addOrder($data) {
		$name = self::checkValid($data['name'], 'Имя', 2, 50);
		$phone = self::checkValid($data['phone'], 'Телефон', 5, 50);
		$street = self::checkValid($data['street'], 'Улица', 5, 100);
		$home = self::checkValid($data['home'], 'Дом', 1, 10);
		$flat = self::checkValid($data['flat'], 'Квартира', 1, 10);
		$comment = self::checkLength($data['comment'], 'Примечания', 0, 1000);
		$promo = self::checkLength($data['promo'], 'Промокод', 0, 50);
		$payment = self::checkValid($data['payment'], 'Способ оплаты', 1, 50);
		$date = time();

		if ( is_array($name) ) { return $name; }
		if ( is_array($phone) ) { return $phone; }
		if ( is_array($street) ) { return $street; }
		if ( is_array($home) ) { return $home; }
		if ( is_array($flat) ) { return $flat; }
		if ( is_array($comment) ) { return $comment; }
		if ( is_array($promo) ) { return $promo; }
		if ( is_array($payment) ) { return $payment; }
									 
		$DB = new \App\Core\DB;

		$result = $DB->insert('orders', array(
			array('order_user_name', htmlspecialchars($name)),
			array('order_user_phone', htmlspecialchars($phone)),
			array('order_user_street', htmlspecialchars($street)),
			array('order_user_home', htmlspecialchars($home)),
			array('order_user_flat', htmlspecialchars($flat)),
			array('order_comments', htmlspecialchars($comment)),
			array('order_promo', htmlspecialchars($promo)),
			array('order_payment', htmlspecialchars($payment)),
			array('order_status', 'new'),
			array('order_date', $date),
		));
		if ( !$result ) {
			return array(
				'status' => 'error',
				'message' => 'Ошибка при оформлении заказа... Попробуйте ещё раз.'
			);
		}

		$result = $DB->get('orders', ['*'], 'order_user_name = \'' . $name . '\' AND order_user_phone = \'' . $phone . '\' AND order_date = ' . $date);
		$order_id = $result[0]['order_id'];
		$cart = Cart::getCart();
		
		foreach ( $cart as $item ) {
			$deleted = implode(', ', array_column($item['item_deleted'], 'ingredient_name'));
			$DB->insert('order_items', array(
				array('oitem_order_id', $order_id),
				array('oitem_name', $item['item_name']),
				array('oitem_image', $item['item_image']),
				array('oitem_category_value', $item['item_category']['category_value']),
				array('oitem_category_name', $item['item_category']['category_value_ru']),
				array('oitem_size', $item['cart_item_size']['size_value'] . $item['item_category']['category_unit']),
				array('oitem_deleted', $deleted),
				array('oitem_dough', $item['cart_item_dough']),
				array('oitem_count', $item['cart_item_count']),
				array('oitem_price', $item['cart_item_size']['size_price']),
			));
		}

		Mail::send_mail('🍣 ' . SITENAME . ' | Поступил новый заказ №'.$order_id, self::generateMail($result[0], $cart), true, CONTACT_MAIL, CONTACT_MAIL);

		$_COOKIE['cart'] = '[]';
		return array(
			'status' => 'success',
			'message' => 'Заказ оформлен! Ожидайте звонка!'
		);
	}

	private static function generateMail($orderInfo, $orderItem) {
		$orderPayment = $orderInfo['order_payment'] == 'card-courier' ? 'Оплата картой курьеру', 'Оплата наличными';
		
		$mail = '<h2>Получатель</h2>
		<p>
		<b>Покупатель: </b> ' . $orderInfo['order_user_name'] . '<br>
		<b>Номер телефона: </b> ' . $orderInfo['order_user_phone'] . '<br>
		<b>Улица: </b> ' . $orderInfo['order_user_street'] . '<br>
		<b>Дом: </b> ' . $orderInfo['order_user_home'] . '<br>
		<b>Квартира: </b> ' . $orderInfo['order_user_flat'] . '<br>
		<b>Примечание: </b> ' . $orderInfo['order_comments'] . '<br>
		<b>Промокод: </b> ' . $orderInfo['order_promo'] . '<br>
		<b>Оплата: </b> ' . $orderPayment . '
		</p>
		<h2>Товары</h2>
		<ol>';
		
		foreach ( $orderItem as $item ) {
			$mail .= '<li><p>' . $item['item_name'] . ' Х ' . $item['cart_item_count'] . '<br>Размер ' . $item['cart_item_size']['size_value'] . $item['item_category']['category_unit'] . '<br>' . $item['cart_item_size']['size_price'] . ' руб.</p></li>';
		}

		$mail .= '</ol>';
		return $mail;
	}


}