<a href="<?php echo '/' . $article->article_type . '/' . $article->article_link; ?>" class="articles_item">
	<img src="<?php echo $article->article_image; ?>" alt="<?php echo $article->article_name; ?>">
	<h3><?php echo $article->article_name; ?></h3>
	<p><?php echo $article->article_description; ?></p>
</a>