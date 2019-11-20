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
$inicioPromo=date("2019-04-15");
$finPromo=date("2019-12-31");
$vigencia=check_in_range($inicioPromo, $finPromo, $hoy);

if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
  if($vigencia){
    $data =array_map('trim',$_POST);
		//valida datos
		$valid = TRUE;

		if (!filter_var($data['usuario'], FILTER_VALIDATE_EMAIL)) {
			$response["error_msg"].= 'usuario incorrecto. ';
			$valid = false;
		}
    if($valid){
			$existe=Usuarios::buscaUsuarioLogin($data);
      if($existe['encontrado']=="si"){
				//ya existe el usuario
				$response["success"]=1;

				$response["error_msg"]="usuario existente";
				//sesion anti anti robo

        $resultado=array("usuario"=>$data['usuario'],"promo"=>"fedex19","reg_nombre"=>$existe['nombre']);
        $ses = Tocken::nuevoToken(json_encode($resultado));
        $_SESSION['fedex19']=$ses;

			}else{
				$response["error_msg"]="usuario no registrado";
			}
    }
  }else{
    $response["error_msg"]="Vigencia de la promoción del 15 de abril al 31 de diciembre del 2019.";
  }
}else{
  $response["error_msg"]="Todos los datos son obligatorios";
}


echo json_encode($response);
?>
