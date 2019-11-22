<?php
session_start();
require_once("js/clases.php");
if (isset($_SESSION['fedex19']) ) {  //existe la session
	//echo "valida usuario";
	$recievedJwt=$_SESSION['fedex19'];
	//token valido
	$tokenValid = Tocken::validaToken($recievedJwt);

	if($tokenValid){  //el token es valido
		//datos de token
		$usuarioC = Tocken::datosToken($recievedJwt);
		$usuarioC = json_decode($usuarioC, true);
		//print_r($usuarioC);
		$existe=Usuarios::buscaUsuario($usuarioC['usuario']);

		if($existe['encontrado'] == "si"){ //el usuario es valido
		}else{
			session_destroy();
			header("Location: index.html");
			exit(0);
		}  //termina usuario

	}else{
		session_destroy();
		header("Location: index.thml");
		exit(0);
	}// termina token

}else{
	session_destroy();
	header("Location: index.html");
	exit(0);
}  //termina session

date_default_timezone_set('America/Mexico_City');
$semana = date("W");


$imagen = "Calcula-Gana.png";
//$imagen = "";
switch ($semana) {
	case '47':
		$imagen = "SOBRE.png";
		break;
	case '48':
		$imagen = "SOBRE.png";
		break;
	case '49':
		$imagen = "FLECHA.png";
		break;
	case '50':
		$imagen = "CARRITO.png";
		break;
	case '51':
		$imagen = "SIGNO_DE_PESOS.png";
		break;
	case '52':
		$imagen = "CASA.png";
		break;
	case '1':
		$imagen = "CAJA.png";
		break;

}

?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">

    <!--CSS Bootrstrap 4.3 & Arturo-->
    <link rel="stylesheet" href="css/bootstrap.min.css?version=1">
    <link rel="stylesheet" href="css/styles.css?version=1">
    <link rel="stylesheet" href="css/animate.css?version=1">
    <link rel="stylesheet" href="css/aos.css?version=1">
    <link rel="stylesheet" href="css/fireworks.css?version=1">

    <!-- favion  -->
     <link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-touch-icon.png">
     <link rel="icon" type="image/png" sizes="32x32" href="favion/favicon-32x32.png">
     <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
     <link rel="manifest" href="favicon/site.webmanifest">
     <link rel="mask-icon" href="favicon/safari-pinned-tab.svg" color="#5bbad5">
     <meta name="msapplication-TileColor" content="#00a300">
     <meta name="theme-color" content="#ffffff">

    <title>Fedex</title>

		<!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-P64832Z');</script>
    <!-- End Google Tag Manager -->


  </head>
  <body>
		<!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P64832Z"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <header>
      <!--NavBar-->
      <nav class="navbar navbar-expand-lg navbar-light " id="NavFedex">

        <img src="images/logo_fedex.png" class="img-fluid" id="Img-Logo" alt="FedEx" onclick="location.href='index.html';">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active text-white" >
              <a class="nav-link text-white" href="index.html#mecanica">Mecánica <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="index.html#registro">Registro</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="index.html#premios">Premios</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="index.html#ganadores">Ganadores</a>
            </li>
          </ul>
          <span class="navbar-text"><a href="#" class="text-white" onclick="location.href='MiCuenta.php';">Mi Cuenta</a></span>
          <img src="images/Icon-cuenta.png" class="img-fluid" id="icon-cuenta" alt="Cuenta">
        </div>
      </nav>
    </header>
    <main>
      <div class="container-fluid CalculaPage">
        <div class="container">

          <div class="row">
            <div class="col-12 col-md-6 ">
              <!--Imagen de las cajas-->
              <picture>
                <source media="(min-width: 992px)" srcset="images/PNG/<?php echo $imagen; ?>">
                <source media="(min-width: 426px)" srcset="images/PNG/<?php echo $imagen; ?>">
                <img class="img-fluid margen-img" src="images/PNG/<?php echo $imagen; ?>" alt="Calcula & Gana">
              </picture>
            </div>
            <div class="col-12 col-md-6 container-game" id="juego">
              <div class="row">
                <div class="col-12 maxwidth">
                  <h2 class="TitulosGame">¿Cuántas cajas hay en la figura?</h2>
                  <form class="" name="formticket" id="formticket" method="post">
                    <input type="hidden" readonly name="fechaActual" id="fechaActual" >
                    <input type="text" name="cajas" id="cajas" placeholder="Numero de cajas" onkeypress="return permite(event, 'num')" maxlength="15">
                    <input type="text" name="guia" id="guia" placeholder="Numero de guia" onkeypress="return permite(event, 'num')" maxlength="12">
                  </form>
                  <div class="col-12 center">
                    <!-- Alerta de validación de campos | el ID esta oculto | Agregar validación -->
                    <p id="alertaRegistro" class="ValidationRegistro">asdasd</p>
                  </div>
                  <!--<button class="btn btn-primary btn-lg maxwidth space" type="button" name="button" data-toggle="modal" data-target="#Gracias-Participar">¡Calcula y gana!</button>-->
                  <button class="btn btn-primary btn-lg maxwidth space" type="button" name="button" id="bt_ticket" >¡Calcula y gana!</button>
                  <p class="timer">Tiempo: <span id="screen">0:00:00</span></p>
                </div>


              </div>
            </div>
          </div>

      <!--Modal | Numero de Guia | Se carga automaticamente al inicar la pagina y pide al usuario el no. de guía-->
      <div class="modal" id="LoadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header modal-backdrop">
            </div>
            <div class="modal-body" id="Modal">
              <div class="row center">
                <img class="img-fluid ImgModal" src="images/ModalJuego.png" alt="Modal Image">
              </div>
              <div class="row">
                <div class="col-12 textcenter">
                  <h2 class="TitulosModal">¿Cuántas cajas hay<br>en la figura?</h2>
                  <p class="ModalText">Si eres 1 de los 3 clientes semanales en acercarte al número de cajas en el menor tiempo posible, ganarás un increíble kit cafetero.</p>
                </div>
              </div>

              <!--INPUT | ALERTA-->
              <div class="row">
                <div class="col-12" id="alertaNoGuia">
                  <p class="ValidationRegistro naranja padding-top-bottom">Podrás ingresar: Guía de servicios nacionales (9 dígitos) o Guía Internacional de exportación (12 dígitos)</p>
                </div>
                <div class="col-12">
                  <form class="" action="" method="post" onsubmit="validador()">
                    <input class="textcenter" id="NoGuia" type="text" name="" value="" size="12" maxlength="12" onclick="DisclaimerChile()" placeholder="*Escriba su No. de guía FedEx">
                  </form>
                </div>
              </div>

              <div class="row">
                <div class="col-12">
                  <button type="button" class="btn btn-primary btn-lg maxwidth EndPage" id="validaGuia" >Participar</button>
                </div>
              </div>
            </div>
            <div class="container-fluid center align" id="CountDown">
              <div class="row">
                <div class="col-12 align">
                  <p id="countdown"></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </main>
		<footer>
      <div class="container">
        <div class="row center">

          <!--
          <div class="col-12 col-md-4 center linea">
            <h4><a href="PDF/TC-FedEx.pdf" target="_blank">Términos y Condiciones de uso</a></h4>
          </div>
          -->

          <div class="col-12 col-md-4 center linea">
            <h4><a href="PDF/AvisoPrivacidad.pdf" target="_blank">Aviso de Privacidad</a></h4>
          </div>
          <div class="col-12 col-md-4 center linea">
            <h4><a href="https://www.fedex.com/es-cl/privacy-policy.html" target="_blank">Declaración de Privacidad</a></h4>
          </div>

          <!--
          <div class="col-12 col-md-2 center linea">
            <h4><a href="PDF/FAQs.pdf" target="_blank">FAQs</a></h4>
          </div>
          -->

          <div class="col-12 col-md-3 center linea">
            <h4><a href="#" data-toggle="modal" data-target="#contacto">Contacto</a></h4>
          </div>

        </div>
        <div class="row">
          <div class="col-12 center">
            <p class="textFooter">TVP. Este sitio utiliza cookies para ayudarnos a mejorar tu experiencia cada vez que lo visites. Al continuar navegando en el, estarás aceptando su uso. Podrás deshabilitarlas accediendo a la configuración de tu navegador.</p>
          </div>
        </div>
      </div>
    </footer>

    <!-- Modal | Contacto-->
    <div class="modal fade" id="contacto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Contacto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p class="textcenter size-modal-text">Para más información y dudas acerca de la promoción comunícate al <a href="tel:223616000">223616000</a> y <a href="tel:223605100">223605100</a></p>
            <hr>
            <p class="textcenter size-modal-text">También puedes escribirnos a: <a href="mailto:promofedexchile@corp.ds.fedex.com?subject=Hola,%20tengo%20una%20pregunta">promofedexchile@corp.ds.fedex.com</a></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Scripts Bootstrap 4.3, AOS Library & Arturo -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js?version=1"></script>
    <script src="js/aos.js?version=1"></script>
    <script type="text/javascript" src="js/validacion.js?version=1"></script>

    <script>
      AOS.init({
        easing: 'ease-in-out-sine'
      });
    </script>
    <script src="js/fedex.js"></script>
  </body>
</html>
