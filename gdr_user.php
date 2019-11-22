<?php
session_start();
$timeout = time() + 3600*24*1; //Expiramos los cookies en 1 dia
require_once("js/clases.php");

ini_set('display_errors', 1);


header('Content-Type: text/html; charset=utf-8');
//zona horarios de mexico
date_default_timezone_set('America/Santiago');
$fechad=date("Y-m-d H:i:s");
$hoy=date("Y-m-d");
$origen = "web";

$data = array();

//array para el JSON
$response = array (
	"nombre" => "",
	"success" => 0,
	"idregistro" => 0,
	"error" => 0,
	"error_msg" => ""
);

//vigencia de promocion
$vigencia=false;
$inicioPromo=date("2019-09-23");
$finPromo=date("2020-01-05");
$vigencia=check_in_range($inicioPromo, $finPromo, $hoy);


if (isset($_POST['Nombre']) && isset($_POST['apellidos']) && isset($_POST['telefono']) && isset($_POST['email']) && isset($_POST['password']) &&  isset($_POST['enteraste'])) {
	//verifica vigencia
	if($vigencia){
		//pasa datos del post a nuestro array usamos una sola variable
		$data =array_map('trim',$_POST);
		//$data['origen']=$origen;
		$data['fecha']=$fechad;
		$data['hoy']=$hoy;
		$data['ip']=$_SERVER['REMOTE_ADDR'];
		//valida datos
		$valid = TRUE;

		//nombre
		if (!preg_match('/^([a-zA-Z ñáéíóú]{2,50})$/i', $data['Nombre'])) {
			$response["error_msg"].="El campo nombre solo permite letras. ";
			$valid = false;
		}
    //apellidos
		if (!preg_match('/^([a-zA-Z ñáéíóú]{2,50})$/i', $data['apellidos'])) {
			$response["error_msg"].="El campo apellidos solo permite letras. ";
			$valid = false;
		}

		//celular
		if (!preg_match('/^[0-9]{10,10}$/', $data['telefono'])) {
			$response["error_msg"].= 'Solo números para el celular 10 dígitos. ';
			$valid = false;
		}

    //correo
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
      $response["error_msg"].= 'Correo invalido. ';
      $valid = false;
    }

		//guarda registro
		if($valid){
			//si el codigo aun no esta registrado primero guardo registro
			$existe=Usuarios::buscaUsuario($data['email']);
			if($existe['encontrado']=="si"){
				//ya existe el usuario
				$response["error_msg"]="Usuario ya existente";
			}else{
				$response["error_msg"]="usuario nuevo";
				Usuarios::regUsuario($data);

				$existe=Usuarios::buscaUsuario($data['email']);
				//print_r($existe);
				if($existe['encontrado']=="si"){
					$response["error_msg"]="Registro correcto";
					$response["success"]=1;

					$resultado=array("usuario"=>$data['email'],"promo"=>"fedex19","reg_nombre"=>$data['Nombre']);
          $ses = Tocken::nuevoToken(json_encode($resultado));
  				$_SESSION['fedex19']=$ses;

				}else{
					$response["error_msg"]="Error de registro";
				}
			}
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
