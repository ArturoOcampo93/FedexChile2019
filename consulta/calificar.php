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
if(!isset($_GET['fecha']) || $_GET['fecha'] == ""){
	$dia = $hoy;
}else{
	$dia = $_GET['fecha'];
}

//cancela guias despues de 3 dias
$regre = Guias::cancelaGuia($hoy);
//marca las guias validas
$regreValidas = Guias::validaGuias($dia);
//lista de guis validas
$guias = Guias::lista100Guias($dia);

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
			<p>Día de consulta: <?php echo $dia; ?></p>
			<!-- inicia calificacion de guias -->
			<table class="cuadro centered highlight">
        <thead>
          <tr>
              <th>Usuario</th>
              <th>No. de Guía</th>
              <th>Cuenta</th>
              <th>Estatus</th>
              <th>Premio</th>
              <th>Boleto</th>
          </tr>
        </thead>

        <tbody>
          <?php
          if (COUNT($guias)>0) {
            for ($i=0; $i < COUNT($guias); $i++) {
              $user = $guias[$i][0];
              $guia = $guias[$i][1];
              $cuenta = $guias[$i][2];
              $estatus = $guias[$i][3];
							$premio = $guias[$i][4];
              $boleto = $guias[$i][5];
              $idPrem = $guias[$i][6];
              $id = $guias[$i][7];
							$monto = 0;
							$im="";

							switch ($idPrem) {

								case "16":
								$tipoCine = "klic";
								//actualiza premio y trae codigo
								$boleto = Guias::actualizaCine($id, $tipoCine);
								//genera imagen y actualiza guia usuario
								$nomCopia=$id."_pelicula.png";
								$nomImagen="FEDEX_mailing_CineClick.png";
								$im = marcadeagua_texto_ttf($nomImagen, $boleto, $nomCopia);
								//actualiza
								$actualizado = Guias::actualizaGuiaUsuario($id, $im);
								break;

								case "15":
								$monto = 50;
								//actualiza premio y trae codigo
								$boleto = Guias::actualizaRecarga($id, $monto);
								//genera imagen y actualiza guia usuario
								$nomCopia=$id."_recarga50.png";
								$nomImagen="FEDEX_mailing_TA_50.png";
								$im = marcadeagua_texto_ttf($nomImagen, $boleto, $nomCopia);
								//actualiza
								$actualizado = Guias::actualizaGuiaUsuario($id, $im);
								break;

								case "14":
								$monto = 30;
								//actualiza premio y trae codigo
								$boleto = Guias::actualizaRecarga($id, $monto);
								//genera imagen y actualiza guia usuario
								$nomCopia=$id."_recarga30.png";
								$nomImagen="FEDEX_mailing_TA_30.png";
								$im = marcadeagua_texto_ttf($nomImagen, $boleto, $nomCopia);
								//actualiza
								$actualizado = Guias::actualizaGuiaUsuario($id, $im);
								break;

								case "13":
								$monto = 20;
								//actualiza premio y trae codigo
								$boleto = Guias::actualizaRecarga($id, $monto);
								//genera imagen y actualiza guia usuario
								$nomCopia=$id."_recarga20.png";
								$nomImagen="FEDEX_mailing_TA_20.png";
								$im = marcadeagua_texto_ttf($nomImagen, $boleto, $nomCopia);
								//actualiza
								$actualizado = Guias::actualizaGuiaUsuario($id, $im);
								break;

								case "12":
								$tipoCine = "cine";
								//actualiza premio y trae codigo
								$boleto = Guias::actualizaCine($id, $tipoCine);
								//genera imagen y actualiza guia usuario
								$nomCopia=$id."_cine.png";
								$nomImagen="FEDEX_mailing_Cinepolis.png";
								$im = marcadeagua_texto_ttf($nomImagen, $boleto, $nomCopia);
								//actualiza
								$actualizado = Guias::actualizaGuiaUsuario($id, $im);
								break;

								case "11":
								$monto = 5000;
								//genera imagen y actualiza guia usuario
								$nomCopia=$id."_5000.png";
								$nomImagen="FEDEX_mailing_GFY_5000.png";
								$im = marcadeagua_texto_ttf($nomImagen, "", $nomCopia);
								//actualiza
								$actualizado = Guias::actualizaGuiaUsuario($id, $im);
								$boleto = $monto;
								break;

								case "10":
								$monto = 10000;
								//genera imagen y actualiza guia usuario
								$nomCopia=$id."_10000.png";
								$nomImagen="FEDEX_mailing_GFY_10000.png";
								$im = marcadeagua_texto_ttf($nomImagen, "", $nomCopia);
								//actualiza
								$actualizado = Guias::actualizaGuiaUsuario($id, $im);
								$boleto = $monto;
								break;

								//5,6,7,8,9
								case "4":
								$tipoCine = "card";
								//actualiza premio y trae codigo
								$boletoCom = Guias::actualizaStarbucks($id, $tipoCine);
								$boleto = $boletoCom[0]."\nPIN: ".$boletoCom[1];
								//genera imagen y actualiza guia usuario
								$nomCopia=$id."_cardDigitalStarbucks.png";
								$nomImagen="FEDEX_mailing_Starbucks_Carddigital_1.png";
								$im = marcadeagua_texto_ttf($nomImagen, $boleto, $nomCopia);
								//actualiza
								$actualizado = Guias::actualizaGuiaUsuario($id, $im);
								break;

								case "3":
								$tipoCine = "combo";
								//actualiza premio y trae codigo
								$boleto = Guias::actualizaBurguer($id, $tipoCine);
								//genera imagen y actualiza guia usuario
								$nomCopia=$id."_comboBurguer.png";
								$nomImagen="FEDEX_mailing_BurgerKing_Combo1.png";
								$im = marcadeagua_texto_ttf($nomImagen, $boleto, $nomCopia);
								//actualiza
								$actualizado = Guias::actualizaGuiaUsuario($id, $im);
								break;

								case "2":
								$tipoCine = "cafe";
								//actualiza premio y trae codigo
								$boleto = Guias::actualizaStarbucks($id, $tipoCine);
								//genera imagen y actualiza guia usuario
								$nomCopia=$id."_cafeStarbucks.png";
								$nomImagen="FEDEX_mailing_Starbucks_cafedeldia_1.png";
								$im = marcadeagua_texto_ttf($nomImagen, $boleto, $nomCopia);
								//actualiza
								$actualizado = Guias::actualizaGuiaUsuario($id, $im);
								break;

								case "1":
								$tipoCine = "cono";
								//actualiza premio y trae codigo
								$boleto = Guias::actualizaBurguer($id, $tipoCine);
								//genera imagen y actualiza guia usuario
								$nomCopia=$id."_conoBurguer.png";
								$nomImagen="FEDEX_mailing_BurgerKing_Cono1.png";
								$im = marcadeagua_texto_ttf($nomImagen, $boleto, $nomCopia);
								//actualiza
								$actualizado = Guias::actualizaGuiaUsuario($id, $im);
								break;
							}

							//envia correo $user, $im
							$para  = $user; // atención a la coma
							// título
							$título = 'Promo Fedex';
							// mensaje
							$mensaje = '
							<html>
							<head>
							<title>Promo Fedex</title>
							</head>
							<body>
							<div style="text-align: center;">
							 <img src="https://promofedex.com.mx/calificador/boletos/'.$im.'" class="img-fluid pull-xs-left" alt="...">
							</div>
							</body>
							</html>
							';

							// Para enviar un correo HTML, debe establecerse la cabecera Content-type
							$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
							$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

							// Cabeceras adicionales
							$cabeceras .= 'To: '.$user.' <'.$user.'>' . "\r\n";
							$cabeceras .= 'From: PromoFedex <noreply@promofedex.com.mx>' . "\r\n";

							// Enviarlo
							if($im == ""){
							}else{
								mail($para, $título, $mensaje, $cabeceras);
							}



							//genera boleto
							/*$boleto = "11111111";
							$miFolio = "2222";
							$nomImagen="boletoPrueba.png";
							$nomCopia=$miFolio."_".$boleto.".png";

							$im = marcadeagua_texto_ttf($nomImagen, $boleto, $nomCopia);//imagen origen, folio que imprime, nombre de imagen generada
							echo $im;*/

              echo'
              <tr>
              <td>'.$user.'</td>
              <td>'.$guia.'</td>
              <td>'.$cuenta.'</td>
              <td>'.$estatus.'</td>
              <td>'.$idPrem.'</td>
              <td>'.$boleto.'</td>
              </tr>
              ';
            }
          }

          ?>

        </tbody>
      </table>
			<!-- termina calificacion de guias -->

			<?php
			/*$boleto = "6156514366078763\nPIN: 12542089";
			$nomCopia="22_cardStarbucks.png";
			$nomImagen="FEDEX_mailing_Starbucks_Carddigital_1.png";
			$im = marcadeagua_texto_ttf($nomImagen, $boleto, $nomCopia);*/
			 ?>

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

	<?php

	//marca agua en imagenes

	function marcadeagua_texto_ttf($imagen, $texto, $miFol, $copia = true)
	{
	  list($ancho, $alto, $tipo) = getimagesize($imagen);

	  switch ( $tipo ){
	    case IMAGETYPE_JPEG: //image/jpg image/jpeg
	      $nueva_imagen = imagecreatefromjpeg( $imagen );
	      break;
	    case IMAGETYPE_PNG: //image/png
	      $nueva_imagen = imagecreatefrompng( $imagen );
	      break;
	    case IMAGETYPE_GIF: //image/gif
	      $nueva_imagen = imagecreatefromgif( $imagen );
	      break;
	    default:
	      return FALSE;
	  }

	  $color = imagecolorallocate($nueva_imagen, 255, 255, 255);
	  //$color = imagecolorallocate($nueva_imagen, 0, 0, 0);

	  //Indicamos el nombre/archivo de la fuente.
	  //debes indicar la ruta correcta
	  $fuente = 'Cabin-SemiBold-TTF.ttf';
		$tamano = 18;

	  //devuelve las coordenadas de la caja que rodea el texto
	  $caja_texto = imagettfbbox(15, 0, $fuente, $texto);
	  $ancho_texto = $caja_texto[2]-$caja_texto[0];
	  $alto_texto = $caja_texto[1]-$caja_texto[5];

	  $texto_x = abs($caja_texto[6]);
	  $texto_y = $alto_texto;

	  //$texto_x += ($ancho-$ancho_texto)/2;
	  //$texto_y += 0;

	  $texto_x += ($ancho_texto+45);
		if($imagen == "FEDEX_mailing_CineClick.png"){
			$texto_y += $alto-$alto_texto-318;
			$texto_x -= 160;
			$tamano = 15;
		}

		if($imagen == "FEDEX_mailing_Cinepolis.png"){
			$texto_x -= 85;
			$texto_y += $alto-$alto_texto-260;
		}
		//burguer cono
		if($imagen == "FEDEX_mailing_BurgerKing_Cono1.png"){
			$texto_x -= 80;
			$texto_y += $alto-$alto_texto-240;
		}

		//burguer combo
		if($imagen == "FEDEX_mailing_BurgerKing_Combo1.png"){
			$texto_x -= 80;
			$texto_y += $alto-$alto_texto-240;
		}

		//cafe dia
		if($imagen == "FEDEX_mailing_Starbucks_cafedeldia_1.png"){
			$texto_x -= 80;
			$texto_y += $alto-$alto_texto-220;
		}

		if($imagen == "FEDEX_mailing_Starbucks_Carddigital_1.png"){
			$texto_x -= 135;
			$texto_y += $alto-$alto_texto-275;
			$tamano = 15;
		}

		if($imagen == "FEDEX_mailing_TA_50.png" || $imagen == "FEDEX_mailing_TA_30.png" || $imagen == "FEDEX_mailing_TA_20.png"  || $imagen == "FEDEX_mailing_GFY_10000.png"  || $imagen == "FEDEX_mailing_GFY_5000.png" ){
			$texto_y += $alto-$alto_texto-215;
		}

	  imagettftext($nueva_imagen, $tamano, 0, $texto_x, $texto_y, $color, $fuente, $texto);

	  $nombre_archivo = $imagen;
	  if ( strpos($nombre_archivo, '/') )
	  {
	    $nombre_archivo = explode('/', $imagen);
	    $nombre_archivo = end($nombre_archivo);
	  }

	  if ( $copia )
	    $nombre_archivo = $miFol;

	  $calidad_imagen = 90;
	  switch ( $tipo ){
	    case IMAGETYPE_JPEG: //image/jpg image/jpeg
	      imagejpeg($nueva_imagen, $nombre_archivo, $calidad_imagen);
	      break;
	    case IMAGETYPE_PNG: //image/png
	      imagepng($nueva_imagen, "boletos/".$nombre_archivo, $calidad_imagen/10);
	      break;
	    case IMAGETYPE_GIF: //image/gif
	      imagegif($nueva_imagen, $nombre_archivo, $calidad_imagen);
	      break;
	    default:
	      return FALSE;
	  }

	  imagedestroy($nueva_imagen);

	  return $nombre_archivo;
	}
 ?>


</body>
</html>
