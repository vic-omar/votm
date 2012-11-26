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

function freezeFirstColumnSorter(tableId, lastColIndex)
{
	if (!lastColIndex) {
		lastColIndex = 0;
	}

	/* object to be returned */
	var ids = {};
	ids.colBodyId = tableId + '_column';
	ids.colHeaderId = tableId + '_columnHeader';

	var $columnTable = $('.sfhtData #' + tableId).clone().attr('id', ids.colBodyId);
	$columnTable.removeAttr('width');
	$columnTable.children().children().each(function(){
		$(this).children(':gt(' + lastColIndex + ')').remove()
	});
	$columnTable.wrap('<div></div>');

	/* floating column */
	var $colDiv = $columnTable.parent();
	$colDiv.attr('class', 'freezCol');

	/* floating header of the floating column */
	var $columnTableHeader = $columnTable.clone();
	$columnTableHeader.children(':gt(' + 0 + ')').remove();
	$columnTableHeader.attr('id', ids.colHeaderId)
	$columnTableHeader.wrap('<div></div>');
	var $colHeaderDiv = $columnTableHeader.parent();
	$colHeaderDiv.addClass('freezColHeader');

	/* $().innerHeight does not seem to work so 17px which is common in a default theme was subtracted to get the innerHeight */
	var scrollHeight = $('#' + tableId).parents('[class="sfhtTable"]').innerHeight() - 17;
	$colDiv.height(scrollHeight);

	/* ref var for floating header */
	var $sfhtHeader = $('#' + tableId).parents('[class="sfhtTable"]').find('.sfhtHeader');

	/* add the header of the floating column */
	$sfhtHeader.parent().append($colHeaderDiv);

	/* add the floating column */
	$sfhtHeader.parent().append($colDiv);

	/* sync vertical scroll */
	$('#' + tableId).parent().scroll(function(){
		$colDiv.scrollTop($(this).scrollTop());
	});

	/* return id object */
	return ids;
}
