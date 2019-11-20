<?php
session_start();
require ('js/clases.php');

$resp = array (
  "success" =>0,
  "fecha" =>'',
  "error_msg" => ''
);

//zona horarios de mexico
date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d H:i:s");
$hoy=date("Y-m-d");


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

      $response["success"]=1;
      $response["fecha"]=$fecha;
      $resultado=array("usuario"=>$usuarioC['usuario'],"promo"=>"fedex19","reg_nombre"=>$usuarioC['reg_nombre'],"fechaIni"=>$fecha);
      $ses = Tocken::nuevoToken(json_encode($resultado));
      $_SESSION['fedex19']=$ses;

		}else{

		}  //termina usuario

	}else{

	}// termina token

}else{

}  //termina session






echo json_encode($response);
?>
