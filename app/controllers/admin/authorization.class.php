<?php

namespace App\Controllers\Admin;

class Authorization {
	private static function get() {
		$DB = new \App\Core\DB;
		$categoryJSON = json_encode($DB->get('users', ['*']));
		return json_decode($categoryJSON);
	 }

	public static function signin($login, $password){
		$DB =  new \App\Core\DB;
		$user = $DB->get('users', ['*'], 'user_login = \'' . $login . '\'');
		if ( !$user ) {
			return array(
				'status' => 'error',
				'message' => 'login'#'Пользователь не существует'
			);
		}
		else { $user = $user[0]; }
		if ( hash('sha256', $password.$user['user_salt']) != $user['user_password'] ) {
			return array(
				'status' => 'error',
				'message' => 'password'#'Пароль введён не верно'
			);
		}

		$_SESSION['user'] = $user;

		return array(
			'status' => 'success',
			'message' => 'Вы успешно авторизировались'
		);
	}
	
	public static function updateInfo($id){
		$DB =  new \App\Core\DB;
		$user = $DB->get('users', ['*'], 'user_id = ' . $id);
		if ( !$user ) {
			redirect('/admin/logout');
		}
		else { $user = $user[0]; }
		$_SESSION['user'] = $user;
		return $user;
	}
}