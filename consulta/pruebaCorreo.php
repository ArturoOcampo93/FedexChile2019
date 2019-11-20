<?php

$para  = "uyepez@tvp.mx"; // atención a la coma
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
 <img src="https://promofedex.com.mx/calificador/boletos/20_cinePrueba.png" class="img-fluid pull-xs-left" alt="...">
</div>
</body>
</html>
';

// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Cabeceras adicionales
$cabeceras .= 'To: '.$para.' <'.$para.'>' . "\r\n";
$cabeceras .= 'From: PromoFedex <noreply@promofedex.com.mx>' . "\r\n";

// Enviarlo
mail($para, $título, $mensaje, $cabeceras);

?>
