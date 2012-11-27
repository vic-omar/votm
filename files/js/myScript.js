$(function() {
	$(".menus").menu({
		icons: {
			submenu: "ui-icon-play"
		}
	});

	//Configurando Datepickers por defecto
	$.datepicker.regional['es'] ={
		clearText: 'Borra',
		clearStatus: 'Borra fecha actual',
		closeText: 'Cerrar',
		closeStatus: 'Cerrar sin guardar',
		prevStatus: 'Mostrar mes anterior',
		prevBigStatus: 'Mostrar a&ntilde;o anterior',
		nextStatus: 'Mostrar mes siguiente',
		nextBigStatus: 'Mostrar año siguiente',
		currentText: 'Hoy',
		currentStatus: 'Mostrar mes actual',
		monthNames:  ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		monthStatus: 'Seleccionar otro mes',
		yearStatus: 'Seleccionar otro año',
		weekHeader: 'Sm',
		weekStatus: 'Semana del año',
		dayNames: ['Domingo', 'Lunes', 'Martes', 'Mi&eacute;rcoles', 'Jueves', 'Viernes', 'S&aacute;bado'],
		dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mi&eacute;', 'Jue', 'Vie', 'S&aacute;b'],
		dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'S&aacute;'],
		dayStatus: 'Set DD as first week day',
		dateStatus: 'Select D, M d',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		initStatus: 'Seleccionar fecha',
		isRTL: false
	};
	$.datepicker.setDefaults($.datepicker.regional['es']);

});

function resetFrm(){
	$('form').each(function(){
		$(this)[0].reset();
	});
}

var baseurl=$('base').attr('href');
var urlraiz=$('base').attr('raiz');
