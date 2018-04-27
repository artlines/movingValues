$(function($){

	$( "form" ).submit(function( event ) {
		event.preventDefault();
		var data = $(this).serialize();
		
		if ($('input[name="date_start"]').val() == '' || $('input[name="date_end"]').val() == '') {
			alert('Задайте промежуток времени!');
			return false;
		}

		$.ajax
	    ({
			type: "POST",
			url: '../index.php',
			data: {data:data},
			dataType: 'html',
			cache: false,
			success: function(data){
				$('.out').html(data);
			},
			error: function(error){
				console.error('Не могу получить данные: ' + error);
			}
	    });
	});


  $('input[name="date_range"]').daterangepicker({
	  "locale": {
      "applyLabel": "Применить",
      "cancelLabel": "Отмена",
  	},
  },
  function(start, end, label){
  	$('input[name="date_start"]').val(start.format("YYYY-MM-DD"));
  	$('input[name="date_end"]').val(end.format("YYYY-MM-DD"));
  });
});