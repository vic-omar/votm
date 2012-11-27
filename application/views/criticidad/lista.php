<div class="space">
<table class="grafico" width='400'>
	<thead>
		<tr class='ui-state-hover'>
			<th colspan='4'>Nivel de Criticidad por Tipo de Alarma</th>
		</tr>
		<tr class='ui-state-error'>
			<th>Funcion</th>
			<th>Critical</th>
			<th>Major</th>
			<th>Warning</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$html="";
		foreach ($rows->result_array() as $val)
		{
			if ($val['funcion'] != 'Totales')
			{
				$html .= "<tr>";
				$html .= "<td>".$val['funcion']."</td>";
				$html .= "<td align='center'>".$val['critical']."</td>";
				$html .= "<td align='center'>".$val['major']."</td>";
				$html .= "<td align='center'>".$val['warning']."</td>";
				$html .= "</tr>";
			}
		}
		echo $html;
		?>
	</tbody>
</table>
</div>

<div class="space">
	<div id="chart1" style="width:600px; height:250px;"></div>
</div>

<div class="enter">&nbsp;</div>
	<?php
	/*	Crear las Variables para el Graficos Estadistico	*/
	$varJS="";
	$tag="";
	$value="";
	$i=1;
	foreach ($rows->result_array() as $val)
	{
		if ($val['funcion'] != 'Totales')
		{
			$varJS .= "var s".$i." = [".$val['critical'].", ".$val['major'].", ".$val['warning']."]; ";
			$tag .= "s".$i.", ";
			$value .= "{ label: '".$val['funcion']."' }, ";
			$i++;
		}
	}
	$tagFin=substr($tag,0,-2);
	$valueFin=substr($value,0,-2);
	?>
<!--	CSS		-->
<link class="include" rel="stylesheet" type="text/css" href="css/jquery.jqplot.min.css" />
<!--	JS	-->
<script class="include" type="text/javascript" src="js/grafico/jquery.jqplot.min.js"></script>
<script class="include" language="javascript" type="text/javascript" src="js/grafico/jqplot.barRenderer.min.js"></script>
<script class="include" language="javascript" type="text/javascript" src="js/grafico/jqplot.categoryAxisRenderer.min.js"></script>
<script class="include" language="javascript" type="text/javascript" src="js/grafico/jqplot.pointLabels.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){

	<?php echo $varJS; ?>
	var ticks = ['Critical', 'Major', 'Warning'];

    var plot1 = $.jqplot('chart1', [ <?php echo $tagFin; ?> ], {
		seriesDefaults:{
			renderer:$.jqplot.BarRenderer,
			rendererOptions: {fillToZero: true}
		},
		series:[ <?php echo $valueFin; ?> ],
		legend: {
			show: true,
			placement: 'outsideGrid'
		},
		axes: {
			xaxis: {
				renderer: $.jqplot.CategoryAxisRenderer,
				ticks: ticks
			}
		}
	});

});
</script>
