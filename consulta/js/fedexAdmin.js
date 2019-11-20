$(document).ready(function(){

	$(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });

	//busca usuario
	$("#bt_busca").click(function(event) {

		var user = $("input#email").val();
		if (user == "") {
			Materialize.toast("El Email es requerido.", 1500);
			$("input#email").focus();
			return false;
		}

		//envia login loginForm
		var dataLogin = {user:user};
		var pathPostL="gdr_validaCorreo.php";

		if(logueando == 0){
			var xhr_post = $.post(pathPostL, dataLogin, function(data) {
				var json= $.parseJSON(data);
				logueando = 1;

				if(json.success==1){
					//Materialize.toast(json.error_msg, 500, '', function(){ window.location="user.php"; });
					window.location="detalle.php?mail="+user;

				}else{
				  Materialize.toast(json.error_msg, 1500);
				  logueando = 0;
				}
			});
			xhr_post.fail(function(data){
				Materialize.toast('Ocurrio un error, intentalo mas adelante', 1500);
				logueando=0;
			});
		}
		return false;


	});

	var logueando = 0;
	//login vendedor
	$("#bt_login").click(function(){
		//usuario
		var user = $("input#email").val();
		if (user == "") {
			Materialize.toast("El usuario es requerido.", 1500);
			$("input#email").focus();
			return false;
		}

		var password = $("input#password").val();
		if (password == "") {
			Materialize.toast("El password es requerido.", 1500);
			$("input#password").focus();
			return false;
		}

		//envia login loginForm
		var dataLogin = {user:user, password:password};
		var pathPostL="gdr_validaUsuario.php";

		if(logueando == 0){
			var xhr_post = $.post(pathPostL, dataLogin, function(data) {
				var json= $.parseJSON(data);
				logueando = 1;

				if(json.success==1){
					//Materialize.toast(json.error_msg, 500, '', function(){ window.location="user.php"; });
					window.location="consulta.php";

				}else{
				  Materialize.toast(json.error_msg, 1500);
				  logueando = 0;
				}
			});
			xhr_post.fail(function(data){
				Materialize.toast('Ocurrio un error, intentalo mas adelante', 1500);
				logueando=0;
			});
		}
		return false;
	});

	//calificar
	$("#btCalificar").click(function(event) {
		var fecha = $("#fecha").val();
		if (fecha == "") {
			Materialize.toast("Selecciona un fecha.", 1500);
			$("#fecha").focus();
			return false;
		}

		window.location="listaParticipaciones.php?dia="+fecha;
	});

	//consulta ganadores
	$("#btGanadores").click(function(event) {
		var fecha = $("#fechaGan").val();
		if (fecha == "") {
			Materialize.toast("Selecciona un fecha.", 1500);
			$("#fechaGan").focus();
			return false;
		}

		window.location="listaGanadores.php?dia="+fecha;
	});

});


//funciones

function permite(elEvento, permitidos) {

  var numeros = "0123456789";
  var caracteres = " abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZáéíóÁÉÍÓÚ";
  var numeros_caracteres = numeros + caracteres;
  var teclas_especiales = [8, 37, 39, 46, 9];

  // 8 = BackSpace, 46 = Supr, 37 = flecha izquierda, 39 = flecha derecha, 9 = tabulador

  // Seleccionar los caracteres a partir del parÃƒÂ¡metro de la funciÃƒÂ³n

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

//pops temporales

/*
function ocultarFila(num,ver) {
  dis= ver ? '' : 'none';
  tab=document.getElementById('trivia');
  tab.getElementsByTagName('tr')[num].style.display=dis;

}*/

$(function() {
	$('#activator').click(function(){
		$('#overlay').fadeIn('fast',function(){
			$('#box').animate({'top':'160px'},500);
		});
	});
	$('#boxclose').click(function(){
		$('#box').animate({'top':'-700px'},500,function(){
			$('#overlay').fadeOut('fast');
			$('#elVideo').replaceWith( "<div></div>" );
		});
	});

});



function calcular_edad(dia_nacim,mes_nacim,anio_nacim)
{
    fecha_hoy = new Date();
    ahora_anio = fecha_hoy.getYear();
    ahora_mes = fecha_hoy.getMonth();
    ahora_dia = fecha_hoy.getDate();
    edad = (ahora_anio + 1900) - anio_nacim;
    if ( ahora_mes < (mes_nacim - 1))
    {
      edad--;
    }
    if (((mes_nacim - 1) == ahora_mes) && (ahora_dia < dia_nacim))
    {
      edad--;
    }
    if (edad > 1900)
    {
    edad -= 1900;
    }
  return edad;
}

function correoValido(correo){
   var expCorreo = /[\w-\.]{2,}@([\w-]{2,})*([\w-]{2,}\.)[\w-]{2,4}/;
   return expCorreo.test(correo);
}
