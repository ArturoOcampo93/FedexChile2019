<?php
session_start();
require ('js/clases.php');

$resp = array (
  "success" =>0,
  "error_msg" => ''
);

//zona horarios de mexico
date_default_timezone_set('America/Santiago');
$fecha=date("Y-m-d H:i:s");
$hoy=date("Y-m-d");
//vigencia de promocion
$vigencia=false;
$inicioPromo=date("2019-11-25");
$finPromo=date("2020-01-05");
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
				$headers .= "From: noreply@promofedexchile.com\r\n";
				$headers .= "Reply-To: noreply@promofedexchile.com\r\n";
				$headers .= "Return-path: noreply@promofedexchile.com\r\n";

				mail($data['usuario'],$asunto,utf8_decode($cuerpo),$headers);


			}else{
				$response["error_msg"]="usuario no registrado";
			}
    }
  }else{
    $response["error_msg"]="Vigencia de la promoción del 25 de noviembre de 2019 al 05 de enero del 2020.";
  }
}else{
  $response["error_msg"]="Todos los datos son obligatorios";
}

echo json_encode($response);
?>
