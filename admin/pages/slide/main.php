<?php 
namespace App; 
require $_SERVER['DOCUMENT_ROOT'] . '/loader.php'; 
if(!isset($_SESSION['user'])) { redirect('/admin/login'); }

// Название страницы
$pageName = 'Слайдер';
// Название страницы и её вложенность 
// &nbsp; - это код пробела
// Например
//$pageTree = 'Новости&nbsp;&nbsp;/&nbsp;&nbsp;Добавить новость';
$pageTree = 'Слайдер';
$all_slide= Controllers\Admin\Slide::view();

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
							
							<h1>Все слайды</h1>

							<!-- НАЧАЛО ТАБЛИЦЫ -->
							<div class="table-wrapper dolphron-elements">
								<table>
									<thead>
										<tr>
											<th style="min-width: 180px">Название слайда</th>
											<th style="min-width: 400px">Фотография</th>
											<th style="min-width: 90px" colspan="2">Действия</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($all_slide as $slide): ?>
										<tr>
											<td><?php echo($slide->slide_name); ?></td>
											<td><img src="<?php echo($slide->slide_image);?>" style="width: 600px; height: 200px; object-fit: cover;"></td>
											<!--<td class="table_action_edit"><a href="/admin/slide/edit/"><i class="fas fa-edit"></i></a></td>-->
											<td class="table_action_delete"><a class="item_deleted" href="/admin/slide/del/<?php echo($slide->slide_id); ?>"><i class="fas fa-trash-alt"></i></a></td>
										</tr>

										<?php endforeach;?>
									</tbody>
								</table>
							</div> 
							<!-- КОНЕЦ ТАБЛИЦЫ -->
						</div>


						<!-- Конец страницы -->
					</div>
				</div>
			</div>
		</div>

		<?php echo template_render('/admin/widgets/main-block/scripts.php', []); ?>
		<script>
		$('a.item_deleted').click(function(){
			var q = confirm('Вы точно хотите удалить запись?');
			return q;
		});
		</script>
	</body>
</html>