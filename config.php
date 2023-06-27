<?php

define('IS_DEBUG', true);

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'pizza_db');

$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
$langArr = array(
	'ru' => 'ru_RU',
	'en' => 'en_EN',
);
if ($lang == 'ru' || $lang == 'en') {
	$lang = $langArr[$lang];
}
else {
	$lang = $langArr['en'];
}
define('LANGUAGE', $lang);

define('SITENAME', 'SushiKO');
define('SITETITLE', 'SushiKO — Доставка роллов по Нижнему Новгороду СушиКО SushiKO');
define('CONTACT_ADDRESS', 'Пр-т Ленина д 28. , Нижний Новгород');
define('CONTACT_PHONE', '+79535554640');
define('CONTACT_MAIL', 'sushiko552@mail.ru');
