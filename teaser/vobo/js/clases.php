<?php
/***********************
conexion a base de datos
***********************/
class dbMySQL{

	/*private $host = "localhost";
	private $usuario = "root";
	private $clave = "";
	private $db = "fedex19";
	private $conn;*/

	//produccion
	private $host = "localhost";
	private $usuario = "promofex_usr19";
	private $clave = 'UmEmf_zR0m#F';
	private $db = "promofex_fedex19";
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
funcion para usuarios
***********************/
class Usuarios{
	private $id;
	private $correo;

	function __construct(){	}

	public static function buscaUsuario($correo){
		$respuest=array();
		$cuantos = 0;
		$nombre = "";

		$db = new dbMySQL();
		$data = $db->query("SELECT COUNT(*) cuantos FROM `tbl_registro` WHERE `cCorreo`='".$correo."'");
		$db->close();
		unset($db);

		$cuantos = $data[0];


		if($cuantos>=1){

			$db = new dbMySQL();
			$data = $db->query("SELECT `cNombre` FROM `tbl_registro` WHERE `cCorreo`='".$correo."'");
			$db->close();
			unset($db);
			$nombre = $data[0];

			$respuest=array("encontrado"=>"si","nombre"=>$nombre,"correo"=>$correo);
		}else{
			$respuest=array("encontrado"=>"no","err"=>"Este usuario no existe.");
		}
		return $respuest;
	}  //termina buscaUsuario

	//login
	public static function buscaUsuarioLogin($dataLogin){
		$respuest=array();
		$cuantos = 0;
		$nombre = "";

		$db = new dbMySQL();
		$data = $db->query("SELECT COUNT(*) cuantos FROM `tbl_registro` WHERE `cCorreo`='".$dataLogin['usuario']."' AND `cContrasena`='".$dataLogin['contrasena']."'");
		$db->close();
		unset($db);

		$cuantos = $data[0];

		if($cuantos>=1){

			$db = new dbMySQL();
			$data = $db->query("SELECT `cNombre` FROM `tbl_registro` WHERE `cCorreo`='".$dataLogin['usuario']."'");
			$db->close();
			unset($db);
			$nombre = $data[0];

			$respuest=array("encontrado"=>"si","nombre"=>$nombre,"correo"=>$dataLogin['usuario']);
		}else{
			$respuest=array("encontrado"=>"no","err"=>"Este usuario no existe.");
		}
		return $respuest;
	}  //termina buscaUsuario login


//registro nuevo
  public static function regUsuario($data){
    $db = new dbMySQL();
    $dateReg = $db->query("INSERT INTO `tbl_registro` (`cNombre`,`cApellidos`,`cTelefono`,`cCorreo`,`cContrasena`,`cNombreEmpresa`,`cDia`,`cFecha`,`cIp`) VALUES ('".$data['Nombre']."','".$data['apellidos']."','".$data['telefono']."','".$data['email']."','".$data['password']."','".$data['empresa']."','".$data['hoy']."','".$data['fecha']."','".$data['ip']."');");
    $db->close();
    unset($db);
  }  //termina registro


//recupera contrasena
	public static function buscaUsuarioRecupera($correo){
		$respuest=array();
		$cuantos = 0;
		$nombre = "";

		$db = new dbMySQL();
		$data = $db->query("SELECT COUNT(*) cuantos FROM `tbl_registro` WHERE `cCorreo`='".$correo."'");
		$db->close();
		unset($db);

		$cuantos = $data[0];

		if($cuantos>=1){

			$db = new dbMySQL();
			$data = $db->query("SELECT `cContrasena` FROM `tbl_registro` WHERE `cCorreo`='".$correo."'");
			$db->close();
			unset($db);
			$contrasena = $data[0];

			$respuest=array("encontrado"=>"si","contrasena"=>$contrasena);
		}else{
			$respuest=array("encontrado"=>"no","err"=>"Este usuario no existe.");
		}
		return $respuest;
	}  //termina recupera contrasena



}  //termina funciones de usuario




/***********************
funcion para usuarios
***********************/
class Guias{
	private $id;
	private $correo;

	function __construct(){	}

	//busca guia
	public static function buscaGuia($guia){
		$respuest=array();
		$cuantos = 0;
		$nombre = "";

		$db = new dbMySQL();
		$data = $db->query("SELECT COUNT(*) cuantos FROM `tbl_guias` WHERE `cGuia`='".$guia."'");
		$db->close();
		unset($db);

		$cuantos = $data[0];

		if($cuantos>=1){
			$respuest=array("encontrado"=>"si");
		}else{
			$respuest=array("encontrado"=>"no","err"=>"Este usuario no existe.");
		}
		return $respuest;
	}  //termina buscaguia


	//registra nueva guia
	public static function regGuia($data){
		$db = new dbMySQL();
		$dateReg = $db->query("INSERT INTO `tbl_guias` (`cUsuario`,`cGuia`,`cCalculo`,`cFechaIni`,`cFecha`,`cTiempo`,`cDia`,`cSemana`,`cIp`) VALUES ('".$data['usuario']."','".$data['guia']."','".$data['cajas']."','".$data['fechaActual']."','".$data['fecha']."','".$data['tiempo']."','".$data['hoy']."','".$data['semana']."','".$data['ip']."');");
		$db->close();
		unset($db);
	}  //termina registro nueva guia

	//historial de guias
	public static function todasGuias($usuario){
		$db = new dbMySQL();
		$data = $db->query2("SELECT * FROM  `tbl_guias` WHERE `cUsuario` = '".$usuario."'");
		$db->close();
		unset($db);

		return $data;
	}  //termina registro nueva guia


}
//terminan guias












/***********************
funcion encriptar
***********************/
class Tocken{
	function __construct(){	}

	public static function nuevoToken( $json ){
		// base64 encodes the header json
		$encoded_header = base64_encode('{"alg": "HS256","typ": "JWT"}');
		// base64 encodes the payload json
		$encoded_payload = base64_encode($json);
		// base64 strings are concatenated to one that looks like this
		$header_payload = $encoded_header . '.' . $encoded_payload;
		//Setting the secret key
		$secret_key = 'promosBayer18';
		// Creating the signature, a hash with the s256 algorithm and the secret key. The signature is also base64 encoded.
		$signature = base64_encode(hash_hmac('sha256', $header_payload, $secret_key, true));
		// Creating the JWT token by concatenating the signature with the header and payload, that looks like this:
		$jwt_token = $header_payload . '.' . $signature;

		return $jwt_token;
	}


	public static function validaToken( $recievedJwt  ){
		$secret_key = 'promosBayer18';
		// Split a string by '.'
		$jwt_values = explode('.', $recievedJwt);
		// extracting the signature from the original JWT
		$recieved_signature = $jwt_values[2];
		// concatenating the first two arguments of the $jwt_values array, representing the header and the payload
		$recievedHeaderAndPayload = $jwt_values[0] . '.' . $jwt_values[1];
		// creating the Base 64 encoded new signature generated by applying the HMAC method to the concatenated header and payload values
		$resultedsignature = base64_encode(hash_hmac('sha256', $recievedHeaderAndPayload, $secret_key, true));
		// checking if the created signature is equal to the received signature
		if($resultedsignature == $recieved_signature) {
			return true;
		}else{
			return false;
		}
	}


	public static function datosToken( $recievedJwt  ){
		$secret_key = 'promosBayer18';
		// Split a string by '.'
		$jwt_values = explode('.', $recievedJwt);
		// extracting the signature from the original JWT
		$recieved_signature = $jwt_values[2];
		// concatenating the first two arguments of the $jwt_values array, representing the header and the payload
		$payload = base64_decode($jwt_values[1]);
		return $payload;

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
