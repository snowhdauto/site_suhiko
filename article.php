<?php namespace App; require $_SERVER['DOCUMENT_ROOT'] . '/loader.php'; ?>
<?php 
	$type = $_GET['type'];
	$link = htmlspecialchars($_GET['link']);
	if (!($type == 'news' || $type == 'sales')) { goToPageError(404); }
	
	$article = Controllers\User\Post::getOnePost($type, $link);
	if ( !$article ) { goToPageError(404); }
?>
<!DOCTYPE html>
<html lang="<?php echo $LOCALE; ?>">
	<head>
		<?php echo template_render('/widgets/main-block/head.php', [
				'SITENAME' => SITETITLE,
				'LOCALE' => LANGUAGE,
				'title' => $article->article_name,
				'description' => $article->article_description,
				'keywords' => '',
				'image' => $article->article_image,
				'curent_url' => '/' . $type . '/' . $link,
				'page_type' => 'article',
				'published' => '',
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
							<h1><?php echo $article->article_name; ?></h1>
							<p><?php echo htmlspecialchars_decode($article->article_description); ?></p>
						</div>
						<img src="<?php echo $article->article_image; ?>" alt="<?php echo $article->article_name; ?>">
						<div class="article_block">
							<?php echo htmlspecialchars_decode($article->article_content); ?>
						</div>
					</div>
				</div>
			</article>
		</div>
		<?php echo template_render('/widgets/main-block/scripts.php', []); ?>
	</body>
</html>