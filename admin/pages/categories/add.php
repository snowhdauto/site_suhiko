<?php 
namespace App; 
require $_SERVER['DOCUMENT_ROOT'] . '/loader.php'; 
if(!isset($_SESSION['user'])) { redirect('/admin/login'); }

// Название страницы 
$pageName = 'Добавить категорию';
// Название страницы и её вложенность 
// &nbsp; - это код пробела
// Например
//$pageTree = 'Новости&nbsp;&nbsp;/&nbsp;&nbsp;Добавить новость';
$pageTree = 'Категории&nbsp;&nbsp;/&nbsp;&nbsp;Добавить категорию';
$data = $_POST;
if ( isset($data) && count($data) != 0 ) {
		Controllers\Admin\Category::add($data);
		redirect('/admin/categories/main');
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
	<body>

		<div class="wrapper">

			<?php echo template_render('/admin/widgets/main-block/header.php', [ 'title' => $pageTree ]); ?>

			<div class="bottom-wrapper">
				<?php echo template_render('/admin/widgets/main-block/sidebar.php', []); ?>
				<div class="page-wrapper">
					<div class="page-container">
						<!-- Начало страницы -->
						<div class="content_block">
							
							<h1>Добавить категорию</h1>
							<?php 
								//echo(Controllers\Admin\News::add_news());
								//var_dump(Controllers\Admin\News::view_news());
							?>

							<form action="/admin/categories/add" method="post">
								<style>
									.add_articles_grid {
										display: grid;
										grid-template-columns: 1fr 1fr;
										grid-gap: 20px;
									}
									.image-container_button input[type="file"] {
										display: none;
									}
									.image-container_button.hidden .button {
										display: none;
									}
									.image-container_button #imageIMG {
										width: 100%;
										height: 290px;
										object-fit: cover;
										border-radius: 10px;
										cursor:pointer;
										display: none;
									}
									.image-container_button.hidden #imageIMG {
										display: block;
									}
									.editable {
										border: 1px solid #ccc;
										padding: 15px 20px;
										border-radius: 5px;
									}
									@media (max-width: 740px) {
										.add_articles_grid {
											grid-template-columns: 1fr;
										}
									}
								</style>
								<div class="add_articles_grid">
									<div>
										<input 
											class="dolphron-elements" 
											type="text" 
											name="category_value_ru" 
											placeholder="Введите название категории"
											data-de-label="Название категории" 
											data-de-maxlength="200"
											require
										/>
									</div>
									<div>
                                        <input 
											class="dolphron-elements" 
											type="text" 
											name="category_unit" 
											placeholder="Введите единицу измерения"
											data-de-label="Единица измерения" 
											data-de-maxlength="50"
											
										/>
									</div>

									
								</div>
								
								<!-- <textarea 
									class="dolphron-elements" 
									type="text" 
									name="article_content" 
									placeholder="Введите содержание" 
									rows="10"
									data-de-label="Содержание" 
									data-de-maxlength="3000"
								></textarea> -->


								<button class="dolphron-elements button button_accent" >Добавить категорию</button>
							</form>
						</div>


						<!-- Конец страницы -->
					</div>
				</div>
			</div>
		</div>

		<?php echo template_render('/admin/widgets/main-block/scripts.php', []); ?>
	</body>
</html>