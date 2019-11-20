<?php

session_start();
require_once("js/clases.php");
$timeout = time() + 3600*24*1;
if (isset($_SESSION['antihack']) ) {
	if($_COOKIE['antihack']  != $_SESSION['antihack']){
		session_destroy();
		header("Location: index.php");
	}else{
		$_SESSION['antihack'] ++;
		setcookie('antihack', $_SESSION['antihack'], $timeout);
		//echo "valida usuario";
		$usuarioVPS=$_SESSION['usuarioVPSRPT'];
		$existe=$usuarioVPS['usuario'];
		if($existe && $usuarioVPS['nombre'] == "reporter" && isset($_GET['desde'])){

			//echo "sesion valida, usuario valido<br>";
			//print_r($usuarioVPS);
		}else{
			session_destroy();
			header("Location: index.php");
		}
	}
}else{
	session_destroy();
	header("Location: index.php");
}

?>

<!doctype html>

<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Modifica recargas</title>

<!--libreria jquery-->

<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

<!--librerias UI-->

<link href="jquery-ui/jquery-ui.css" rel="stylesheet"/>
<link href="jquery-ui/jquery-ui.min.css" rel="stylesheet"/>
<script src="jquery-ui/jquery-ui.js"></script>
<script src="jquery-ui/jquery-ui.min.js"></script>

<!--pasar calendario en español-->

<script src="datapickerSpanol.js"></script>

<!--TODO-->

<script src="modificaRecarga.js"></script>

<!-- Bootstrap -->

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<style></style>

<body>
<?php
		 $regreso=Reportes::repRegistros($_GET['desde'], $_GET['hasta']);
		 //$respuest=array("reg"=>$reg,"tic"=>$par);
		 $r_usuarios=$regreso['reg'];
		 $r_tickets=$regreso['tic'];
    ?>

<div class="container">
  <div class="row">
    <div class="col-xs-6">




      <h4 align="center"><?php echo $r_usuarios; ?> Usuarios registrados y <?php echo $r_tickets; ?> Tickets </h4>

      <!-- REGISTROS POR DIA -->

      <table class="table table-bordered table-striped table-condensed table-hover">
        <thead>
          <tr class="info">
            <th>DIA</th>
            <th>REGISTROS</th>
          </tr>
        </thead>
        <tbody>
          <?php

				 if ($_GET['desde']!='') {

					$histRegdia= Reportes::repRegsxDia($_GET['desde'], $_GET['hasta']);
					$tregdia=0;

					for($i=0; $i<count($histRegdia); $i+=1){
							$tregdia+=$histRegdia[$i][1];
							echo '
								<tr>
									<td><span  class="style8">'.$histRegdia[$i][0].'</span></td>
								  	<td height="19"><span  class="style8">'.$histRegdia[$i][1].'</span></td>
								</tr>
							';
					}
						echo '<tr class="info">
								<td><span  class="style8"><strong>TOTAL</strong></span></td>
								<td height="19"><span  class="style8"><strong>'.$tregdia.'</strong></span></td>
							  </tr>';
				}

				?>
        </tbody>
      </table>
      <br>
      <br>
      <br>
      <h4 align="center"><?php echo $r_usuarios; ?> Usuarios registrados y <?php echo $r_tickets; ?> Tickets </h4>

      <!-- TICKETS POR DIA -->

      <table class="table table-bordered table-striped table-condensed table-hover">
        <thead>
          <tr class="info">
            <th>DIA</th>
            <th>TICKETS</th>
          </tr>
        </thead>
        <tbody>
          <?php

				 if ($_GET['desde']!='') {

					$histTicDia= Reportes::repTicketsxDia($_GET['desde'], $_GET['hasta']);
					$tticdia=0;


					for($i=0; $i<count($histTicDia); $i+=1){
							$tticdia+=$histTicDia[$i][1];
							echo '
								<tr>
									<td><span  class="style8">'.$histTicDia[$i][0].'</span></td>
								  	<td height="19"><span  class="style8">'.$histTicDia[$i][1].'</span></td>
								</tr>
							';
					}
						echo '<tr class="info">
								<td><span  class="style8"><strong>TOTAL</strong></span></td>
								<td height="19"><span  class="style8"><strong>'.$tticdia.'</strong></span></td>
							  </tr>';

				}

				?>
        </tbody>
      </table>
      <br>
      <br>
      <br>




    </div>
  </div>
</div>

<!-- Include all compiled plugins (below), or include individual files as needed -->

<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
