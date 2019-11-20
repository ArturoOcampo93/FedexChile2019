<?php
session_start();
$timeout = time() + 3600*24*1; //Expiramos los cookies en 1 dia

ini_set('display_errors', 1);


header('Content-Type: text/html; charset=utf-8');

$data = array('reg_log'=>'correo');

//array para el JSON
$response = array (
"nombre" => "",
"success" => 0,
"idregistro" => 0,
"error" => 0,
"error_msg" => ""
);



// validate $_POST data
if (isset($_POST['reg_log']) || isset($_POST['password'])) {

		//pasa datos del post a nuestro array usamos una sola variable
		$data =array_map('trim',$_POST);

		//echo "<br><br>";
		//print_r($data);
		//valida datos
		$valid = TRUE;

		//valida datos
		//correo
		if (!filter_var($data['reg_log'], FILTER_VALIDATE_EMAIL)) {
			$response["error_msg"].= 'Correo invalido. ';
			$valid = false;
		}

		if ($data['reg_log'] !== "uyepez@tvp.mx" || $data['password'] !== "tvp2019") {
			$response["error_msg"].= 'Correo invalido. ';
			$valid = false;
		}

		if($valid){

				$response["success"]=1;
				$response["error_msg"]="usuario correcto";
				//sesion anti anti robo
				if ( !isset($_SESSION['antihack']) ) {
					setcookie( 'antihack', $_SESSION['antihack'] = 0, $timeout);
				}else{
					$_SESSION['antihack'] ++;
					setcookie('antihack', $_SESSION['antihack'], $timeout);
				}

				$resultado=array("usuario"=>$data['reg_log'],"promo"=>"vps","nombre"=>"reporter");

				$_SESSION['usuarioVPSRPT']=$resultado;
		}else{
			$response["error_msg"]="usuario incorrecto";
		}
}else{

	$response["error_msg"]="Todos los datos son obligatorios";
}

echo json_encode($response);
?>
