<?php
session_start();
$timeout = time() + 3600*24*1; //Expiramos los cookies en 1 dia
require_once("js/clases.php");

ini_set('display_errors', 1);


header('Content-Type: text/html; charset=utf-8');

$data = array('mail'=>'correo');

//array para el JSON
$response = array (
"nombre" => "",
"tipo" => "",
"success" => 0,
"idregistro" => 0,
"error" => 0,
"error_msg" => ""
);

//zona horarios de mexico
date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d H:i:s");
$hoy=date("Y-m-d");


//vigencia de promocion
$vigencia=false;
$inicioPromo=date("2018-04-01");
$finPromo=date("2018-12-31");
$vigencia=check_in_range($inicioPromo, $finPromo, $hoy);




// validate $_POST data
if (isset($_POST['user'])) {

	//verifica vigencia
	if($vigencia){

		//pasa datos del post a nuestro array usamos una sola variable
		$data =array_map('trim',$_POST);

		//echo "<br><br>";
		//print_r($data);
		//valida datos
		$valid = TRUE;

		//valida datos
		//usuario
		/*if (!preg_match('/^([a-z0-9 ñáéíóú]{2,60})$/i', $data['user'])) {
			$response["error_msg"].="usuario incorrecto. ";
			$valid = false;
		}*/

		if (!filter_var($data['user'], FILTER_VALIDATE_EMAIL)) {
			$response["error_msg"].= 'usuario incorrecto. ';
			$valid = false;
		}

		//contra
		/*if (!preg_match('/^([a-z0-9 ñáéíóú]{2,60})$/i', $data['contra'])) {
			$response["error_msg"].="contraseña incorrecta. ";
			$valid = false;
		}*/

		if($valid){
			$existe=Usuarios::buscaUsuario($data['user']);
      //echo "<br>existe <br>";
      //print_r($existe);

      if($existe['encontrado']=="si"){
				//ya existe el usuario
				$response["success"]=1;

				$response["error_msg"]="usuario existente";
			}else{
				$response["error_msg"]="usuario no registrado";
			}
		}
	}else{
		//$response["error_msg"]="Vigencia ya termino.";
		$response["error_msg"]="Vigencia del 01 de abril al 19 de mayo de 2018.";
	}
}else{

	$response["error_msg"]="Todos los datos son obligatorios";
}

echo json_encode($response);
?>
