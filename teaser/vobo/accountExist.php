<?php
session_start();
require_once("js/clases.php");

//array para el JSON
$response = array (
	"nombre" => "",
	"success" => 0,
	"idregistro" => 0,
	"error" => 0,
	"error_msg" => ""
);

if (isset($_SESSION['fedex19']) ) {  //existe la session
  //echo "valida usuario";
  $recievedJwt=$_SESSION['fedex19'];
  //token valido
  $tokenValid = Tocken::validaToken($recievedJwt);
  if($tokenValid){  //el token es valido
    //datos de token
    $usuarioC = Tocken::datosToken($recievedJwt);
    $usuarioC = json_decode($usuarioC, true);
    $existe=Usuarios::buscaUsuario($usuarioC['usuario']);

    if($existe['encontrado']=="si"){ //el usuario es valido
      $response["success"]=1;
    } //termina usuario
  }
}

echo json_encode($response);
?>
