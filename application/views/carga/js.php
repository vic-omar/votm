<script type="text/javascript">
$(document).ready(function(){
	resetFrm();

	//	Boton Cargar
	$(".btnLoadTxt").button({
		icons: {
			primary: "ui-icon-disk"
		}
	}).click(function(e){
		e.preventDefault();

		$(".resultadoLoad").html("<img src='img/load.gif' alt='Load...' />");

		var api=$('input[name=txtLoad]');
		var cadena = $(".frmLoadTxt").serialize();
		var url="../index/sys/txtUpLoad/";

		api.upload(url,{text_file: 'txtLoad',val:api.val(),cadena:cadena},function(data){
			if(data.result==1)
			{
				var htmlTex="<div class='ui-state-highlight ui-corner-all' style='width:650px;padding: 5px 10px 5px 10px;text-align: justify;margin:5px 0 0 15px'>";
					htmlTex+="<span class='ui-icon ui-icon-alert' style='float:left'></span>";
					htmlTex+="<div class='space'><strong>&nbsp;[ Alerta ]</strong>&nbsp;&nbsp;&nbsp;";
					htmlTex+=data.msj;
					htmlTex+="</div></div>";
				$(".resultadoLoad").html(htmlTex);
				resetFrm();
			}
			else
			{
				var htmlText="<div class='ui-state-error ui-corner-all' style='width:650px;padding: 5px 10px 5px 10px;text-align: justify;margin:5px 0 0 15px'>";
					htmlText+="<span class='ui-icon ui-icon-alert' style='float:left'></span>";
					htmlText+="<div class='space'><strong>&nbsp;[ Alerta ]</strong>&nbsp;&nbsp;&nbsp;";
					htmlText+=data.msj;
					htmlText+="</div></div>";
				$(".resultadoLoad").html(htmlText);
				resetFrm();
			}
		}, 'json');
	}); //  Fin de Boton

});
</script>
