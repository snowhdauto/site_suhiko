<?php 
namespace App; 
require $_SERVER['DOCUMENT_ROOT'] . '/loader.php'; 
if(!isset($_SESSION['user'])) { redirect('/admin/login'); }

// Название страницы
$pageName = 'Добавить слайд';
// Название страницы и её вложенность 
// &nbsp; - это код пробела
// Например
//$pageTree = 'Новости&nbsp;&nbsp;/&nbsp;&nbsp;Добавить новость';
$pageTree = 'Слайд&nbsp;&nbsp;/&nbsp;&nbsp;Добавить слайд';

$data = $_POST;
if ( isset($_FILES['image']) && isset($data) && count($data) != 0 ) {
	$file = $_FILES['image'];
	$image = Controllers\Admin\Image::load($file);
	if ( $image ) {
		Controllers\Admin\Slide::add($data, $image);
		redirect('/admin/slide/main');
	} 
	redirect('/admin/slide/main');
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
							
							<h1>Добавить слайдер</h1>
							<?php 
								//echo(Controllers\Admin\News::add_news());
								//var_dump(Controllers\Admin\News::view_news());
							?>

							<form action="/admin/slide/add" method="post" enctype="multipart/form-data">
								<style>
									.add_articles_grid {
										display: grid;
										grid-template-columns: 1fr 300px;
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
											name="slide_name" 
											placeholder="Введите краткое описание"
											data-de-label="Краткое описание слайда" 
											data-de-maxlength="200"
											require
										/>
                                        <input 
											class="dolphron-elements" 
											type="text" 
											name="slide_link" 
											placeholder="Ссылка для изображения"
											data-de-label="Ссылка" 
											data-de-maxlength="2000"
											
										/>
									</div>

									<div class="add_articles_image-container">
										<p>Изображение (1635x500)</p>
										<label class="image-container_button">
											<input type="file" id="image" name="image" require>
											<div class="dolphron-elements button button_primary">Добавить картинку</div>
											<img src="#" id="imageIMG" alt="">
										</label>
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


								<button class="dolphron-elements button button_accent" >Добавить</button>
							</form>
						</div>


						<!-- Конец страницы -->
					</div>
				</div>
			</div>
		</div>

		<?php echo template_render('/admin/widgets/main-block/scripts.php', []); ?>
		<script>
			var editor = new MediumEditor('.editable');
			// Получить содержимое $ editor.getContent()
			$('form').submit(function(){
				var content = editor.getContent();
				$('[name="article_content"]').val(content);
			});
			$("#image").change(function(){
				var input = this;
				if (input.files && input.files[0]) {
					var reader = new FileReader();
					reader.onload = function (e) {
						$('#imageIMG').attr('src', e.target.result);
					};
					reader.readAsDataURL(input.files[0]);
					$('.image-container_button').addClass('hidden');
				}
			});
		</script>
	</body>
</html>