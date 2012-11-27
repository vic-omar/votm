<script type="text/javascript">
$(document).ready(function(){
	resetFrm();

	//	Rango de Fechas
	var dates = $("#desde, #hasta").datepicker({
		onSelect: function(selectedDate) {
			var option = this.id == "desde" ? "minDate" : "maxDate",
			instance = $(this).data("datepicker"),
			date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
			dates.not(this).datepicker("option", option, date);
		}
	});

	//	Boton Buscar Alarmas
	$(".btnFindAlarmas").button({
		icons: {
			primary: "ui-icon-search"
		}
	}).click(function(e){
		e.preventDefault();

		var cadena = $(".frmFindAlarmas").serialize();
		var url="../index/sys/indicadorLista/";

		$.ajax({
			url:url,
			type: "POST",
			data: ({cadena:cadena}),
			dataType:"html",
			beforeSend : function(){
				$(".resultadoLoad").html("<img src='img/load.gif' alt='Load...' />");
			},
			success: function(data){
				$('.resultadoLoad').html(data);
			},
			complete: function(){
				//
			}
		});

	});

//	Popup Configuracion
	$(".popupAlarma").dialog({
		modal: true,
		autoOpen: false,
		show: "slide",
		hide: "drop",
		width: 700,
		height: 450,
		buttons: {
			Ok: function() {
				$( this ).dialog( "close" );
			}
		}
	});

});
</script>
