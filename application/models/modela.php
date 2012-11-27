<?php
class Modela extends CI_Model {

function __construct()
{
	parent::__construct();  // Llama el constructor del Modelo
}

//~ Eliminar Equipos x Fecha
function deleteEquipo($fecha)
{
	$sqlDE = " DELETE FROM equipos WHERE fecha=STR_TO_DATE('".$fecha."','%d/%m/%Y') ";
	$this->db->query($sqlDE);
}

//~ Eliminar Alarmas x Fecha
function deleteAlarma($fecha)
{
	$sqlDA = " DELETE FROM vicOmar WHERE fecha=STR_TO_DATE('".$fecha."','%d/%m/%Y') ";
	$this->db->query($sqlDA);
}

//~ Insertar Equipos
function insertEquipo($val)
{
	$sqlIE = " INSERT INTO equipos (codigo, nombre, fecha, hora, usuario) VALUES ".$val."  ";
	$this->db->query($sqlIE);
}

//~ Insertar Alarmas
function insertAlarma($val)
{
	$sqlIA = " INSERT INTO vicOmar VALUES ".$val;
	$this->db->query($sqlIA);
}

function indicador($ini,$fin)
{
	$sql="SELECT IFNULL(al.alarma,'Totales') AS alarma, al.nombre, IFNULL(al.fecha,'Totales') AS fechas, al.cantidad FROM ( "
			."SELECT a.AlarmSource AS alarma, IFNULL(a.Name,'Totales') AS nombre, STR_TO_DATE(LEFT(TRIM(a.GeneratedTime), 10),'%d/%m/%Y') AS fecha, "
				."COUNT(STR_TO_DATE(LEFT(TRIM(a.GeneratedTime), 10),'%d/%m/%Y')) AS cantidad "
			."FROM vicOmar a "
			."WHERE STR_TO_DATE(LEFT(TRIM(a.GeneratedTime), 10),'%d/%m/%Y') BETWEEN '".$ini."' AND '".$fin."' "
			."GROUP BY a.AlarmSource, a.Name, STR_TO_DATE(LEFT(TRIM(a.GeneratedTime), 10),'%d/%m/%Y') WITH ROLLUP "
		.") al ";
	$kry=$this->db->query($sql);
	return $kry;
}

function convertir_array_con_fechas($filas,$fechas)
{
	//	Capturar las campos de la consulta
	$campos=$filas->list_fields();
	//	Agregamos el rango de fechas
	$array=$fechas;
	//	Creando el Array de las Filas
	if($filas->num_rows()!=0)
	{
		foreach($filas->result_array() as $rows)
		{
			$array[$rows[$campos[0]]][$rows[$campos[1]]][$rows[$campos[2]]]=$rows[$campos[3]];
		}
	}
	else
	{
		$array=array();
	}
	return $array;
}

function criticidad($ini,$fin)
{
	$sql="SELECT IFNULL(a.funcion,'Totales') AS funcion, a.critical, a.major, a.warning, a.total FROM ( "
			."SELECT trim(a.FunctionType) as funcion "
				.",SUM(IF(trim(a.Severity) = 'Critical',1,0)) AS 'Critical' "
				.",SUM(IF(trim(a.Severity) = 'Major',1,0)) AS 'Major' "
				.",SUM(IF(trim(a.Severity) = 'Warning',1,0)) AS 'Warning' "
				.",COUNT(*) AS Total "
			."FROM vicOmar a "
			."WHERE STR_TO_DATE(LEFT(TRIM(a.GeneratedTime), 10),'%d/%m/%Y') BETWEEN '".$ini."' AND '".$fin."' "
			."GROUP BY trim(a.FunctionType) WITH ROLLUP "
		.") a ";
	$kry=$this->db->query($sql);
	return $kry;
}

}	// Fin clase
?>
