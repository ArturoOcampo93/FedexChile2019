<?php
session_start();
require_once("js/clases.php");
$valid = true;
if (isset($_SESSION['fedex19']) ) {  //existe la session
	//echo "valida usuario";
	$recievedJwt=$_SESSION['fedex19'];
	//token valido
	$tokenValid = Tocken::validaToken($recievedJwt);

	if($tokenValid){  //el token es valido
		//datos de token
		$usuarioC = Tocken::datosToken($recievedJwt);
		$usuarioC = json_decode($usuarioC, true);
		//print_r($usuarioC);
		$existe=Usuarios::buscaUsuario($usuarioC['usuario']);

		if($existe['encontrado'] == "si"){ //el usuario es valido
		}else{
			$valid = false;
		}  //termina usuario
	}else{
		$valid = false;
	}// termina token

}else{
	$valid = false;
}  //termina session


header('Content-Type: text/html; charset=utf-8');
//zona horarios de mexico
//date_default_timezone_set('America/Mexico_City');
date_default_timezone_set('America/Santiago');
$fechad=date("Y-m-d H:i:s");
$hoy=date("Y-m-d");
$semana = date("W");
$origen = "web";

$data = array();

//array para el JSON
$response = array (
	"nombre" => "",
	"success" => 0,
	"idregistro" => 0,
	"error" => 0,
	"error_msg" => "ninguno"
);

//vigencia de promocion
$vigencia=false;
$inicioPromo=date("2019-11-25");
$finPromo=date("2020-01-05");
$vigencia=check_in_range($inicioPromo, $finPromo, $hoy);


if (isset($_POST['cajas']) && isset($_POST['guia']) && isset($_POST['fechaActual']) && isset($usuarioC['fechaIni']) && $valid == true) {
	//verifica vigencia
	if($vigencia){
		//pasa datos del post a nuestro array usamos una sola variable
		$data =array_map('trim',$_POST);
		$data['usuario']=$usuarioC['usuario'];
		$data['fecha']=$fechad;
		$data['hoy']=$hoy;
		$data['semana']=$semana;
		$data['ip']=$_SERVER['REMOTE_ADDR'];
		$data['tipo'] = "internacionales";
		//valida datos

		//cajas
		if (!preg_match('/^[0-9]{1,15}$/', $data['cajas'])) {
			$response["error_msg"].= 'Solo números para el calculo. ';
			$valid = false;
		}

		//cajas
		if (!preg_match('/^[0-9]{9,12}$/', $data['guia'])) {
			$response["error_msg"].= 'Solo números para el numero de guia. ';
			$valid = false;
		}

		if ( strlen($data['guia']) == 9) {
			$data['tipo'] = "nacionales";
		}

		if ( strlen($data['guia']) == 9 || strlen($data['guia']) == 12) {}else{
			$response["error_msg"].= 'Formato de guia incorrecto. ';
			$valid = false;
		}

		//guarda registro
		if($valid &&  $data['fechaActual'] == $usuarioC['fechaIni'] ){
			$response["error_msg"]="iguales";
			//si el codigo aun no esta registrado primero guardo registro
			$existe=Guias::buscaGuia($data['guia']);
			if($existe['encontrado']=="si"){
				//ya existe el usuario
				$response["error_msg"]="Guia ya registrada";
			}else{
				//tiempo diferencia entre las 2 fechas
				$diferencia = timeBetween($data['fechaActual'], $fechad);
				$data['tiempo'] = "Horas: ".$diferencia['horas'].", Minutos: ".$diferencia['minutos'].", Segundos: ".$diferencia['segundos'];

				$response["error_msg"]="Nueva guia";
				Guias::regGuia($data);

				$existe=Guias::buscaGuia($data['guia']);
				//print_r($existe);
				if($existe['encontrado']=="si"){
					$response["error_msg"]="Registro correcto";
					$response["success"]=1;

					$resultado=array("usuario"=>$usuarioC['usuario'],"promo"=>"fedex19","reg_nombre"=>$usuarioC['reg_nombre']);
          $ses = Tocken::nuevoToken(json_encode($resultado));
  				$_SESSION['fedex19']=$ses;

				}else{
					$response["error_msg"]="Error de registro";
				}
			}
		}else{
			$response["error_msg"]="fecha incorrecta";
		}

	}else{
		$response["error_msg"]="Vigencia de la promoción del 23 de septiembre al 30 de noviembre del 2019.";
	}
}else{

	//$response["error_msg"]="El formato de la fecha de nacimiento es incorrecto (Ej: aaaa-mm-dd) y recuerde no dejar espacios.";
	$response["error_msg"]="Todos los datos son obligatorios";
	//header("Location: registro.php");
}

echo json_encode($response);

?>
