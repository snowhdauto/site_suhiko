<?php namespace App; require $_SERVER['DOCUMENT_ROOT'] . '/loader.php'; ?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE; ?>">
	<head>
		<?php echo template_render('/widgets/main-block/head.php', [
				'SITENAME' => SITETITLE,
				'LOCALE' => LANGUAGE,
				'title' => 'Контакты',
				'description' => 'Заказать роллы и другие блюда японской кухни Вы можете, позвонив по телефону: +7 (953) 555-46-40 Заказы принимаются пн-чт с 11:30...',
				'keywords' => '',
				'image' => '/assets/img/og_image_white.png',
				'curent_url' => '/contact',
				'page_type' => 'article',
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

					<div class="contact_left">
						<div>
							<h2 class="contact_title">Контакты</h2>
							<div class="contact_block">
								<p>Если у тебя возникли вопросы, ты можешь написать нам сообщение на почту и мы обязательно на него ответим, а также можешь позвонить по телефону. </p>
								<p><i class="far fa-map-marker-alt"></i>&nbsp;&nbsp; <?php echo CONTACT_ADDRESS; ?></p>
								<p><a href="mailto:<?php echo CONTACT_MAIL; ?>"><i class="far fa-envelope"></i>&nbsp;&nbsp; <?php echo CONTACT_MAIL; ?></a></p>
								<p><a href="tel:<?php echo CONTACT_PHONE; ?>"><i class="far fa-phone"></i>&nbsp;&nbsp; <?php echo phoneFormat(CONTACT_PHONE); ?></a></p>
							</div>
						</div>
						<div>
							<h2 class="contact_title">Режим работы</h2>
							<div class="contact_block">
								<table class="contact_table">
									<tr>
										<td>ПН-ЧТ</td>
										<td>с 09:00 до 23:00</td>
									</tr>
									<tr>
										<td>ПТ-СБ</td>
										<td>с 09:00 до 01:00</td>
									</tr>
									<tr>
										<td>ВС</td>
										<td>с 13:00 до 23:00</td>
									</tr>
								</table>
							</div>
						</div>
					</div>

					<style>
						.contact_block_last h3,
						.contact_block_last h4,
						.contact_block_last p {
							margin-bottom: 10px;
						}
						.contact_block_last ol, .contact_block_last ul {
							margin-left: 20px;
							margin-bottom: 10px;
						}
						.contact_block_last a{
							color: #050505;
							text-decoration: none;
							transition: 0.2s color;
						}
						.contact_block_last a:hover{
							color: #fc9c20;
						}
						.cb-content-top {
							display: grid; grid-template-columns: 1fr 300px; grid-gap: 20px;
						}
						.cb-content-top img {
							width: 100%;
						}
						@media (max-width: 768px) {
							.cb-content-top { grid-template-columns: 1fr 200px; }
						}
						@media (max-width: 600px) {
							.cb-content-top { grid-template-columns: 1fr; }
						}
					</style>
					<div class="contact_block_last" style="margin-bottom: 20px;">
						<h2 class="contact_title">Доставка и оплата</h2>
						<div class="contact_block">
							<div class="cb-content-top">
								<div>
									<p>Заказать роллы и другие блюда японской кухни Вы можете, позвонив по телефону: <a href="tel:<?php echo CONTACT_PHONE; ?>"><?php echo phoneFormat(CONTACT_PHONE); ?></a></p>
									<p>Заказы принимаются:</p>
									<ul>
									<li>ПН-ЧТ с 11:30 до 21:30</li>
									<li>ПТ-ВС с 11:30 до 21:30</li>
									</ul>
								</div>
								<div style="margin-bottom: 20px;">
									<img src="/assets/img/Lexus-300x92.png" alt="">
								</div>
							</div>
							<p>Бесплатная доставка в Ленинском районе осуществляется при заказе от 500 рублей</p>
							<p>Другие направления: районы, посёлки и.т.д уточняйте по телефону <a href="tel:<?php echo CONTACT_PHONE; ?>"><?php echo phoneFormat(CONTACT_PHONE); ?></a></p>
							<p>Время доставки — в течение 1 часа. В зависимости от загруженности дорог и кухни, время может быть увеличено.</p>
							<p>Способы оплаты: наличными курьеру, банковской картой курьеру, он-лайн оплата на карту Сбербанка</p>
							<p>Просим обратить Ваше внимание на то, что японская кухня имеет свои пищевые особенности. Компания «СУШИ&KO…» не несет ответственности за возможные аллергические реакции организма на некоторые ингредиенты, входящие в состав блюда!</p>
							<p>Роллы, как и любое блюдо, имеет ограниченный срок хранения. Если вы решили отложить употребление, то необходимо хранить блюдо не более 4-х часов.</p>
							<h3>Условия заказа через наш Интернет сайт</h3>
							<ol>
							<li>После заказа через Интернет в течение 10 минут с Вами свяжется наш оператор и уточнит информацию о заказе.</li>
							<li>В случае, если в течении 10 минут с Вами не связались наши операторы (по причине не правильного ввода данных, сбой в работе Интернет-провайдера и т.д.), рекомендуем Вам самим позвонить нам по телефону <a href="tel:<?php echo CONTACT_PHONE; ?>"><?php echo phoneFormat(CONTACT_PHONE); ?></a> и уточнить статус Вашего заказа.</li>
							<li>Все претензии по качеству приготовленной продукции адресовать по телефону заказа <a href="tel:<?php echo CONTACT_PHONE; ?>"><?php echo phoneFormat(CONTACT_PHONE); ?></a> или на электронный ящик <a href="mailto:<?php echo CONTACT_MAIL; ?>"><?php echo CONTACT_MAIL; ?></a>.</li>
							</ol>
							<br>
							<h4 style="text-align:center">ЖЕЛАЕМ ВАМ ПРИЯТНОГО АППЕТИТА!</h4>
						</div>
					</div>


					<!-- <div class="contact_right">
						<h2 class="contact_title">Область доставки</h2>
						<iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Ad081e2c9e879aaf3bd8e55db312ca87f4280e8af30f21b14a785150daa3fdc33&amp;source=constructor" width="100%" height="500" frameborder="0"></iframe>
					</div> -->
					
					
				</div>
			</main>
			<?php echo template_render('/widgets/main-block/footer.php', [
				'SITENAME' => SITENAME,
				'CONTACT_PHONE' => CONTACT_PHONE,
				'CONTACT_MAIL' => CONTACT_MAIL
			]); ?>
		</div>
		<?php echo template_render('/widgets/main-block/scripts.php', []); ?>
	</body>
</html>