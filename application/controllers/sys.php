<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sys extends CI_Controller {

	/**
	* Developer : Vic Omar TM
	* @v_omar
	*/

	public function index()
	{
		$data['css'] = $this->vic->css();
		$data['js'] = $this->vic->js();
		$data['title'] = "BIENVENIDO";
		$this->load->view('html/head.php',$data);
		$this->load->view('html/menu.php',$data);
		$this->load->view('html/welcome.php');
		$this->load->view('html/foot.php');
	}

	public function carga()
	{
		$data['css'] = $this->vic->css();
		$jsLoad = $this->vic->js();
		array_push($jsLoad, 'js/jquery.upload.1.0.2.js');
		$data['js'] = $jsLoad;
		$data['title'] = "FORMULARIO DE CARGA DE ARCHIVO";
		$this->load->view('html/head.php',$data);
		$this->load->view('html/menu.php',$data);
		$this->load->view('carga/form.php');
		$this->load->view('carga/js.php');
		$this->load->view('html/foot.php');
	}

	public function txtUpLoad()
	{
		error_reporting(0);
		$uploaddir = '/var/www/votm/files/txt/';
		$files = $this->input->post('text_file');
		$valFile = $this->input->post('val');

		if(!empty($valFile))
		{
			//~ Campos
			$tamanio = $_FILES[$files]['size'];
			$tipo = $_FILES[$files]['type'];
			$archivo = $_FILES[$files]['name'];
			$temp = $_FILES[$files]['tmp_name'];

			//  Extraer la Extension
			$extension = explode('.',$archivo);
			$numExt=count($extension)-1;
			$ext= $extension[$numExt];

			$nameFileFoto = $archivo;  //  Nombre del Archivo
			$exTipos=array("TXT","txt","Txt");  //  Tipos de Formatos

			//~ Validar Extension
			if(in_array($ext, $exTipos))
			{
				//~ Copiar al Servidor el File
				if(copy($temp,$uploaddir.$nameFileFoto))
				{
					$carga = $this->filesVic($uploaddir.$nameFileFoto);

					$carga = 1;

					//	Retorno de valores
					if($carga==1)
					{
						$data["result"]='1';
						$data["msj"]="Se carg&oacute; correctamente el archivo ' ".$archivo." '";
						$data["xls"]="";
					}
					else
					{
						$data["result"]='0';
						$data["msj"]="[Error]: Existe un error al ingresar los datos al sistema";
						$data["xls"]="";
					}
				}
				else
				{
					$data["result"]='0';
					$data["msj"]="[Error]: Existe un error al cargar archivo. No pudo guardarse [".$archivo."]";
					$data["xls"]="";
				}

			}
			else
			{
				$data["result"]='0';
				$data["msj"]="[Error]: Solo se admite archivos planos (TXT) - [ ".$archivo." ]";
				$data["xls"]="";
			}

		}
		else
		{
			$data["result"]='0';
			$data["msj"]='Falta seleccionar un archivo';
			$data["xls"]=$valFile;
		}

		echo json_encode($data);
	}

	public function filesVic($file="")
	{
		//~ Archivo
		$filas=file($file);
		//~ $filas=file("/var/www/votm/files/txt/Alarm_2012_09_14_15_38_01.txt");

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
		$this->modela->deleteEquipo($fechaReporte[2]);
		//~ Insertar Equipos
		$values = substr($sqlEquipo,0,-1);
		$this->modela->insertEquipo($values);

		//~ Registro de Alarmas	------------------------
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
		$this->modela->deleteAlarma($fechaReporte[2]);
		//~ Insertar Alarmas
		$valInsert = substr($insert,0,-2);
		$this->modela->insertAlarma($valInsert);
	}

	public function indicador()
	{
		$data['css'] = $this->vic->css();
		$data['js'] = $this->vic->js();
		$data['title'] = "GENERAR REPORTE DE INDICADORES";
		$this->load->view('html/head.php',$data);
		$this->load->view('html/menu.php',$data);
		$this->load->view('indicador/form.php');
		$this->load->view('indicador/js.php');
		$this->load->view('html/foot.php');
	}


	public function indicadorLista()
	{
		$row=$this->vic->datosEnviadosJS($this->input->post('cadena'));
		$ini=$this->vic->dateFormat($row['desde']);		//	2012-09-10
		$fin=$this->vic->dateFormat($row['hasta']);		//	2012-09-14
		$formato='diario';

		//	Crear rango de fechas
		$rangoFecha = $this->vic->rangoDate($ini,$fin,0,$formato);

		//	Query de Consultas
		$data=$this->modela->indicador($ini,$fin);

		if ($data->num_rows() > 0)
		{
			$cabecera_fecha=array('fecha' => array('votm' => $rangoFecha));

			//	Union de Fechas con los Datos que existe en la Base de Datos
			$union_fecha_datos=$this->modela->convertir_array_con_fechas($data,$cabecera_fecha);

			//	Agregar las fechas en las otras filas que no existen en la Base de Datos
			$array_fecha_datos=$this->agregar_fechas_a_datos($union_fecha_datos);

			array_shift($array_fecha_datos);	//	Eliminar el Primer Array (Cabecera Fechas)

			$head = $this->vista_cabecera_nombre($union_fecha_datos,'votm','ALARMAS','th');

			$body = $this->vista_cuerpo($array_fecha_datos);

			$datos['head'] = $head;
			$datos['body'] = $body;
			$datos['rows'] = $array_fecha_datos;
			$this->load->view('indicador/lista.php',$datos);
		}
		else
		{
			$get=array('OK','500','ui-icon-circle-check','Alerta','No existe Datos para Generar el Reporte de Indicadores.');
			echo $this->vic->msgBox($get);
		}

	}

	public function agregar_fechas_a_datos($arrayFecha)
	{

		//	Formamos los datos apartir del Rango de Fechas
		$clave=array_keys($arrayFecha['fecha']);	//	Sacamos los Clave Principales
		//	Comenzamos del Segunto Item
		foreach ($arrayFecha as $key => $val)
		{
			foreach ($val as $keySub => $valSub)
			{
				$vic=$this->vic->agregarFechas($arrayFecha['fecha']['votm'],$arrayFecha[$key][$keySub]);
				if(!empty($vic))
				{
					$arrayFecha[$key][$keySub]=$vic;
				}
				else
				{
					ksort($arrayFecha[$key][$keySub]);
				}
			}
		}
		return $arrayFecha;
	}

	public function vista_cabecera_nombre($array_rango_fecha,$nombre_campo,$nombre_fila,$etiqueta)
	{
		if ($etiqueta=="td") {
			$tag="td";
		}
		elseif ($etiqueta=="th") {
			$tag="th";
		}
		else {
			$tag="div";
		}

		$html="<".$tag.">".$nombre_fila."</".$tag.">";
		foreach($array_rango_fecha['fecha'][$nombre_campo] as $dia => $val)
		{
			if($dia!='Totales')
			{
				$html.= "<".$tag.">".date("d/m",strtotime($dia))."</".$tag.">";
			}
			else
			{
				$html.= "<".$tag.">".$dia."</".$tag.">";
			}
		}

		return $html;
	}

	public function vista_cuerpo($array_body)
	{
		$html="";
		foreach($array_body as $keys => $vals)
		{
			$html .= "<tr><th class='ui-state-highlight'>".$keys."</th></tr>";
			foreach ($vals as $keysSub => $valsSub )
			{
				if ($keysSub != 'Totales')
				{
					$html.="<tr><td>".$keysSub."</td>";
					foreach($valsSub as $k => $v)
					{
						$html.="<td align='center'>".$v."</td>";
					}
					$html.="</tr>";
				}
			}
		}
		return $html;
	}

	public function detalleTotal()
	{
		$text = json_decode($this->input->post('texto'), true);
		$html = "";

		foreach($text as $key => $val)
		{
			foreach ($val as $keySub => $valSub)
			{
				if ($keySub == 'Totales')
				{
					$total[$key] = $valSub['Totales'];
				}
			}
		}
		array_multisort($total, SORT_DESC);		//	Odenar el Numero Mayor
		array_shift($total);	//	Eliminar el Primer Datos

		$html .= "<div class='space ui-state-error' style='width:400px;text-align:center'>ALARMAS</div><div class='space'>&nbsp;</div>"
				."<div class='space ui-state-error' style='width:100px;text-align:center'>TOTAL</div>"
				."<div class='enter'></div>";
		$i=1;
		foreach ($total as $keyT => $valT)
		{
			if ($i > 10)
			{
				break;
			}
			$html .= "<div class='space ui-state-highlight' style='width:400px'>&nbsp;".$keyT."</div>"
					."<div class='space'>&nbsp;</div>"
					."<div class='space ui-state-highlight' style='width:100px;text-align:center'>".$valT."</div>"
					."<div class='enter'></div>";
			$i++;
		}
		echo $html;
	}

	public function criticidad()
	{
		$cssLoad = $this->vic->css();
		//~ array_push($cssLoad, 'css/visualize.css', 'css/visualize-light.css');
		$data['css'] = $cssLoad;

		$jsLoad = $this->vic->js();
		//~ array_push($jsLoad, 'js/excanvas.js', 'js/visualize.jQuery.js');
		$data['js'] = $jsLoad;

		$data['title'] = "REPORTE DE CRITICIDAD";
		$this->load->view('html/head.php',$data);
		$this->load->view('html/menu.php',$data);
		$this->load->view('criticidad/form.php');
		$this->load->view('criticidad/js.php');
		$this->load->view('html/foot.php');
	}

	public function criticidadReport()
	{
		$row=$this->vic->datosEnviadosJS($this->input->post('cadena'));
		$ini=$this->vic->dateFormat($row['desde']);
		$fin=$this->vic->dateFormat($row['hasta']);

		//	Sentencia Reporte
		$data = $this->modela->criticidad($ini,$fin);
		if ($data->num_rows() > 0) 
		{
			$datos['rows'] = $data;
			$this->load->view('criticidad/lista.php',$datos);
		}
		else 
		{
			$get=array('OK','500','ui-icon-circle-check','Alerta','No existe Datos para Generar el Reporte de Criticidad.');
			echo $this->vic->msgBox($get);
		}
		
	}
	

}

/* End of file Sys.php */
/* Location: ./application/controllers/Sys.php */
