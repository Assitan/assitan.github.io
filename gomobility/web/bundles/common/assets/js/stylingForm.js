'use strict';

var stylingForm = (function(){

	var $form_edit_comments = $('#form_edit_comment'),
	    $form_edit_ecoactors = $('#form_edit_ecoactor'),
	    $form_edit_actus = $('#form_edit_actu'),
	    $ecoactors_date = $('#gomobility_publicbundle_ecoactors_date_date'),
	    $ecoactors_time = $('#gomobility_publicbundle_ecoactors_date_time'),
	    $comments_date = $('#gomobility_publicbundle_comments_date_date'),
	    $comments_time = $('#gomobility_publicbundle_comments_date_time'),
	    $actualites_date = $('#gomobility_publicbundle_actualite_date_date'),
	    $actualites_time = $('#gomobility_publicbundle_actualite_date_time');

	 function stylingForm($form, $date, $time){
	 	$form.addClass('col-md-6');
	    $form.find('select').addClass('form-control');
		$form.find('input').addClass('form-control');
		$form.find('textarea').addClass('form-control');

		$date.parent().css({
			'margin-bottom':'10px',
			'overflow':'hidden'
		});

		$date.css(
			'overflow','hidden'
		);

		$('#gomobility_publicbundle_ecoactors_game')
			.removeClass('form-control')
			.css('margin-left','10px');

		$date.children('select')
			.css({
				'width':'85px',
				'float':'left'
			});

		$time.children('select')
			.css({
				'width':'85px',
				'float':'left'
			});
	 }

	 stylingForm($form_edit_comments, $comments_date, $comments_time);
	 stylingForm($form_edit_ecoactors, $ecoactors_date, $ecoactors_time);
	 stylingForm($form_edit_actus, $actualites_date, $actualites_time);

	 return stylingForm;
})();