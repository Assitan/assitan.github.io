$(function() {
		
	$(window).scroll(function(){

		var top_header = $('#top');
		

		if($(window).scrollTop() > 70){
			$('.scrollTop').show();
						   $('.scrollTop').click(function(){
								$('body').animate({
									scrollTop: top_header.offset().top
								},'slow');
			});
		}else{
			$('.scrollTop').hide();
		}

	});

});