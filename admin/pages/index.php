<?php 
namespace App; 
require $_SERVER['DOCUMENT_ROOT'] . '/loader.php'; 
if(!isset($_SESSION['user'])) { redirect('/admin/login'); }

// Название страницы
$pageName = 'Главная';
// Название страницы и её вложенность 
// &nbsp; - это код пробела
// Например
//$pageTree = 'Новости&nbsp;&nbsp;/&nbsp;&nbsp;Добавить новость';
$pageTree = 'Главная';

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

						<?php 
							$view_all_orders=Controllers\Admin\Statistics::view_all_orders()[0]['count'];
							$view_all_sum_orders = Controllers\Admin\Statistics::view_all_sum_orders()[0]['summ'];
							$view_cur_orders=Controllers\Admin\Statistics::view_cur_orders()[0]['count'];
							$view_cur_sum_orders = Controllers\Admin\Statistics::view_cur_sum_orders()[0]['summ'];
						?>
						<style>
							.stat-group {
								display: grid;
								grid-template-columns: 1fr 1fr 1fr 1fr;
								grid-gap: 20px;
								margin-top: 30px;
							}
							.stat-item {
								background: #fff;
								box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
								padding: 20px;
								border-radius: 10px;
								-webkit-border-radius: 10px;
								-moz-border-radius: 10px;
								-ms-border-radius: 10px;
								-o-border-radius: 10px;
								position: relative;
							}
							.stat-item p {
								margin-bottom: 60px;
							}
							.stat-item p span {
								color: #9f040c;
								font-size: 0.9rem;
							}
							.stat-item h2 {
								position: absolute;
								bottom: 15px;
								right: 20px;
							}
							@media (max-width: 1200px) {
								.stat-group {
									grid-template-columns: 1fr 1fr;
								}
							}
							@media (max-width: 500px) {
								.stat-group {
									grid-template-columns: 1fr;
								}
							}
						</style>
						<div class="stat-group">
							<div class="stat-item">
								<p>Количество заказов<br><span>весь период</span></p>
								<h2><?php echo $view_all_orders; ?></h2>
							</div>
							<div class="stat-item">
								<p>Сумма заказов<br><span>весь период</span></p>
								<h2><?php echo(($view_all_sum_orders == NULL) ? 0 : $view_all_sum_orders); ?></h2>
							</div>
							<div class="stat-item">
								<p>Количество заказов<br><span>текущий месяц</span></p>
								<h2><?php echo $view_cur_orders; ?></h2>
							</div>
							<div class="stat-item">
								<p>Сумма заказов<br><span>текущий месяц</span></p>
								<h2><?php echo(($view_cur_sum_orders == NULL) ? 0 : $view_cur_sum_orders); ?></h2>
							</div>
						</div>

						<div class="content_block">
							<h2>Статистика по месяцам</h2>
							
							<canvas id="myChart"></canvas>
							</div> 
							<!-- КОНЕЦ ТАБЛИЦЫ -->
						</div>


						
						<!-- Конец страницы -->
					</div>
				</div>
			</div>
		</div>

		<?php echo template_render('/admin/widgets/main-block/scripts.php', []); ?>
		
		<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script><script>
		// var editor = new MediumEditor('.editable');
		// Получить содержимое $ editor.getContent()
		// $('form').submit(function(){
		// 	var content = editor.getContent();
		// 	$('[name="content"]').vla(content);
		// });
		var ctx = document.getElementById('myChart').getContext('2d');
		var chart = new Chart(ctx, {
			// The type of chart we want to create
			type: 'line',
			<?php 
			$chart = Controllers\Admin\Statistics::getChartData();
			?>
			// The data for our dataset
			data: {
					labels: ['<?php echo implode('\', \'', $chart['labels']); ?>'],
					datasets: [{
							label: 'Доход (руб.)',
							backgroundColor: 'rgb(255, 99, 132)',
							borderColor: 'rgb(255, 99, 132)',
							data: [<?php echo implode(', ', $chart['data']); ?>]
					}]
			},

			// Configuration options go here
			options: {}
		});
		</script>
	</body>
</html>