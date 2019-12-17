<?php
/***********************
conexion a base de datos
***********************/
class dbMySQL{

	/*private $host = "localhost";
	private $usuario = "root";
	private $clave = "";
	private $db = "costena";
	private $conn;*/

	//produccion
	private $host = "localhost";
	private $usuario = "fexchile_userchl";
	private $clave = 'mR2J-o7k3]-5';
	private $db = "fexchile_dexchile";
	private $conn;


	//conexion a base de datos
	public function __construct(){
		$this->conn = mysqli_connect($this->host, $this->usuario, $this->clave, $this->db);
		if(mysqli_connect_error()){
			printf("Error en la conexion a la base de datos: %d",mysqli_connect_error());
			exit;
		}else{
			//printf("Conexion exitosa.<br>");
		}
	}

	//query
	public function query($q, $op=true){
		$data = array();
		if($q!=""){
			if($r=mysqli_query($this->conn, $q)){
				if($op)@$data = mysqli_fetch_row($r);
			}
		}
		return $data;
	}

	public function query2($q){
		$data = array();
		if($q!=""){
			if($r=mysqli_query($this->conn, $q)){
				while($row =  mysqli_fetch_row($r)){
					array_push($data, $row);
				}
			}
		}
		return $data;
	}


	//cerrar conexion a base de datos
	public function close(){
		mysqli_close($this->conn);
		//print "Cerrar la conexion de forma exitosa";
	}
}



/***********************
Reportes
***********************/

class Reportes{
	private $id;

	function __construct(){	}

	public static function repRegistros($desde, $hasta){

		$respuest=array();

		$desde=$desde." 00:00:00";
		$hasta=$hasta." 23:59:59";
		$reg=0;
		$par=0;

		$db = new dbMySQL();
		$data = $db->query("SELECT COUNT(*) FROM `tbl_registro` WHERE `cFecha` between '".$desde."' AND '".$hasta."'");
		$db->close();
		unset($db);
		$reg = $data[0];

		$db = new dbMySQL();
		$datah = $db->query("SELECT COUNT(*) FROM `tbl_guias` WHERE `cFecha` between '".$desde."' AND '".$hasta."'");
		$db->close();
		unset($db);
		$par = $datah[0];



		$respuest=array("reg"=>$reg,"guias"=>$par);

		return $respuest;
		//return "SELECT COUNT(*) FROM tbl_registro WHERE cFecha between '".$desde."' AND '".$hasta."'";
	}

	//edad
	public static function repEmpresas($desde, $hasta){

		$desde=$desde." 00:00:00";
		$hasta=$hasta." 23:59:59";

		$db = new dbMySQL();
		$data = $db->query2("SELECT `cNombreEmpresa`, count( * ) cuantos FROM  `tbl_registro` WHERE  `cFecha` between '$desde' and '$hasta' GROUP BY `cNombreEmpresa`");
		$db->close();
		unset($db);

		return $data;
	}



	public static function repRegsxDia($desde, $hasta){

		$desde=$desde." 00:00:00";
		$hasta=$hasta." 23:59:59";

		$db = new dbMySQL();
		$data = $db->query2("SELECT `cDia`, count(*) FROM `tbl_registro`	WHERE cFecha between '$desde' and '$hasta' group by `cDia`");

		$db->close();
		unset($db);
		return $data;
	}

	public static function repTicketsxDia($desde, $hasta){

		$desde=$desde." 00:00:00";
		$hasta=$hasta." 23:59:59";

		$db = new dbMySQL();
		$data = $db->query2("SELECT `cDia`, count(*) FROM `tbl_guias` WHERE `cFecha` between '$desde' and '$hasta' group by `cDia`");

		$db->close();
		unset($db);
		return $data;
	}


}



/***********************
dentro de un rango de dias
***********************/
function check_in_range($start_date, $end_date, $evaluame) {
    $start_ts = strtotime($start_date);
    $end_ts = strtotime($end_date);
    $user_ts = strtotime($evaluame);
    return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
}



/***********************
 calcula diferencia
 ************************/
 function timeBetween($desde,$hasta) {
    $ini = explode(" ",$desde);
    $fIni = $ini[0];
    $hIni = $ini[1];
    $fIni = explode("-",$fIni);
    $hIni = explode(":",$hIni);

    $fin = explode(" ",$hasta);
    $fFin = $fin[0];
    $hFin = $fin[1];
    $fFin = explode("-",$fFin);
    $hFin = explode(":",$hFin);

    $anos = $fFin[0] - $fIni[0];
    $meses = $fFin[1] - $fIni[1];
    $dias = $fFin[2] - $fIni[2];
    $horas = $hFin[0] - $hIni[0];
    $minutos = $hFin[1] - $hIni[1];
    $segundos = $hFin[2] - $hIni[2];

    if ($segundos < 0) {
        $minutos--;
        $segundos = 60 + $segundos;
    }
    if ($minutos < 0) {
        $horas--;
        $minutos = 60 + $minutos;
    }
    if ($horas < 0) {
        $dias--;
        $horas = 24 + $horas;
    }
    if ($dias < 0)
    {
        --$meses;
        switch ($fIni[1]) {
            case 1:     $dias_mes_anterior=31; break;
            case 2:     $dias_mes_anterior=31; break;
            case 3:
                if (checkdate(2,29,$fIni[0]))
                {
                    $dias_mes_anterior=29; break;
                } else {
                    $dias_mes_anterior=28; break;
                }
            case 4:     $dias_mes_anterior=31; break;
            case 5:     $dias_mes_anterior=30; break;
            case 6:     $dias_mes_anterior=31; break;
            case 7:     $dias_mes_anterior=30; break;
            case 8:     $dias_mes_anterior=31; break;
            case 9:     $dias_mes_anterior=31; break;
            case 10:     $dias_mes_anterior=30; break;
            case 11:     $dias_mes_anterior=31; break;
            case 12:     $dias_mes_anterior=30; break;
        }

        $dias=$dias + $dias_mes_anterior;
    }
    if ($meses < 0)
    {
        --$anos;
        $meses = $meses + 12;
    }
    return array("ayos" => $anos,
                "meses" => $meses,
                "dias" => $dias,
                "horas" => $horas,
                "minutos" => $minutos,
                "segundos" => $segundos);
}


//acompletar con ceros un numero 1 -> 001
//$6digitos = number_pad($numero,6);
function number_pad($number,$n) {
  return str_pad((int) $number,$n,"0",STR_PAD_LEFT);
}

?>
