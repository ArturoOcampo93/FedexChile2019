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

//registros
$num_registros = Usuarios::cuantosRegistros();
$num_participaciones = Usuarios::cuantosParticipaciones();
$num_participacionesGan = Usuarios::cuantosParticipacionesGan();
//participaciones
//$num_tickets = Usuarios::cuantosTickets();


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
      <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">Fedex / Consulta</a>
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

     <ul class="collapsible" data-collapsible="accordion">


			 <li>
				 <div class="collapsible-header #ab47bc purple lighten-1 white-text"><i class="material-icons">done_all</i>Ganadores</div>
				 <div class="collapsible-body center">
					 <a class="waves-effect #4a148c purple darken-1 waves-light btn"> Total de participaciones: <?php echo $num_participacionesGan; ?> </a>

					 <div class="input-field col s12">
						 <label class="active" for="fechaGan">Selecciona una fecha:</label>
						 <input type="text" class="datepicker" name="fechaGan" id="fechaGan">
					 </div>
					 <!--<a class="waves-effect #4a148c purple darken-1 waves-light btn" href="calificar.php">Calificar</a>-->
					 <a class="waves-effect #4a148c purple darken-1 waves-light btn" id="btGanadores" >Consultar</a>
				 </div>
			 </li>
			 <li>
				 <div class="collapsible-header #9c27b0 purple  white-text"><i class="material-icons">thumb_up</i>Participaciones</div>
				 <div class="collapsible-body center">
					 <a class="waves-effect #4a148c purple darken-1 waves-light btn"> Total de participaciones: <?php echo $num_participaciones; ?> </a>
					 <div class="input-field col s12">
						 <label class="active" for="fecha">Selecciona una fecha:</label>
						 <input type="text" class="datepicker" name="fecha" id="fecha">
					 </div>
					 <!--<a class="waves-effect #4a148c purple darken-1 waves-light btn" href="calificar.php">Calificar</a>-->
					 <a class="waves-effect #4a148c purple darken-1 waves-light btn" id="btCalificar" >Consultar</a>
				 </div>
			 </li>

      <li>
        <div class="collapsible-header #8e24aa purple darken-1 white-text"><i class="material-icons">description</i>Registros</div>
        <div class="collapsible-body center">
          <a class="waves-effect #4a148c purple darken-1 waves-light btn"> Total de Registros: <?php echo $num_registros; ?> </a>
          <a class="waves-effect #4a148c purple darken-2 waves-light btn" href="registros.php">Ver Registros</a>
          <!--<a class="col s12 m12 waves-effect #d32f2f red darken-1 waves-light btn" href="">Exportar Registros</a>-->
        </div>
      </li>

				<li>
          <div class="collapsible-header  #7b1fa2 purple darken-2 white-text"><i class="material-icons">find_in_page</i>Busca Usuario</div>

          <div class="collapsible-body center">
						<div class="row">
							<div class="input-field col s6">
								<input id="email" name="email" type="email" class="validate">
								<label for="email" data-error="correo no válido" data-success="correo válido">Email</label>
							</div>
						</div>
						 <a class="waves-effect #4a148c purple darken-1 waves-light btn"  href="JavaScript:void(0);" id="bt_busca" >Buscar</a>
					 </div>
        </li>
        <li>
          <div class="collapsible-header  #6a1b9a purple darken-3 white-text"><i class="material-icons">highlight_off</i>Cerrar Sesión</div>
          <div class="collapsible-body center"> <a class="waves-effect #6a1b9a purple darken-3 waves-light btn"  href="salir.php">Cerrar Sesión</a></div>
        </li>
      </ul>
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
