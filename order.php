<?php namespace App; require $_SERVER['DOCUMENT_ROOT'] . '/loader.php'; 

if( $_COOKIE['cart'] == '[]' ) {
	redirect('/');
}

$response = false;
$data = $_POST;

if( isset($data) && count($data) != 0 ) {
	$response = Controllers\User\Order::addOrder($data);
	if( $response['status'] == 'success' ) {
		$data = array();
	}
}

?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE; ?>">
	<head>
		<?php echo template_render('/widgets/main-block/head.php', [
				'SITENAME' => SITETITLE,
				'LOCALE' => LANGUAGE,
				'title' => 'Оформление заказа',
				'description' => '',
				'keywords' => '',
				'image' => '/assets/img/og_image_white.png',
				'curent_url' => '/order',
				'page_type' => 'website',
				'published' => '2020-10-01T00:00:00+03:00',
			]); ?>
	</head>
	<body>
		<div class="blackout hidden"></div>
		<?php echo template_render('/widgets/main-block/loader.php', [
			'SITENAME' => SITENAME
		]); ?>
		<?php echo template_render('/widgets/main-block/header.php', [
			'SITENAME' => SITENAME,
			'CONTACT_PHONE' => CONTACT_PHONE,
			'CONTACT_MAIL' => CONTACT_MAIL
		]); ?>
		<div id="app">
			<main class="main">
				<div class="content_position">
					<h2 class="contact_title">Оформление заказа</h2>
					<style>
						.order-page_block {
							display: grid;
							grid-gap: 20px;
							grid-template-columns: 1fr 300px;
							margin-bottom: 20px;
						}
						.order-page_checkout {
							position: relative;
							display: block;
							background: #F9F9F9;
							-webkit-box-shadow: 0px 20px 50px rgba(0, 0, 0, 0.3);
    					box-shadow: 0px 20px 50px rgba(0, 0, 0, 0.3);
						}
						li {
							background: url('/assets/img/point-checkout.svg');
							background-size: 10.5px;
						}
						li p span {
							background: #F9F9F9;
						}
						.order_input-group {
							display: grid;
							grid-template-columns: 1fr;
							grid-gap: 20px;
						}
						.order_input-group_div2 {
							display: grid;
							grid-template-columns: repeat(2, 1fr);
							grid-gap: 20px;
						}
						.order_input-group_div322 {
							display: grid;
							grid-template-columns: 3fr 2fr 2fr;
							grid-gap: 20px;
						}
						.order_input-group h4 {
							margin-bottom: 10px;
						}
						.order-page_info-auth {
							border: 1px solid #addaff;
    					background: #f0f8ff;
							padding: 20px;
							border-radius: 5px;
							margin-bottom: 20px;
						}
						.order-page_error {
							border: 1px solid #ffadad;
    					background: #fff0f0;
							padding: 20px;
							border-radius: 5px;
							margin-bottom: 20px;
						}
						.order-page_success {
							border: 1px solid #8bcf90;
    					background: #efffee;
							padding: 20px;
							border-radius: 5px;
							margin-bottom: 20px;
						}
						
						.order-page_error.hidden {
							display: none;
						}

						.order-page_info-auth a {
							text-decoration: none;
    					color: #f36638;
						}
						.order-page_info-auth a:hover {
							text-decoration: underline;
						}
						.auth_block {
							margin-top: 20px;
							display: none;
						}
						.auth_block.show {
							display: block;
						}
						@media (max-width: 900px) {
							.order-page_block {
								grid-template-columns: 1fr;
							}
						}
						@media (max-width: 600px) {
							.order_input-group_div322 {
								grid-template-columns: 1fr;
							}
						}
						@media (max-width: 500px) {
							.order_input-group_div2 {
								grid-template-columns: 1fr;
							}
						}
					</style>
					<div class="order-page_block">
						<form action="/order" method="post">

							<!-- <div class="order-page_info-auth">
								<p>У вас есть аккаунт? <a href="/signin">Авторизируйтесь</a> и прошлые данные автоматически подставятся!</p>
							</div> -->

							<?php if ($response !== false): ?>
							<div class="order-page_<?php echo($response['status']); ?>"><?php echo($response['message']); ?></div>
								<?php if($response['status'] == 'success'):?>
								<script>
									setTimeout(() => {
										set_cookie('cart', '[]');
										window.location.href = '/';
									}, 1000);
								</script>
								<?php endif; ?>
							<?php endif; ?>

							<div class="order_input-group">
								<div>
									<h4>Ваши контакты</h4>
									<div class="order_input-group_div2">
										<label class="order_input">
											<span class="icon"><i class="fas fa-user"></i></span>
											<input type="text" placeholder="Имя" name="name" required value="<?php if( isset($data['name']) ) { echo $data['name']; }?>">
										</label>
										<label class="order_input">
											<span class="icon"><i class="fas fa-phone"></i></span>
											<input type="text" placeholder="Телефон" name="phone" required value="<?php if( isset($data['phone']) ) { echo $data['phone']; }?>">
										</label>
									</div>
								</div>
								

								<div>
									<h4>Куда доставить ваш заказ?</h4>
									<div class="order_input-group_div322">
										<label class="order_input">
											<span class="icon"><i class="fas fa-map-marker-alt"></i></span>
											<input type="text" placeholder="Улица" name="street" required value="<?php if( isset($data['street']) ) { echo $data['street']; }?>">
										</label>
										<label class="order_input">
											<input type="text" placeholder="Дом" name="home" required value="<?php if( isset($data['home']) ) { echo $data['home']; }?>" style="padding-left: 30px;">
										</label>
										<label class="order_input">
											<input type="text" placeholder="Квартира" name="flat" required value="<?php if( isset($data['flat']) ) { echo $data['flat']; }?>" style="padding-left: 30px;">
										</label>
									</div>
								</div>

								<!-- <div class="ask_reg">
									<h4>Хотите зарегестрироваться?</h4>

									<div style="display: flex; flex-wrap: wrap;">
										<div class="input_checkbox" data-value="no" style="margin-right: 20px; cursor: pointer;">
											<span class="input_checkbox_icon checked"></span>
											<span>Нет</span>
										</div>
										<div class="input_checkbox" data-value="yes" style="cursor: pointer;">
											<span class="input_checkbox_icon"></span>
											<span>Да</span>
										</div> 
									</div>

									<div class="auth_block" style="padding: 20px; background: #f8f8f8; border: 2px solid #e9e9e9; border-radius: 5px;">
										<h4>Регистрация</h4>
										<div class="order_input-group_div2">
											<label class="order_input">
												<span class="icon"><i class="fas fa-at"></i></span>
												<input type="text" placeholder="E-amil" name="name">
											</label>
											<label class="order_input">
												<span class="icon"><i class="fas fa-unlock"></i></span>
												<input type="password" placeholder="Пароль" name="name">
											</label>
										</div>
									</div>
								</div>

								<div>
									<h4>Промокод</h4>
									<div>
										<label class="order_input">
											<span class="icon"><i class="fas fa-ticket-alt"></i></span>
											<input type="text" placeholder="Промокод" name="name">
										</label>
									</div>
								</div> -->

								<div>
									<h4>Примечание к заказу</h4>
									<div>
										<label class="order_input">
											<span class="icon"><i class="fas fa-comment"></i></span>
											<textarea type="text" placeholder="Примечание к вашему заказу, например, особые пожелания отделу доставки" name="comment"><?php if( isset($data['comment']) ) { echo $data['comment']; }?></textarea>
										</label>
									</div>
								</div>

								<div>
									<h4>Промокод</h4>
									<div>
										<label class="order_input">
											<span class="icon"><i class="fas fa-ticket-alt"></i></span>
											<input type="text" placeholder="Промокод" name="promo" value="<?php if( isset($data['promo']) ) { echo $data['promo']; }?>">
										</label>
									</div>
								</div>

								<style>
								/* .get-cash-info .input_checkbox .input_checkbox_icon {
									border-radius: 3px;
									width: 14px;
									height: 14px
								}
								.get-cash-info .input_checkbox .input_checkbox_icon.checked::before {
									border-radius: 2px;
									width: 8px;
									height: 8px
								} */
								</style>
								<div class="get-cash-info">
									<input type="hidden" name="payment" required value="<?php echo(isset($data['payment']) ? $data['payment'] : 'cash'); ?>">
									<div style="display: flex;flex-wrap: wrap;">
										<div class="input_checkbox" data-value="cash" style="margin-right: 20px; cursor: pointer;">
											<span class="input_checkbox_icon <?php if( isset($data['payment']) ) { if( $data['payment'] == 'cash') { echo 'checked'; }; } else { echo 'checked'; } ?>"></span>
											<span>Оплата наличными</span>
										</div>
										<div class="input_checkbox" data-value="card-courier" style="cursor: pointer;">
											<span class="input_checkbox_icon <?php if( isset($data['payment']) ) { if( $data['payment'] == 'card-courier' ) { echo 'checked'; }; }?>"></span>
											<span>Оплата картой курьеру</span>
										</div> 
									</div>
								</div>
								<div>
									<p>При нажатии на кнопку "Оформить заказ" вы даете согласие на обработку <a href="/privacy" target="_blank"> персональных данных</a></p>
								</div>
								<div>
									<button class="main-btn">Оформить заказ</button>
								</div>
								
							</div>
						</form>

						




						<div>
							<div class="order-page_checkout">
								<?php if($response['status'] == 'success'):?>
									<code style="padding: 20px;display: block;">
									<p style="text-align:center;"><?php echo SITENAME; ?></p>
									<br>
									<p style="text-align:center;">СПАСИБО ЗА ЗАКАЗ!</p>
									</code>
								<?php else:?>
								<code style="padding: 20px;display: block;">
									<p style="text-align:center; "><?php echo SITENAME; ?></p>
									<p style="text-align: center; padding-bottom: 10px; border-bottom-style: double; border-bottom-color: #d1d1d1;"></p>
									<ol style="margin-left: 30px; margin-top: 10px; margin-bottom: 10px;">
										<?php
										
										$countAllOrders = Controllers\User\Cart::getCartCount();
										$items = Controllers\User\Cart::getCart();

										$price = 0;
										if ( $countAllOrders > 0 ) {
											foreach ( $items as $item) {
												$price += ($item['cart_item_size']['size_price'] * $item['cart_item_count']);
												echo('<li>
												<p style="text-align: justify;"><span style="padding-right: 7px;">' . $item['item_name'] . '</span></p>
												<p><span style="padding-right: 7px;">' . $item['cart_item_size']['size_value'] . $item['item_category']['category_unit'] . ' Х ' . $item['cart_item_count'] . '</span></p>
												<p style="display: flex; justify-content: space-between;"><span style="padding-right: 7px;">Стоимость</span><span style="padding-left: 7px;">' . $item['cart_item_size']['size_price'] * $item['cart_item_count'] . 'р.</span></p>
											</li>');
											}
										}
										?>
									</ol>
									<p style="padding-top: 10px; border-top-style: double; border-top-color: #d1d1d1;display: flex; justify-content: space-between;"><span style="padding-right: 7px;"><b>Итого</b></span><span style="padding-left: 7px;"><?php echo $price; ?>р.</span></p>
								</code>
							</div>
							<?php endif; ?>
						</div>

					

				</div>
			</main>
			<?php echo template_render('/widgets/main-block/footer.php', [
				'SITENAME' => SITENAME,
				'CONTACT_PHONE' => CONTACT_PHONE,
				'CONTACT_MAIL' => CONTACT_MAIL
			]); ?>
		</div>
		<?php echo template_render('/widgets/main-block/scripts.php', []); ?>
		<script>
			$('.ask_reg .input_checkbox').click(function(){
				$('.ask_reg .input_checkbox_icon').removeClass('checked');
				$(this).children('.input_checkbox_icon').addClass('checked');
				if ( $(this).attr('data-value') == 'yes' ) {
					$('.auth_block').addClass('show');
				}
				else {
					$('.auth_block').removeClass('show');
				}
			});

			$('.get-cash-info .input_checkbox').click(function(){
				$('.get-cash-info .input_checkbox_icon').removeClass('checked');
				$(this).children('.input_checkbox_icon').addClass('checked');
				$('[name="payment"]').val($(this).attr('data-value'));
			});
		</script>
	</body>
</html>