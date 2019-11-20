//Ancla
 $('.ancla').on('click', function(e){
e.preventDefault();
var strAncla = '#' + $(this).data('ancla');
$('html,body').animate({scrollTop: $(strAncla).offset().top}, 2000);
});
