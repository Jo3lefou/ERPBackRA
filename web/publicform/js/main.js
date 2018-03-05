// JavaScript Document

$(document).ready(function(){
	//Open Question Additionnel
	$('input[type=radio]').click(function() {
		var rel = $(this).parent().parent().parent().attr('rel');
	   if( $(this).is(':checked') && $(this).val() == '1' ){ 
		   $('div[rel='+rel+'-yes]').slideDown();
		   $('div[rel='+rel+'-non]').slideUp();
	   }else{
		   $('div[rel='+rel+'-yes]').slideUp();
		   $('div[rel='+rel+'-non]').slideDown();
	   }
	});
	$('.datepicker').datepicker({ dateFormat: "yy-mm-dd" });
	
	// Limitation choix robes
	
	$('input.singlecheckbox').on('change', function(evt) {
	   //alert( $('.checkbox').find('input.singlecheckbox:checked').length );
	   var limit = 6;
	   if( $('.checkbox').find('input.singlecheckbox:checked').length >= limit) {
		   
		   this.checked = false;
		   alert('Vous ne pouvez pas choisir plus de 5 robes. / / You can\'t choose more than 5 dresses');
		   
	   }
	});
	
});