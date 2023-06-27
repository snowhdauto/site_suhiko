<footer class="footer">
	<div class="content_position">
		<div class="footer_top">
			<a href="/" class="logo white">
				<img class="logo_image" src="/assets/img/logo-white.svg" alt="">
				<!-- <h2 class="logo_text"><?php echo $SITENAME; ?><span>.</span></h2> -->
			</a>
			<nav class="nav">
				<?php echo template_render('/widgets/main-block/navigation-links.php', []); ?>
			</nav>
			<div class="footer_contact">
				<h2><a style="text-decoration: none;" href="tel:<?php echo $CONTACT_PHONE; ?>"><?php echo phoneFormat($CONTACT_PHONE); ?></a></h2>
				<a href="mailto:<?php echo $CONTACT_MAIL; ?>"><?php echo $CONTACT_MAIL; ?></a>
			</div>
		</div>
		<div class="footer_bottom">
			<p>© <?php echo $SITENAME; ?> <?php echo date('Y'); ?>. Все права защищены. Разработка <a style="text-decoration: revert;" href="https://www.dolphron.com" target="_blank">Dolphron</a></p>
			<div class="social">
				<a target="_blank" href="https://vk.com/sushikonn"><i class="fab fa-vk"></i></a>&nbsp;&nbsp;&nbsp;
				<a target="_blank" href="https://www.instagram.com/sushiko_nn/"><i class="fab fa-instagram"></i></a>
			</div>
		</div>
	</div>
</footer>