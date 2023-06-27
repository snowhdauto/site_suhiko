<section>
	<div class="swiper-container slider-container">
		<div class="swiper-wrapper slider-wrapper">
			<?php foreach($items as $item): ?>
				<a href="<?php echo $item->slide_link; ?>" class="swiper-slide slider-slide">
					<img src="<?php echo $item->slide_image; ?>" alt="<?php echo $item->slide_name; ?>">
				</a>
			<?php endforeach; ?>
		</div>
		<div class="swiper-button-next slider-button-next"><i class="far fa-chevron-right"></i></div>
		<div class="swiper-button-prev slider-button-prev"><i class="far fa-chevron-left"></i></div>
	</div>
</section>
