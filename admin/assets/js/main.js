$(document).ready(function(){
	$('.sidebar_navigation_parent_btn').click(function(){
		$(this).toggleClass('close');
		$(this).parent().parent().children('.sidebar_navigation_children').toggleClass('hidden');
	});
	$('.header_mobile_btn').click(function(){
		$('.wrapper').toggleClass('sidebar-close');
	});
	function checkWidthForSidebar(){
		if ( window.innerWidth < 1024 ) {
			$('.wrapper').addClass('sidebar-close');
		}
		else {
			$('.wrapper').removeClass('sidebar-close');
		}
	}
	checkWidthForSidebar();
	$(window).resize(function(){
		checkWidthForSidebar();
	});
});