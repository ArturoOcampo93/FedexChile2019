<?php
session_start();
require_once("js/clases.php");
if (isset($_SESSION['costenaAdmin']) ) {  //existe la session
    //echo "valida usuario";
		$recievedJwt=$_SESSION['costenaAdmin'];
		//token valido
		$tokenValid = Tocken::validaToken($recievedJwt);

		if($tokenValid){  //el token es valido
			//datos de token
			$usuarioC = Tocken::datosToken($recievedJwt);
			$usuarioC = json_decode($usuarioC, true);
      //print_r($usuarioC);
			//$existe=Usuarios::buscaUsuario($usuarioC['usuario']);

			if($usuarioC['usuario'] == "admin@fedex.com"){ //el usuario es valido
			}else{
				session_destroy();
				header("Location: index.html");
				exit(0);
			}  //termina usuario

		}else{
			session_destroy();
			header("Location: index.html");
			exit(0);
		}// termina token

}else{
	session_destroy();
	header("Location: index.html");
	exit(0);
}  //termina session

//fecha para consultar
$semana = "1";
if(!isset($_GET['semana']) || $_GET['semana'] == ""){
	$semana = $_GET['semana'];
}

//cancela guias despues de 3 dias
$regre = Guias::guiaSinTipo($semana);

if(count($regre)>0){
	for ($i=0; $i < count($regre); $i++) {
		$id = $regre[$i][0];
		$guia = $regre[$i][1];
		$cuenta = $regre[$i][2];

		//busca tipo
		$tipo = Guias::tipoGuia($guia, $id);
		 //actualiza tipo en guias
	}
}
//lista de guis validas
//$guias = Guias::lista100Guias($semana);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
	<title>fedex</title>

	<!-- CSS  -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	<link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	<link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
	<link rel="manifest" href="/site.webmanifest">
	<link rel="mask-icon" href="favicon/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#b91d47">
	<meta name="theme-color" content="#ffffff">
</head>
<body>
	<main>
		<nav class="#4a148c purple darken-4" role="navigation">
			<div class="nav-wrapper container"><a id="logo-container" href="consulta.php" class="brand-logo">Fedex / Consulta</a>
				<ul class="right hide-on-med-and-down">
					<li><a href="#"></a></li>
				</ul>
				<ul id="nav-mobile" class="side-nav">
					<li><a href="#"></a></li>
				</ul>
				<a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
			</div>
		</nav>
		<br>
		<br>
		<div class="row center col s12 m12 responsive-img">
			<img style="width: 250px;" src="img/logo_promocional.png">
		</div>
		<div class="container">
			<p>Día de consulta: </p>
			<!-- inicia calificacion de guias -->

			<!-- termina calificacion de guias -->



		</div>
	</main>
	<footer>
	</footer>
	<!--  Scripts-->
	<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script src="js/materialize.js"></script>
	<script src="js/init.js"></script>
	<!--  Scripts-->
	<script src="js/fedexAdmin.js"></script>




</body>
</html>
