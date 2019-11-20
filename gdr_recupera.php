<?php
session_start();
require ('js/clases.php');

$resp = array (
  "success" =>0,
  "error_msg" => ''
);

//zona horarios de mexico
date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d H:i:s");
$hoy=date("Y-m-d");
//vigencia de promocion
$vigencia=false;
$inicioPromo=date("2019-09-23");
$finPromo=date("2019-11-30");
$vigencia=check_in_range($inicioPromo, $finPromo, $hoy);

if (isset($_POST['usuario']) ) {
  if($vigencia){
    $data =array_map('trim',$_POST);
		//valida datos
		$valid = TRUE;

		if (!filter_var($data['usuario'], FILTER_VALIDATE_EMAIL)) {
			$response["error_msg"].= 'usuario incorrecto. ';
			$valid = false;
		}
    if($valid){
			$existe=Usuarios::buscaUsuarioRecupera($data['usuario']);
      if($existe['encontrado']=="si"){
				//ya existe el usuario
				$response["success"]=1;
				$response["error_msg"]="usuario existente";

        //noreply@promofedex.com.mx

				//envia correo con contraseña
        //$existe['contrasena'];
        $asunto ="Promofedex recupera contraseña";

				$cuerpo='
        <!DOCTYPE HTML>
        <html>
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Tu Posibilidad de Ganar</title>
        </head>

        <body style="background: #4c148c; color:white;">
          <div style="text-align:center;">
            <img src="https://promofedex.com.mx/vobo/images/logo_fedex.png" alt="logo_fedex">
            <h1>Tu Posibilidad de Ganar</h1>
            <p>Contraseña:'.$existe['contrasena'].' </p>

          </div>
        </body>
        </html>';
				$headers = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$headers .= "From: noreply@promofedex.com.mx\r\n";
				$headers .= "Reply-To: noreply@promofedex.com.mx\r\n";
				$headers .= "Return-path: noreply@promofedex.com.mx\r\n";

				mail($data['usuario'],$asunto,utf8_decode($cuerpo),$headers);


			}else{
				$response["error_msg"]="usuario no registrado";
			}
    }
  }else{
    $response["error_msg"]="Vigencia de la promoción del 23 de septiembre al 30 de noviembre del 2019.";
  }
}else{
  $response["error_msg"]="Todos los datos son obligatorios";
}


echo json_encode($response);
?>
