$(function () {
	$("#hero__fab").click(function (){
		$(".mdl-layout__content").animate({
			scrollTop: $(".jumbotron").outerHeight()
		}, 300);
	});
});

var showInfo = function(info, onClose){
	var dialog = $("#info_dialog");
	if (!dialog[0].showModal) {
		dialogPolyfill.registerDialog(dialog[0]);
    }
	var content = dialog.find(".mdl-dialog__content > p");
	var btn = dialog.find("#dialog_ok");
	content.append(info);
	btn.click(function() {
		dialog[0].close();
		if (onClose){
			onClose();
		}
		content.append("");
	});
	dialog[0].showModal();
	return dialog;
}