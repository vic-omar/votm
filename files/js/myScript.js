$(function() {
	$(".menus").menu({
		icons: {
			submenu: "ui-icon-play"
		}
	});
});

function resetFrm(){
	$('form').each(function(){
		$(this)[0].reset();
	});
}

var baseurl=$('base').attr('href');
var urlraiz=$('base').attr('raiz');
