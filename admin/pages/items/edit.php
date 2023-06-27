<?php 
namespace App; 
require $_SERVER['DOCUMENT_ROOT'] . '/loader.php'; 
if(!isset($_SESSION['user'])) { redirect('/admin/login'); }

// Название страницы 
$pageName = 'Редактировать товар';
// Название страницы и её вложенность 
// &nbsp; - это код пробела
// Например
//$pageTree = 'Новости&nbsp;&nbsp;/&nbsp;&nbsp;Добавить новость';
$pageTree = 'Товары&nbsp;&nbsp;/&nbsp;&nbsp;Редактировать товар';

if(isset($_GET['id'])) { 
	$id = $_GET['id'];
	$post= Controllers\Admin\Item::getOne($id);
	if(count($post)>0){
			$post=$post[0];
	}
	else{
			redirect('/admin/items/main');
	}
}
else if (isset($_POST)) {
	$postData = $_POST;
	if ( isset($postData) && count($postData) != 0 ) {
			$image = $postData['imageSRC'];
			if( $postData['imageSRC'] == 'false' ){
					$file = $_FILES['image'];
					$image = Controllers\Admin\Image::load($file);
			}
			if ( $image ) {
					Controllers\Admin\Item::edit($postData, $image);
					//redirect('/admin/articles/'.$postData['article_type']);
			} 
			redirect('/admin/items/edit/'.$postData['id']);
	}
}
else {
	redirect('/admin/items/main'); 
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
							
							<h1>Редактировать товар</h1>

							<form action="/admin/items/edit" method="post" enctype="multipart/form-data">
								<input type="hidden" name="id" value="<?php echo($id); ?>">
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
											<option <?php if ($post->item_category_id == $item->category_id) { echo('selected'); } ?> value="<?php echo($item->category_id); ?>" data-category-name="<?php echo($item->category_value); ?>" data-category-unit="<?php echo($item->category_unit); ?>"><?php echo($item->category_value_ru); ?></option>
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
											value="<?php echo($post->item_name); ?>"
										/>

										<input 
											class="dolphron-elements"
											type="text"
											name="item_prefix"
											placeholder="Введите префикс" 
											data-de-label="Префик" 
											data-de-maxlength="70"
											value="<?php echo($post->item_prefix); ?>"
										/>
										<div class="item_dough <?php echo( ( $post->item_category_id == 1 ) ? '' : 'hidden' ); ?>">
											<select
												class="dolphron-elements" 
												type="text" 
												name="item_dough" 
												data-de-label="Размер теста" 
												required
											>
												<option <?php if ($post->item_dough == 'all') { echo('selected'); } ?> value="all">Все</option>
												<option <?php if ($post->item_dough == 'standart') { echo('selected'); } ?> value="standart">Стандартное</option>
												<option <?php if ($post->item_dough == 'slim') { echo('selected'); } ?> value="slim">Тонкая</option>
											</select>
										</div>
										
									</div>

									<div class="add_articles_image-container">
                    <input type="hidden" name="imageSRC" value="<?php echo($post->item_image);?>">
										<p>Изображение</p>
										<label class="image-container_button hidden">
											<input type="file" id="image" name="image">
											<div class="dolphron-elements button button_primary">Добавить картинку</div>
											<img src="<?php echo($post->item_image);?>" id="imageIMG" alt="">
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
								><?php echo($post->item_description); ?></textarea>
								
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
								<?php for ( $i = 1; $i <= 4; $i++ ): ?>
								<?php 
								$var_val = 'item_size' . $i . '_value'; 
								$var_cost = 'item_size' . $i . '_cost'; 
								if ( $post->$var_val != NULL ): 
								?>
								<div class="price-item">

									<input 
										class="dolphron-elements" 
										type="text" 
										name="item_size[value][]" 
										placeholder="Введите размер" 
										data-de-label="Размер"
										required
										value="<?php echo( $post->$var_val ); ?>"
									/>

									<input 
										class="dolphron-elements" 
										type="text" 
										name="item_size[price][]" 
										placeholder="Введите цену" 
										data-de-label="Цена"
										required
										value="<?php echo( $post->$var_cost ); ?>"
									/>

									<a class="dolphron-elements button button_primary remove-price-item" style="margin-top: 44px; margin-bottom: 30px;"><i class="far fa-times"></i></a>
								</div>
								<?php endif; ?>
								<?php endfor; ?>
								</div>


								<button class="dolphron-elements button button_accent" >Сохранить</button>
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
					$('[name="imageSRC"]').val('false');
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