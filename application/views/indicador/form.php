<form class='frmFindAlarmas' method="post">

	<div class="space ui-state-hover ui-corner-all redon">FECHA DE ALARMAS</div>
	<div class="space ui-state-hover ui-corner-all redon">DESDE:</div>
	<div class="space">
		<input type="text" name="desde" id="desde" class="ui-widget ui-widget-content" value="<?php echo date("d/m/Y"); ?>" style="width: 100px">
	</div>
	<div class="space ui-state-hover ui-corner-all redon">HASTA:</div>
	<div class="space">
		<input type="text" name="hasta" id="hasta" class="ui-widget ui-widget-content" value="<?php echo date("d/m/Y"); ?>" style="width: 100px">
	</div>
	<div class="space" style='margin-left:200px'>
		<button class='btnFindAlarmas'>BUSCAR ALARMAS</button>
	</div>
	<div class="enter">&nbsp;</div>

	<div class="resultadoLoad"></div>

</form>

<!--	Popup	-->
<div class="popupAlarma" title="Detalle de Alarma">asdsd</div>
