<?php namespace App; require $_SERVER['DOCUMENT_ROOT'] . '/loader.php'; ?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE; ?>">
	<head>
		<?php echo template_render('/widgets/main-block/head.php', [
				'SITENAME' => SITETITLE,
				'LOCALE' => LANGUAGE,
				'title' => 'Все акции',
				'description' => 'Лучшие скидки на различную продукцию нашего сайта. Приходи и заберай!',
				'keywords' => '',
				'image' => '/assets/img/og_image_white.png',
				'curent_url' => '/sales',
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
					<h2 class="main_title">Акции</h2>
					<div class="articles">
						<?php 
							$limitCount = 9;
							$countAllArticles = Controllers\User\Post::getPostsCount('sales');
							if ( $countAllArticles > 0 ) {
								$items = Controllers\User\Post::getPosts('sales', array('article_date', 'DESC'), $limitCount, 0);
								foreach ($items as $item) {
									echo template_render('/widgets/article-block.php', [
										'article' => $item,
									]); 
								}
							}
							else {
								echo '<p>Записи отсутствуют...</p>';
							}
						?>
					</div>
					<?php if ( $countAllArticles > $limitCount ): ?>
					<div style="text-align: center; margin-bottom: 60px;">
						<a class="main-btn loadmore"></a>
					</div>
					<?php endif; ?>
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
			var articleLimit = 9;
			var articleOffset = 9;

			$('.loadmore').click(function(){
				var btn = $(this);
				btn.addClass('loading');
				$.ajax({
					url: '/ajax.php',
					method: 'post',
					dataType: 'json',
					data: { action: 'getPosts', type: 'sales', limit: articleLimit, offset: articleOffset },
					success: function(data){
						if (data.status == 'success') {
							articleOffset += articleLimit;
							$('.articles').append(data.text);
							if ( data.count < articleLimit ) { $('.loadmore').addClass('hidden'); }
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