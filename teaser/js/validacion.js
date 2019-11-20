
//Carga en automatico el Modal al iniciar sesión
$( document ).ready(function() {
    $('#LoadModal').modal('toggle')
});
//Validador de No. de Guia
function validador(){
  var guia = document.getElementById('NoGuia').value;
  if (guia.length < 12) {
    document.getElementById("error").style.display = "block";
  }
  else {
    document.getElementById('Modal').style.display = "none";
    document.getElementById('CountDown').style.display = "block";

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
