<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vic {

	public function dateFormat($fechaFormat)
	{
		$fecha = str_replace("/","-",$fechaFormat);
		$fechaExe = explode("-", $fecha);
		$fechaFinal = $fechaExe[2]."-".$fechaExe[1]."-".$fechaExe[0];
		return $fechaFinal;
	}

	public function datosEnviadosJS($rows)
	{
		$inputbox = stripslashes($rows);
		parse_str($inputbox,$array);
		$array=($array);
		$campos=$array;
		return $campos;
	}

	public function msgBox($get)
	{
		$tipo=$get[0];
		$ancho=$get[1];
		$icono=$get[2];
		$titulo=$get[3];
		$contenido=$get[4];
		$html="";
		if($tipo=='BAD')
		{
			$html.="<div class='enter'></div>"
					."<div class='ui-state-error ui-corner-all' style='width:".$ancho."px;padding: 0 3px 0 3px;text-align: justify;margin:0 auto'><p>"
					."<span class='ui-icon ".$icono." left'></span><strong>&nbsp;".$titulo."&nbsp;:&nbsp;</strong>"
					."".$contenido.""
					."</p></div>"
				."<div class='enter'></div>";
		}
		else
		{
			$html.="<div class='enter'></div>"
					."<div class='ui-state-highlight ui-corner-all' style='width:".$ancho."px;padding: 0 3px 0 3px;text-align: justify;margin:0 auto'><p>"
					."<span class='ui-icon ".$icono." left'></span><strong>&nbsp;".$titulo."&nbsp;:&nbsp;</strong>"
					."".$contenido.""
					."</p></div>"
					."<div class='enter'></div>";
		}
		return $html;
	}

	public function js()
	{
		$js = array('js/modernizr.custom.js', 'js/jquery-1.8.2.js', 'js/jquery-ui-1.9.1.custom.js', 'js/myScript.js');
		return $js;
	}

	public function css()
	{
		$css = array('css/styles.css','theme/humanity/jquery-ui-1.9.1.custom.css');
		return $css;
	}

}
/* End of file vic.php - Mis Funciones Globales	- Omar Tomailla	*/
