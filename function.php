<?php

function goToPageError($num) {
	if($num == 404) {
		header( "HTTP/1.1 404 Not Found" );
		exit();
	}
}
function redirect($loc) {
	header( "Location: " . $loc );
	exit();
}

/**
* Renders template
*
* @param string 0 Name of your template
* @param mixed 1 Data passed to template
* @return string
*/

function template_render($__view, $__data)
{
	extract($__data);

	ob_start();
	
	require $_SERVER['DOCUMENT_ROOT'].$__view;

	$output = ob_get_clean();

	return $output;
}

function phoneFormat($phone) {
	#$phone = explode('', $phone);
	return $phone[0] . $phone[1] . ' (' . $phone[2] . $phone[3] . $phone[4] . ') ' . $phone[5] . $phone[6] . $phone[7] . ' ' . $phone[8] . $phone[9] . '-' . $phone[10] . $phone[11];
}

function page_active($name) {
	if($_SERVER['REQUEST_URI'] == $name) return 'class="active"';
	return '';
 }
 
 function output( $data ) {
	header("Content-Type: application/json; charset=utf-8");
	echo json_encode($data);
	exit();
}

function translit($value) {
	$converter = array(
		'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
		'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
		'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
		'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
		'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
		'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
		'э' => 'e',    'ю' => 'yu',   'я' => 'ya',
 
		'А' => 'A',    'Б' => 'B',    'В' => 'V',    'Г' => 'G',    'Д' => 'D',
		'Е' => 'E',    'Ё' => 'E',    'Ж' => 'Zh',   'З' => 'Z',    'И' => 'I',
		'Й' => 'Y',    'К' => 'K',    'Л' => 'L',    'М' => 'M',    'Н' => 'N',
		'О' => 'O',    'П' => 'P',    'Р' => 'R',    'С' => 'S',    'Т' => 'T',
		'У' => 'U',    'Ф' => 'F',    'Х' => 'H',    'Ц' => 'C',    'Ч' => 'Ch',
		'Ш' => 'Sh',   'Щ' => 'Sch',  'Ь' => '',     'Ы' => 'Y',    'Ъ' => '',
		'Э' => 'E',    'Ю' => 'Yu',   'Я' => 'Ya',
		
		' ' => '_',    '-' => '_',
		',' => '',     '.' => '',     '/' => '',     '\\' => '',     '@' => '',
		'!' => '',     '?' => '',     '#' => '',     '$' => '',      '%' => '',
		'^' => '',     '&' => '',     '*' => '',     '(' => '',      ')' => '',
		'+' => '',     ':' => '',     ';' => '',     '№' => '',      '"' => '',
		'`' => '',     '\'' => '',
	);
 
	$value = strtolower(strtr($value, $converter));
	return $value;
}
