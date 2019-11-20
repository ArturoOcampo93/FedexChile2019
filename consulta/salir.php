<?php
//Inicio la sesi�n
session_start();
header("Cache-control: private"); //Arregla IE 6
//--------------------------------------------------------------------------------
   //descoloco todas la variables de la sesi�n
 session_unset();
//--------------------------------------------------------------------------------
   //Destruyo la sesi�n
 session_destroy();

// Y me voy al inicio
 header("Location: index.html");
     echo "<html></html>";
   exit;
?>
