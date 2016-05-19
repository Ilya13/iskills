$(function () {
	$("#hero__fab").click(function (){
		$(".mdl-layout__content").animate({
			scrollTop: $(".jumbotron").outerHeight()
		}, 300);
	});
});