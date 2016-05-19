$(document).ready(function (){
	$('.hero__fab').click(function (){
		$('.mdl-layout__content').animate({
			scrollTop: $('.section__hero').outerHeight()
		}, 300);
	});
});