<div>
	<div class="content_position">
		<header class="header">
			
			<?php echo template_render('/widgets/main-block/header-logo.php', [
				'SITENAME' => $SITENAME
			]); ?>
			<?php echo template_render('/widgets/main-block/header-navigation.php', ['CONTACT_PHONE' => $CONTACT_PHONE]); ?>
			<?php echo template_render('/widgets/main-block/header-contact.php', [
				'SITENAME' => $SITENAME,
				'CONTACT_PHONE' => $CONTACT_PHONE,
				'CONTACT_MAIL' => $CONTACT_MAIL
			]); ?>
			<?php echo template_render('/widgets/main-block/header-cart.php', []); ?>
			
		</header>
	</div>
</div>