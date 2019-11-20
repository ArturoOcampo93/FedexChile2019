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
			$existe=Usuarios::buscaUsuario($usuarioC['usuario']);

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


//numero de pagina
if(!isset($_GET['pagina'])){
  $pagina = 1;
}else{
  $pagina = $_GET['pagina'];
}

//numero de semana
if(!isset($_GET['sem'])){
  $semana = 1;
}else{
  $semana = $_GET['sem'];
}

$cuantos_tabla = Usuarios::cuantosTicketsSemana($semana);
$por_pagina = 100;

$pagination = paginar_todo($pagina, $por_pagina, $cuantos_tabla);
$registros = Usuarios::ticketsPagina($semana, $pagina, $por_pagina);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Radioshack</title>

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
    <nav class="#b71c1c red darken-4" role="navigation">
      <div class="nav-wrapper container"><a id="logo-container" href="consulta.php" class="brand-logo">Radioshack / Participaciones</a>
        <ul class="right hide-on-med-and-down">
          <li><a href="consulta.php"></a></li>
        </ul>
        <ul id="nav-mobile" class="side-nav">
          <li><a href="consulta.php"></a></li>
        </ul>
        <a href="consulta.php" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
      </div>
    </nav>
    <br>
    <br>
    <div class="row center col s2 m12 responsive-img">
     <img style="width: 180px;" src="img/logo_promocional.png">
   </div>
   <div class="container">
    <h3 class="center">Participaciones</h3>
    <table class="center striped centered">
      <thead>
        <tr>
          <th>Folio</th>
          <th>Nombre</th>
          <th>Ticket</th>
          <th>Email</th>
          <th>Monto</th>

          <th>Estatus</th>

        </tr>
      </thead>
      <tbody>
        <?php
				if (COUNT($registros)>0) {
					for ($i=0; $i < COUNT($registros) ; $i++) {
						$id = $registros[$i][0];
						$nombre = $registros[$i][1];
            $estado = utf8_encode($registros[$i][2]);
						$mail = $registros[$i][3];
						$ticket = $registros[$i][4];
						$monto = $registros[$i][5];
						$dia = $registros[$i][6];
						$estatus = $registros[$i][7];
						$premio = $registros[$i][8];
            $ganador = "";

            /*if($estatus == 'no'){
              $ganador = 'respuesta incorrecta';
            }
            if($estatus == 'pendiente'){
              $ganador = 'ganador';
            }*/

            /*if($estatus == 'ganador'){
              $ganador = $estatus;
            }*/

						echo '
						<tr>
						<td>'.$id.'</td>
						<td>'.$nombre.'</td>
						<td>'.$ticket.'</td>
						<td><a href="detalle.php?mail='.$mail.'">'.$mail.'</a></td>
						<td>'.$monto.'</td>
            <td>'.$estatus.'</td>
						</tr>
						';
					}
				}

				?>

      </tbody>
    </table>


    <ul class="pagination">
      <li class="waves-effect"><a href="participaciones.php?pagina=<?php echo $pagination['pagina_anterior'] ?>&sem=<?php echo $semana; ?>"><i class="material-icons">chevron_left</i></a></li>
      <?php
      for ($i=0; $i < $pagination['total_paginas']; $i++) {
        $active = "";
        $actual = $i+1;
        if($actual==$pagination['pagina_actual']){
          $active = 'class="active"';
        }else{
          $active = 'class="waves-effect"';
        }
        echo'<li '.$active.'><a href="participaciones.php?pagina='.$actual.'&sem='.$semana.'">'.$actual.'</a></li>';
      }
      ?>

      <li class="waves-effect"><a href="participaciones.php?pagina=<?php echo $pagination['pagina_siguiente'] ?>&sem=<?php echo $semana; ?>"><i class="material-icons">chevron_right</i></a></li>
    </ul>


  </div>
</main>
<footer>
</footer>


<!-- Modal Structure -->
<div id="modal1" class="modal">
  <div class="modal-content center">
    <img class="responsive-img" id="imgTicket" src="../imagesFTP/1521656605_img.jpg" alt="">
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cerrar</a>
  </div>
</div>

<!--  Scripts-->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.js"></script>
<script src="js/init.js"></script>

<script type="text/javascript">
$(document).ready(function(){
  $('.modal').modal();

  $(".cambiaimagen").click(function(event) {
    var imgNueva =  $(this).data("imagen");
    $("#imgTicket").attr("src", "../imagesFTP/"+imgNueva);
    //alert(imgNueva);
  });
});
</script>

</body>
</html>
