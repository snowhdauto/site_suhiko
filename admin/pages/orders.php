<?php 
namespace App; 
require $_SERVER['DOCUMENT_ROOT'] . '/loader.php'; 
if(!isset($_SESSION['user'])) { redirect('/admin/login'); }

// Название страницы
$pageName = 'Заказы';
// Название страницы и её вложенность 
// &nbsp; - это код пробела
// Например
//$pageTree = 'Новости&nbsp;&nbsp;/&nbsp;&nbsp;Добавить новость';
$pageTree = 'Заказы';
$all_orders= Controllers\Admin\Orders::view();

function orderNumber($num) {
	$count = 11 - strlen($num);
	for ( $i = 0; $i < $count; $i++ ) { $num = '0' . $num; }
	return $num;
}

function statusName ($str) {
	if ( $str == 'new' ) { return 'Новый заказ'; }
	else if ( $str == 'cancelled' ) { return 'Заказ отменён'; }
	else if ( $str == 'delivery' ) { return 'Заказ в пути'; }
	else if ( $str == 'success' ) { return 'Выполнен'; }
	return $str;
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
					
						<div class="content_block">
							<!-- Начало страницы -->
							<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;flex-wrap: wrap;">
								<h1>Заказы</h1>
								<div class="dolphron-elements button button_accent" data-autoreload>Автообновление</div>
							</div>

								<style>
									.button.button_primary.order_status_success {	color: #33691E;	background: #AED581; }
									.button.button_primary.order_status_success:hover {	color: #33691E;	background: #9ac766; }
									
									.button.button_primary.order_status_new {	color: #0D47A1; background: #64B5F6; }
									.button.button_primary.order_status_new:hover {	color: #0D47A1;	background: #55a6e7; }
									
									.button.button_primary.order_status_cancelled {	color: #B71C1C; background: #E57373; }
									.button.button_primary.order_status_cancelled:hover {	color: #B71C1C; background: #EF5350; }
									
									.button.button_primary.order_status_delivery { color: #E65100; background: #FFB74D; }
									.button.button_primary.order_status_delivery:hover {	color: #E65100; background: #f2a83c; }
								</style>    
								<!-- НАЧАЛО ТАБЛИЦЫ -->
								<div class="table-wrapper dolphron-elements">
									<table>
										<thead>
											<tr>
												<th style="min-width: 100px">Номер заказа</th>
												<th style="min-width: 180px; max-width: 180px;">Общая информация</th>
												<th style="min-width: 180px; max-width: 180px;">Товары</th>
												<th style="min-width: 200px; max-width: 200px;">Статус заказа</th>
												<th style="min-width: 120px">Сумма заказа</th>
												<th style="min-width: 120px">Дата заказа</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($all_orders as $order): ?>
											<tr>
												<td><?php echo(orderNumber($order->order_id)); ?></td>
												<td><div class="dolphron-elements button button_primary" data-get-info="<?php echo($order->order_id); ?>">Смотреть</div></td>
												<td><div class="dolphron-elements button button_primary" data-get-items="<?php echo($order->order_id); ?>">Смотреть</div></td>
												<td><div class="dolphron-elements button button_primary order_status_<?php echo($order->order_status); ?>" data-get-status="<?php echo($order->order_id); ?>"><?php echo(statusName($order->order_status)); ?></div></td>
												<td><?php echo($order->order_summ); ?></td>
												<td><?php echo(date('d.m.Y', $order->order_date) . '<br>' . date('H:i:s', $order->order_date)); ?></td>
                                                
												<!--<td class="table_action_edit"><a href="/admin/categories/edit/<?php //echo($cat->category_id); ?>"><i class="fas fa-edit"></i></a></td>-->
												<!--<td class="table_action_delete"><a class="item_deleted" href="/admin/categories/del/<?php //echo($cat->category_id); ?>"><i class="fas fa-trash-alt"></i></a></td>-->
											</tr>

											<?php endforeach;?>
										</tbody>
									</table>
								</div> 
								<!-- КОНЕЦ ТАБЛИЦЫ -->
							</div>
						</div>

						<!-- Конец страницы -->
					</div>
				</div>
			</div>
		</div>

		<style>
			.modal-window-wrapper {
				position: fixed;
				top: 0;
				left: 0;
				z-index: 20;
				width: 100vw;
				height: 100vh;
				background: rgba(0, 0, 0, 0.3);
				display: flex;
				align-items: center;
			}
			.modal-window-wrapper.hidden {
				display: none;
			}
			.modal-window-cotainer {
				margin: 0 auto;
				padding: 50px 20px;
				width: 100%;
				max-width: 500px;
			}
			.modal-window-content{
				background: #ffffff;
				padding: 20px;
				border-radius: 10px;
				box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
				max-height: calc(100vh - 100px);
				overflow: auto;
			}
			.modal-window-content-title {
				margin-bottom: 20px;
			}
			.modal-window-content-footer {
				margin-top: 20px;
			}
			.order-group {
				display: grid;
				grid-gap: 20px;
			}
			.order-item {
				display: grid;
				grid-template-columns: 100px 1fr;
				grid-gap: 10px;
			}
			.order-item img {
				width: 100%;
			}
			.order-item span.deleted {
				color: #a8a8a8;
    		text-decoration: line-through;
			}
			@media(max-width:500px) {
				.order-item img {
					display: none;
				}
				.order-item {
					grid-template-columns: 1fr;
				}
			}
		</style>

		<div class="modal-window-wrapper hidden"> <!-- hidden -->
			<div class="modal-window-cotainer">
				<!-- 
				<div class="modal-window-content">
					<h2 class="modal-window-content-title">Новый заказ</h2>
					<div class="modal-window-content-block">
						<p>Поступил новый заказ!</p>
					</div>
					<div class="modal-window-content-footer">
						<div class="dolphron-elements button button_accent" data-close>ОК!</div>
					</div>
				</div> 
				-->
				
				<!-- 
				<div class="modal-window-content">
					<h2 class="modal-window-content-title">Изменить статус</h2>
					<div class="modal-window-content-block">
						<div class="dolphron-elements button button_primary order_status_new" data-order-id="@@@@" data-status-change="new">Новый заказ</div>
						<br>
						<div class="dolphron-elements button button_primary order_status_delivery" data-order-id="@@@@" data-status-change="delivery">Заказ в пути</div>
						<br>
						<div class="dolphron-elements button button_primary order_status_success" data-order-id="@@@@" data-status-change="success">Выполнен</div>
						<br>
						<div class="dolphron-elements button button_primary order_status_cancelled" data-order-id="@@@@" data-status-change="cancelled">Заказ отменён</div>
					</div>
					<div class="modal-window-content-footer">
						<div class="dolphron-elements button button_accent" data-close>Закрыть</div>
					</div>
				</div>
				-->

				<!-- <div class="modal-window-content">
					<h2 class="modal-window-content-title">Основная информация</h2>
					<div class="modal-window-content-block">
						<p><b>Покупатель: </b> Никита</p>
						<p><b>Номер телефона: </b> +79875431025</p>
						<p><b>Улица: </b> Рождественская</p>
						<p><b>Дом: </b> 8</p>
						<p><b>Квартира: </b> 8</p>
						<p><b>Примечание: </b> Позвоните за 10 минут до приезда!</p>
						<p><b>Оплата: </b> Картой курьеру</p>
					</div>
					<div class="modal-window-content-footer">
						<div class="dolphron-elements button button_accent" data-close>Закрыть</div>
					</div>
				</div> -->

				<!-- <div class="modal-window-content">
					<h2 class="modal-window-content-title">Список товаров</h2>
					<div class="modal-window-content-block">
						<div class="order-group">
							<div class="order-item">
								<img src="/assets/img/pizza.png" alt="">
								<div>
									<h4>Название Х 3</h4>
									<p>Стандартное тесто, размер 25см.</p>
									<p>
										<span class="deleted">asd</span>
										<span class="deleted">asd</span>
										<span class="deleted">asd</span>
									</p>
									<h4>200 руб.</h4>
								</div>
							</div>
							<div class="order-item">
								<img src="/assets/img/pizza.png" alt="">
								<div>
									<h4>Название Х 1</h4>
									<p>Стандартное тесто, размер 25см.</p>
									<p>
										<span class="deleted">asd</span>
										<span class="deleted">asd</span>
										<span class="deleted">asd</span>
									</p>
									<h4>200 руб.</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-window-content-footer">
						<div class="dolphron-elements button button_accent" data-close>Закрыть</div>
					</div>
				</div> -->

			</div>
		</div>

		<?php echo template_render('/admin/widgets/main-block/scripts.php', []); ?>
		<script>
		$(document).ready(function(){			
			var audio = new Audio('/assets/notify_main.mp3');

			$('a.item_deleted').click(function(){
				var q = confirm('Вы точно хотите удалить запись?');
				return q;
			});

			$('.modal-window-wrapper').on('click', '[data-close]', function(){
				$('.modal-window-wrapper').addClass('hidden');
				audio.pause();
				audio.currentTime = 0;
			});

			$('.table-wrapper').on('click', '[data-get-info]', function(){
				var itemId = $(this).attr('data-get-info');
				$.ajax({
					url: '/ajax.php',
					method: 'post',
					dataType: 'json',
					data: { action: 'getOrderInfo', id: itemId },
					success: function(data){
						if (data.status == 'success') {
							function paymentName(str) {
								if (str == 'card-courier') { return 'Оплата картой курьеру'; }
								else if (str == 'cash') { return 'Оплата наличными'; }
								return str;
							}
							html = '<div class="modal-window-content"><h2 class="modal-window-content-title">Основная информация</h2><div class="modal-window-content-block"><p><b>Покупатель: </b> ' + data.data.order_user_name + '</p><p><b>Номер телефона: </b> ' + data.data.order_user_phone + '</p><p><b>Улица: </b> ' + data.data.order_user_street + '</p><p><b>Дом: </b> ' + data.data.order_user_home + '</p><p><b>Квартира: </b> ' + data.data.order_user_flat + '</p><p><b>Примечание: </b> ' + data.data.order_comments + '</p><p><b>Промокод: </b> ' + data.data.order_promo + '</p><p><b>Оплата: </b> ' + paymentName(data.data.order_payment) + '</p></div><div class="modal-window-content-footer"><div class="dolphron-elements button button_accent" data-close>Закрыть</div></div></div>';
							$('.modal-window-wrapper .modal-window-cotainer').empty();
							$('.modal-window-wrapper .modal-window-cotainer').append(html);
							$('.modal-window-wrapper').removeClass('hidden');
						} 
						else {
							console.error(data.text);
						}
					},
					error: function(data){
						console.error('Opps... Error getting data. Please refresh the page.');
					}
				});
			});

			$('.table-wrapper').on('click', '[data-get-items]', function(){
				var itemId = $(this).attr('data-get-items');
				$.ajax({
					url: '/ajax.php',
					method: 'post',
					dataType: 'json',
					data: { action: 'getOrderItems', id: itemId },
					success: function(data){
						if (data.status == 'success') {
							html = '<div class="modal-window-content"><h2 class="modal-window-content-title">Список товаров</h2><div class="modal-window-content-block"><div class="order-group">';
							for( var i = 0; i < data.data.length; i++ ){
								html += '<div class="order-item">';
									html += '<img src="' + data.data[i].oitem_image + '" alt="">';
									html += '<div>';
										html += '<h4>' + data.data[i].oitem_name + ' Х ' + data.data[i].oitem_count + '</h4>';
										html += '<p>';
										if ( data.data[i].oitem_category_value == 'pizza' ) {
											if ( data.data[i].oitem_dough == 'standart' ) { html += 'Стандартное тесто'; }
											else if ( data.data[i].oitem_dough == 'slim' ) { html += 'Тонкое тесто'; }
											html += ', р';
										}
										else {
											html += 'Р';
										}
										html += 'азмер ' + data.data[i].oitem_size + '</p>';
										if ( data.data[i].oitem_category_value == 'pizza' && data.data[i].oitem_deleted != '' ) {
											html += '<p><b>Удалённые ингредиенты:</b> ' + data.data[i].oitem_deleted + '</p>';
										}
										html += '<h4>' + data.data[i].oitem_price + ' руб.</h4>';
									html += '</div>';
								html += '</div>';
							}
							html += '</div></div><div class="modal-window-content-footer"><div class="dolphron-elements button button_accent" data-close>Закрыть</div></div></div>';
							$('.modal-window-wrapper .modal-window-cotainer').empty();
							$('.modal-window-wrapper .modal-window-cotainer').append(html);
							$('.modal-window-wrapper').removeClass('hidden');
						} 
						else {
							console.error(data.text);
						}
					},
					error: function(data){
						console.error('Opps... Error getting data. Please refresh the page.');
					}
				});
			});

			$('.table-wrapper').on('click', '[data-get-status]', function(){
				var itemId = $(this).attr('data-get-status');
				html = '<div class="modal-window-content"><h2 class="modal-window-content-title">Изменить статус</h2><div class="modal-window-content-block"><div class="dolphron-elements button button_primary order_status_new" data-order-id="' + itemId + '" data-status-change="new">Новый заказ</div><br><div class="dolphron-elements button button_primary order_status_delivery" data-order-id="' + itemId + '" data-status-change="delivery">Заказ в пути</div><br><div class="dolphron-elements button button_primary order_status_success" data-order-id="' + itemId + '" data-status-change="success">Выполнен</div><br><div class="dolphron-elements button button_primary order_status_cancelled" data-order-id="' + itemId + '" data-status-change="cancelled">Заказ отменён</div></div><div class="modal-window-content-footer"><div class="dolphron-elements button button_accent" data-close>Закрыть</div></div></div> ';
				$('.modal-window-wrapper .modal-window-cotainer').empty();
				$('.modal-window-wrapper .modal-window-cotainer').append(html);
				$('.modal-window-wrapper').removeClass('hidden');
			});

			$('.modal-window-wrapper').on('click', '[data-status-change]', function(){
				var itemId = $(this).attr('data-order-id');
				var newStatus = $(this).attr('data-status-change');
				$.ajax({
					url: '/ajax.php',
					method: 'post',
					dataType: 'json',
					data: { action: 'changeOrderStatus', id: itemId, new: newStatus },
					success: function(data){
						if (data.status == 'success') {
							function statusName (str) {
								if ( str == 'new' ) { return 'Новый заказ'; }
								else if ( str == 'cancelled' ) { return 'Заказ отменён'; }
								else if ( str == 'delivery' ) { return 'Заказ в пути'; }
								else if ( str == 'success' ) { return 'Выполнен'; }
								return str;
							}
							$('[data-get-status="' + itemId + '"]').removeClass('order_status_new');
							$('[data-get-status="' + itemId + '"]').removeClass('order_status_cancelled');
							$('[data-get-status="' + itemId + '"]').removeClass('order_status_delivery');
							$('[data-get-status="' + itemId + '"]').removeClass('order_status_success');
							$('[data-get-status="' + itemId + '"]').addClass('order_status_' + newStatus);
							$('[data-get-status="' + itemId + '"]').empty();
							$('[data-get-status="' + itemId + '"]').append(statusName(newStatus));
							$('.modal-window-wrapper').addClass('hidden');
						} 
						else {
							console.error(data.text);
						}
					},
					error: function(data){
						console.error('Opps... Error getting data. Please refresh the page.');
					}
				});
			});

			var TimeData = 0;
			function TimeUpdate() {
				TimeData = Math.floor(Date.now() / 1000);
			}
			TimeUpdate();
			function newOrders() {
				$('.modal-window-wrapper').addClass('hidden');
				$('.modal-window-wrapper .modal-window-cotainer').empty();
				html = '<div class="modal-window-content"><h2 class="modal-window-content-title">Новый заказ</h2><div class="modal-window-content-block"><p>Поступил новый заказ!</p></div><div class="modal-window-content-footer"><div class="dolphron-elements button button_accent" data-close>ОК!</div></div></div> ';
				$('.modal-window-wrapper .modal-window-cotainer').append(html);
				$('.modal-window-wrapper').removeClass('hidden');
				audio.play();
			}

			$('.button_accent[data-autoreload]').click(function(){
				$(this).removeClass('button_accent');
				$(this).addClass('button_disabled');
				setInterval(() => {
					$.ajax({
						url: '/ajax.php',
						method: 'post',
						dataType: 'json',
						data: { action: 'newOrders', date: TimeData },
						success: function(data){
							if (data.status == 'success') {
								if ( data.data.length != 0 ) {
									function orderNumber(num) {
										count = 11 - num.length;
										for ( var i = 0; i < count; i++ ) { num = '0' + num; }
										return num;
									}

									function statusName (str) {
										if ( str == 'new' ) { return 'Новый заказ'; }
										else if ( str == 'cancelled' ) { return 'Заказ отменён'; }
										else if ( str == 'delivery' ) { return 'Заказ в пути'; }
										else if ( str == 'success' ) { return 'Выполнен'; }
										return str;
									}

									format = function date2str(x, y) {
										var z = {
												M: x.getMonth() + 1,
												d: x.getDate(),
												h: x.getHours(),
												m: x.getMinutes(),
												s: x.getSeconds()
										};
										y = y.replace(/(M+|d+|h+|m+|s+)/g, function(v) {
												return ((v.length > 1 ? "0" : "") + eval('z.' + v.slice(-1))).slice(-2)
										});

										return y.replace(/(y+)/g, function(v) {
												return x.getFullYear().toString().slice(-v.length)
										});
									};
									
									function dateFormat(num) {
										var date = new Date(num * 1000);
										return format(date, 'dd.MM.yyyy') + '<br>' + format(date, 'hh:mm:ss');
									}
									var html = '';

									for ( var i = 0; i < data.data.length; i++ ) {
										html += '<tr><td>' + orderNumber(data.data[i].order_id) + '</td><td><div class="dolphron-elements button button_primary" data-get-info="' + data.data[i].order_id + '">Смотреть</div></td><td><div class="dolphron-elements button button_primary" data-get-items="' + data.data[i].order_id + '">Смотреть</div></td><td><div class="dolphron-elements button button_primary order_status_' + data.data[i].order_status + '" data-get-status="' + data.data[i].order_id + '">' + statusName(data.data[i].order_status) + '</div></td><td>' + data.data[i].order_summ + '</td><td>' + dateFormat(data.data[i].order_date) + '</td></tr>';
									}
									$('.table-wrapper tbody').prepend(html);

									newOrders();
									TimeUpdate();
								}
							} 
							else {
								console.error(data.text);
							}
						},
						error: function(data){
							console.error('Opps... Error getting data. Please refresh the page.');
						}
					});
				}, 5000);
			});
		});
		</script>
	</body>
</html>