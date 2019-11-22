function Show() {
  /* Obtener valores */
  var x = document.getElementById('Registrate');
  var y = document.getElementById('LogIn');

  /* Proceso y Salida */
  if (y.style.display === "block") {
    y.style.display = "none";
    x.style.display = "block"
    document.getElementById("Registrate").style.animation = "fadeInLeft 2s 1";
  } else {
    y.style.display = "block";
    x.style.display = "none"
    document.getElementById("LogIn").style.animation = "fadeInLeft 2s 1";
  }
}
function recuperacion(){
  var x = document.getElementById('Registrate');
  var y = document.getElementById('LogIn');
  var z = document.getElementById('Recuperacion');

  if(z.style.display === "block"){
    x.style.display = "none";
    z.style.display = "none";
    y.style.display = "block";
    document.getElementById("LogIn").style.animation = "fadeInLeft 2s 1";
  }
  else {
    x.style.display = "none"
    y.style.display = "none";
    z.style.display = "block";
    document.getElementById("Recuperacion").style.animation = "fadeInLeft 2s 1";
  }
}
function Disclaimer() {
  document.getElementById('alertaNombre').style.display = "block";
  document.getElementById("alertaNombre").style.animation = "fadeInUp 2s 1";
  var x = myFunction();
}
function myFunction() {
  var myVar = setTimeout(alertFunc, 5000);
}

function alertFunc() {
  document.getElementById("alertaNombre").style.animation = "fadeOutDown 2s 1";
  var y = setTimeout(close,2000);
}
function close(){
  document.getElementById('alertaNombre').style.display = "none";
}

// Alerta No. de Guía - Chile
function DisclaimerChile() {
  document.getElementById('alertaNoGuia').style.display = "block";
  document.getElementById("alertaNoGuia").style.animation = "fadeInUp 2s 1";
  var x = myFunctionChile();
}
function myFunctionChile() {
  var myVar = setTimeout(alertFuncChile, 5000);
}

function alertFuncChile() {
  document.getElementById("alertaNoGuia").style.animation = "fadeOutDown 2s 1";
  var y = setTimeout(closeChile,2000);
}
function closeChile(){
  document.getElementById('alertaNoGuia').style.display = "none";
}