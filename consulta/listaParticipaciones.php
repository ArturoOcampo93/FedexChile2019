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


date_default_timezone_set('America/Mexico_City');
$fechaReg=date("Y-m-d H:i:s");
$hoy=date("Y-m-d");

//fecha para consultar
$dia = "";
if(!isset($_GET['dia']) || $_GET['dia'] == ""){
	$dia = $hoy;
}else{
	$dia = $_GET['dia'];
}


if(!isset($_GET['pagina'])){
  $pagina = 1;
}else{
  $pagina = $_GET['pagina'];
}

$cuantos_tabla = Guias::cuantosParticipaciones($dia);
$por_pagina = 100;

$pagination = paginar_todo($pagina, $por_pagina, $cuantos_tabla);
//$registros = Usuarios::registrosPagina($pagina, $por_pagina);
$registros = Guias::participacionesPagina($pagina, $por_pagina, $dia);

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


    <h3 class="center">Participaciones</h3>

		<a href="excelParticipaciones.php?dia=<?php echo $dia; ?>" class="waves-effect #4a148c purple darken-1 waves-light btn"><i class="material-icons">file_download</i> EXPORTAR </a>

    <table class="center striped centered">
      <thead>
        <tr>
          <th>Id</th>
          <th>Correo</th>
					<th>Guias</th>
					<th>Cuenta</th>
					<th>Estatus</th>
					<th>Premio</th>
					<th>Boleto</th>
					<th>Fecha</th>
        </tr>
      </thead>
      <tbody>
				<?php
				if (COUNT($registros)>0) {
					for ($i=0; $i < COUNT($registros) ; $i++) {
						$id = $registros[$i][0];
						$mail = $registros[$i][1];
						$guia = $registros[$i][2];
						$cuenta = $registros[$i][3];
						$estatus = $registros[$i][6];
						$premio = $registros[$i][7];
						$idPrem = $registros[$i][8];
						$im = $registros[$i][13];
						$fecha = $registros[$i][5];

						if($estatus == 'ok'){
							$estatus = "Válida";
						}
						if($premio == ''){
							$estatus = "Sin participación";
						}

						echo '
						<tr>
						<td>'.$id.'</td>
						<td>'.$mail.'</td>
						<td>'.$guia.'</td>
						<td>'.$cuenta.'</td>
						<td>'.$estatus.'</td>
						<td>'.$premio.'</td>
						<td>'.$im.'</td>
						<td>'.$fecha.'</td>
						</tr>
						';
					}//end for
				}

				?>
      </tbody>
    </table>

	<ul class="pagination">
    <li class="waves-effect"><a href="listaParticipaciones.php?dia=<?php echo $dia; ?>&pagina=<?php echo $pagination['pagina_anterior'] ?>"><i class="material-icons">chevron_left</i></a></li>
		<?php
		for ($i=0; $i < $pagination['total_paginas']; $i++) {
			$active = "";
			$actual = $i+1;
			if($actual==$pagination['pagina_actual']){
				$active = 'class="active"';
			}else{
				$active = 'class="waves-effect"';
			}
			echo'<li '.$active.'><a href="listaParticipaciones.php?dia='.$dia.'&pagina='.$actual.'">'.$actual.'</a></li>';
		}
		?>

    <li class="waves-effect"><a href="listaParticipaciones.php?dia=<?php echo $dia; ?>&pagina=<?php echo $pagination['pagina_siguiente'] ?>"><i class="material-icons">chevron_right</i></a></li>
  </ul>


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
