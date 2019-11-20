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


//datos usuario
if (isset($_GET['mail'])) {
	$correo = $_GET['mail'];
	//echo $correo;
	//$datos = Usuarios::buscaNombre($correo);
	//print_r($datos);
	$guias = Usuarios::guias($correo);
	//print_r($tickets);

}else{
	header("Location: consulta.php");
	exit(0);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Fedex</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

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
    <div class="row center col s2 m12 responsive-img">
     <img style="width: 180px;" src="img/logo_promocional.png">
   </div>
   <div class="container">

		 <ul class="collection with-header">

        <li class="collection-item">Correo: <?php echo $correo; ?></li>

      </ul>



    <h3 class="center">Registros</h3>
    <table class="center striped centered">
      <thead>
				<tr>
					<th>Folio</th>
					<th>No. de guia</th>
					<th>Cuenta</th>
					<th>Estatus</th>
					<th>Premio</th>
					<th>Boleto</th>
					<th>Día</th>

				</tr>
      </thead>
      <tbody>
				<?php
				if (COUNT($guias)>0) {
					for ($i=0; $i < COUNT($guias); $i++) {
						$folio = $guias[$i][0];
						//$guia = $guias[$i][1];
						$guia = $guias[$i][2];
						$cuenta = $guias[$i][3];
						$estatus = $guias[$i][4];
						$premio = $guias[$i][5];
						$boleto = $guias[$i][6];
						$fecha = $guias[$i][7];

						if($estatus == 'ok'){
							$estatus = "Válida";
						}
						if($premio == ''){
							$estatus = "Sin participación";
						}

						echo'
						<tr>
						<td>'.$folio.'</td>
						<td>'.$guia.'</td>
						<td>'.$cuenta.'</td>
						<td>'.$estatus.'</td>
						<td>'.$premio.'</td>
						<td>'.$boleto.'</td>
						<td>'.$fecha.'</td>
						</tr>
						';
					}
				}
				?>
      </tbody>
    </table>



  </div>
</main>
<footer>
</footer>
<!--  Scripts-->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.js"></script>

</body>
</html>
