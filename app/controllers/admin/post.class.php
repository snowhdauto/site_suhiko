<?php

namespace App\Controllers\Admin;

class Post {
	public static function add($data, $image) {
		$article_name = $data['article_name'];
		$article_description = $data['article_description'];
		$article_content = $data['article_content'];
		$article_type = $data['article_type'];
		$article_date = time();
		$article_link = translit($article_name);
		$article_image = $image;
		$article_deleted = 0;


		$DB = new \App\Core\DB;
		
		$result = $DB->insert('articles', array(
			array('article_type', $article_type),
			array('article_name', htmlspecialchars($article_name)),
			array('article_description', htmlspecialchars($article_description)),
			array('article_image', $article_image),
			array('article_content', $article_content),
			array('article_link', $article_link),
			array('article_date', $article_date),
			array('article_deleted', $article_deleted),
		));
		
		if ( !$result ) {
			return array(
				'status' => 'error',
				'message' => 'Ошибка.'
			);
		}
		else{
			\App\Controllers\User\Sitemap::update();
			return array(
				'status' => 'succes',
				'message' => 'Новость добавлена.'
			);
		}
	}
	public static function edit($data, $image) {
		$article_id = $data['id'];
		$article_name = $data['article_name'];
		$article_description = $data['article_description'];
		$article_content = $data['article_content'];
		$article_type = $data['article_type'];
		$article_date = time();
		$article_link = translit($article_name);
		$article_image = $image;
		$article_deleted = 0;


		$DB = new \App\Core\DB;
		
		$result = $DB->update('articles', ('article_id = ' . $article_id), array(
			array('article_type', $article_type),
			array('article_name', htmlspecialchars ($article_name)),
			array('article_description', htmlspecialchars($article_description)),
			array('article_image', $article_image),
			array('article_content', $article_content),
			array('article_link', $article_link),
			array('article_date', time()),
			array('article_deleted', $article_deleted),
		));
		if ( !$result ) {
			return array(
				'status' => 'error',
				'message' => 'Ошибка.'
			);
		}
		else{
			\App\Controllers\User\Sitemap::update();
			return array(
				'status' => 'succes',
				'message' => 'Новость добавлена.'
			);
		}
	}
	public static function delete($data) {
		$where = 'article_id = '.$data;
		$DB = new \App\Core\DB;
		$result = $DB->update('articles', $where,array(
			array('article_deleted', 1),
		));
		\App\Controllers\User\Sitemap::update();
	}
	public static function view($type) {
		$DB = new \App\Core\DB;
		$where = 'article_deleted = 0';
		if ( $type != 'all' ) {
			$where .= ' AND article_type = \'' . $type . '\'';
		}
		$result = $DB->get('articles', ['*'], $where, ['article_date', 'DESC']);
		$postsJSON = json_encode($result);
		return json_decode($postsJSON);
	}
	public static function viewOne($data) {
		$DB = new \App\Core\DB;
		$where = 'article_id = '.$data;
		$result = $DB->get('articles', ['*'], $where);
		$postsJSON = json_encode($result);
		return json_decode($postsJSON);
	}

}