<?php 
session_start();

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
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Modifica recargas</title>
<!--libreria jquery-->
<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

<!--librerias UI-->
<link href="jquery-ui/jquery-ui.css" rel="stylesheet"/>
<link href="jquery-ui/jquery-ui.min.css" rel="stylesheet"/>

<script src="jquery-ui/jquery-ui.js"></script>
<script src="jquery-ui/jquery-ui.min.js"></script>

<!--pasar calendario en español-->
<script src="datapickerSpanol.js"></script>

<!--TODO-->
<script src="modificaRecarga.js"></script>

<!-- Bootstrap -->
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">


</head>
<style>

</style>
<body>
<h1>Registros y participaciones</h1>
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h4>
				<form action="_gdr.php" method="post" name="formRegistros" id="formRegistros">
				
				<br><br>

					<p>Fecha desde: <input type="text" id="fecha" name="fecha" /></p>
					<p>Fecha hasta: <input type="text" id="hasta" name="hasta" /></p>
					<br>
					<a href="javascript:void(0);" class="btn btn-primary" id="btRegistros">Consultar</a>
					<br>	 
				</form>
			</h4>	
		</div>

		<div class="col-xs-12" id="contUpdate">

		</div>	
	</div>

	<a href="exportar_reg.php" class="btn btn-primary">Exportar</a>
</div>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>