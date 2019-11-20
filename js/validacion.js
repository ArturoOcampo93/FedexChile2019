//Carga en automatico el Modal al iniciar sesión
$( document ).ready(function() {
    $('#LoadModal').modal('toggle');

    closeForm();
    //detecta cuando cierra el modal

    $("#validaGuia").click(function(event) {
      validador();
    });

    $('#LoadModal').on('hidden.bs.modal', function () {
      //cuando cerramos el modal
      start();
      validaFecha();
    });

    //registra calculo
    $("#bt_ticket").click(function(event) {
      var cajas = $.trim($("#cajas").val());
      if (cajas.length == 0 ) {
        $("#alertaRegistro").html("Debe proporcionar en numero de cajas");
        DisclaimerForm();
        return false;
      }

      var guia = $.trim($("#guia").val());
      if (guia.length == 0 ) {
        $("#guia").show();
        $("#alertaRegistro").html("Debe proporcionar en numero de guia");
        DisclaimerForm();
        return false;
      }
       //detiene cronometro y guarda calculo
       var data = $("#formticket").serialize();
       var pathPost="gdr_guia.php";

       var xhr_posts = $.post(pathPost, data, function(data) {
         var json= $.parseJSON(data);
         if(json.success==1){
           // insertado
           window.location='MiCuenta.php';
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

    });
});  //termina ready

//fecha actual
function validaFecha(){

  var data = {user:"user"};
  var pathPost="gdr_timeIni.php";

  var xhr_posts = $.post(pathPost, data, function(data) {
    var json= $.parseJSON(data);
    if(json.success==1){
      // insertado
      $("#fechaActual").val(json.fecha);
    }
  });
  xhr_posts.fail(function(data){
  });

  return false;
}



//Validador de No. de Guia
function validador(){
  var guia = document.getElementById('NoGuia').value;
  if (guia.length < 12) {
    document.getElementById("error").style.display = "block";
  }
  else {
    document.getElementById('Modal').style.display = "none";
    document.getElementById('CountDown').style.display = "block";

    document.getElementById('guia').value = guia;
    document.getElementById('guia').style.display = "none";

    var startNum;
    function anim(n) {
      $('#countdown').fadeIn('fast', function() {
        if ($(this).html() == "") {
          $(this).html(n); // init first time based on n
        }
    $('#countdown').delay(600).hide('puff', 400, function () {
      if (n == 1) n = startNum; else n--;
      $(this).html(n);
      anim(n);
      }); // end puff
    });
  }
  $(function() {
    anim(5);
  });

  myVar = setTimeout(load, 5000);
  myVar = setTimeout(close, 6500);
  function load(){
  //document.getElementById('LoadModal').style.display = "none";
  document.getElementById("LoadModal").style.animation = "bounceOutUp 2s 1";
  }
  function close(){
    $('#LoadModal').modal('hide');
  }
}
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



//cronometro

window.onload = function() {
   pantalla = document.getElementById("screen");
}
var isMarch = false;
var acumularTime = 0;
function start () {
         if (isMarch == false) {
            timeInicial = new Date();
            control = setInterval(cronometro,10);
            isMarch = true;
            }
         }
function cronometro () {
         timeActual = new Date();
         acumularTime = timeActual - timeInicial;
         acumularTime2 = new Date();
         acumularTime2.setTime(acumularTime);
         cc = Math.round(acumularTime2.getMilliseconds()/10);
         ss = acumularTime2.getSeconds();
         mm = acumularTime2.getMinutes();
         hh = acumularTime2.getHours()-18;
         if (cc < 10) {cc = "0"+cc;}
         if (ss < 10) {ss = "0"+ss;}
         if (mm < 10) {mm = "0"+mm;}
         if (hh < 10) {hh = "0"+hh;}
         //pantalla.innerHTML = hh+" : "+mm+" : "+ss+" : "+cc;
         pantalla.innerHTML = hh+" : "+mm+" : "+ss;
         }

function stop () {
         if (isMarch == true) {
            clearInterval(control);
            isMarch = false;
            }
         }

function resume () {
         if (isMarch == false) {
            timeActu2 = new Date();
            timeActu2 = timeActu2.getTime();
            acumularResume = timeActu2-acumularTime;

            timeInicial.setTime(acumularResume);
            control = setInterval(cronometro,10);
            isMarch = true;
            }
         }

function reset () {
         if (isMarch == true) {
            clearInterval(control);
            isMarch = false;
            }
         acumularTime = 0;
         pantalla.innerHTML = "00 : 00 : 00 : 00";
         }
