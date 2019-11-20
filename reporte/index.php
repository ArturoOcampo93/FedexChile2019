<?php 
/*require_once("../clases.php");

if (!isset($_GET['fecha'])) {
	date_default_timezone_set('America/Mexico_City');
	$hoy=date("Y-m-d");
}else{
	$hoy=$_GET['fecha'];
}

$pendientes=Codigos::estatusRecargas($hoy);*/

?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Reporte</title>
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

<style type="text/css" media="screen">
	body{padding-top:50px;}
</style>

</head>
<style>

</style>
<body>
<form  action="gdr_.php"  method="post" id="formLogin" name="formLogin" >
	<div class="container">
	    <div class="row">
			<div class="col-md-4 col-md-offset-4">
	    		<div class="panel panel-default">
				  	<div class="panel-heading">
				    	<h3 class="panel-title">sign in</h3>
				 	</div>
				  	<div class="panel-body">
				    	<form accept-charset="UTF-8" role="form">
	                    <fieldset>
				    	  	<div class="form-group">
				    		    <input class="form-control" placeholder="E-mail" name="reg_log" type="text" class="input-big" id="reg_log">
				    		</div>
				    		<div class="form-group">
				    			<input class="form-control" placeholder="Password" name="password" type="password" id="password" value="">
				    		</div>
				    		<div class="checkbox">
				    	    	<div id="error_msg">
				    	    		
				    	    	</div>
				    	    </div>
				    		<input class="btn btn-lg btn-success btn-block" type="button" value="Login" id="btLogin">
				    	</fieldset>
				      	</form>
				    </div>
				</div>
			</div>
		</div>
	</div>
</form>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>