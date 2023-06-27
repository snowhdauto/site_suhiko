<?php 
namespace App; 
require $_SERVER['DOCUMENT_ROOT'] . '/loader.php'; 
if(!isset($_SESSION['user'])) { redirect('/admin/login'); }

// Название страницы 
$pageName = 'Добавить товар';
// Название страницы и её вложенность 
// &nbsp; - это код пробела
// Например
//$pageTree = 'Новости&nbsp;&nbsp;/&nbsp;&nbsp;Добавить новость';
$pageTree = 'Товары&nbsp;&nbsp;/&nbsp;&nbsp;Добавить товар';

$data = $_POST;
if ( isset($_FILES['image']) && isset($data) && count($data) != 0 ) {
	$file = $_FILES['image'];
	$image = Controllers\Admin\Image::load($file);
	if ( $image ) {
		Controllers\Admin\Item::add($data, $image);
		redirect('/admin/items/main');
	} 
	redirect('/admin/items/add');
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
							
							<h1>Добавить товар</h1>

							<form action="/admin/items/add" method="post" enctype="multipart/form-data">
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
									.item_dough.hidden {
										display: none;
									}
									@media (max-width: 740px) {
										.add_articles_grid {
											grid-template-columns: 1fr;
										}
									}
								</style>
								<div class="add_articles_grid">
									<div>
										
										<select
											class="dolphron-elements" 
											type="text" 
											name="item_category" 
											data-de-label="Категории"
											required 
										>
											<?php 
											$cat = Controllers\Admin\Category::view();
											foreach ( $cat as $item ): 
											?>
											<option value="<?php echo($item->category_id); ?>" data-category-name="<?php echo($item->category_value); ?>" data-category-unit="<?php echo($item->category_unit); ?>"><?php echo($item->category_value_ru); ?></option>
											<?php endforeach; ?>
										</select>

										<input 
											class="dolphron-elements" 
											type="text" 
											name="item_name" 
											placeholder="Введите название" 
											data-de-label="Название товара" 
											data-de-maxlength="70"
											required
										/>

										<input 
											class="dolphron-elements"
											type="text"
											name="item_prefix"
											placeholder="Введите префикс" 
											data-de-label="Префик" 
											data-de-maxlength="70"
										/>
										<div class="item_dough <?php echo( ( $cat[0]->category_id == 1 ) ? '' : 'hidden' ); ?>">
											<select
												class="dolphron-elements" 
												type="text" 
												name="item_dough" 
												data-de-label="Размер теста" 
												required
											>
												<option value="all">Все</option>
												<option value="standart">Стандартное</option>
												<option value="slim">Тонкая</option>
											</select>
										</div>
										
									</div>

									<div class="add_articles_image-container">
										<p>Изображение</p>
										<label class="image-container_button">
											<input type="file" id="image" name="image" required>
											<div class="dolphron-elements button button_primary">Добавить картинку</div>
											<img src="#" id="imageIMG" alt="">
										</label>
									</div>
								</div>

								<textarea 
									class="dolphron-elements" 
									type="text" 
									name="item_description" 
									placeholder="Введите описание" 
									rows="6"
									data-de-label="Описание" 
									data-de-maxlength="3000"
									required
								></textarea>
								
								<style>
								.price-item {
									display: grid;
									grid-template-columns: 1fr 300px 50px;
									grid-gap: 20px;
								}
								.ss {
									display: flex;
									align-items: center;
									justify-content: space-between;
								}
								@media (max-width: 1024px) {
									.price-item {
										grid-template-columns: 1fr 1fr 50px;
									}
								}
								</style>

								<div class="price-group">
									<div class="price-item ss">

										<h3>Размеры</h3>
										<div>
											<a class="dolphron-elements button button_primary add-price-item">Добавить размер</a>
										</div>

									</div>

								<div class="price-item">

									<input 
										class="dolphron-elements" 
										type="text" 
										name="item_size[value][]" 
										placeholder="Введите размер" 
										data-de-label="Размер"
										required
									/>

									<input 
										class="dolphron-elements" 
										type="text" 
										name="item_size[price][]" 
										placeholder="Введите цену" 
										data-de-label="Цена"
										required
									/>

									<a class="dolphron-elements button button_primary remove-price-item" style="margin-top: 44px; margin-bottom: 30px;"><i class="far fa-times"></i></a>
								</div>

								</div>


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
			$(document).ready(function(){
				$('[name="item_category"]').on('change', function() {
					if($(this).val() == '1'){
						$('[name="item_dough"]').parent().parent().removeClass('hidden');
					}
					else {
						$('[name="item_dough"]').parent().parent().addClass('hidden');
					}
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
				$('.price-group').on('click', '.remove-price-item', function(){
					var itemsCount = $(this).parent().parent().find('.price-item').length - 1;
					if ( itemsCount > 1 ) {
						$(this).parent().remove();
					}
				});
				$('.price-group').on('click', '.add-price-item', function(){
					var itemsCount = $(this).parent().parent().parent().find('.price-item').length - 1;
					if ( itemsCount < 4 ) {
						var html = '<div class="price-item"><input class="dolphron-elements" type="text" name="item_size[value][]" placeholder="Введите размер" data-de-label="Размер" required /><input class="dolphron-elements" type="text" name="item_size[price][]" placeholder="Введите цену" data-de-label="Цена" required /><a class="dolphron-elements button button_primary remove-price-item" style="margin-top: 44px; margin-bottom: 30px;"><i class="far fa-times"></i></a></div>';
						$('.price-group').append(html);
						var inputs = $('.price-item:last-child input.dolphron-elements');
						for ( var i = 0; i < inputs.length; i++ ) {
							dElementsRender(inputs[i]);
						}
					}
				});
			});
		</script>
	</body>
</html>