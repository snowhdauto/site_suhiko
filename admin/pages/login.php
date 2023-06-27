<?php 
namespace App; 
require $_SERVER['DOCUMENT_ROOT'] . '/loader.php'; 


// Название страницы
$pageName = 'Авторизация';
// Название страницы и её вложенность 
// &nbsp; - это код пробела
// Например
//$pageTree = 'Новости&nbsp;&nbsp;/&nbsp;&nbsp;Добавить новость';
$pageTree = 'Авторизация';

if(isset($_SESSION['user'])) { redirect('/admin/'); }

if ( count($_POST) > 0  ) {
	$login = $_POST['user_login'];
	$password = $_POST['user_password'];
	$auth = Controllers\Admin\Authorization::signin($login,$password);
	if ( $auth['status'] == 'success' ) {
		redirect('/admin/');
	}
}
?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE; ?>">
	<head>
		<?php echo template_render('/admin/widgets/main-block/head.php', [
				'SITENAME' => 'Панель управления',
				'LOCALE' => LANGUAGE,
				'title' => $pageName,
				'description' => '',
				'keywords' => '',
				'image' => '/assets/img/og_image_white.png',
				'curent_url' => '/',
				'page_type' => 'website',
				'published' => '2020-10-01T00:00:00+03:00',
			]); ?>
	</head>
	<body style="display: flex; align-items: center; min-height: 100vh;">
    <div class="content_block" style="margin: 0 auto; max-width: 440px; width: 100%; padding: 50px 20px;">
    	<h1 style="margin-bottom: 30px;">Авторизация</h1>
			<form action="/admin/login" method="post">
				<style>
					.add_articles_grid {
						display: grid;
						grid-template-columns: 1fr;
						/* grid-gap: 20px;
						margin-bottom: 20px; */
					}
				</style>

				<div class="add_articles_grid">
					<div>
						<input 
							class="dolphron-elements" 
							type="text" 
							name="user_login" 
							placeholder="Введите логин"
							data-de-label="Логин" 
							<?php if ( isset($auth) ) { if ( $auth['status'] == 'error' && $auth['message'] == 'login' ) { echo('data-de-error-massage="Пользователь не существует"'); }} ?>
							required
						/>
					</div>
					<div>
																<input 
							class="dolphron-elements" 
							type="password" 
							name="user_password" 
							placeholder="Введите пароль"
							data-de-label="Пароль" 
							<?php if ( isset($auth) ) { if ( $auth['status'] == 'error' && $auth['message'] == 'password' ) { echo('data-de-error-massage="Пароль введён не верно"'); }} ?>
							required
						/>
					</div>
				</div>
				<button style="width: 100%;" class="dolphron-elements button button_accent" >Войти</button>
			</form>
		</div>
		<?php echo template_render('/admin/widgets/main-block/scripts.php', []); ?>
	</body>
</html>