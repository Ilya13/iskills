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

var getParams = function (query) {
	var queryString = {};
	var vars = query.split("&");
	for (var i=0;i<vars.length;i++) {
		var pair = vars[i].split("=");
		//If first entry with this name
		if (typeof queryString[pair[0]] === "undefined") {
			queryString[pair[0]] = decodeURIComponent(pair[1]);
			// If second entry with this name
		} else if (typeof queryString[pair[0]] === "string") {
			var arr = [ queryString[pair[0]],decodeURIComponent(pair[1]) ];
			queryString[pair[0]] = arr;
			// If third or later entry with this name
		} else {
			queryString[pair[0]].push(decodeURIComponent(pair[1]));
		}
	}
	return queryString;
}

var dayesToString = function (dayes) {
	if (dayes >= 365){
		
	}
}