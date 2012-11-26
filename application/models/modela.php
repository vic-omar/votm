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

}	// Fin clase
?>
