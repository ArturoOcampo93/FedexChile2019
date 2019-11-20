<?php
/***********************
conexion a base de datos
***********************/
class dbMySQL{

	/*private $host = "localhost";
	private $usuario = "root";
	private $clave = "";
	private $db = "fedex";
	private $conn;*/

	//produccion
	private $host = "localhost";
	private $usuario = "promofex_crtgm";
	private $clave = "JnWb0[aBoKpI";
	private $db = "promofex_cartas";
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
		$data = $db->query("select count(*) cuantos from tbl_registro where cCorreo='".$correo."'");
		$db->close();
		unset($db);

		$cuantos = $data[0];
		//$nombre = $data[1];

		if($cuantos>=1){
			$respuest=array("encontrado"=>"si", "correo"=>$correo);

			return $respuest;
		}else{

			$respuest=array("encontrado"=>"no","err"=>"Este usuario no existe.");
			return $respuest;
		}
		return $respuest;
	}



	public static function regUsuario($data){
		$db = new dbMySQL();
		$dateReg = $db->query("INSERT INTO `tbl_registro` (`nId`, `cNombre`, `cNacimiento`, `cTelefono`, `cDireccion`, `cEstado`, `cCorreo`, `cTerminos`, `cDia`, `cFecha`, `cIp`, `cOrigen`) VALUES (NULL, '".$data['nombre']."', '".$data['fecha']."', '".$data['telefono']."', '".$data['direccion']."', '".$data['estado']."', '".$data['correo']."', 'ok', '".$data['hoy']."', '".$data['fechareg']."', '".$data['ip']."', '".$data['origen']."');");
		$db->close();
		unset($db);

		//return "INSERT INTO `tbl_participantes` (`nId`, `cNombre`, `cPaterno`, `cMaterno`, `cCorreo`, `cTelefono`, `cRegistrante`, `cEstatus`, `cDia`, `cFecha`, `cDetalle`) VALUES (NULL, '".$data['nombre']."', '".$data['paterno']."', '".$data['materno']."', '".$data['correo']."', '".$data['telefono']."', '".$data['registrante']."', '".$data['estatus']."', '".$data['hoy']."', '".$data['fecha']."', '".$data['detalle']."');";
	}

	public static function buscaNombre($usuario){
		$db = new dbMySQL();
		$data = $db->query("SELECT * FROM `tbl_registro` WHERE `cCorreo`='$usuario'");
		$db->close();
		unset($db);

		return $data;
	}

	public static function guias($usuario){
		$db = new dbMySQL();
		$data = $db->query2("SELECT `nId`, `cUser`, `cGuia`, `cCuenta`, `cEstatus`, `cPremio`, `cBoleto`, `cDia` FROM `tbl_guiausuario` WHERE `cUser` = '".$usuario."'");
		$db->close();
		unset($db);

		return $data;
	}

	public static function cuantosRegistros(){
		$db = new dbMySQL();
		$data = $db->query("SELECT COUNT(*) FROM `tbl_registro`");
		$db->close();
		unset($db);

		return $data[0];
	}
	public static function cuantosParticipaciones(){
		$db = new dbMySQL();
		$data = $db->query("SELECT COUNT(*) FROM `tbl_guiausuario`");
		$db->close();
		unset($db);

		return $data[0];
	}

	public static function cuantosParticipacionesGan(){
		$db = new dbMySQL();
		//$data = $db->query("SELECT COUNT(*) FROM `tbl_guiausuario` WHERE  `cEstatus` = 'ok' AND `cPremio` IN('Smartwhatch', 'Tablet', 'Smart TV', 'Laptop', 'Bocinas' ) ");
		$data = $db->query("SELECT COUNT(*) FROM `tbl_guiausuario` WHERE  `cEstatus` = 'ok' AND `cBoleto`!= '' ");
		$db->close();
		unset($db);

		return $data[0];
	}

	public static function cuantosTickets(){
		$db = new dbMySQL();
		$data = $db->query("SELECT COUNT(*) FROM `tbl_ticket`");
		$db->close();
		unset($db);

		return $data[0];
	}


	public static function registrosPagina($pagina, $por_pagina){
		$pagina-=1;
		$desde = $pagina * $por_pagina;

		$db = new dbMySQL();
		$data = $db->query2("SELECT * FROM `tbl_registro` ORDER BY nId LIMIT ".$desde.", ".$por_pagina." ");
		$db->close();
		unset($db);

		return $data;
	}

	public static function cuantosTicketsSemana( $semana ){
		$db = new dbMySQL();
		$data = $db->query("SELECT COUNT(*) FROM `tbl_ticket` WHERE cSemana ='".$semana."' ");
		$db->close();
		unset($db);

		return $data[0];
	}

	public static function ticketsPagina($semana, $pagina, $por_pagina){
		$pagina-=1;
		$desde = $pagina * $por_pagina;

		$db = new dbMySQL();
		$data = $db->query2("SELECT A.`nIdSemana`, B.`cNombre`, B.`cEstado`, B.`cCorreo`, A.`cTicket`, A.`cMonto`, A.`cFecha`, A.`cEstatus`, A.`cOrigen`, A.`cPremio`  FROM `tbl_ticket` AS A, `tbl_registro` AS B  WHERE A.`cUsuario` = B.`cCorreo` AND  A.`cSemana` = '".$semana."' ORDER BY A.`nIdSemana` LIMIT ".$desde.", ".$por_pagina." ");
		$db->close();
		unset($db);

		return $data;
	}

	public static function ganadoresTodos($semana){
		$db = new dbMySQL();
		$data = $db->query2("SELECT B.`nIdSemana`, CONCAT(A.`cNombre`,' ',A.`cPaterno`,' ',A.`cMaterno` ), A.`cNacimiento`, A.`cTelefono`, A.`cCelular`, A.`cEstado`, A.`cCorreo`, B.`cTicket`, B.`cMonto`, B.`cEstatus` FROM `tbl_registro` AS A, `tbl_ticket` AS B WHERE A.cCorreo = B.cUsuario AND B.cSemana ='".$semana."' ORDER BY B.`nIdSemana`");
		$db->close();
		unset($db);

		return $data;
	}
}

/***********************
funcion para usuarios
***********************/
class Guias{
	function __construct(){	}
	//ganadores de dia
	public static function cuantosGan($dia){
		$db = new dbMySQL();
		$data = $db->query("SELECT COUNT(*) FROM `tbl_guiausuario` WHERE `cDia`='".$dia."' AND `cEstatus` = 'ok' ");
		$db->close();
		unset($db);

		return $data[0];
	}

	//paginar ganadores por dia
	public static function ganadoresPagina($pagina, $por_pagina, $dia){
		$pagina-=1;
		$desde = $pagina * $por_pagina;

		$db = new dbMySQL();
		$data = $db->query2("SELECT * FROM `tbl_guiausuario`  WHERE `cDia`='".$dia."' AND `cEstatus` = 'ok' ORDER BY nId LIMIT ".$desde.", ".$por_pagina." ");
		$db->close();
		unset($db);

		return $data;
	}

//guias por dia
	public static function cuantosParticipaciones($dia){
		$db = new dbMySQL();
		$data = $db->query("SELECT COUNT(*) FROM `tbl_guiausuario` WHERE `cDia`='".$dia."' ");
		$db->close();
		unset($db);

		return $data[0];
	}

	//por dia
	public static function cuantosParticipacionesDia($dia){
		$db = new dbMySQL();
		$data = $db->query2("SELECT * FROM `tbl_guiausuario` WHERE `cDia`='".$dia."' ");
		$db->close();
		unset($db);

		return $data;
	}

	//por semana
	public static function cuantosParticipacionesSemana($semana){
		$db = new dbMySQL();
		$data = $db->query2("SELECT * FROM `tbl_guiausuario` WHERE `cDia`='".$semana."'");
		$db->close();
		unset($db);

		return $data;
	}

	public static function datosGuia($guia){
		$db = new dbMySQL();
		$data = $db->query("SELECT * FROM `tbl_guia` WHERE `cGuia`='".$guia."' ");
		$db->close();
		unset($db);

		return $data;
	}

	//guias por dia y limit
	public static function participacionesPagina($pagina, $por_pagina, $dia){
		$pagina-=1;
		$desde = $pagina * $por_pagina;

		$db = new dbMySQL();
		$data = $db->query2("SELECT * FROM `tbl_guiausuario`  WHERE `cDia`='".$dia."' ORDER BY nId LIMIT ".$desde.", ".$por_pagina." ");
		$db->close();
		unset($db);

		return $data;
	}

	//actualiza tipo de guias
	public static function guiaSinTipo($semana){
		$db = new dbMySQL();
		$data = $db->query2("SELECT `nId`, `cGuia`, `cCuenta` FROM `tbl_guiausuario` WHERE `cCuenta`!='' AND `cTipo`='' AND `cSemana`='".$semana."'");
		$db->close();
		unset($db);

		return $data;
	}

	//busca tipo
	public static function tipoGuia($guia, $id){
		$db = new dbMySQL();
		$data = $db->query("SELECT `cServicio` FROM `tbl_guia` WHERE `cGuia`='".$guia."'");
		$db->close();
		unset($db);

		$tipo = $data[0];

		if ($tipo == '') {
		}else{
			//actualiza el tipo
			$db = new dbMySQL();
			$data = $db->query("UPDATE `tbl_guiausuario` SET `cTipo` = '".$tipo."'  WHERE `nId`=".$id." LIMIT 1");
			$db->close();
			unset($db);
		}
	}


	//total de guias por usuario
	public static function guiasusuarios($usuario){
		$db = new dbMySQL();
		$data = $db->query("SELECT COUNT(*) cuantos FROM `tbl_guiausuario` WHERE `cUser`='".$usuario."'");
		$db->close();
		unset($db);

		return $data[0];
	}

	public static function nuevaGuia($data){
		date_default_timezone_set('America/Mexico_City');
		//$fechaReg=date("Y-m-d H:i:s");
		$hoy=date("Y-m-d");
		$db = new dbMySQL();
		$dateReg = $db->query("INSERT INTO `tbl_guia` (`nId`, `cGuia`, `cUs`, `cCuenta`, `cDate`, `cNombreCuenta`, `cSegmentacion`, `cServicio`, `cDia`) VALUES (NULL, '".$data[0]."', '".$data[1]."', '".$data[2]."', '".$data[3]."', '".$data[4]."', '".$data[5]."', '".$data[6]."', '".$hoy."');");
		$db->close();
		unset($db);

		//return "INSERT INTO `tbl_guia` (`nId`, `cGuia`, `cUs`, `cCuenta`, `cNombreCuenta`, `cSegmentacion`, `cServicio`, `cDia`) VALUES (NULL, '".$data[0]."', '".$data[1]."', '".$data[2]."', '".$data[3]."', '".$data[4]."', '".$data[5]."', '".$hoy."');";
	}

	//cancela guias despues de 3 dias
	public static function cancelaGuia($hoy){
		$fecha = date($hoy);
		$nuevafecha = strtotime ( '-4 day' , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );

		$db = new dbMySQL();
		$dateReg = $db->query("UPDATE `tbl_guiausuario` SET `cEstatus` = 'cancelada' WHERE `cDia`<='".$nuevafecha."' AND `cEstatus` = 'Pendiente'");
		$db->close();
		unset($db);

		$db = new dbMySQL();
		$dateReg = $db->query("UPDATE `tbl_guiausuario` SET `cEstatus` = 'cancelada' WHERE `cDia`<='".$hoy."' AND `cPremio` = ''");
		$db->close();
		unset($db);
	}

	//limite de 3
	public static function validaGuiasLimite3($id, $cuenta, $dia, $estatus){
		//busca hasta tres cuentas
		$db = new dbMySQL();
		$dataCuentasRep = $db->query("SELECT COUNT(*) cuantos FROM `tbl_guiausuario` WHERE `cCuenta`='".$cuenta."' AND `cDia` = '".$dia."'");
		$db->close();
		unset($db);

		$cuantasCts = $dataCuentasRep[0];

		if($cuantasCts>=3){
			//actualiza guias validas
			$db = new dbMySQL();
			$dataUpdt = $db->query("UPDATE `tbl_guiausuario` SET `cEstatus` = 'cancelada' WHERE `nId` =".$id);
			$db->close();
			unset($db);
			$estatus = 'cancelada';
		}

		return $estatus;
	}
	//marca guias validas
	public static function validaGuiasId($id, $guia, $dia, $estatus){
		//busca guia en base fedex

			$db = new dbMySQL();
			$dataGuia = $db->query("SELECT COUNT(*) cuantos, `cCuenta`, `cServicio`  FROM `tbl_guia` WHERE `cGuia`='".$guia."'");
			$db->close();
			unset($db);

			$cuenta = $dataGuia[1];
			$serv = $dataGuia[2];
			//$estatus = "";

			if($dataGuia[0]>=1){
				//busca hasta tres cuentas
				$db = new dbMySQL();
				$dataCuentasRep = $db->query("SELECT COUNT(*) cuantos FROM `tbl_guiausuario` WHERE `cCuenta`='".$cuenta."' AND `cDia` = '".$dia."'");
				$db->close();
				unset($db);

				$cuantasCts = $dataCuentasRep[0];

				if($cuantasCts<3){
					//actualiza guias validas
					$db = new dbMySQL();
					$dataUpdt = $db->query("UPDATE `tbl_guiausuario` SET `cEstatus` = 'ok', `cCuenta`='".$cuenta."', `cTipo`='".$serv."' WHERE `nId` =".$id);
					$db->close();
					unset($db);
					$estatus = "ok";
				}else{
					//actualiza guias validas
					$db = new dbMySQL();
					$dataUpdt = $db->query("UPDATE `tbl_guiausuario` SET `cEstatus` = 'cancelada', `cCuenta`='".$cuenta."', `cTipo`='".$serv."' WHERE `nId` =".$id);
					$db->close();
					unset($db);
					$estatus = "cancelada";
				}
			}
			$respuest=array("cuenta"=>$cuenta, "estatus"=>$estatus);

			return $respuest;
	}
	public static function validaGuias($dia){
		$db = new dbMySQL();
		$listaGuias = $db->query2("SELECT `nId`, `cGuia`, `cCuenta` FROM `tbl_guiausuario` WHERE  `cEstatus` = 'Pendiente' AND `cDia` = '".$dia."' LIMIT 500");
		$db->close();
		unset($db);

		for ($i=0; $i < count($listaGuias); $i++) {
			$id = $listaGuias[$i][0];
			$guia = $listaGuias[$i][1];
			$cuenta = $listaGuias[$i][2];

			//busca guia en base fedex
			if($cuenta == ""){
				$db = new dbMySQL();
				$dataGuia = $db->query("SELECT COUNT(*) cuantos, `cCuenta` FROM `tbl_guia` WHERE `cGuia`='".$guia."'");
				$db->close();
				unset($db);

				$cuenta = $dataGuia[1];

				if($dataGuia[0]>=1){
					//busca hasta tres cuentas
					$db = new dbMySQL();
					$dataCuentasRep = $db->query("SELECT COUNT(*) cuantos FROM `tbl_guiausuario` WHERE `cCuenta`='".$cuenta."' AND `cDia` = '".$dia."'");
					$db->close();
					unset($db);

					$cuantasCts = $dataCuentasRep[0];

					if($cuantasCts<3){
						//actualiza guias validas
						$db = new dbMySQL();
						$dataUpdt = $db->query("UPDATE `tbl_guiausuario` SET `cEstatus` = 'ok', `cCuenta`='".$cuenta."' WHERE `nId` =".$id);
						$db->close();
						unset($db);
					}else{
						//actualiza guias validas
						$db = new dbMySQL();
						$dataUpdt = $db->query("UPDATE `tbl_guiausuario` SET `cEstatus` = 'cancelada', `cCuenta`='".$cuenta."' WHERE `nId` =".$id);
						$db->close();
						unset($db);
					}

				}
			}else{
				//busca hasta tres cuentas
				$db = new dbMySQL();
				$dataCuentasRep = $db->query("SELECT COUNT(*) cuantos FROM `tbl_guiausuario` WHERE `cCuenta`='".$cuenta."' AND `cDia` = '".$dia."'");
				$db->close();
				unset($db);

				$cuantasCts = $dataCuentasRep[0];

				if($cuantasCts>=3){
					//actualiza guias validas
					$db = new dbMySQL();
					$dataUpdt = $db->query("UPDATE `tbl_guiausuario` SET `cEstatus` = 'cancelada' WHERE `nId` =".$id);
					$db->close();
					unset($db);

				}

			}



		}

	}//termina marca

	//lista de guias validas
	public static function lista100Guias($dia){
		$db = new dbMySQL();
		$listaGuias = $db->query2("SELECT `cUser`, `cGuia`, `cCuenta`, `cEstatus`, `cPremio`, `cBoleto`, `nIdPremio`, `nId` FROM `tbl_guiausuario` WHERE `cEstatus` = 'ok' AND `cDia` = '".$dia."' AND `cBoleto` = '' LIMIT 100");
		$db->close();
		unset($db);

		return $listaGuias;
	}
	//actualiza recarga
	public static function actualizaRecarga($id, $monto){
		//actualiza recarga
		$db = new dbMySQL();
		$listaGuias = $db->query("UPDATE `tbl_recargas` SET `cEstatus`='".$id."' WHERE `cEstatus` = '' AND `cMonto` = '".$monto."' LIMIT 1");
		$db->close();
		unset($db);

		//trea codigo premio
		$db = new dbMySQL();
		$listaGuias = $db->query("SELECT `cCodigo` FROM `tbl_recargas` WHERE `cEstatus`='".$id."'");
		$db->close();
		unset($db);

		return $listaGuias[0];
	}

	//actualiza cine y clik
	public static function actualizaCine($id, $tipoCine){
		//actualiza recarga
		$db = new dbMySQL();
		$listaGuias = $db->query("UPDATE `tbl_cine` SET `cEstatus`='".$id."' WHERE `cEstatus` = '' AND `cTipo` = '".$tipoCine."' LIMIT 1");
		$db->close();
		unset($db);

		//trea codigo premio
		$db = new dbMySQL();
		$listaGuias = $db->query("SELECT `cCodigo` FROM `tbl_cine` WHERE `cEstatus`='".$id."'");
		$db->close();
		unset($db);

		return $listaGuias[0];
	}

	//actualiza cono
	public static function actualizaBurguer($id, $tipoCine){
		//actualiza recarga
		$db = new dbMySQL();
		$listaGuias = $db->query("UPDATE `tbl_burguer` SET `cEstatus`='".$id."' WHERE `cEstatus` = '' AND `cTipo` = '".$tipoCine."' LIMIT 1");
		$db->close();
		unset($db);

		//trea codigo premio
		$db = new dbMySQL();
		$listaGuias = $db->query("SELECT `cCodigo` FROM `tbl_burguer` WHERE `cEstatus`='".$id."'");
		$db->close();
		unset($db);

		return $listaGuias[0];
	}

	//actualiza starbucks
	public static function actualizaStarbucks($id, $tipo){
		//actualiza recarga
		$db = new dbMySQL();
		$listaGuias = $db->query("UPDATE `tbl_starbucks` SET `cEstatus`='".$id."' WHERE `cEstatus` = '' AND `cTipo` = '".$tipo."' LIMIT 1");
		$db->close();
		unset($db);

		//trea codigo premio
		$db = new dbMySQL();
		$listaGuias = $db->query("SELECT `cCodigo`, `cPin` FROM `tbl_starbucks` WHERE `cEstatus`='".$id."'");
		$db->close();
		unset($db);

		if($tipo == 'cafe'){
			return $listaGuias[0];
		}else{
			return $listaGuias;
		}

	}

	//actualiza guia de usuario
	public static function actualizaGuiaUsuario($id, $imagen){
		$db = new dbMySQL();
		$listaGuias = $db->query("UPDATE `tbl_guiausuario` SET `cBoleto`='".$imagen."' WHERE `cEstatus` = 'ok' AND `nId` = ".$id);
		$db->close();
		unset($db);

	}
}



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
		$secret_key = 'promoCostena18';
		// Creating the signature, a hash with the s256 algorithm and the secret key. The signature is also base64 encoded.
		$signature = base64_encode(hash_hmac('sha256', $header_payload, $secret_key, true));
		// Creating the JWT token by concatenating the signature with the header and payload, that looks like this:
		$jwt_token = $header_payload . '.' . $signature;

		return $jwt_token;
	}


	public static function validaToken( $recievedJwt  ){
		$secret_key = 'promoCostena18';
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
		$secret_key = 'promoCostena18';
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


/********************
PAGINACION
********************/
function paginar_todo($pagina =1, $por_pagina = 20, $cuantos){

  if (!isset($por_pagina)) {
    $por_pagina = 20;
  }

  if (!isset($pagina)) {
    $pagina = 1;
  }

  $total_paginas = ceil($cuantos / $por_pagina);

  if($pagina > $total_paginas){
    $pagina = $total_paginas;
  }
  $pagina-=1;
  $desde = $pagina * $por_pagina;

  //pagina siguiente
  if ($pagina >= $total_paginas-1) {
    $pag_siguiente = 1;
  }else{
    $pag_siguiente = $pagina + 2;
  }

  //pagina anterior
  if($pagina < 1){
    $pag_anterior = $total_paginas;
  }else{
    $pag_anterior = $pagina;
  }


  $respuesta = array(
    'err' => FALSE,
    'cuantos' => $cuantos,
    'total_paginas' => $total_paginas,
    'pagina_actual' => $pagina+1,
    'pagina_siguiente' => $pag_siguiente,
    'pagina_anterior' => $pag_anterior
  );

  return $respuesta;
  //$this->response($respuesta);
}


?>
