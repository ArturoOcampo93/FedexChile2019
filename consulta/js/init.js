(function($){
  $(function(){

    $('.button-collapse').sideNav();

    $('.datepicker').pickadate({
			format: 'yyyy-mm-dd',
			today: 'Hoy',
			clear: 'Limpiar',
			close: 'Aceptar',
			selectYears: true,
			selectYears: 100,
			selectMonths: true,
			monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
			weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			weekdaysShort: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
			showMonthsShort: true,
			weekdays: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
			weekdaysLetter: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
			max: '1900-1-1',
		});

  }); // end of document ready
})(jQuery); // end of jQuery name space
