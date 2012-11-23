<!DOCTYPE html>
<html lang="es">
<head>
	<base href="<?php echo $this->config->item('base_url') ?>files/" raiz="<?php echo $this->config->item('base_url') ?>" />
	<meta charset="utf-8">
	<title>Proyecto de Telecomunicaciones - UW</title>
<?php
	//~ Archivos CSS
	$fileCSS="";
	foreach ($css as $fc)
	{
		$fileCSS .= '<link href="'.$fc.'" rel="stylesheet" type="text/css" />';
	}
	echo $fileCSS;

	//~ Archivos Javascript
	$fileJS="";
	foreach ($js as $fj)
	{
		$fileJS .= '<script type="text/javascript" src="'.$fj.'"></script>';
	}
	echo $fileJS;
?>
</head>
<body>

