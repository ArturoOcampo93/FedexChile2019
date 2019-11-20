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

			if($usuarioC['usuario'] == "admin@admin.com"){ //el usuario es valido
			}else{
				session_destroy();
				header("Location: home.html");
				exit(0);
			}  //termina usuario

		}else{
			session_destroy();
			header("Location: home.html");
			exit(0);
		}// termina token

}else{
	session_destroy();
	header("Location: home.html");
	exit(0);
}  //termina session

//registros
//$num_registros = Usuarios::cuantosRegistros();
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
		<div class="row center col s12 m12 responsive-img">
			<img style="width: 250px;" src="img/logo_promocional.png">
		</div>
		<div class="container">
			<!-- importa excel  -->

			<?php
			if (isset($_FILES['file'])) {

				require_once 'excel/simplexlsx.class.php';

				if ( $xlsx = SimpleXLSX::parse( $_FILES['file']['tmp_name'] ) ) {


					list( $cols, ) = $xlsx->dimension();

					foreach ( $xlsx->rows() as $k => $r ) {
						//		if ($k == 0) continue; // skip first row
						//echo '<tr><td>';
						/*echo $r[ 0 ]."<br>";
						echo $r[ 1 ]."<br>";
						echo $r[ 2 ]."<br>";
						echo $r[ 3 ]."<br>";
						echo $r[ 4 ]."<br>";
						echo $r[ 5 ]."<br>";
						echo $r[ 6 ]."<br>";*/

						$regre = Guias::nuevaGuia($r);

						//echo $regre.'<tr>';
						/*echo '<tr>';
						for ( $i = 0; $i < $cols; $i ++ ) {
							echo '<td>' . ( ( isset( $r[ $i ] ) ) ? $r[ $i ] : '&nbsp;' ) . '</td>';
						}*/
						//echo '</td></tr>';
					}
					//echo '</table>';
					$numTotal = $xlsx->rows();
					echo '<h2>Resultados:</h2>'.count($numTotal)." Registros realizados.";
						//print_r( $xlsx->rows() );
				} else {
					echo SimpleXLSX::parse_error();
				}
			}
			?>

			<h2>Importar Excel</h2>
			<form method="post" enctype="multipart/form-data">
			*.XLSX <input type="file" name="file"/>&nbsp;&nbsp;<input type="submit" class="#4a148c purple darken-2 btn" value="Importar" />
			</form>

			<!-- termina importa excel  -->
		</div>
	</main>
	<footer>
	</footer>
	<!--  Scripts-->
	<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script src="js/materialize.js"></script>
	<script src="js/init.js"></script>

</body>
</html>
