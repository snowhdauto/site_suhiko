<?php

namespace App\Controllers\User;

class Post {
	public static function getPosts($type, $orderBy = false, $limit = false, $offset = false) {


		# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #
		#                                                                     #
		#                  ВНИМАНИЕ! ОБЯЗАТЕЛЬНО К ПРОЧЕНИЮ!                  #
		#           Это небольшая инструкция по разработке методов.           #
		#                                                                     #
		# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #


		// Здесь обращаемся к классам из ядра (Core)

		// Переменная postsJSON имеет строку в JSON с масиивом полученных данных (что бы всё работало 
		// данные обязательно должны быть в таком виде (я про название переменных))

		// Задача сделать правильный запрос к методу т.е указать поля которые нужно получить, 
		// тип записи, прописать услове что бы не получать удалённые записи

		// Дальнейшие методы здесь и в других классах будут иметь похожую стилистику 

		// Простое обращение к методу после которого ты получаешь данные 
		// Делаешь всё что бы результат был в точности такой же как и татичная хуйня и отрезаешь лишнее для тестирования 
		// методов есть специальная страница в корне сайта "/test.php" на ней тестируй свои функции

		
		$DB = new \App\Core\DB;
		$result = $DB->get('articles', ['article_type', 'article_link', 'article_image', 'article_name', 'article_description', 'article_date'], 'article_type = \'' . $type . '\' AND article_deleted = 0', $orderBy, $limit, $offset);
		$postsJSON = json_encode($result);
		return json_decode($postsJSON);
	}

	public static function getPostsCount($type) {
		$DB = new \App\Core\DB;
		$DBResult = mysqli_fetch_assoc($DB->query('SELECT COUNT(article_id) AS count FROM articles WHERE article_type = \'' . $type . '\' AND article_deleted = 0'));
		return $DBResult['count'];
	}

	public static function getOnePost($type, $link) {
		$DB = new \App\Core\DB;

		$result = $DB->get('articles', ['*'], 'article_type = \'' . $type . '\' AND article_link = \'' . $link . '\'');
		if ( !$result ) { return false; }
		$postJSON = json_encode($result[0]);

		return json_decode($postJSON);
	}
}