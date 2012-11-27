<div class="space">
	<button class='btnDetalleAlarma'>DETALLE DE LAS ALARMAS</button>
	<input type="hidden" name="jsonTotal" class="jsonTotal" value='<?php echo json_encode($rows); ?>' />
</div>

<table border='1' class="estiloTable" cellpadding='2' width="1000">
	<thead>
		<tr class="ui-state-hover">
		<?php
		echo $head;
		?>
		</tr>
	</thead>
	<tbody>
		<?php
			echo $body;
		?>
	</tbody>
</table>
<div class='enter'>&nbsp;</div>

<script type="text/javascript">
$(document).ready(function(){

//	Boton de Detalle de Alarmas
	$(".btnDetalleAlarma").button({
		icons: {
			primary: "ui-icon-folder-open"
		}
	}).click(function(e){
		e.preventDefault();

		$.ajax({
			url:"../index/sys/detalleTotal/",
			type: "POST",
			data: ({ texto : $('.jsonTotal').val() }),
			dataType:"html",
			success: function(data){
				$('.popupAlarma').html(data);
			},
			complete: function(){
				$(".popupAlarma").dialog("open");
			}
		});

		return false;
	});

/*	Pintar Filas	*/
	$('.estiloTable tbody tr').live('mouseover', function() {
		$(this).addClass("ui-state-highlight");
	}).end();
	$('.estiloTable tbody tr').live('mouseout', function() {
		$(this).removeClass("ui-state-highlight");
	});

});
</script>
<style type="text/css">

.estiloTable, .estiloTable th, .estiloTable td {
	border-collapse: collapse;
	border-color:#79B7E7;
	font-size:10px;
}

</style>
