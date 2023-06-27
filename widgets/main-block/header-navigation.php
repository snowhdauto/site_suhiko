<nav class="nav">
	<div class="nav_btn"><i class="fas fa-bars"></i></div>
	<div class="nav_links hidden">
		<div class="nav_head">
			<h2>Меню</h2>
			<h2><span class="nav_btn_close"><i class="far fa-times"></i></span></h2>
		</div>
		<div class="nav_content">
			<?php echo template_render('/widgets/main-block/navigation-links.php', []); ?>
			
			<div class="nav_footer">
				<h2><a style="color: #050505; text-decoration: none;" href="tel:<?php echo $CONTACT_PHONE; ?>"><?php echo phoneFormat($CONTACT_PHONE); ?></a></h2>
			</div>
		</div>
	</div>
</nav>