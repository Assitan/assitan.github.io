$(function() {

	var slider      = $('#slider ul'),
	  	slide       = slider.children('li'),
		slide_width = slide.width(),
		btn_left    = $('#navigation').find('#left'),
		btn_right   = $('#navigation').find('#right'),
		compteur    = 0,
		i           = 0;

	/*
	** MENU 
	*/	

	//création du menu
	if(slide.length){ //s'il y a des images dans le slider
		$('<div id="dots"><ul></ul></div>').appendTo('#navigation');//on ajoute le menu dans le bloc #navigation
		for( ; i < slide.length; i++){//on parcourt les images du slider
			$('<li>').appendTo($('#dots ul'));//on rajoute les boutons au menu
			slide[i] === $('#dots ul li')[i];//on fait correspondre le nombre d'images du slider au nombre de boutons du menu
		}

		//effets lors du clic
		var currentDot = $('#dots ul li').index();//on récupère l'index du bouton en cours
		$('#dots ul li').eq(currentDot).addClass('nav-active');

		$('#dots ul li').click(function(){
			$('#dots ul li').removeClass('nav-active');	//empeche l'ajout du fond noir sur tous les dots		
			var indice = $(this).index();
			$(this).addClass('nav-active');
			slider.animate({marginLeft : slide_width * (-indice)});//l'animation de l'image se fait de la droite vers la gauche
																	//et on récupère grâce à l'indice la bonne position de l'image
		});
	}

	//Même principe
	var auto = setInterval(function(){
		if(compteur < slide.length -1){//si le compteur est plus petit que l'index de la dernière image
		 	compteur++;
			slider.animate({
				marginLeft : slide_width * (-compteur)
			},'slow');
		}

		$('#dots li').removeClass('nav-active');
		$('#dots li:eq('+ compteur + ')').addClass('nav-active');

		if(compteur === slide.length -1){
		 	compteur = -1;	//afin que le compteur revienne à zéro
		}

	},2000);

	$('#stop').click(function(){
		clearInterval(auto);
	});
	

});

	