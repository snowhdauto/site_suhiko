<?php namespace App; require $_SERVER['DOCUMENT_ROOT'] . '/loader.php'; ?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE; ?>">
	<head>
		<?php echo template_render('/widgets/main-block/head.php', [
				'SITENAME' => SITETITLE,
				'LOCALE' => LANGUAGE,
				'title' => 'Меню',
				'description' => 'Заказ суши, роллов, китайской лапши WOK, плова в Нижнем Новгороде по доступным ценам. Быстрая бесплатная доставка на дом и в офис. Акции, скидки, подарки и бонусы! ... Доставка заказа в течение 50-70 минут (точное время доставки уточняйте у оператора). Прием заказов: с 11:30 до 21:30',
				'keywords' => '',
				'image' => '/assets/img/og_image_white.png',
				'curent_url' => '/',
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
					<?php 
					$slidesCount = Controllers\User\Slide::getSlidesCount();
					if ( $slidesCount > 0 ) {
						echo template_render('/widgets/index-slider.php', [
							'items' => Controllers\User\Slide::getSlides()
						]); 
					} 
					?>
					<section class="main_menu">
						<div class="menu_header">
							<h2>Товары</h2>
							<div class="menu_filter">
								<!-- <span class="menu_cat active" data-filter="all">Всё</span> -->
								<?php
									$firstCat = 'all';
									$categoriesCount = Controllers\User\Category::getCategoriesCount();
									if ( $categoriesCount > 0 ) {
										$catLists = Controllers\User\Category::getCategories();
										$firstCat = $catLists[0]->category_value;
										foreach ( $catLists as $cat ) {
											echo('<span class="menu_cat ' . (($firstCat == $cat->category_value) ? 'active' : '') . '" data-filter="' . $cat->category_value . '">' . $cat->category_value_ru . '</span>');
										}
									}
								?>
								<div class="pc-btn">
									<div class="menu_cat_more">Ещё...</div>
									<div class="block_hiddenItem">
										<div class="hiddenItem"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="menu_content">
							<?php
								$limitCount = 8;
								$countAllProducts = Controllers\User\Item::getItemsCount($firstCat);
								if ( $countAllProducts > 0 ) {
									$items = Controllers\User\Item::getItems($firstCat, array('item_date', 'DESC'), $limitCount, 0);
									foreach ($items as $item) {
										echo template_render('/widgets/index-menu-item.php', ['item' => $item]); 
									}
								}
								else {
									echo '<p>Товары отсутствуют...</p>';
								}
							?>
						</div>


						<div style="text-align: center; margin: 60px 0px;">
							<a class="main-btn loadmore<?php if ( $countAllProducts <= $limitCount ) { echo ' hidden'; } ?>"></a>
						</div>


					</section>
				</div>
			</main>
			<?php echo template_render('/widgets/main-block/footer.php', [
				'SITENAME' => SITENAME,
				'CONTACT_PHONE' => CONTACT_PHONE,
				'CONTACT_MAIL' => CONTACT_MAIL
			]); ?>
		</div>
		<?php echo template_render('/widgets/main-block/scripts.php', []); ?>
		<script type="text/javascript">
			var slider = new Swiper('.slider-container', {
				loop: true,
				autoplay: {
					delay: 6000,
					disableOnInteraction: false,
				},
				navigation: {
					nextEl: '.slider-button-next',
					prevEl: '.slider-button-prev',
				},
			});
			
			$('.menu_content').on('click', '[data-size]', function(){
				var newPrice = $(this).attr('data-price');
				$(this).parent().parent().parent().find('.menu_item_price span').html(newPrice);
				$(this).parent().find('.active').removeClass('active');
				$(this).addClass('active');
				checkInCart($(this).parent().parent().parent().parent()[0]);
			});
			
			$('.menu_content').on('click', '.menu_item_doughs span', function(){
				$(this).parent().find('span').each(function(){
					$(this).removeClass('active');
				});
				$(this).addClass('active');
				checkInCart($(this).parent().parent().parent().parent()[0]);
			});
			
			$('.menu_content').on('click', '.menu_item_info', function(){
				$(this).parent().parent().addClass('blur');
				$(this).parent().parent().parent().find('.menu_item_description').removeClass('hidden');
			});

			$('.menu_content').on('click', '.menu_item_description_close', function(){
				$(this).parent().parent().find('.menu_item_content').removeClass('blur');
				$(this).parent().addClass('hidden');
			});
			
			
			$('.menu_content').on('click', '.menu_item_ingredients .changing', function(){
				$(this).toggleClass('deleted');
				checkInCart($(this).parent().parent().parent()[0]);
			});

			$('.menu_cat_more').click(function(){
				if($('.pc-btn').hasClass('show')){
					$('.pc-btn').removeClass('show');
				}
				else {
					$('.pc-btn').addClass('show');
				}
			});

			var mainMenu = '.menu_filter';
			var hideMenu = '.hiddenItem';
			var hideMenuWrapper = '.pc-btn';
			
			function hideElem(elem){
				$(elem).css({opacity: '0'})
					.detach()
					.prependTo(hideMenu)
					.stop().animate({
						'opacity': 1
					}, 300);
			};
			function showElem(elem){
				var hideElements = $(hideMenuWrapper);
				$(elem).css({opacity: '0'})
					.detach()
					.appendTo(mainMenu)
					.stop().animate({
						'opacity': 1
					}, 300);
				$(hideElements).appendTo(mainMenu);
			};
			function menu(){
				var widthElMainMenu = 0;
				var voidWidth = $(mainMenu).parent().width() - $(mainMenu).parent().children('h2').width();

				if ($(window).width() >= 1024) {
					$('.menu_cat_more').empty();
					$('.menu_cat_more').append('Ещё...');
					$(mainMenu + ' > .menu_cat').each(function(){
						widthElMainMenu += $(this).width() + 40;
					});

					if(voidWidth < widthElMainMenu + 80 && voidWidth > 80){
						while(voidWidth < widthElMainMenu + 80){
							hideElem($(mainMenu + ' > .menu_cat')[$(mainMenu + ' > .menu_cat').length - 1]);
							widthElMainMenu = 0;
							$(mainMenu + ' > .menu_cat').each(function(){
								widthElMainMenu += $(this).width() + 40;
							});
						}
					} 
					else{
						if(widthElMainMenu + $(hideMenu + ' > .menu_cat:first-child').text().length * 10 + 150 < voidWidth){
							showElem($(hideMenu + ' > .menu_cat')[0]);
							}
					}
					if($(hideMenu + ' > .menu_cat')[0]){
						$(hideMenuWrapper).css({display: 'inline-block'});
					}
					else{
						$(hideMenuWrapper).css({display: 'none'});
					}
				}
				else {
					$('.menu_cat_more').empty();
					$('.menu_cat_more').append('Меню');
					var elements = [];
					$(mainMenu + ' > .menu_cat').each(function(){
						elements.push($(this));
					});
					elements.reverse().forEach(element => {
						hideElem(element)
					});
				}
				
			};
			$(document).ready(function(){ menu(); });
			$(window).resize(function(){ menu(); });

			var ProductLimit = 8;
			var ProductOffSet = 8;

			$('[data-filter]').click(function(){
				$('.menu_content').empty();
				$('.pc-btn').removeClass('show');
				$('.loadmore').removeClass('hidden');
				$('.active[data-filter]').removeClass('active');
				$(this).addClass('active');
				var menuCategory = $('.active[data-filter]').attr('data-filter');
				var btn = $(this);
				btn.addClass('loading');
				ProductOffSet = 0;
				$.ajax({
					url: '/ajax.php',
					method: 'post',
					dataType: 'json',
					data: { action: 'getItems', category: menuCategory, limit: ProductLimit, offset: ProductOffSet },
					success: function(data){
						if (data.status == 'success') {
							ProductOffSet += ProductLimit;
							$('.menu_content').html(data.text);
							if ( data.count < ProductLimit ) { $('.loadmore').addClass('hidden'); }
						} 
						else {
							console.error(data.text);
						}
						btn.removeClass('loading');
					},
					error: function(data){
						console.error('Opps... Error getting data. Please refresh the page.');
						btn.removeClass('loading');
					}
				});
			});
			$('.loadmore').click(function(){
				var menuCategory = $('.active[data-filter]').attr('data-filter');
				var btn = $(this);
				btn.addClass('loading');
				$.ajax({
					url: '/ajax.php',
					method: 'post',
					dataType: 'json',
					data: { action: 'getItems', category: menuCategory, limit: ProductLimit, offset: ProductOffSet },
					success: function(data){
						if (data.status == 'success') {
							ProductOffSet += ProductLimit;
							$('.menu_content').append(data.text);
							if ( data.count < ProductLimit ) { $('.loadmore').addClass('hidden'); }
						} 
						else {
							console.error(data.text);
						}
						btn.removeClass('loading');
					},
					error: function(data){
						console.error('Opps... Error getting data. Please refresh the page.');
						btn.removeClass('loading');
					}
				});
			});
		</script>
	</body>
</html>