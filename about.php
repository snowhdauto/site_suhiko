<?php namespace App; require $_SERVER['DOCUMENT_ROOT'] . '/loader.php'; ?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE; ?>">
	<head>
		<?php echo template_render('/widgets/main-block/head.php', [
				'SITENAME' => SITETITLE,
				'LOCALE' => LANGUAGE,
				'title' => 'О нас',
				'description' => 'Команда SushiKO приветствует тебя, гурман! Ценишь качество и настоящее сочетание вкуса от роллов? У нас есть свои секреты настоящего вкуса...',
				'keywords' => '',
				'image' => '/assets/img/og_image_white.png',
				'curent_url' => '/about',
				'page_type' => 'article',
				'published' => '2020-10-01T00:00:00+03:00',
			]); ?>
	</head>
	<body>
		<div class="blackout hidden"></div>
		<?php echo template_render('/widgets/main-block/loader.php', [
			'SITENAME' => SITENAME
		]); ?>
		<div id="app">
			<article class="article">
				<div class="content_position">
					<div class="article_header">
						<a href="/" class="logo nuxt-link-active">
							<img src="/assets/img/logo.svg" alt="" class="logo_image">
							<!-- <h2 class="logo_text"><?php echo SITENAME; ?><span>.</span></h2> -->
						</a>
						<?php 
							$scheme = isset($_SERVER['HTTP_SCHEME']) ? $_SERVER['HTTP_SCHEME'] : ( 
								( (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || 443 == $_SERVER['SERVER_PORT'] ) ? 'https://' : 'http://'
							);
							$siteurl = $scheme . $_SERVER["SERVER_NAME"];

							$backLink = '/';

							if ( isset($_SERVER['HTTP_REFERER']) ) {
								if ( $_SERVER['HTTP_REFERER'] != ($siteurl . '/' . $type . '/' . $link) ) {
									$backLink = $_SERVER['HTTP_REFERER'];
								}
							}
						?>
						<a href="<?php echo($backLink); ?>" class="article_close"><i class="far fa-times"></i></a>
					</div>
					<div class="article_container">
						<div class="article_block">
							<h1>О нас</h1>
							<p>Команда SushiKO приветствует тебя, гурман! Ценишь качество и настоящее сочетание вкуса от роллов? У нас есть свои секреты настоящего вкуса 😉</p>
						</div>
						<img src="/assets/img/resizeImage-1-1024x683.jpg" alt="">
						<div class="article_block">
							<h2>Наши правила</h2>
							<p>Перечень правил которыми мы руководствуемся!</p>
							<style>
								
								blockquote {
									-moz-border-bottom-colors: none;
									-moz-border-left-colors: none;
									-moz-border-right-colors: none;
									-moz-border-top-colors: none;
									background:#f7f7f7;
									border-color: transparent;
									border-style: solid;
									border-width: 15px;
									box-shadow: 0 0 3px #cacaca;
									color: #555555;
									font-family: arial;
									font-size: 17px;
									font-style: italic;
									line-height: 1.45;
									text-align:center;
									padding: 19px 31px;
									width: 100%;
									margin-top: 20px;
								}

								.about_rules-item {
									display: grid;
									grid-template-columns: 1fr 300px;
									grid-auto-flow: dense;
									margin-top: 20px;
									grid-gap: 20px;
								}
								.about_rules-item.reverse {	grid-template-columns: 300px 1fr; }
								.about_rules-item .content img {
									width:100%;
									margin: 0px;
									border-radius: 20px;
									height: 230px;
									object-fit: cover;
								}
								.about_rules-item .content { grid-column: 1 / 2; }
								.about_rules-item .content:nth-child(2) { grid-column: 2 / 3; }
								.about_rules-item.reverse > .content { grid-column: 2 / 3; }
								.about_rules-item.reverse > .content:nth-child(2) { grid-column: 1 / 2; }
								@media(max-width: 717px){
									.about_rules-item,
									.about_rules-item.reverse {	grid-template-columns: 1fr; }
									.about_rules-item .content img { height: 300px;	}
									.about_rules-item .content {grid-column: 1 / 3;	}
									.about_rules-item .content:nth-child(2) {	grid-column: 1 / 3;	}
									.about_rules-item.reverse >  .content { grid-column: 1 / 3;	}
									.about_rules-item.reverse >  .content:nth-child(2) {	grid-column: 1 / 3;	}
								}
								@media(max-width: 550px){
									
								blockquote {
									padding: 0px;
								}
									.about_rules-item .content img { height: 250px;	}
								}
								@media(max-width: 400px){
									.about_rules-item .content img { height: 200px;	}
								}
								@media(max-width: 350px){
									.about_rules-item .content img { height: 150px;	}
								}
							</style>

							<div class="about_rules-item reverse">
								<div class="content" style="display: flex;align-items: center;">
									<div>
										<p><b>Правило 1:</b>&nbsp;&nbsp;&nbsp;Свежая рыба и настоящая икра — это первый залог настоящего вкуса японской, корейской и китайской кухни в твоем городе!</p>
									</div>
								</div>
								<div class="content"><img src="/assets/img/1793961.jpg" alt=""></div>
							</div>
							<div class="about_rules-item">
								<div class="content" style="display: flex;align-items: center;">
									<div>
										<p><b>Правило 2:</b>&nbsp;&nbsp;&nbsp;Рис — это основа ролла, поэтому мы используем премиальный сорт нашего поставщика. Так же рис должен быть всегда свежесваренным!</p>
									</div>
								</div>
								<div class="content"><img src="/assets/img/maxresdefault-1024x576.jpg" alt=""></div>
							</div>
							<div class="about_rules-item reverse">
								<div class="content" style="display: flex;align-items: center;">
									<div>
										<p><b>Правило 3:</b>&nbsp;&nbsp;&nbsp;Соевый соус — скажем нет фабрикату! Мы замешиваем соус в ручную, по рецепту шеф повара!</p>
									</div>
								</div>
								<div class="content"><img src="/assets/img/4d46dd54b6113ec7760a7a7ee47ae042-768x768.jpg" alt=""></div>
							</div>

							<blockquote>
								<p><b>Наша цель:</b> доставить до вас блюда с подачей и качеством ресторанного уровня в ваш дом по доступным ценам!</p>
							</blockquote>

						</div>
					</div>
				</div>
			</article>
		</div>
		<?php echo template_render('/widgets/main-block/scripts.php', []); ?>
	</body>
</html>