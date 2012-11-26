<div class="space">
	<button class='btnDetalleAlarma'>DETALLE DE LAS ALARMAS</button>
</div>

<table border='1' id='reportIndicador' class="estiloTable scrollableFixedHeaderTable" cellpadding='2' width="1000">
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
	})

/*
	var lastColIndex = 0;
	$('#reportIndicador').scrollableFixedHeaderTable(1000, 800);
	colIds =freezeFirstColumnSorter('reportIndicador', lastColIndex);

	$('#' + colIds.colHeaderId + ' th').attr('class', $('.sfhtData thead th:nth(0)').attr('class'));

	$('.sfhtHeader thead th').each(function(index){
		var $cloneTH = $(this);
		var $trueTH = $($('.sfhtData thead th')[index]);
		$cloneTH.attr('class', $trueTH.attr('class'));
		$cloneTH.click(function(){
			$trueTH.click();
		});
	});

	$('#' + colIds.colHeaderId + ' th').each(function(index){
		$(this).click(function(){
			$('.sfhtData thead th:nth(' + index + ')').click();
		});
	});
*/

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
.estiloTable .header th {
	font-weight: bold;
	background-color: #6FA7D1;
	color: white;
	text-align:center;
	font-size:10px;
}

.estiloTable .pintarName {
	background-color: #6FA7D1;
	padding-left:2px;
	color: white;
}

.estiloTable, .estiloTable th, .estiloTable td {
	border-collapse: collapse;
	border-color:#79B7E7;
	font-size:10px;
}

.freezCol {
	position: absolute;
	overflow: hidden;
	z-index: 100;
}

.freezColHeader {
	position: absolute;
	z-index: 101;
}
</style>
