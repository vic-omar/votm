<?php
//~ Developer Vic Omar Tomailla
//~ GPL	- General Public License

//~ Conexion BD
include_once("cn.php");

//~ Archivo
$filas=file('alerta.txt');

//~ Variables
$i=0;
$f=0;
$array=array();
$puntos="";
$registros=count($filas);
$sqlEquipo="";

//~ Recorrer cada fila del Files
while($i < $registros)
{
	//~ Fecha y Hora del Reporte de Alarmas
	if ( substr(trim($filas[$i]),0,4) == "Save" )
	{
		$fechaReporte = explode(" ", trim($filas[$i]));
	}
	//~ Encontrar el primer registro de Alarmas
	if ( substr(trim($filas[$i]),0,9) == "---------" )
	{
		$puntos="alarmas";
	}

	if ($puntos == "alarmas") 
	{
		//~ Verificar Filas vacias y el nombre Total
		if ( (trim($filas[$i]) != "") AND ( substr(trim($filas[$i]),0,5) != "Total") ) 
		{
			//~ Registro de Alarmas
			$new = substr($filas[$i],0,9);
			if($new == "---------")
			{
				$f++;
			}
			else
			{
				$rows = explode("|",$filas[$i]);
				$array[$f][] = $rows;
			} 
		}
	}
	else
	{
		//~ Verificar Filas vacias y Puntos ... para insertar los Nombres de los Equipos
		if ( (trim($filas[$i]) != "") AND ( md5(substr(trim($filas[$i]),0,3)) != "96303d80a13755b27a99bbfa1af2dca0" ) ) 
		{
			if (isset($fechaReporte)) 
			{
				$sqlEquipo.="(NULL, '".trim($filas[$i])."', STR_TO_DATE('".$fechaReporte[2]."','%d/%m/%Y'), '".$fechaReporte[3]."', '".$fechaReporte[(count($fechaReporte) - 1)]."'),";
			}
		}
	}
	$i++;
}

//~ Eliminar Equipos x Fecha
mysql_query(" DELETE FROM equipos WHERE fecha=STR_TO_DATE('".$fechaReporte[2]."','%d/%m/%Y') ");
//~ Insertar Equipos
mysql_query("INSERT INTO equipos (codigo, nombre, fecha, hora, usuario) VALUES ".substr($sqlEquipo,0,-1)." ");

//~ Variables
/*
$x=0;
$null="null";
$row="";

foreach ($array[1][0] as $celda)
{
	if (trim($celda)=="")
	{
		$row.=$null.$x.' varchar(250),';
		$x++;
	}
	else
	{
		$row.=str_replace(' ','',trim($celda)).' varchar(250),';
	}
}

$tables = "create table vicOmar (".str_replace("(Minute)","Minute",$row)." fecha DATE DEFAULT NULL, hora TIME DEFAULT NULL, usuario VARCHAR(100) DEFAULT NULL)";
mysql_query($tables);
*/

//~ Variables
$campo="";
$values="";
$count = count($array[1][0]);	//	Cantidad de Columna
$insert = "";

//~ Eliminar campos [Primer Registro]
array_shift($array);

foreach ($array as $field)
{
	for ($i = 0; $i < $count; $i++)
	{
		foreach ($field as $key => $val)
		{
			//~ Buscar los campos que necesita tener espacios en blanco
			if ( ( substr_count($val[$i],"/") >=1 ) OR ( substr_count($val[$i],"Frame=") >=1 ) OR ( substr_count($val[$i],"Subslot=") >=1 )  )
			{
				$campo.=trim($val[$i])." ";
			}
			else
			{
				$campo.=trim($val[$i]);
			}
		}
		$values.= "'".$campo."',";
		$campo="";
	}

	$insert .= "(".substr($values,0,-1).", STR_TO_DATE('".$fechaReporte[2]."','%d/%m/%Y'), '".$fechaReporte[3]."', '".$fechaReporte[(count($fechaReporte) - 1)]."'), ";
	$values="";
}

//~ Eliminar Alarmas x Fecha
mysql_query(" DELETE FROM vicOmar WHERE fecha=STR_TO_DATE('".$fechaReporte[2]."','%d/%m/%Y') ");
//~ Insertar Alarmas
$sqlInsertar = "INSERT INTO vicOmar VALUES ".substr($insert,0,-2);
mysql_query($sqlInsertar);

?>
