$(document).ready(function(e) {

	 $("#fecha").datepicker({
	 	dateFormat:"yy-mm-dd"
	 });

	  $("#hasta").datepicker({
	 	dateFormat:"yy-mm-dd"
	 });

	 $("#bt_consulta").click(function(event) {
	 	var fecha;
	 	fecha=$("#fecha").val();
	 });

	 //para obtener fila que lo contiene
	 var padre_tr;
	 //activa o desactiva recarga
	 $(".miId").click(function(event) {
	 	var miid;

	 	miid=$(this).attr('id');
	 	padre_tr = $(this).parents('tr');

	 	$.post("gdr_cambiaRecarga.php",{id:miid}, onCargaPost)
	 	.fail(function(){
	 		alert("error");
	 	});
	 });

	 function onCargaPost(resp, estado, xhr){

		var json= $.parseJSON(resp);
		if(json.success==1){
			//padre_tr.addClass('danger')
			alert(json.error_msg);
			location.reload(true);
		}else{
			alert(json.error_msg);
		}
	}


	//login
	$("#btLogin").click(function(){
		var correo = $("input#reg_log").val();
		if (correo == "") {
			alert("La dirección e-mail parece incorrecta.");
			$("input#reg_log").focus();

			return false;
		}else{
			if($("#reg_log").val().indexOf('@', 0) == -1 || $("#reg_log").val().indexOf('.', 0) == -1) {
				alert("La dirección e-mail parece incorrecta.");
				$("input#reg_log").focus();

				return false;
			}
		}



		//envia login loginForm
		var dataLogin = $("#formLogin").serialize();
		var pathPostL="gdr_valida.php";

		var xhr_post = $.post(pathPostL, dataLogin, function(data) {
			var json= $.parseJSON(data);

			if(json.success==1){
				window.location="home.php";
			}else{
			  $("#error_msg").html(json.error_msg);
			}
		});
		xhr_post.fail(function(data){
			alert ('Ocurrio un error, intentalo mas adelante');
		});
		return false;
	});


	//consulta
	$("#btRegistros").click(function(event) {
		/* Act on the event */
		var fecha = $("input#fecha").val();
		if (fecha == "") {
			alert("selecciona una fecha o rango de fechas.");
			$("input#fecha").focus();

			return false;
		}

		//envia login loginForm
		var dataReg = $("#formRegistros").serialize();
		var pathPostL="gdr_participaciones.php";

		var xhr_post = $.post(pathPostL, dataReg, function(data) {
			var json= $.parseJSON(data);

			if(json.success==1){
				$("#contUpdate").html('Usuarios Registrados:'+json.reg+'<br><br>Guias Registrados:'+json.guias+'<br><br> Registrados:	<a href="estados.php?desde='+json.desde+'&hasta='+json.hasta+'" class="btn btn-primary" >Consultar estados</a> <br><br>	<a href="exportar_corte.php?desde='+json.desde+'&hasta='+json.hasta+'" class="btn btn-primary" >corte ganadores</a>');
			}else{
			  $("#error_msg").html(json.error_msg);
			}
		});
		xhr_post.fail(function(data){
			alert ('Ocurrio un error, intentalo mas adelante');
		});
		return false;
	});
});

// FUNCIONES

function permite(elEvento, permitidos) {

  var numeros = "0123456789";
  var caracteres = " abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
  var numeros_caracteres = numeros + caracteres;
  var teclas_especiales = [8, 37, 39, 46, 9];

  // 8 = BackSpace, 46 = Supr, 37 = flecha izquierda, 39 = flecha derecha, 9 = tabulador

  // Seleccionar los caracteres a partir del parÃ¡metro de la funciÃ³n

  switch(permitidos) {

    case 'num':
      permitidos = numeros;
      break;
    case 'car':
      permitidos = caracteres;
      break;
    case 'num_car':
      permitidos = numeros_caracteres;
      break;
  }

  // Obtener la tecla pulsada
  var evento = elEvento || window.event;
  var codigoCaracter = evento.charCode || evento.keyCode;
  var caracter = String.fromCharCode(codigoCaracter);
  var tecla_especial = false;

  for(var i in teclas_especiales) {
    if(codigoCaracter == teclas_especiales[i]) {
      tecla_especial = true;
      break;
    }
  }
  return permitidos.indexOf(caracter) != -1 || tecla_especial;
}
