$(function(){ 
	$(".alert-message").delegate("a.close", "click", function(event) { 
		event.preventDefault(); 
		$(this).closest(".alert-message").fadeOut(function(event){ 
			$(this).remove(); 
		}); 
	}); 
}); 

