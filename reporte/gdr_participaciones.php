<?php

session_start();
require_once("js/clases.php");

$timeout = time() + 3600*24*1;
if (isset($_SESSION['antihack']) ) {
	if($_COOKIE['antihack']  != $_SESSION['antihack']){
		session_destroy();
		header("Location: index.php");
	}else{
		$_SESSION['antihack'] ++;
		setcookie('antihack', $_SESSION['antihack'], $timeout);
		//echo "valida usuario";
		$usuarioVPS=$_SESSION['usuarioVPSRPT'];
		$existe=$usuarioVPS['usuario'];

		if($existe && $usuarioVPS['nombre'] == "reporter"){
			//echo "sesion valida, usuario valido<br>";
			//print_r($usuarioVPS);
		}else{
			session_destroy();
			header("Location: index.php");
		}
	}
}else{
	session_destroy();
	header("Location: index.php");

}


//array para el JSON
$response = array (
"nombre" => "",
"success" => 0,
"reg" => 0,
"part" => 0,
"desde" => $_POST['fecha'],
"hasta" => $_POST['hasta'],
"error" => 0,
"error_msg" => ""
);

if (isset($_POST['fecha'])) {

	$data =array_map('trim',$_POST);

	if ($_POST['hasta']=="") {
		$data['hasta']=$data['fecha'];
		$response["hasta"] = $data['fecha'];
	}


	$registros = Reportes::repRegistros($data['fecha'], $data['hasta']);
	$response["reg"] = $registros['reg'];
	$response["guias"] = $registros['guias'];
	$response["success"] = 1;
	//print_r($registros);

}else{
	$response["error_msg"]="Todos los datos son obligatorios";
}

echo json_encode($response);

?>
