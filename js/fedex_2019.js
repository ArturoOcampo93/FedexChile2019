$(document).ready(function() {

  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });

closeForm();
closeFormLogin();
closeFormRecupera();

  $('#password').keydown(function (e){
    if(e.keyCode == 13){
      $( "#bt_login" ).trigger( "click" );
    }
  })

  //boton de registro
  $("#bt_registro").click(function(event) {

    var nombre = $.trim($("#Nombre").val());
    if (nombre.length == 0 ) {
      $("#alertaRegistro").html("Debe proporcionar nombre(s)");
      DisclaimerForm();
			return false;
		}

    var apellidos = $.trim($("#apellidos").val());
    if (apellidos.length == 0 ) {
      $("#alertaRegistro").html("Debe proporcionar sus apellidos");
      DisclaimerForm();
			return false;
		}

    //telefono
    var telefono = $.trim($("#telefono").val());
    if (telefono.length == 0 ) {
      $("#alertaRegistro").html("Debe proporcionar su número telefónico");
      DisclaimerForm();
			return false;
		}

    var email = $.trim($("#email").val());
    var email2 = $.trim($("#email2").val());
    if (email.length == 0 ){
      $("#alertaRegistro").html("Debe proporcionar su email");
      DisclaimerForm();
      return false;
    }else{
      if (valEmail(email)){
      }else{
        $("#alertaRegistro").html("La dirección de correo" +" "+email+" " + "no es correcta");
        DisclaimerForm();
        return false;
      }
    }

    if (email2.length == 0 ){
      $("#alertaRegistro").html("Debe confirmar su email");
      DisclaimerForm();
      return false;
    }

    //compara emails
    if (email != email2) {
      $("#alertaRegistro").html("No coincide la dirección de correo");
      DisclaimerForm();
      return false;
    }

    //contraseñas
    var password = $.trim($("#password").val());
    if (password.length == 0 ) {
      $("#alertaRegistro").html("Debe proporcionar sus password");
      DisclaimerForm();
			return false;
		}

    var password2 = $.trim($("#password2").val());
    if (password2.length == 0 ) {
      $("#alertaRegistro").html("Debe confirmar sus password");
      DisclaimerForm();
			return false;
		}

    //compara passwords
    if (password !== password2) {
      $("#alertaRegistro").html("No coincide el password");
      DisclaimerForm();
      return false;
    }

    //como te enteraste
    var enteraste = $.trim($("#enteraste").val());
    if (enteraste == 0 ) {
      $("#alertaRegistro").html("¿Cómo te enteraste de la promoción?");
      DisclaimerForm();
      return false;
    }

    //mayor de edad
    if($("#mayor").is(':checked')) {

    }else{
      $("#alertaRegistro").html("Certifico que soy mayor de 18 años");
      DisclaimerForm();
      return false;
    }

    //terminos y aviso
    if($("#terminos").is(':checked')) {

    }else{
      $("#alertaRegistro").html("Debe aceptar los términos y condiciones de la promoción");
      DisclaimerForm();
      return false;
    }

    if($("#aviso").is(':checked')) {

    }else{
      $("#alertaRegistro").html("Debe aceptar el aviso de privacidad");
      DisclaimerForm();
      return false;
    }

    var data = $("#formregistro").serialize();
    var pathPost="gdr_user.php";

    var xhr_posts = $.post(pathPost, data, function(data) {
      var json= $.parseJSON(data);
      if(json.success==1){
        // insertado
        window.location='ThankYouPage.php';
        return false;
      }else{

        $("#alertaRegistro").html(json.error_msg);
        DisclaimerForm();
      }
    });
    xhr_posts.fail(function(data){
      $("#alertaRegistro").html(json.error_msg);
      DisclaimerForm();
    });

    return false;

  }); //termina registro de usuario


  //login de usuario
  $("#bt_login").click(function(event) {


    var usuario = $.trim($("#usuario").val());
    if (usuario.length == 0 ){
      $("#alertaLogIn").html("Debe proporcionar su usuario");
      DisclaimerFormLogin();
      return false;
    }else{
      if (valEmail(usuario)){
      }else{
        $("#alertaLogIn").html("La dirección de correo" +" "+usuario+" " + "no es correcta");
        DisclaimerFormLogin();
        return false;
      }
    }

    var contrasena = $.trim($("#contrasena").val());
    if (contrasena.length == 0 ) {
      $("#alertaLogIn").html("Debe proporcionar su contraseña");
      DisclaimerFormLogin();
      return false;
    }

    //envia dataformulario
    var data = {usuario:usuario,contrasena:contrasena };
    var pathPost="gdr_valida.php";

    var xhr_posts = $.post(pathPost, data, function(data) {
      var json= $.parseJSON(data);
      if(json.success==1){
        // insertado
        window.location='Calcula&Gana.php';
        return false;
      }else{

        $("#alertaLogIn").html(json.error_msg);
        DisclaimerFormLogin();
      }
    });
    xhr_posts.fail(function(data){
      $("#alertaLogIn").html(json.error_msg);
      DisclaimerFormLogin();
    });

    return false;


  });
  //termina login de usuario

  //recupera contrasena
  $("#bt_recupera").click(function(event) {

    var usuario = $.trim($("#CorreoValidacion").val());
    if (usuario.length == 0 ){
      $("#alertaRecupera").html("Debe proporcionar su usuario");
      DisclaimerFormRecupera();
      return false;
    }else{
      if (valEmail(usuario)){
      }else{
        $("#alertaRecupera").html("La dirección de correo" +" "+usuario+" " + "no es correcta");
        DisclaimerFormRecupera();
        return false;
      }
    }

    //envia dataformulario
    var data = {usuario:usuario };
    var pathPost="gdr_recupera.php";

    var xhr_posts = $.post(pathPost, data, function(data) {
      var json= $.parseJSON(data);
      if(json.success==1){
        // insertado
        $("#alertaRecupera").html("Tu contraseña fue enviado a tu correo de registro.");
        DisclaimerFormRecupera();
      }else{

        $("#alertaRecupera").html(json.error_msg);
        DisclaimerFormRecupera();
      }
    });
    xhr_posts.fail(function(data){
      $("#alertaRecupera").html(json.error_msg);
      DisclaimerFormRecupera();
    });

    return false;



  });




});  //termina ready



//valida cuenta activa
function validaActivo(){

  var data = {user:"user"};
  var pathPost="accountExist.php";

  var xhr_posts = $.post(pathPost, data, function(data) {
    var json= $.parseJSON(data);
    if(json.success==1){
      // insertado
      $("#conCuenta").show('slow/400/fast', function() {

      });
      $("#sinCuenta").hide('slow/400/fast', function() {

      });
    }else{

    }
  });
  xhr_posts.fail(function(data){

  });

  return false;
}

//errores formularios
function DisclaimerForm() {
  document.getElementById('alertaRegistro').style.display = "block";
  document.getElementById("alertaRegistro").style.animation = "fadeInUp 1s 1";
  var x = myFunctionForm();
}
function myFunctionForm() {
  var myVar = setTimeout(alertFuncForm, 2500);
}

function alertFuncForm() {
  document.getElementById("alertaRegistro").style.animation = "fadeOutDown 2s 1";
  var y = setTimeout(closeForm,1000);
}
function closeForm(){
  document.getElementById('alertaRegistro').style.display = "none";
}

//login
function DisclaimerFormLogin() {
  document.getElementById('alertaLogIn').style.display = "block";
  document.getElementById("alertaLogIn").style.animation = "fadeInUp 1s 1";
  var x = myFunctionFormLogin();
}
function myFunctionFormLogin() {
  var myVar = setTimeout(alertFuncFormLogin, 2500);
}

function alertFuncFormLogin() {
  document.getElementById("alertaLogIn").style.animation = "fadeOutDown 2s 1";
  var y = setTimeout(closeFormLogin,1000);
}
function closeFormLogin(){
  document.getElementById('alertaLogIn').style.display = "none";
}

//recupera
function DisclaimerFormRecupera() {
  document.getElementById('alertaRecupera').style.display = "block";
  document.getElementById("alertaRecupera").style.animation = "fadeInUp 1s 1";
  var x = myFunctionFormRecupera();
}
function myFunctionFormRecupera() {
  var myVar = setTimeout(alertFuncFormRecupera, 2500);
}

function alertFuncFormRecupera() {
  document.getElementById("alertaRecupera").style.animation = "fadeOutDown 2s 1";
  var y = setTimeout(closeFormRecupera,1000);
}
function closeFormRecupera(){
  document.getElementById('alertaRecupera').style.display = "none";
}




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


//VALIDA CORREO

function valEmail(valor){

	re=/^[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/;
	if(!re.exec(valor))
	{
		//alert("El correo no es correcto");
		return false;
	}else{
		return true;
	}
}
